<?php
//// File: /mod/mymodulename/view.php
//require_once('../../config.php');
////$cmid = required_param('id', PARAM_INT);
//$cm = get_coursemodule_from_id('weplay', $cmid, 0, false, MUST_EXIST);
//$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
//
//require_login($course, true, $cm);
//$PAGE->set_url('/blocks/weplay/leader_board.php'/*, array('id' => $cm->id)*/);
//$PAGE->set_title('My modules page title');
//$PAGE->set_heading('My modules page heading');


require_once('../../config.php');

$PAGE->set_context(get_system_context());
$PAGE->set_pagelayout('standard');
$PAGE->set_title("Leader Board page");
$PAGE->set_heading("Leader Board");
$PAGE->set_url($CFG->wwwroot . '/blocks/weplay/leader_board.php');


echo $OUTPUT->header();

// Actual content goes here
echo "This is the leaderboard";

echo $OUTPUT->footer();

