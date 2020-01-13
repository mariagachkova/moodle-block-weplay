<?php


namespace block_weplay\output;

use renderable;

class wp_history_preview  implements renderable
{

    /**
     * @var array $logs
     */
    public $logs;
    /**
     * @var string $courseName
     */
    public $courseName;

    /**
     * @var int $courseId
     */
    public $courseId;

    /**
     * @var int $userId
     */
    public $userId;

    public function __construct(int $courseId, int $userId, array $logs, string $courseName = null) {
        $this->logs = $logs;
        $this->courseId = $courseId;
        $this->userId = $userId;
        $this->courseName = $courseName;
    }
}