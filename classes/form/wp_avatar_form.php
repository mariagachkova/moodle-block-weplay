<?php


namespace block_weplay\form;


class wp_avatar_form extends \core\form\persistent
{
    /** @var string Persistent class name. */
    protected static $persistentclass = 'block_weplay\\models\\wp_avatar';

    /**
     * Define the form.
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('header','displayinfo', get_string('avatar_form_general', 'block_weplay'));

        //Title change
        $mform->addElement('text', 'avatar_title', get_string('avatar_title', 'block_weplay'));
        $mform->addHelpButton('avatar_title', 'avatar_title_icon', 'block_weplay');
        $mform->setType('avatar_title', PARAM_RAW);

        //Name change
        $mform->addElement('text', 'avatar_name', get_string('avatar_name', 'block_weplay'));
        $mform->addHelpButton('avatar_name', 'avatar_name_icon', 'block_weplay');
        $mform->setType('avatar_name', PARAM_RAW);


        //Description change
        $mform->addElement('textarea', 'avatar_description', get_string('avatar_description', 'block_weplay'));
        $mform->addHelpButton('avatar_description', 'avatar_description_icon', 'block_weplay');
        $mform->setType('avatar_description', PARAM_RAW);

$options = ['subdirs' => 0, 'areamaxbytes' => 10485760, 'maxfiles' => 1,
    'accepted_types' => ['jpg', 'png', 'jpe', 'jpeg', 'gif', 'svg', 'svgz']];
        $draftitemid = file_get_submitted_draft_itemid('avatar_image');
        file_prepare_draft_area($draftitemid, CONTEXT_BLOCK, 'user', 'avatar_image', 0, $options);

        $mform->addElement('filemanager', 'avatar_image', get_string('avatar_image', 'block_weplay'), null,$options);

//        $mform->addElement('filepicker', 'avatar_image', get_string('avatar_image', 'block_weplay'), null, array('accepted_types' => ['jpg', 'png']));
        $mform->addHelpButton('avatar_image', 'avatar_image_icon', 'block_weplay');

        // hidden elements
        $mform->addElement('hidden', 'userid');
        $mform->addElement('hidden', 'courseid');

        $this->add_action_buttons();
    }

}