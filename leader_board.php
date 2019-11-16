<?php
//// File: /mod/mymodulename/view.php
//require_once('../../config.php');
////$cmid = required_param('id', PARAM_INT);
//$cm = get_coursemodule_from_id('weplay', $cmid, 0, false, MUST_EXIST);
//$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
//
//require_login($course, true, $cm);
//$PAGE->set_url('/blocks/weplay/leader_board.php'/*, array('id' => $cm->id)*/);
//$PAGE->set_title('My modules page title');
//$PAGE->set_heading('My modules page heading');


require_once('../../config.php');
global $DB, $OUTPUT, $PAGE, $CFG;

$PAGE->set_context(get_system_context());
$PAGE->set_pagelayout('incourse');
$PAGE->set_title("Leader Board page");
$PAGE->set_heading("Leaderboard");
$PAGE->set_url($CFG->wwwroot . '/blocks/weplay/leader_board.php');


echo $OUTPUT->header();

$html = html_writer::start_tag('div', ['class' => 'progress mt-3']);
$html .= html_writer::tag('div', '', ['class' => 'progress-bar', 'role' => 'progressbar', 'style' => 'width: 25%', 'aria-valuenow' => 25, 'aria-valuemin' => 0, 'aria-valuemax' => 100]);
$html .= html_writer::end_tag('div');
$html .= html_writer::tag('div', html_writer::tag('p', '25 points achieved'), ['class' => 'text-center']);

$html1 = html_writer::start_tag('div', ['class' => 'progress mt-3']);
$html1 .= html_writer::tag('div', '', ['class' => 'progress-bar', 'role' => 'progressbar', 'style' => 'width: 33%', 'aria-valuenow' => 33, 'aria-valuemin' => 0, 'aria-valuemax' => 100]);
$html1 .= html_writer::end_tag('div');
$html1 .= html_writer::tag('div', html_writer::tag('p', '33 points achieved'), ['class' => 'text-center']);

$html2 = html_writer::start_tag('div', ['class' => 'progress mt-3']);
$html2 .= html_writer::tag('div', '', ['class' => 'progress-bar', 'role' => 'progressbar', 'style' => 'width: 75%', 'aria-valuenow' => 75, 'aria-valuemin' => 0, 'aria-valuemax' => 100]);
$html2 .= html_writer::end_tag('div');
$html2 .= html_writer::tag('div', html_writer::tag('p', '75 points achieved'), ['class' => 'text-center']);

// Actual content goes here
echo '
<div class="leaderboard we-play">
<ul class="nav nav-tabs mb-3">
  <li class="nav-item"><a class="nav-link text-center" href="http://localhost/blocks/weplay/avatar.php?courseid=5">
  <i class="fa fa-user-circle-o" aria-hidden="true"></i><small> Avatar</small></a></li>
  <li class="nav-item"><a class="nav-link text-center active" href="http://localhost/blocks/weplay/leader_board.php">
  <i class="fa fa-trophy" aria-hidden="true"></i><small> Board</small></a></li>
  <li class="nav-item"><a class="nav-link text-center" href="http://localhost/blocks/weplay/avatar.php?courseid=5">
  <i class="fa fa-history" aria-hidden="true"></i><small> History</small></a></li>
</ul>


<div class="row">
<div class="col-lg-12 col-md-12 col-xs-12">
<div class="table-responsive">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Participant</th>
      <th scope="col">Level</th>
      <th scope="col">Progress</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td><img alt="Image placeholder" class="userpicture" style="width: 50px; height: 50px" src="pix/avatar/batman.jpg"> Batman</td>
      <td><img alt="Image placeholder" class="" src="pix/thumb_level_5.png"></td>
      <td>' . $html2 . '</td>
      <td><i class="fa fa-question-circle pull-right"/></td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td><img alt="Image placeholder" class="userpicture" style="width: 50px; height: 50px"  src="pix/avatar/bugs_bunny.jpg"> Bugs Bunny</td>
      <td><img alt="Image placeholder" class="" src="pix/thumb_level_3.png"></td>
      <td>' . $html1 . '</td>
      <td><i class="fa fa-question-circle pull-right"/></td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td><img alt="Image placeholder" class="userpicture" style="width: 50px; height: 50px"  src="http://localhost/pluginfile.php/5/user/icon/boost/f1?rev=367"> Mr. Cookie Monster</td>
      <td><img alt="Image placeholder" class="" src="pix/thumb_level_1.png"></td>
      <td>' . $html . '</td>
      <td><i class="fa fa-question-circle pull-right" data-togle="tooltip" title="Cookie Monster is a Muppet on the Sesame Street. He is best known for his voracious appetite and his famous eating phrases, such as \"Me want cookie!\"."/></td>
    </tr>
  </tbody>
</table>
</div>
                </div>
                </div>
                </div>
';

echo $OUTPUT->footer();

