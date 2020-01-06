<?php

class block_weplay_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        //Title change
        $mform->addElement('text', 'config_title', get_string('block_title', 'block_weplay'));
        $mform->addHelpButton('config_title', 'config_title_icon', 'block_weplay');
        $mform->setDefault('config_title', get_string('weplay', 'block_weplay'));
        $mform->setType('config_title', PARAM_RAW);

        //Description change
        $mform->addElement('textarea', 'config_description', get_string('blockdescription', 'block_weplay'));
        $mform->addHelpButton('config_description', 'config_description_icon', 'block_weplay');
        $mform->setDefault('config_description', get_string('blockdescriptiondefault', 'block_weplay'));
        $mform->setType('config_description', PARAM_RAW);

        $mform->addElement('header', 'config_header', get_string('config_header_points', 'block_weplay'));

        //Definition of CRUD C operation points
        $mform->addElement('text', 'config_crud_c', get_string('config_crud_c', 'block_weplay'));
        $mform->addHelpButton('config_crud_c', 'config_crud_c_icon', 'block_weplay');
        $mform->setDefault('config_crud_c', 15);
        $mform->setType('config_crud_c', PARAM_INT);

        //Definition of CRUD R operation points
        $mform->addElement('text', 'config_crud_r', get_string('config_crud_r', 'block_weplay'));
        $mform->addHelpButton('config_crud_r', 'config_crud_r_icon', 'block_weplay');
        $mform->setDefault('config_crud_r', 3);
        $mform->setType('config_crud_r', PARAM_INT);

        //Definition of CRUD U operation points
        $mform->addElement('text', 'config_crud_u', get_string('config_crud_u', 'block_weplay'));
        $mform->addHelpButton('config_crud_u', 'config_crud_u_icon', 'block_weplay');
        $mform->setDefault('config_crud_u', 1);
        $mform->setType('config_crud_u', PARAM_INT);

        //Definition of CRUD D operation points
        $mform->addElement('text', 'config_crud_d', get_string('config_crud_d', 'block_weplay'));
        $mform->addHelpButton('config_crud_d', 'config_crud_d_icon', 'block_weplay');
        $mform->setDefault('config_crud_d', 0);
        $mform->setType('config_crud_d', PARAM_INT);
    }
}