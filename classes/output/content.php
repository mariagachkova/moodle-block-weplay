<?php

namespace block_weplay\output;

use moodle_url;
use html_writer;

class content
{
    /* @var Stores attributes for the menu items depending on rights */
    var $menuItems = [];

    public function __construct()
    {
        $this->setMenuItems();
    }

    public function getFooter()
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
        foreach ($this->menuItems as $item) {
            $html .= self::getMenuItem($item['title'], $item['url'], $item['faClass']);
        }
        $html .= html_writer::end_tag('ul');
        $html .= html_writer::end_tag('div');

        $html .= html_writer::end_tag('nav');


        return $html;
    }

    public function getText()
    {
        $html = html_writer::tag('div', '', ['class' => 'block_wp-level']);

        $html .= html_writer::start_tag('div', ['class' => 'progress mt-3']);
        $html .= html_writer::tag('div', '', ['class' => 'progress-bar', 'role' => 'progressbar', 'style' => 'width: 25%', 'aria-valuenow' => 25, 'aria-valuemin' => 0, 'aria-valuemax' => 100]);
        $html .= html_writer::end_tag('div');
        $html .= html_writer::tag('div', html_writer::tag('p', 'You have achieved 25 points'), ['class' => 'text-center']);
        return $html;
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

    protected function setMenuItems()
    {

        global $COURSE;
        $urlEdit = new moodle_url('/blocks/weplay/view.php', array('courseid' => $COURSE->id));
        $urlView = new moodle_url('/blocks/weplay/view.php', array('courseid' => $COURSE->id, 'viewpage' => true, 'id' => 1));

        $this->menuItems = [
            [
                'title' => 'Avatar',
                'url' => $urlEdit,
                'faClass' => 'fa fa-user-circle-o',
            ],
            [
                'title' => 'Board',
                'url' => new moodle_url('/blocks/weplay/leader_board.php'),
                'faClass' => 'fa fa-trophy',
            ],
            [
                'title' => 'History',
                'url' => $urlView,
                'faClass' => 'fa fa-history',
            ],
//            [
//                'title' => 'Setting',
//                'url' => new moodle_url('/user/view.php', ['id' => 3, 'course' => 5]),
//                'faClass' => 'fa fa-cog',
//            ],
        ];
    }
}