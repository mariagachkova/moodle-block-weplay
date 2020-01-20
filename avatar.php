<?php

global $DB, $PAGE, $OUTPUT, $USER, $CFG;
require_once('../../config.php');

//require_once("$CFG->dirroot/local/filemanager/uploaderform.php");

use block_weplay\models\wp_avatar;
use block_weplay\form\wp_avatar_form;
use block_weplay\output\wp_avatar_preview;


// Check for all required variables.
$courseid = required_param('courseid', PARAM_INT);
// Next look for optional variables.
$view = optional_param('view', true, PARAM_BOOL);

if (!$course = $DB->get_record('course', ['id' => $courseid])) {
    print_error('invalidcourse', 'block_weplay', $courseid);
}

require_login($course);
$blockrecord = $DB->get_record('block_instances', ['blockname' => 'weplay', 'parentcontextid' => $this->event->courseid]);
$context = context_block::instance($blockrecord->id);
$PAGE->set_url('/blocks/weplay/avatar.php', ['courseid' => $courseid]);
$PAGE->set_pagelayout('incourse');
$PAGE->set_heading(get_string('avatar_form_title', 'block_weplay'));

$avatar = wp_avatar::get_record(['userid' => $USER->id, 'courseid' => $courseid]);

echo $OUTPUT->header();
if ($view && $avatar) {
    $output = $PAGE->get_renderer('block_weplay');
    $avatarwidget = new wp_avatar_preview($avatar, $courseid, $USER->id, $course->fullname);
    echo $output->render($avatarwidget);
} else {
    if (!$avatar) {
        $data = (object)['userid' => $USER->id, 'courseid' => $courseid];
        $avatar = new wp_avatar(0, $data);
    }

    $avatarform = new wp_avatar_form($PAGE->url->out(false), ['persistent' => $avatar]);

    if ($avatarform->is_cancelled()) {
        // Cancelled forms redirect to the course main page.
        $courseurl = new moodle_url('/course/avatar.php', array('courseid' => $courseid));
        redirect($courseurl);
    } else if ($data = $avatarform->get_data()) { // Get the data. This ensures that the form was validated.
        if (empty($data->id)) {
            //create a new record.
            $avatar = new wp_avatar(0, $data);
            $avatar->create();
        } else {
            //update a record.
            $avatar->from_record($data);
            $avatar->update();
        }

        file_save_draft_area_files($data->avatar_image, $context->id, 'block_weplay', 'avatar_image',
            $avatar['id'], ['subdirs' => 0, 'maxbytes' => $maxbytes, 'maxfiles' => 1]);

//        $fileSave = file_save_draft_area_files(, $context->id, 'user', 'avatarimage',
//            $avatar->to_record()->id, ['subdirs' => 0, 'maxfiles' => 1]);
//
//        echo var_dump($fileSave);
//        $courseurl = new moodle_url('/blocks/weplay/avatar.php', array('courseid' => $courseid));
//        redirect($courseurl);
    } else {
        // form didn't validate or this is the first display
        $site = get_site();
        $avatarform->display();
    }
}
echo $OUTPUT->footer();
