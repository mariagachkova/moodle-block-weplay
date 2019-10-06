<?php

namespace block_weplay\output;

use moodle_url;
use html_writer;

class content
{
    /* @var Stores attributes for the menu items depending on rights */
    var $menuItems = [];

    public function getText()
    {
        $html = html_writer::start_tag('nav', ['class' => 'navbar navbar-expand-sm navbar-light bg-light mt-3']);
        $html .= html_writer::tag('button', html_writer::tag('i', '', ['class' => 'fa fa-bars', 'aria-hidden' => 'true']), [
            'class' => 'navbar-toggler btn btn-light',
            'type' => 'button',
            'data-toggle' => 'collapse',
            'data-target' => '#navbarNavDropdown',
            'aria-controls' => 'navbarNavDropdown',
            'aria-expanded' => 'false',
            'aria-label' => 'Toggle navigation',
        ]);

        $html .= html_writer::start_tag('div', ['class' => 'collapse navbar-collapse', 'id' => 'navbarNavDropdown']);
        $html .= html_writer::start_tag('ul', ['class' => 'navbar-nav']);
        $html .= self::getMenuItem('User', new moodle_url('/user/view.php', ['id' => 3, 'course' => 5]), 'fa fa-user-circle-o');
        $html .= self::getMenuItem('Board', new moodle_url('/blocks/weplay/leader_board.php'), 'fa fa-trophy');
        $html .= self::getMenuItem('History', new moodle_url('/user/view.php', ['id' => 3, 'course' => 5]), 'fa fa-history');
        $html .= self::getMenuItem('Set', new moodle_url('/user/view.php', ['id' => 3, 'course' => 5]), 'fa fa-cog');
        $html .= html_writer::end_tag('ul');
        $html .= html_writer::end_tag('div');

        $html .= html_writer::end_tag('nav');


        return $html;
    }

    public function getFooter()
    {
        global $COURSE;

// The other code.

        $urlEdit = new moodle_url('/blocks/weplay/view.php', array('courseid' => $COURSE->id));
        $urlView = new moodle_url('/blocks/weplay/view.php', array('courseid' => $COURSE->id, 'viewpage' => true, 'id' => 1));

        return '
<div class="mx-auto">
<div class="d-flex p-2 block_wp-level"></div>
</div>
            <div class="progress mt-3">
  <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<div class="text-center"><p>You have achieved 25 points</p></div>
<div>' . html_writer::link($urlEdit, get_string('editavatar', 'block_weplay')) . '</div>
<div>' . html_writer::link($urlView, get_string('viewavatar', 'block_weplay')) . '</div>';
    }

    private static function getMenuItem(string $menuTitle, moodle_url $menuUrl, string $menuFaIconClass)
    {
        $icon = html_writer::tag('i', '', ['class' => $menuFaIconClass, 'aria-hidden' => 'true']);
        $label = html_writer::tag('small', $menuTitle);
        $html = html_writer::start_tag('li', ['class' => 'nav-item']);
        $html .= html_writer::link($menuUrl, $icon . $label, ['class' => 'nav-link text-center']);
        $html .= html_writer::end_tag('li');
        return $html;
    }

}