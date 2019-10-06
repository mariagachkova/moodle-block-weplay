<?php

require_once('../../config.php');
//require_once('classes/form/weplay_avatar_form.php');
require_once('lib.php');

use block_weplay\form\weplay_avatar_form;

global $DB, $PAGE, $OUTPUT, $USER, $COURSE;

// Check for all required variables.
$courseid = required_param('courseid', PARAM_INT);
// Next look for optional variables.
$id = optional_param('id', 0, PARAM_INT);
$viewpage = optional_param('viewpage', false, PARAM_BOOL);

//$settingsnode = $PAGE->settingsnav->add(get_string('avatarformtitle', 'block_weplay'));
//$editurl = new moodle_url('/blocks/weplay/view.php', array('id' => $id, 'courseid' => $courseid, 'blockid' => $blockid));
//$editnode = $settingsnode->add(get_string('avatarformtitleedit', 'block_weplay'), $editurl);
//$editnode->make_active();

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'block_weplay', $courseid);
}

require_login($course);

$PAGE->set_url('/blocks/weplay/view.php', array('courseid' => $courseid));
$PAGE->set_pagelayout('incourse');
$PAGE->set_heading(get_string('avatar_form_title', 'block_weplay'));


echo $OUTPUT->header();
if ($viewpage) {
    $avatar = $DB->get_record('block_wp_avatar', array('id' => $id));
    block_weplay_print_page($avatar);
} else {
    $avatarform = new weplay_avatar_form();

    $toform['userid'] = $USER->id;
    $toform['courseid'] = $courseid;
    $avatarform->set_data($toform);

    if($avatarform->is_cancelled()) {
        // Cancelled forms redirect to the course main page.
        $courseurl = new moodle_url('/course/view.php', array('id' => $id));
        redirect($courseurl);
    }else if ($fromform = $avatarform->get_data()) {
        if (!$DB->insert_record('block_wp_avatar', $fromform)) {
            print_error('inserterror', 'block_weplay');
        }

        $courseurl = new moodle_url('/blocks/weplay/view.php', array('courseid' => $COURSE->id, 'viewpage' => true, 'id' => $id));
        redirect($courseurl);
    } else {
        // form didn't validate or this is the first display
        $site = get_site();
        $avatarform->display();
    }
}
echo $OUTPUT->footer();
