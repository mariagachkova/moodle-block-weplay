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
$PAGE->set_heading("Leaderboard");
$PAGE->set_title("Leader Board page");

$outputL = $PAGE->get_renderer('block_weplay');
$level_records = $DB->get_records('block_wp_level', ['courseid' => $courseid], 'points DESC');

$leaderboardwidget = new wp_leaderboard_preview($courseid, $USER->id, $level_records, $course->fullname);
echo $OUTPUT->header();
echo $outputL->render($leaderboardwidget);
echo $OUTPUT->footer();

