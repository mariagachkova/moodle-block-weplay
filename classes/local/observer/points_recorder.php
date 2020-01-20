<?php


namespace block_weplay\local\observer;

use core\event\base;
use core\session\exception;

defined('MOODLE_INTERNAL') || die();

class points_recorder
{
    /**
     * @var $db
     */
    protected $db;
    /**
     * @var base $event
     */
    protected $event;
    /**
     * @var array $plugin_config
     */
    protected $plugin_config;

    /**
     * Default points for crud events
     */
    const DEFAULT_POINTS = [
        'crud_c' => 15,
        'crud_r' => 3,
        'crud_u' => 1,
        'crud_d' => 0,
    ];

    /**
     * Default points that students should earn to get the next level
     */
    const DEFAULT_LEVEL_POINTS = [
        1 => 0,
        2 => 40,
        3 => 92,
        4 => 159,
        5 => 247,
    ];
    /**
     * Default time in days that system will store the logs
     */
    const DEFAULT_LOG_LIFETIME = 60;
    /**
     * Event names that should be excluded from earning points
     */
    const EXCLUDED_EVENTS = [
        '\mod_forum\event\subscription_created',
        '\mod_forum\event\discussion_subscription_created',
        '\mod_book\event\course_module_viewed',
        'assessable_submitted',
        'assessable_uploaded',
    ];

    public function __construct()
    {
        $this->setDB();
        $this->setPluginConfig();
    }

    protected function setDB()
    {
        global $DB;
        $this->db = $DB;
    }

    protected function setPluginConfig()
    {
        $this->plugin_config = get_config('block_weplay');
    }

    protected function setEvent(base $event)
    {
        $this->event = $event;
    }

    public function log_event(base $event)
    {
        $this->setEvent($event);
        $points = $this->calculate_points();

        if (is_int($points) && $points > 0) {
            $this->record_log($points);
            $this->record_level($points);
        }
    }

    /**
     * @param base $event
     * @return int
     */
    private function calculate_points()
    {
        if (strlen(str_replace(static::EXCLUDED_EVENTS, '', $this->event->eventname)) == strlen($this->event->eventname)) {
            $blockrecord = $this->db->get_record('block_instances', ['blockname' => 'weplay', 'parentcontextid' => $this->event->courseid]);
            if ($blockrecord) {
                $blockinstance = block_instance('weplay', $blockrecord);
                $config_name = 'crud_' . $this->event->crud;

                if (isset($blockinstance->config->$config_name) && is_int($blockinstance->config->$config_name)) {
                    return $blockinstance->config->$config_name;
                } elseif (isset(static::DEFAULT_POINTS[$config_name]) && is_int(static::DEFAULT_POINTS[$config_name])) {
                    return static::DEFAULT_POINTS[$config_name];
                }
            }
        }
        return 0;
    }

    /**
     * @param int $points
     */
    private function record_log(int $points)
    {
        $logRecord = new \stdClass();
        $logRecord->userid = $this->event->userid;
        $logRecord->courseid = $this->event->courseid; #return 0 if global course selected
        $logRecord->eventname = $this->event->eventname;
        $logRecord->points = $points;
        $logRecord->time = $this->event->timecreated; /* $time->getTimestamp(); $time = new DateTime(); */
        try {
            $this->db->insert_record('block_wp_log', $logRecord);
        } catch (exception $e) {
            debugging($e->getMessage(), DEBUG_NORMAL);
        }
    }

    /**
     * @param int $points
     */
    private function record_level(int $points)
    {
        $levelRecord = $this->db->get_record('block_wp_level', ['userid' => $this->event->userid, 'courseid' => $this->event->courseid]);
        if (!$levelRecord) {
            $levelRecord = new \stdClass();
            $levelRecord->userid = $this->event->userid;
            $levelRecord->courseid = $this->event->courseid; #return 0 if global course selected
            $levelRecord->level = 1;
            $levelRecord->points = $points;
            $levelRecord->progress_bar_percent = static::calculate_progress($levelRecord);
            try {
                $this->db->insert_record('block_wp_level', $levelRecord);
            } catch (exception $e) {
                debugging($e->getMessage(), DEBUG_NORMAL);
            }
        } else {
            $levelRecord->points += $points;
            $next_level = $levelRecord->level + 1; //check next current level points

            if (isset(static::DEFAULT_LEVEL_POINTS[$next_level]) && static::DEFAULT_LEVEL_POINTS[$next_level] < $levelRecord->points) {
                //@todo raise event for getting to the next level
                $levelRecord->level = $next_level;
            }

            $levelRecord->progress_bar_percent = static::calculate_progress($levelRecord);

            try {
                $this->db->update_record('block_wp_level', $levelRecord);
            } catch (exception $e) {
                debugging($e->getMessage(), DEBUG_NORMAL);
            }
        }
    }

    /**
     * Calculate percentage for progress bar
     * @param $levelRecord
     * @return float
     */
    private static function calculate_progress($levelRecord)
    {
        $proportion = 100;
        if (isset(static::DEFAULT_LEVEL_POINTS[($levelRecord->level + 1)])) {
            //get total points that should be earned to get from current level to next one
            $totalPointsToEarn = static::DEFAULT_LEVEL_POINTS[($levelRecord->level + 1)] - static::DEFAULT_LEVEL_POINTS[$levelRecord->level];
            //get only the points that are earned after the current level has been achieved
            $earnedPointsInCurrentLevel = $levelRecord->points - static::DEFAULT_LEVEL_POINTS[$levelRecord->level];
            //check division by zero
            if ($earnedPointsInCurrentLevel !== 0) {
                //proportion for points
                $proportion = $totalPointsToEarn / $earnedPointsInCurrentLevel;
            }
        }
        //get percents
        $rawProgress = 100 / $proportion;
        $progress = round($rawProgress, 2);
        return is_float($progress) ? $progress : 0;
    }

    /**
     *
     * @throws \Exception
     */
    public function delete_older_logs()
    {
        if (isset($this->plugin_config->loglifetime) && $this->plugin_config->loglifetime) {
            $days = $this->plugin_config->loglifetime;
        } else {
            $days = static::DEFAULT_LOG_LIFETIME;
        }
        $date_time = new \DateTime();
        $date_time->setTimestamp(time() - ($days * DAYSECS));

        $this->db->delete_records_select(
            'block_wp_log',
            'time < :time',
            [
                'time' => $date_time->getTimestamp()
            ]
        );
    }
}