<?php


namespace block_weplay\output;

use block_weplay\models\wp_avatar;
use moodle_url;
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

    /**
     * @var string $imageUrl
     */
    public $imageUrl;

    public function __construct(wp_avatar $avatar, int $courseId, int $userId, string $courseName = null)
    {
        $this->avatar = $avatar->to_record();
        $this->courseId = $courseId;
        $this->userId = $userId;
        $this->courseName = $courseName;
        $this->imageUrl = $this->getImageUrl();
        ;
    }

    protected function getImageUrl()
    {
//        $fs = get_file_storage();
//            $fileDB = $DB->get_record('files');
//        $file = $fs->get_file(5, 'user', 'draft', 0, '/', 'profile-image.jpg');
//        if ($file) {
            return moodle_url::make_draftfile_url($this->avatar->avatar_image, '/', 'profile-image.jpg');
//        }
//        return 'qew';
    }
}