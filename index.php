<?php

// Standard GPL and phpdocs
require_once('../../config.php');
require_once('lib.php');

use block_weplay\output\leaderboard_page;

global $DB, $PAGE, $OUTPUT;

// Check for all required variables.
$courseid = required_param('courseid', PARAM_INT);

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'block_weplay', $courseid);
}
require_login($course);

$title = get_string('leaderboard_title', 'block_weplay');
$pagetitle = $title;


$PAGE->set_url('/blocks/weplay/index.php', array('courseid' => $courseid));
$PAGE->set_pagelayout('incourse');
$PAGE->set_heading($title);
$PAGE->set_title($title);

//$output = $PAGE->get_renderer('tool_demo');

echo $OUTPUT->header();
echo $OUTPUT->heading($pagetitle);

$renderable = new leaderboard_page('Some text');
echo $renderable->sometext;

echo $OUTPUT->footer();