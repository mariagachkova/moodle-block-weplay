<?php

use block_weplay\local\observer\points_recorder;
use block_weplay\output\wp_avatar_preview;
use block_weplay\output\wp_history_preview;
use block_weplay\output\wp_leaderboard_preview;

/**
 * Class block_weplay_renderer Base renderer class for we play block plugin
 */
class block_weplay_renderer extends plugin_renderer_base
{
    protected function render_wp_avatar_preview(wp_avatar_preview $avatar_preview)
    {
        $out = $this->navigation_tabs($avatar_preview->userId, $avatar_preview->courseId, 'avatar_menu_title');
        $out .= html_writer::start_div('row');

        $out .= $this->avatar_info($avatar_preview);
        $out .= $this->reports($avatar_preview->userId, $avatar_preview->courseId);
        $out .= $this->login_activity($avatar_preview->userId);

        $out .= html_writer::end_div();
        return $this->output->container($out, 'avatar');
    }

    protected function navigation_tabs(int $userId, int $courseId, string $active)
    {
        $out = html_writer::start_tag('ul', ['class' => 'nav nav-tabs mb-3']);

        $menu_items = $this->menu_list($userId, $courseId);
        foreach ($menu_items as $string_key => $menu) {
            $out .= html_writer::start_tag('li', ['class' => 'nav-item']);
            $icon = html_writer::tag('i', '', ['class' => $menu['icon_class'], 'aria-hidden' => true]);
            $small = html_writer::tag('small', get_string($string_key, 'block_weplay'));

            $out .= html_writer::link($menu['url'], $icon . ' ' . $small, ['class' => 'nav-link text-center' . ($active == $string_key ? ' active' : '')]);
            $out .= html_writer::end_tag('li');
        }
        $out .= html_writer::end_tag('ul');
        return $out;
    }

    private function reports(int $userId, int $courseId)
    {
        $out = html_writer::start_div('col-lg-4 col-md-6 col-xs-12');
        $out .= html_writer::start_div('card');
        $out .= html_writer::start_div('card-body');

        $out .= html_writer::tag('h5', get_string('report', 'block_weplay'), ['class' => 'card-title']);
        $out .= html_writer::tag('p', get_string('report_info', 'block_weplay'), ['class' => 'card-text']);
        $out .= html_writer::start_tag('ul', ['class' => 'list-group list-group-flush']);

        $logs = $this->report_list($userId, $courseId);
        foreach ($logs as $string_key => $url) {
            $out .= html_writer::start_tag('li', ['class' => 'list-group-item']);
            $out .= html_writer::link($url, get_string($string_key, 'block_weplay'));
            $out .= html_writer::end_tag('li');
        }
        $out .= html_writer::end_tag('ul');

        $out .= html_writer::end_div();
        $out .= html_writer::end_div();
        $out .= html_writer::end_div();

        return $out;
    }

    private function login_activity(int $userId)
    {
        $out = html_writer::start_div('col-lg-4 col-md-6 col-xs-12');
        $out .= html_writer::start_div('card');
        $out .= html_writer::start_div('card-body');

        $out .= html_writer::tag('h5', get_string('loginactivity'), ['class' => 'card-title']);
        $out .= html_writer::start_tag('ul');

        $login_info_list = $this->login_info_list($userId);
        foreach ($login_info_list as $string_key => $value) {
            $out .= html_writer::start_tag('li', ['class' => 'contentnode']);
            $out .= html_writer::start_tag('dl');
            $out .= html_writer::tag('dt', get_string($string_key));
            $out .= html_writer::tag('dd', $value);
            $out .= html_writer::end_tag('dl');
            $out .= html_writer::end_tag('li');
        }
        $out .= html_writer::end_tag('ul');

        $out .= html_writer::end_div();
        $out .= html_writer::end_div();
        $out .= html_writer::end_div();

        return $out;
    }

    protected function avatar_info(wp_avatar_preview $avatar_preview)
    {
        $urlEditAvatar = new moodle_url('/blocks/weplay/avatar.php', array('courseid' => $avatar_preview->courseId, 'view' => false));

        $out = html_writer::start_div('col-lg-4 col-md-6 col-xs-12');
        $out .= html_writer::start_div('card');
        $out .= html_writer::start_div('card-body text-center');
        $out .= html_writer::tag('a', html_writer::img('http://localhost/pluginfile.php/5/user/icon/boost/f1?rev=367', 'Image placeholder', ['class' => 'userpicture']), ['href' => '#', 'class' => 'avatar avatar-lg rounded-circle']);
        $out .= html_writer::tag('span', '', ['class' => 'avatar-child avatar-badge bg-success']);

        $out .= html_writer::tag('h5', clean_text($avatar_preview->avatar->avatar_title . ' ' . $avatar_preview->avatar->avatar_name), ['class' => 'h3 mt-4 mb-0']);
        $out .= html_writer::tag('p', get_string('avatar_information_applied', 'block_weplay'), ['class' => 'd-block text-sm text-muted mb-0']);
        $out .= html_writer::link('#', $avatar_preview->courseName, ['class' => 'd-block text-sm text-muted mb-3']);
        $out .= html_writer::tag('p', clean_text($avatar_preview->avatar->avatar_description), ['class' => 'd-block text-sm text-justify mb-3']);

        $out .= html_writer::link($urlEditAvatar, html_writer::tag('i', '', ['class' => 'fa fa-pencil']) . ' ' . get_string('avatar_edit', 'block_weplay'), ['class' => 'action-item pull-right']);
        $out .= html_writer::tag('p', html_writer::tag('small', get_string('last_updated', 'block_weplay', userdate($avatar_preview->avatar->timemodified)), ['class' => 'text-muted']), ['class' => 'card-text']);

        $out .= html_writer::end_div();
        $out .= html_writer::end_div();
        $out .= html_writer::end_div();

        return $out;
    }

