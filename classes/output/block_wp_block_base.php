<?php

namespace block_weplay\output;

use moodle_url;
use html_writer;

class block_wp_block_base
{
    /* @var array $menuItems Stores attributes for the menu items depending on rights */
    protected $menuItems = [];

    /* @var int $level Stores current user level */
    protected $level = 1;

    /* @var int $points Stores current user points */
    protected $points = 0;

    /* @var int $points Stores current user progress bar percent */
    protected $progress_bar_percent = 0;

    protected $userid;
    protected $courseid;

    public function __construct()
    {
        $this->setMenuItems();
        $this->setUserProperties();
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
            $html .= self::getMenuItem($item['string_key'], $item['url'], $item['faClass'], $item['class']);
        }

        $icon = html_writer::tag('i', '', ['class' => 'fa fa-refresh', 'aria-hidden' => 'true']);
        $label = html_writer::tag('small', 'Refresh');
        $html .= html_writer::start_tag('li', ['class' => 'nav-item refresh_icon', 'data-userid' => $this->userid, 'data-courseid' => $this->courseid]);
        $html .= $icon . '<br>' . $label;
        $html .= html_writer::end_tag('li');

        $html .= html_writer::end_tag('ul');
        $html .= html_writer::end_tag('div');

        $html .= html_writer::end_tag('nav');


        return $html;
    }

    public function getText()
    {
        $html = html_writer::tag('div', '', ['class' => 'block_wp-level level-' . $this->level]);

        $html .= html_writer::start_tag('div', ['class' => 'progress mt-3']);
        $html .= html_writer::tag('div', '', ['class' => 'progress-bar', 'role' => 'progressbar', 'style' => 'width: ' . $this->progress_bar_percent . '%', 'aria-valuenow' => 25, 'aria-valuemin' => 0, 'aria-valuemax' => 100]);
        $html .= html_writer::end_tag('div');
        $html .= html_writer::tag('div', html_writer::tag('p', 'You have achieved <b class="points">' . $this->points . '</b> points'), ['class' => 'text-center weplay-points']);
        return $html;
    }

    private static function getMenuItem(string $stringKey, moodle_url $menuUrl, string $menuFaIconClass, string $liClass)
    {
        $icon = html_writer::tag('i', '', ['class' => $menuFaIconClass, 'aria-hidden' => 'true']);
        $label = html_writer::tag('small', get_string($stringKey, 'block_weplay'));
        $html = html_writer::start_tag('li', ['class' => 'nav-item ' . $liClass]);
        $html .= html_writer::link($menuUrl, $icon . '<br>' . $label, ['class' => 'nav-link text-center']);
        $html .= html_writer::end_tag('li');
        return $html;
    }

    protected function setMenuItems()
    {

        global $COURSE;
        $urlEditAvatar = new moodle_url('/blocks/weplay/avatar.php', ['courseid' => $COURSE->id]);
        $urlLeaderBoard = new moodle_url('/blocks/weplay/leader_board.php', ['courseid' => $COURSE->id]);
        $urlHistory = new moodle_url('/blocks/weplay/history.php', ['courseid' => $COURSE->id]);

        $this->menuItems = [
            [
                'class' => 'avatar',
                'string_key' => 'avatar_menu_title',
                'url' => $urlEditAvatar,
                'faClass' => 'fa fa-user-circle-o',
            ],
            [
                'class' => 'board',
                'string_key' => 'leaderboard_menu_title',
                'url' => $urlLeaderBoard,
                'faClass' => 'fa fa-trophy',
            ],
            [
                'class' => 'history',
                'string_key' => 'history_menu_title',
                'url' => $urlHistory,
                'faClass' => 'fa fa-history',
            ],
        ];
    }

    private function setUserProperties()
    {
        global $DB, $COURSE, $USER;
        $levelInfo = $DB->get_record('block_wp_level', ['userid' => $USER->id, 'courseid' => $COURSE->id]);
        if($levelInfo){
            $this->level = $levelInfo->level;
            $this->points = $levelInfo->points;
            $this->progress_bar_percent = $levelInfo->progress_bar_percent;
        }
        $this->userid = $USER->id;
        $this->courseid = $COURSE->id;
    }
}