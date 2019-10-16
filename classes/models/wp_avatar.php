<?php

namespace block_weplay\models;

class wp_avatar extends \core\persistent
{
    /** Table name for the avatar. */
    const TABLE = 'block_wp_avatar';

    /**
     * Return the definition of the properties of this model.
     *
     * @return array
     */
    protected static function define_properties()
    {
        return [
            'courseid' => array(
                'type' => PARAM_INT,
            ),
            'userid' => array(
                'type' => PARAM_INT,
            ),
            'avatar_title' => array(
                'type' => PARAM_RAW,
            ),
            'avatar_name' => array(
                'type' => PARAM_RAW,
            ),
            'avatar_description' => array(
                'type' => PARAM_RAW,
            ),
            'avatar_image' => array(
                'type' => PARAM_INT,
            ),
        ];
    }
}