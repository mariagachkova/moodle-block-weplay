<?php

defined('MOODLE_INTERNAL') || die();

function block_weplay_print_page($weplayblock, $return = false)
{
    global $OUTPUT;
    $display = $OUTPUT->heading($weplayblock->avatar_title);
    $display .= $OUTPUT->box_start();
    $display .= html_writer::start_tag('div', array('class' => 'simplehtml displaydate'));
    $display .= clean_text($weplayblock->avatar_name);
//    $display .= userdate($weplayblock->title);
    $display .= html_writer::end_tag('div');

//close the box
    $display .= $OUTPUT->box_end();

    if($return) {
        return $display;
    } else {
        echo $display;
    }
}