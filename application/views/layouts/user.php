<nav class="nav navbar-nav">
    <ul class=" navbar-right">
        <li class="nav-item dropdown open" style="padding-left: 15px;">
            <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                <img src="<?php base_url() ?>../resources/template/production/images/user.png" alt="">Hai,<?php echo $this->session->userdata('nama'); ?>
            </a>
            <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                <!-- <a class="dropdown-item" href="javascript:;"> Edit Profile</a> -->
                <a class="dropdown-item" href="javascript:;" onclick="edit_password()"><i class="fa fa-gear pull-right"></i> Edit Password</a>
                <!-- <a class="dropdown-item" href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                    </a> -->
                <!-- <a class="dropdown-item" href="javascript:;">Help</a> -->
                <a class="dropdown-item" href="<?php echo base_url('LoginController/logout'); ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
            </div>
        </li>
    </ul>
</nav>