<?php

namespace block_weplay\task;
use block_weplay\local\observer\points_recorder;

defined('MOODLE_INTERNAL') || die();

class delete_older_logs extends \core\task\scheduled_task
{

    /**
     * @inheritDoc
     */
    public function get_name()
    {
        return get_string('delete_older_logs', 'block_weplay');
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $points_recorder = new points_recorder();
        $points_recorder->delete_older_logs();
    }
}