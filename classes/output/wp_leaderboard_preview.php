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

    /**
     * @var array $theadColumns
     */
    public $theadColumns;

    public function __construct(int $courseId, int $userId, array $levelRecords, string $courseName = null) {
        $this->levelRecords = $levelRecords;
        $this->courseId = $courseId;
        $this->userId = $userId;
        $this->courseName = $courseName;
        $this->theadColumns = [
            '#',
            get_string('leaderboard_participant', 'block_weplay'),
            get_string('leaderboard_level', 'block_weplay'),
            get_string('leaderboard_progress', 'block_weplay'),
            '',
        ];
    }
}