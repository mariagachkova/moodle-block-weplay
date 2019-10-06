<?php

defined('MOODLE_INTERNAL') || die();

function block_weplay_print_page($avatar, $return = false)
{
    global $OUTPUT;
    $display = $OUTPUT->heading($avatar->avatar_title);
    $display .= $OUTPUT->box_start();
    $display .= html_writer::start_tag('div', array('class' => 'simplehtml displaydate'));
    $display .= clean_text($avatar->avatar_name);
//    $display .= userdate($avatar->title);
    $display .= html_writer::end_tag('div');

    if ($avatar->avatar_image) {
        $display .= $OUTPUT->box_start();
//        $images = block_simplehtml_images();
//        $display .= $images[$avatar->avatar_image];
        $display .= html_writer::start_tag('p');
        $display .= clean_text($avatar->avatar_description);
        $display .= html_writer::end_tag('p');
        $display .= $OUTPUT->box_end();
    }
    
    
//close the box
    $display .= $OUTPUT->box_end();

    if($return) {
        return $display;
    } else {
        echo $display;
    }
}