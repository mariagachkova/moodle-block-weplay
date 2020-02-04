<?php
define('AJAX_SCRIPT', true);

require_once('../../config.php');
global $DB;

require_login();

$userid = required_param('userid', PARAM_INT);
$courseid = required_param('courseid', PARAM_INT);

$level_info = $DB->get_record('block_wp_level', ['userid' => $userid, 'courseid' => $courseid]);

if ($level_info) {
    return json_encode([
        'points' => $level_info->points,
        'percent' => $level_info->percent . '%',
        'level' => $level_info->level,
    ]);
} else {
    return json_encode([
        'points' => 'N/A',
        'percent' => '0%',
        'level' => 1,
    ]);
}