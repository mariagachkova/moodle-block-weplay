<?php
// File: /mod/mymodulename/view.php
require_once('../../config.php');
//$cmid = required_param('id', PARAM_INT);
$cm = get_coursemodule_from_id('weplay', $cmid, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);

require_login($course, true, $cm);
$PAGE->set_url('/blocks/weplay/leader_board.php'/*, array('id' => $cm->id)*/);
$PAGE->set_title('My modules page title');
$PAGE->set_heading('My modules page heading');