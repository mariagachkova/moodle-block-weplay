<?php

namespace block_weplay\local\observer;

use core\event\base;
use core\session\exception;

defined('MOODLE_INTERNAL') || die();

class observer
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
     * Observe all events.
     *
     * @param \core\event\base $event The event.
     * @return void
     * @throws \dml_exception
     */
    public static function catch_all(\core\event\base $event)
    {

        static::log_event($event);
        $userid = $event->userid;

        if ($event->edulevel !== \core\event\base::LEVEL_PARTICIPATING) {
            // Ignore events that are not participating.
            return;
        } else if (!in_array($event->contextlevel, [CONTEXT_COURSE, CONTEXT_MODULE])) {
            // Ignore events that are not in the right context.
            return;
        } else if (!$userid || isguestuser($userid) || is_siteadmin($userid)) {
            // Skip non-logged in users and guests.
            return;
        } else if ($event->anonymous) {
            // Skip all the events marked as anonymous.
            return;
        } else if (!$event->get_context()) {
            // For some reason the context does not exist...
            return;
        }
//        else if ($event->component === 'block_weplay') {
//            // Skip own events.
//            return;
//        }


        try {
            // It has been reported that this can throw an exception when the context got missing
            // but is still cached within the event object. Or something like that...
            $canearn = has_capability('block/weplay:earnpoint', $event->get_context(), $userid);
        } catch (\moodle_exception $e) {
            return;
        }

        // Skip the events if the user does not have the capability to earn XP.
        if (!$canearn) {
            return;
        }

        static::log_event($event);
    }

    /**
     * Delete all related data to the course
     * @param \core\event\course_deleted $event
     * @throws \dml_exception
     */
    public static function course_deleted(\core\event\course_deleted $event)
    {
        global $DB;

        $courseid = $event->objectid;

        // Clean up the data that could be left behind.
        $conditions = array('courseid' => $courseid);
        $DB->delete_records('block_wp_log', $conditions);
        $DB->delete_records('block_wp_avatar', $conditions);
        $DB->delete_records('block_wp_level', $conditions);
    }

    private static function log_event(base $event)
    {
        global $DB;
        $points = static::calculate_points($event, $DB);

        if (is_int($points) && $points > 0) {
            $logRecord = new \stdClass();
            $logRecord->userid = $event->userid;
            $logRecord->courseid = $event->courseid; #return 0 if global course selected
            $logRecord->eventname = $event->eventname;
            $logRecord->points = $points;
            $logRecord->time = $event->timecreated; /* $time->getTimestamp(); $time = new DateTime(); */
            try {
                $DB->insert_record('block_wp_log', $logRecord);
            } catch (exception $e) {
                // Ignore, but please the linter.
                $pleaselinter = true;
            }
        }

    }

    /**
     * @param base $event
     * @param $DB
     * @return int
     */
    private static function calculate_points(base $event, $DB)
    {
        global $COURSE;
        $coursecontext = \context_course::instance($COURSE->id);
        $blockrecord = $DB->get_record('block_instances', array('blockname' => 'weplay', 'parentcontextid' => $coursecontext->id));
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

}