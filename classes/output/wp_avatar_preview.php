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

    public function __construct(wp_avatar $avatar, array $permissions = [], string $courseName = '') {
        $this->avatar = $avatar->to_record();
        $this->permissions = $permissions;
        $this->courseName = $courseName;
    }
}