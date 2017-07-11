<div class="page-header navbar navbar-fixed-top">
        <?php $page_main_title = !empty($this->sess_cus['sltLocation'])?base64_decode($this->sess_cus['sltLocation']):'Application Management Console'; ?>
        <div class="page-main-title" title="<?php echo $page_main_title; ?>">
            <?php echo $page_main_title; ?>
        </div>
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner">
            <div class="page-logo"></div>
            <div class="hor-menu hidden-sm hidden-xs">
                <ul class="nav navbar-nav">
                    <li class="cls-active cls-customers active">
                        <a href="<?php echo url::base() ?>admin_customers">
                            Customers
                        </a>
                    </li>
                    <li class="cls-active cls-administrators">
                        <a href="<?php echo url::base() ?>admin_administrators">
                            Administrators
                        </a>
                    </li>
                    <li class="cls-active cls-options">
                        <a href="<?php echo url::base() ?>admin_options">
                            Default Settings
                        </a>
                    </li>
                </ul>
            </div>
            <!-- END HORIZANTAL MENU -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="logo user" width="29px" height="29px" class="img-circle" src="<?php echo !empty($this->sess_admin['file_id'])?$this->hostGetImg .'?files_id='.$this->sess_admin['file_id']:$this->site['theme_url'].'pages/img/avatar.png' ?>"/>
                        <span class="username username-hide-on-mobile">
                            <?php echo !empty($this->sess_admin['super_name'])?$this->sess_admin['super_name']:''; ?> 
                        </span>
                        <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="<?php echo url::base() ?>admin_administrators/myprofile">
                                <i class="icon-user"></i> My Profile </a>
                            </li>
                            <li class="divider">
                            </li>
                            <li>
                                <a href="<?php echo url::base() ?>admin_login/logout">
                                <i class="icon-key"></i> Log Out </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END HEADER INNER -->
    </div>