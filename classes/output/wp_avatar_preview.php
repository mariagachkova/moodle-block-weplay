<?php


namespace block_weplay\output;

use block_weplay\models\wp_avatar;
use renderable;

class wp_avatar_preview implements renderable
{
    /**
     * @var wp_avatar $avatar
     */
    public $avatar;
    /**
     * @var array $rules
     */
    public $permissions;

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

    public function __construct(wp_avatar $avatar, int $courseId, int $userId, string $courseName = null) {
        $this->avatar = $avatar->to_record();
        $this->courseId = $courseId;
        $this->userId = $userId;
        $this->courseName = $courseName;
    }
}