<?php

require_once('../../config.php');
require_once('weplay_avatar_form.php');

global $DB, $PAGE, $OUTPUT, $USER;

// Check for all required variables.
$courseid = required_param('courseid', PARAM_INT);
$blockid = required_param('blockid', PARAM_INT);

// Next look for optional variables.
$id = optional_param('id', 0, PARAM_INT);

//$settingsnode = $PAGE->settingsnav->add(get_string('avatarformtitle', 'block_weplay'));
//$editurl = new moodle_url('/blocks/weplay/view.php', array('id' => $id, 'courseid' => $courseid, 'blockid' => $blockid));
//$editnode = $settingsnode->add(get_string('avatarformtitleedit', 'block_weplay'), $editurl);
//$editnode->make_active();

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'block_weplay', $courseid);
}

require_login($course);

$PAGE->set_url('/blocks/weplay/view.php', array('id' => $courseid));
$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('avatar_form_title', 'block_weplay'));



$avatarform = new weplay_avatar_form();

$toform['userid'] = $USER->id;
$toform['courseid'] = $courseid;
$avatarform->set_data($toform);

if($avatarform->is_cancelled()) {
    // Cancelled forms redirect to the course main page.
    $courseurl = new moodle_url('/course/view.php', array('id' => $id));
    redirect($courseurl);
}else if ($fromform = $avatarform->get_data()) {
    #@todo
    // We need to add code to appropriately act on and store the submitted data
    // but for now we will just redirect back to the course main page.
//    $courseurl = new moodle_url('/course/view.php', array('id' => $courseid));
//    redirect($courseurl);

    print_object($fromform);
} else {
    // form didn't validate or this is the first display
    $site = get_site();
    echo $OUTPUT->header();
    $avatarform->display();
    echo $OUTPUT->footer();
}
