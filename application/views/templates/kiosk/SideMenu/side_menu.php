<style type="text/css">
    .adminPanel:hover{ color: #d5dce4;background: #3f4f62 !important; }
    .adminPanel:focus{ background: none !important; }
</style>
<div class="page-header navbar navbar-fixed-top">
        <?php $page_main_title = !empty($this->sess_cus['sltLocation'])?base64_decode($this->sess_cus['sltLocation']):'Dashboard'; ?>
        <div class="page-main-title" title="<?php echo $page_main_title; ?>">
            <?php echo $page_main_title; ?>
        </div>
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner">
            <div class="page-logo"></div>
            <div class="hor-menu hidden-sm hidden-xs">
                <ul class="nav navbar-nav">
                    <li class="classic-menu-dropdown cls-active cls-home">
                        <a href="<?php echo url::base() ?>">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <?php if(!empty($this->sess_cus['admin_id']) && $this->sess_cus['admin_id'] == $this->sess_cus['admin_refer_id'] && empty($thiss->sess_cus['store_id'])): ?>
                    <li class="cls-store cls-active">
                        <a href="<?php echo url::base() ?>store">
                            Store Management
                        </a>
                    </li>
                    <?php endif ?>
                    <li class="cls-customers cls-active">
                        <a href="<?php echo url::base() ?>customers">
                            Customers
                        </a>
                    </li>
                    <li class="cls-accounting cls-active">
                        <a href="<?php echo url::base() ?>accounting">
                            Accounting
                        </a>
                    </li>
                     <?php if(!empty($this->sess_cus['admin_level']) && !empty($this->sess_cus['storeId']) && base64_decode($this->sess_cus['storeId']) != '0'): ?>
                    <li class="cls-catalogs cls-active">
                        <a href="<?php echo url::base() ?>catalogs">
                            Operations
                        </a>
                    </li>
                     <?php endif ?>
                    <?php if(!empty($this->sess_cus['admin_level']) && $this->sess_cus['admin_level'] == 1 && !empty($this->sess_cus['storeId']) && base64_decode($this->sess_cus['storeId']) == '0'): ?>
                    <li class="cls-warehouse cls-active">
                        <a href="/warehouse">
                            Warehouse
                        </a>
                    </li>
                    <?php endif ?>
            		<?php /* ?>
                        <li class="cls-marketing cls-active">
                            <a href="<?php echo url::base() ?>marketing">
                                Marketing
                            </a>
                        </li>
            		<?php */ ?>

                    <li class="cls-reports cls-active">
                        <a href="<?php echo url::base() ?>reports">
                            Reports
                        </a>
                    </li>
                    <li class="cls-employees cls-active">
                        <a href="<?php echo url::base() ?>employees">
                            Employees
                        </a>
                    </li>
                    <li class="cls-settings cls-active">
                        <a href="<?php echo url::base() ?>settings">
                            Settings
                        </a>
                    </li>
                    <!-- <li class="cls-help cls-active">
                        <a href="#">
                            Help
                        </a>
                    </li>
                    <li class="cls-remarks cls-active">
                        <a href="#">
                            Remarks
                        </a>
                    </li> -->
                </ul>
            </div>
            <!-- END HORIZANTAL MENU -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN GO TO STORE -->
                    <?php if(!empty($this->sess_cus['admin_level']) && (string)$this->sess_cus['admin_level'] == '1'): ?>
                    <?php 
                        $storeSlt = base64_decode($this->sess_cus['storeId']);
                        $this->db->select('store_id', 'store');
                        $this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
                        $this->db->where('status', 1);
                        $mrStore = $this->db->get('store')->result_array(false); 
                        if((string)$storeSlt != '0'): ?>
                            <li class="dropdown-user">
                                <a style="color: #c6cfda;" class="dropdown-toggle adminPanel" href="<?php echo url::base() ?>home/gotoStore/QWRkbWluaXN0cmF0b3I=">Admin Panel</a>
                            </li>
                        <?php endif ?>
                        <?php if(!empty($mrStore)): ?>
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <span class="username">
                                    <i class="fa fa-bank"></i> Store
                                </span>
                                <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <?php foreach ($mrStore as $key => $value): ?>
                                        <li>
                                            <a <?php if(!empty($value['store_id']) && $value['store_id'] == $storeSlt): ?> style="background-color: #ddd;overflow: hidden;text-overflow: ellipsis;" <?php else: ?> style="overflow: hidden;text-overflow: ellipsis;" <?php endif ?> href="<?php echo url::base() ?>home/gotoStore/<?php echo !empty($value['store_id'])?$value['store_id']:'' ?>">
                                            <i class="fa fa-angle-double-right"></i> <?php echo !empty($value['store'])?$value['store'].' ':'' ?></a>
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                            </li> 
                        <?php endif ?>
                    <?php endif ?>
                    <!-- END GO TO STORE -->
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="logo user" width="29px" height="29px" class="img-circle" src="<?php echo !empty($this->sess_cus['file_id'])?$this->hostGetImg .'?files_id='.$this->sess_cus['file_id']:$this->site['theme_url'].'pages/img/avatar.png' ?>"/>
                        <span class="username username-hide-on-mobile">
                            <?php echo !empty($this->sess_cus['admin_first_name'])?$this->sess_cus['admin_first_name']:''; ?>&nbsp;<?php echo !empty($this->sess_cus['admin_name'])?$this->sess_cus['admin_name']:''; ?> 
                        </span>
                        <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="<?php echo url::base() ?>myprofile">
                                <i class="icon-user"></i> My Profile </a>
                            </li>
                            <li class="divider">
                            </li>
                            <li>
                                <a href="<?php echo url::base() ?>login/logout">
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