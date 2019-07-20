<?php

class block_weplay_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        //Title change
        $mform->addElement('text', 'config_title', get_string('blocktitle', 'block_weplay'));
        $mform->addHelpButton('config_title', 'config_title_icon', 'block_weplay');
        $mform->setDefault('config_title', get_string('weplay', 'block_weplay'));
        $mform->setType('config_title', PARAM_RAW);

        //Description change
        $mform->addElement('textarea', 'config_description', get_string('blockdescription', 'block_weplay'));
        $mform->addHelpButton('config_description', 'config_description_icon', 'block_weplay');
        $mform->setDefault('config_description', get_string('blockdescriptiondefault', 'block_weplay'));
        $mform->setType('config_description', PARAM_RAW);

    }
}