<?php

namespace block_weplay\local\observer;

use context_course;
use core\event\base;
use core\session\exception;

defined('MOODLE_INTERNAL') || die();

class observer
{
    /**
     * Observe all events.
     *
     * @param \core\event\base $event The event.
     * @return void
     * @throws \dml_exception
     * @throws \coding_exception
     */
    public static function catch_all(\core\event\base $event)
    {

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
        } else if ($event->component === 'block_weplay') {
            // Skip own events.
            return;
        }

        try {
            // It has been reported that this can throw an exception when the context got missing
            // but is still cached within the event object.
            $canearn = has_capability('block/weplay:earnpoint', $event->get_context(), $userid);
        } catch (\moodle_exception $e) {
            return;
        }

        // Skip the events if the user does not have the capability to earn points.
        if (!$canearn) {
            return;
        }

        $points_recorder = new points_recorder();
        $points_recorder->log_event($event);
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
}