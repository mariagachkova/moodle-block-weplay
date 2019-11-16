<?php

use block_weplay\output\wp_avatar_preview;

/**
 * Class block_weplay_renderer Base renderer class for we play block plugin
 */
class block_weplay_renderer extends plugin_renderer_base
{
    protected function render_wp_avatar_preview(wp_avatar_preview $avatar_preview)
    {
        $out = html_writer::start_div('avatar');
        $out .= $this->navigation_tabs($avatar_preview->permissions);
        $out .= html_writer::start_div('row');
        $out .= html_writer::start_div('col-lg-4 col-md-6 col-xs-12');
        $out .= html_writer::start_div('card');
        $out .= html_writer::start_div('card-body text-center');
        $out .= html_writer::start_div('avatar-parent-child');
        $out .= html_writer::tag('a', html_writer::img('http://localhost/pluginfile.php/5/user/icon/boost/f1?rev=367', 'Image placeholder', ['class' => 'userpicture']), ['href' => '#', 'class' => 'avatar avatar-lg rounded-circle']);
        $out .= html_writer::tag('span', '', ['class' => 'avatar-child avatar-badge bg-success']);
        $out .= html_writer::end_div();

        $out .= html_writer::tag('h5', clean_text($avatar_preview->avatar->avatar_title . ' ' . $avatar_preview->avatar->avatar_name), ['class' => 'h3 mt-4 mb-0']);
        $out .= html_writer::tag('p', get_string('avatar_information_applied', 'block_weplay'), ['class' => 'd-block text-sm text-muted mb-0']);
        $out .= html_writer::link('#', $avatar_preview->courseName, ['class' => 'd-block text-sm text-muted mb-3']);
        $out .= html_writer::tag('p', clean_text($avatar_preview->avatar->avatar_description), ['class' => 'd-block text-sm text-justify mb-3']);

        $out .= html_writer::link('#', html_writer::tag('i', '', ['class' => 'fa fa-pencil']) . ' ' . get_string('avatar_edit', 'block_weplay'), ['class' => 'action-item pull-right']);
        $out .= html_writer::tag('p', html_writer::tag('small', get_string('last_updated', 'block_weplay') . ' ' .  userdate($avatar_preview->avatar->timemodified), ['class' => 'text-muted']), ['class' => 'card-text']);

        $out .= html_writer::end_div();
        $out .= html_writer::end_div();
        $out .= html_writer::end_div();

        $out .= '<div class="col-lg-4 col-md-6 col-xs-12">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Reports</h5>
                        <p class="card-text">Here you can access some of the reports for your profile</p>
                      </div>
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="http://localhost/report/log/user.php?id=2&amp;course=1&amp;mode=today">Today\'s logs</a></li>
                        <li class="list-group-item"><a href="http://localhost/report/log/user.php?id=2&amp;course=1&amp;mode=all">All logs</a></li>
                        <li class="list-group-item"><a href="http://localhost/report/outline/user.php?id=2&amp;course=1&amp;mode=outline">Outline report</a></li>
                        <li class="list-group-item"><a href="http://localhost/course/user.php?mode=grade&amp;id=1&amp;user=2">Grade</a></li>
                        <li class="list-group-item"><a href="http://localhost/grade/report/overview/index.php?userid=2&amp;id=1">Grades overview</a></li>
                        <li class="list-group-item"><a href="http://localhost/report/outline/user.php?id=2&amp;course=1&amp;mode=complete">Complete report</a></li>
                      </ul>
                    </div>
                </div>';

        $out .= '<div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Login activity</h5>
                    <ul>
                        <li class="contentnode">
                            <dl>
                                <dt>First access to site</dt>
                                <dd>Wednesday, 18 July 2018, 10:30 AM&nbsp; (1 year 96 days)</dd>
                            </dl>
                        </li>
                        <li class="contentnode">
                            <dl>
                                <dt>Last access to site</dt>
                                <dd>Tuesday, 22 October 2019, 7:19 PM&nbsp; (now)</dd>
                            </dl>
                        </li>
                        <li class="contentnode">
                            <dl>
                                <dt>Last IP address</dt>
                                <dd>
                                    <a href="http://localhost/iplookup/index.php?ip=0%3A0%3A0%3A0%3A0%3A0%3A0%3A1&amp;user=2">0:0:0:0:0:0:0:1</a>
                                </dd>
                            </dl>
                        </li>
                    </ul>
                </div>
            </div>
        </div>';

        $out .= html_writer::end_div();
        $out .= html_writer::end_div();
        return $this->output->container($out, 'avatar');
    }

    protected function navigation_tabs(array $permissions = [])
    {
        return '<ul class="nav nav-tabs mb-3">
  <li class="nav-item"><a class="nav-link text-center active" href="http://localhost/blocks/weplay/avatar.php?courseid=5"><i class="fa fa-user-circle-o" aria-hidden="true"></i><small> Avatar</small></a></li><li class="nav-item"><a class="nav-link text-center" href="http://localhost/blocks/weplay/leader_board.php"><i class="fa fa-trophy" aria-hidden="true"></i><small> Board</small></a></li><li class="nav-item"><a class="nav-link text-center" href="http://localhost/blocks/weplay/avatar.php?courseid=5"><i class="fa fa-history" aria-hidden="true"></i><small> History</small></a></li>
</ul>';
    }
}
