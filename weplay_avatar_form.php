<?php
require_once("{$CFG->libdir}/formslib.php");

class weplay_avatar_form extends moodleform {

    function definition() {

        $mform =& $this->_form;
        $mform->addElement('header','displayinfo', get_string('avatarformdescription', 'block_weplay'));
    }
}