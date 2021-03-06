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

    /**
     * @var array $theadColumns
     */
    public $theadColumns;

    public function __construct(int $courseId, int $userId, array $logs, string $courseName = null) {
        $this->logs = $logs;
        $this->courseId = $courseId;
        $this->userId = $userId;
        $this->courseName = $courseName;
        $this->theadColumns = [
            '#',
            get_string('log_time', 'block_weplay'),
            get_string('log_points', 'block_weplay'),
            get_string('log_name', 'block_weplay'),
        ];
    }

    public static function event_readable_name(string $class) {
        // Override in subclass with real lang string.
        $parts = explode('\\', $class);
        if (count($parts) !== 4) {
            return get_string('unknownevent', 'error');
        }
        return str_replace('_', ' ', $parts[3]);
    }
}