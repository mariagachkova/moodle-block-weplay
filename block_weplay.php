<?php

/**
 * Class block_weplay
 * Hold the class definition for the block we play
 * and used to manage it as a plugin and to render it onscreen
 */
class block_weplay extends block_base
{
    public function init()
    {
        $this->title = get_string('weplay', 'block_weplay');
    }
    // The PHP tag and the curly bracket for the class definition
    // will only be closed after there is another function added in the next section.

    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content         =  new stdClass;
        $this->content->text   = 'The content of our we PLAY block!';
        $this->content->footer = 'Footer here...';

        return $this->content;
    }
}