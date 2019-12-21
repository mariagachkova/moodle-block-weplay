<?php

namespace block_weplay\local\observer;

use core\session\exception;
use DateTime;

defined('MOODLE_INTERNAL') || die();

class observer
{
    /**
     * Observe all events.
     *
     * @param \core\event\base $event The event.
     * @return void
     */
    public static function catch_all(\core\event\base $event) {
        global $DB, $COURSE;

        $time = new DateTime();

        $logRecord = new \stdClass();
        $logRecord->userid = $event->userid;
        $logRecord->courseid = $COURSE->id;
        $logRecord->eventname = $event->eventname;
        $logRecord->points = 5;
        $logRecord->time = $time->getTimestamp();
        try {
            $DB->insert_record('block_wp_log', $logRecord);
        } catch (exception $e) {
            echo 'There was an error saving we play log';
            // Ignore, but please the linter.
            $pleaselinter = true;
        }

    }
}