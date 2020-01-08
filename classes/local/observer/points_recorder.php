<?php


namespace block_weplay\local\observer;

use core\event\base;
use core\session\exception;

defined('MOODLE_INTERNAL') || die();

class points_recorder
{
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

    public static function log_event(base $event)
    {
        global $DB;
        $points = static::calculate_points($event, $DB);

        if (is_int($points) && $points > 0) {
            static::record_log($event, $points, $DB);
            static::record_level($event, $points, $DB);
        }
    }

    /**
     * @param base $event
     * @param $DB
     * @return int
     */
    private static function calculate_points(base $event, $DB)
    {
        $coursecontext = \context_course::instance($event->courseid);
        $blockrecord = $DB->get_record('block_instances', ['blockname' => 'weplay', 'parentcontextid' => $coursecontext->id]);
        if ($blockrecord) {
            $blockinstance = block_instance('weplay', $blockrecord);
            $config_name = 'crud_' . $event->crud;

            if (isset($blockinstance->config->$config_name) && is_int($blockinstance->config->$config_name)) {
                return $blockinstance->config->$config_name;
            } elseif (isset(static::DEFAULT_POINTS[$config_name]) && is_int(static::DEFAULT_POINTS[$config_name])) {
                return static::DEFAULT_POINTS[$config_name];
            }
        }
        return 0;
    }

    /**
     * @param base $event
     * @param int $points
     * @param $DB
     */
    private static function record_log(base $event, int $points, $DB)
    {
        $logRecord = new \stdClass();
        $logRecord->userid = $event->userid;
        $logRecord->courseid = $event->courseid; #return 0 if global course selected
        $logRecord->eventname = $event->eventname;
        $logRecord->points = $points;
        $logRecord->time = $event->timecreated; /* $time->getTimestamp(); $time = new DateTime(); */
        try {
            $DB->insert_record('block_wp_log', $logRecord);
        } catch (exception $e) {
            debugging($e->getMessage(), DEBUG_NORMAL);
        }
    }

    /**
     * @param base $event
     * @param int $points
     * @param $DB
     */
    private static function record_level(base $event, int $points, $DB)
    {
        $levelRecord = $DB->get_record('block_wp_level', ['userid' => $event->userid, 'courseid' => $event->courseid]);
        if (!$levelRecord) {
            $levelRecord = new \stdClass();
            $levelRecord->userid = $event->userid;
            $levelRecord->courseid = $event->courseid; #return 0 if global course selected
            $levelRecord->level = 1;
            $levelRecord->points = $points;
            $levelRecord->progress_bar_percent = static::calculateProgress($levelRecord);
            try {
                $DB->insert_record('block_wp_level', $levelRecord);
            } catch (exception $e) {
                debugging($e->getMessage(), DEBUG_NORMAL);
            }
        } else {
            $levelRecord->points += $points;
            $next_level = $levelRecord->level + 1; //check next current level points

            if (static::DEFAULT_LEVEL_POINTS[$next_level] < $levelRecord->points) {
                //@todo raise event for getting to the next level
                $levelRecord->level = $next_level;
            }

            $levelRecord->progress_bar_percent = static::calculateProgress($levelRecord);

            try {
                $DB->update_record('block_wp_level', $levelRecord);
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
    private static function calculateProgress($levelRecord)
    {
        $totalPointsToEarn = static::DEFAULT_LEVEL_POINTS[($levelRecord->level + 1)] - static::DEFAULT_LEVEL_POINTS[$levelRecord->level];
        $earnedPointsInCurrentLevel = $levelRecord->points - static::DEFAULT_LEVEL_POINTS[$levelRecord->level];
        if ($earnedPointsInCurrentLevel !== 0) {
            $proportion = $totalPointsToEarn / $earnedPointsInCurrentLevel;
        }else{
            $proportion = 100;
        }
        $rawProgress = 100 / $proportion;
        $progress = round($rawProgress, 2);
        return is_float($progress) ? $progress : 0;
    }
}