<?php


namespace block_weplay\output;


use renderable;

class wp_leaderboard_preview implements renderable
{
    /**
     * @var array $levelRecords
     */
    public $levelRecords;

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

    public function __construct(int $courseId, int $userId, array $levelRecords, string $courseName = null) {
        $this->levelRecords = $levelRecords;
        $this->courseId = $courseId;
        $this->userId = $userId;
        $this->courseName = $courseName;
    }
}