<?php

namespace block_weplay\output;

class content
{
    public function getText()
    {
        return '<nav class="navbar navbar-expand-sm navbar-light bg-light mt-3">

  <button class="navbar-toggler btn btn-light" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fa fa-bars" aria-hidden="true"></i>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link text-center" href="#">
          <i class="fa fa-user-circle-o" aria-hidden="true"></i>
          <small>User</small>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-center" href="#"><i class="fa fa-trophy" aria-hidden="true"></i> 
        <small>Board</small></a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link text-center" href="#"><i class="fa fa-history" aria-hidden="true"></i><small>History</small></a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-center" href="#">
        <i class="fa fa-cog" aria-hidden="true"></i>
        <small>Set</small>
        </a>
      </li>
    </ul>
  </div>
</nav>';
    }

    public function getFooter(){
        return '<img class="mt-3" src="http://www.soniceliteallstars.com/uploads/2/4/9/6/24965304/s716730810348540971_p78_i1_w200.png">
            <div class="progress mt-3">
  <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<div class="text-center"><p>You have achieved 25 points</p></div>';
    }
}