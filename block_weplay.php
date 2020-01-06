<?php

/**
 * Class block_weplay
 * Hold the class definition for the block we play
 * and used to manage it as a plugin and to render it onscreen
 */

use block_weplay\output\block_wp_block_base;

class block_weplay extends block_base
{
    public function init()
    {
        $this->title = get_string('weplay', 'block_weplay');
    }
    // The PHP tag and the curly bracket for the class definition
    // will only be closed after there is another function added in the next section.

    /**
     * Build the HTML for the block
     * @return stdClass
     */
    public function get_content()
    {
        if ($this->content !== null) {
            return $this->content;
        }

        $content = new block_wp_block_base();

        $this->content = new stdClass;

        $this->content->footer = $content->getFooter();

        $this->content->text = $content->getText();

        return $this->content;
    }

    /**
     * Set plugin title from settings after the init()
     * because $this->config do not exists in init()
     */
    public function specialization()
    {
        if (isset($this->config) && !empty($this->config->title)) {
            $this->title = $this->config->title;
        }
    }

    /**
     * Prevent for adding multiple visualization on same page
     * @return bool
     */
    public function instance_allow_multiple()
    {
        return false;
    }

    /**
     * @return array
     */
    public function applicable_formats()
    {
        return array(
            'admin' => false,
            'site-index' => false,
            'course-view' => true,
            'mod' => false,
            'my' => false
        );
    }

    /**
     * Allow global configuration from settings.php
     * @return bool
     */
    function has_config()
    {
        return true;
    }
}