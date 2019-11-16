<?php

defined('MOODLE_INTERNAL') || die();




function block_weplay_print_page($avatar, $return = false)
{
    global $OUTPUT, $COURSE;
//    $display = $OUTPUT->heading($avatar->avatar_title);
//    $display .= $OUTPUT->box_start();
//    $display .= html_writer::start_tag('div', array('class' => 'simplehtml displaydate'));

    $display .= '
<div class="avatar">
<ul class="nav nav-tabs mb-3">
  <li class="nav-item"><a class="nav-link text-center active" href="http://localhost/blocks/weplay/avatar.php?courseid=5"><i class="fa fa-user-circle-o" aria-hidden="true"></i><small> Avatar</small></a></li><li class="nav-item"><a class="nav-link text-center" href="http://localhost/blocks/weplay/leader_board.php"><i class="fa fa-trophy" aria-hidden="true"></i><small> Board</small></a></li><li class="nav-item"><a class="nav-link text-center" href="http://localhost/blocks/weplay/avatar.php?courseid=5"><i class="fa fa-history" aria-hidden="true"></i><small> History</small></a></li>
</ul>


<div class="row">
<div class="col-lg-4 col-md-6 col-xs-12">
<div class="card">
                  <div class="card-body text-center">
                    <div class="avatar-parent-child">
                      <a href="#" class="avatar avatar-lg rounded-circle">
                        <img alt="Image placeholder" class="userpicture" src="http://localhost/pluginfile.php/5/user/icon/boost/f1?rev=367">
                      </a>
                      <span class="avatar-child avatar-badge bg-success"></span>
                    </div>
                    <h5 class="h3 mt-4 mb-0">' . clean_text($avatar->avatar_title . ' ' . $avatar->avatar_name) . '</h5>
                    <p class="d-block text-sm text-muted mb-0">avatar information applied in</p>
                    <a href="#" class="d-block text-sm text-muted mb-3">' . $COURSE->fullname . '</a>
                    <p class="d-block text-sm text-justify mb-3">' . $avatar->avatar_description . '</p>
                    
                      <a href="#" class="action-item pull-right">
                        <i class="fa fa-pencil"></i> Edit Avatar
                      </a>
                    <p class="card-text"><small class="text-muted">Last updated ' . userdate($avatar->timemodified) . '</small></p>
                  </div>
                   
                  </div>
                </div>
                <div class="col-lg-4 col-md-6 col-xs-12">
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
                </div>
                <div class="col-lg-4 col-md-6 col-xs-12">
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
                    <dd><a href="http://localhost/iplookup/index.php?ip=0%3A0%3A0%3A0%3A0%3A0%3A0%3A1&amp;user=2">0:0:0:0:0:0:0:1</a>
                    </dd>
                </dl>
            </li>
        </ul>
                      </div>
                    </div>
                </div>
                </div>
                </div>';

//    $display .= clean_text($avatar->avatar_name);
////    $display .= userdate($avatar->title);
//    $display .= html_writer::end_tag('div');
//
//    if ($avatar->avatar_image) {
//        $display .= $OUTPUT->box_start();
////        $images = block_simplehtml_images();
////        $display .= $images[$avatar->avatar_image];
//        $display .= html_writer::start_tag('p');
//        $display .= clean_text($avatar->avatar_description);
//        $display .= html_writer::end_tag('p');
//        $display .= $OUTPUT->box_end();
//    }
//
//
////close the box
//    $display .= $OUTPUT->box_end();

    if ($return) {
        return $display;
    } else {
        echo $display;
    }
}