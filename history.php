<?php

use block_weplay\output\wp_history_preview;

require_once('../../config.php');
global $DB, $PAGE, $OUTPUT, $USER;

// Check for all required variables.
$courseid = required_param('courseid', PARAM_INT);

if (!$course = $DB->get_record('course', ['id' => $courseid])) {
    print_error('invalidcourse', 'block_weplay', $courseid);
}

require_login($course);

//$PAGE->set_context(context_system::instance());
$PAGE->set_url('/blocks/weplay/history.php', ['courseid' => $courseid]);
$PAGE->set_pagelayout('incourse');
$PAGE->set_heading(get_string('log_page_header', 'block_weplay'));
$PAGE->set_title("Logs timestamps");

$outputL = $PAGE->get_renderer('block_weplay');

$logs = $DB->get_records('block_wp_log', ['courseid' => $courseid, 'userid' => $USER->id], 'time DESC', '*', 0, 20);

$logswidget = new wp_history_preview($courseid, $USER->id, $logs, $course->fullname);
echo $OUTPUT->header();
echo $outputL->render($logswidget);
echo $OUTPUT->footer();

