<?php

use block_weplay\output\wp_leaderboard_preview;

require_once('../../config.php');
global $DB, $PAGE, $OUTPUT;

// Check for all required variables.
$courseid = required_param('courseid', PARAM_INT);

if (!$course = $DB->get_record('course', ['id' => $courseid])) {
    print_error('invalidcourse', 'block_weplay', $courseid);
}

require_login($course);

//$PAGE->set_context(context_system::instance());
$PAGE->set_url('/blocks/weplay/leader_board.php', ['courseid' => $courseid]);
$PAGE->set_pagelayout('incourse');
$PAGE->set_heading(get_string('leaderboard_page_header', 'block_weplay'));
$PAGE->set_title("Leader Board page");

$outputL = $PAGE->get_renderer('block_weplay');

$sql =<<<sql
SELECT lvl.id, lvl.userid, lvl.courseid, lvl.level, lvl.points, lvl.progress_bar_percent, avt.avatar_title, avt.avatar_name, avt.avatar_description, avt.avatar_image
FROM {block_wp_level} lvl LEFT OUTER JOIN {block_wp_avatar} avt ON avt.userid = lvl.userid AND avt.courseid = lvl.userid
WHERE lvl.courseid = $courseid ORDER BY points DESC LIMIT 10
sql;

$combined_records = $DB->get_records_sql($sql);

$leaderboardwidget = new wp_leaderboard_preview($courseid, $USER->id, $combined_records, $course->fullname);
echo $OUTPUT->header();
echo $outputL->render($leaderboardwidget);
echo $OUTPUT->footer();