    protected function report_list(int $userId, int $courseId)
    {
        //@todo add capabilities
        return [
            'today_logs' => new moodle_url('/report/log/user.php', ['id' => $userId, 'course' => $courseId, 'mode' => 'today']),
            'all_logs' => new moodle_url('/report/log/user.php', ['id' => $userId, 'course' => $courseId, 'mode' => 'all']),
            'grade' => new moodle_url('/course/user.php', ['id' => $courseId, 'user' => $userId, 'mode' => 'grade']),
            'grade_overview' => new moodle_url('/grade/report/overview/index.php', ['userid' => $userId, 'id' => $courseId]),
        ];
    }

    protected function login_info_list(int $userId)
    {
        global $DB;
        $user = $DB->get_record('user', ['id' => $userId]);

        if ($user) {
            $datestringfa = userdate($user->firstaccess) . "&nbsp; (" . format_time(time() - $user->firstaccess) . ")";
            $datestringla = userdate($user->lastaccess) . "&nbsp; (" . format_time(time() - $user->lastaccess) . ")";

            return [
                'firstaccess' => $datestringfa,
                'lastaccess' => $datestringla,
                'lastip' => $user->lastip,
            ];
        }
        return [];
    }

    protected function menu_list(int $userId, int $courseId)
    {
        //@todo add capabilities
        return [
            'avatar_menu_title' => [
                'icon_class' => 'fa fa-user-circle-o',
                'url' => new moodle_url('/blocks/weplay/avatar.php', ['courseid' => $courseId]),
            ],
            'leaderboard_menu_title' => [
                'icon_class' => 'fa fa-trophy',
                'url' => new moodle_url('/blocks/weplay/leader_board.php', ['courseid' => $courseId]),
            ],
            'history_menu_title' => [
                'icon_class' => 'fa fa-history',
                'url' => new moodle_url('/blocks/weplay/history.php', ['courseid' => $courseId]),
            ],
//            'settings_menu_title' => 'fa fa-user-circle-o',
        ];
    }

    protected function render_wp_leaderboard_preview(wp_leaderboard_preview $leaderboard_preview)
    {

        $out = html_writer::start_div('leaderboard we-play block_weplay');
        $out .= $this->navigation_tabs($leaderboard_preview->userId, $leaderboard_preview->courseId, 'leaderboard_menu_title');
        $out .= $this->responsive_table($leaderboard_preview->levelRecords, $leaderboard_preview->theadColumns, 'leaderboard_table_body');
        $out .= html_writer::end_div();

        return $this->output->container($out);
    }

    private function responsive_table(array $records, array $theadColumns, string $functionName)
    {
        $out = html_writer::start_div('row');
        $out .= html_writer::start_div('col-lg-12 col-md-12 col-xs-12');
        $out .= html_writer::start_div('table-responsive');

        $out .= html_writer::start_tag('table', ['class' => 'table table-hover']);
        $out .= $this->table_head($theadColumns);
        $out .= $this->$functionName($records);
        $out .= html_writer::end_tag('table');

        $out .= html_writer::end_div();
        $out .= html_writer::end_div();
        $out .= html_writer::end_div();
        return $out;
    }

    /**
     * Get leaderboard table header
     * @param array $theadColumns
     * @return string
     */
    private function table_head(array $theadColumns)
    {
        $out = html_writer::start_tag('thead');
        $out .= html_writer::start_tag('tr');

        foreach ($theadColumns as $theadColumn) {
            $out .= html_writer::tag('th', $theadColumn, ['scope' => 'col']);
        }

        $out .= html_writer::end_tag('tr');
        $out .= html_writer::end_tag('thead');
        return $out;
    }

    /**
     * Get leaderboard table body
     * @param array $levelRecords
     * @return string
     * @throws coding_exception
     */
    private function leaderboard_table_body(array $levelRecords)
    {
        global $USER;
        $out = html_writer::start_tag('tbody');
        $i = 1;
        foreach ($levelRecords as $key => $levelRecord) {
            $title = $levelRecord->points . (isset(points_recorder::DEFAULT_LEVEL_POINTS[($levelRecord->level + 1)]) ? ' are earned from ' . points_recorder::DEFAULT_LEVEL_POINTS[($levelRecord->level + 1)] . ' needed to achieve the next level' : '');
            $icon = html_writer::tag('i', '', ['class' => 'fa fa-question-circle pull-right', 'aria-hidden' => true, 'title' => $title]);
            $participant_name = trim($levelRecord->avatar_title . ' ' . $levelRecord->avatar_name);
            $is_current_user = $USER->id == $levelRecord->userid;

            $out .= html_writer::start_tag('tr', ['class' => ($is_current_user ? 'table-dark' : '')]);
            $out .= html_writer::tag('th', $i++, ['scope' => 'row']);
            $out .= html_writer::tag('td', $this->leaderboard_avatar_info($participant_name, $levelRecord->avatar_description, $is_current_user));
            $out .= html_writer::tag('td', $this->leaderboard_level_info($levelRecord->level));
            $out .= html_writer::tag('td', $this->progress_bar($levelRecord->progress_bar_percent, $levelRecord->points));
            $out .= html_writer::tag('td', $icon);
            $out .= html_writer::end_tag('tr');
        }
        $out .= html_writer::end_tag('tbody');
        return $out;
    }

    /**
     * Get progress bar html based on percent
     * @param float $progress_bar_percent
     * @param int $points
     * @return string
     */
    private function progress_bar(float $progress_bar_percent, int $points)
    {
        $html = html_writer::start_tag('div', ['class' => 'progress mt-3']);
        $html .= html_writer::tag('div', '', ['class' => 'progress-bar', 'role' => 'progressbar', 'style' => 'width: ' . $progress_bar_percent . '%', 'aria-valuemin' => 0, 'aria-valuemax' => 100]);
        $html .= html_writer::end_tag('div');
        $html .= html_writer::tag('div', html_writer::tag('p', $points . ' points achieved'), ['class' => 'text-center']);
        return $html;
    }

    /**
     * Return avatar picture and names with title
     * @param string $participant_name
     * @param string $avatar_description
     * @param bool $is_current_user
     * @return string
     * @throws coding_exception
     */
    private function leaderboard_avatar_info(string $participant_name, $avatar_description, bool $is_current_user)
    {
        global $CFG;
        $icon = '';
        if ($avatar_description) {
            $icon = html_writer::tag('i', '', ['class' => 'fa fa-info-circle', 'aria-hidden' => true, 'title' => $avatar_description]);
        }
        $name = $participant_name ? ($participant_name . ' ' . $icon) : get_string('leaderboard_unknown', 'block_weplay');
        $current = $is_current_user ? get_string('leaderboard_current', 'block_weplay') : '';
        $html = html_writer::img($CFG->wwwroot . '/pluginfile.php/5/user/icon/boost/f1?rev=367', 'Image placeholder', ['class' => 'userpicture', 'style' => "width: 50px; height: 50px"]);
        $html .= $name . $current;
        return $html;
    }

    /**
     * Get image tag with thumb level
     * @param int $level
     * @return string
     */
    private function leaderboard_level_info(int $level)
    {
        return html_writer::img('pix/thumb_level_' . $level . '.png', 'Image placeholder');
    }

    protected function render_wp_history_preview(wp_history_preview $history_preview)
    {
        $out = html_writer::start_div('history we-play block_weplay');
        $out .= $this->navigation_tabs($history_preview->userId, $history_preview->courseId, 'history_menu_title');
        $out .= $this->responsive_table($history_preview->logs, $history_preview->theadColumns, 'logs_table_body');
        $out .= html_writer::end_div();

        return $this->output->container($out);
    }

    /**
     * Get history log table body
     * @param array $logRecords
     * @return string
     * @throws coding_exception
     */
    private function logs_table_body(array $logRecords)
    {
        $out = html_writer::start_tag('tbody');
        $i = 1;
        foreach ($logRecords as $log) {
            $iconCal = html_writer::tag('i', '', ['class' => 'fa fa-calendar', 'aria-hidden' => true]);
            $iconClock = html_writer::tag('i', '', ['class' => 'fa fa-clock-o', 'aria-hidden' => true]);
            $time = $iconCal . ' ' . date('d.m', $log->time) . '   ' . $iconClock . ' ' . date('H:i:s', $log->time);

            $out .= html_writer::start_tag('tr');
            $out .= html_writer::tag('th', $i++, ['scope' => 'row']);
            $out .= html_writer::tag('td', $time);
            $out .= html_writer::tag('td', $log->points);
            $out .= html_writer::tag('td', wp_history_preview::event_readable_name($log->eventname));
            $out .= html_writer::end_tag('tr');
        }
        $out .= html_writer::end_tag('tbody');
        return $out;
    }
}
