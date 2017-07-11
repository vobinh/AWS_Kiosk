<div class="col-md-3 left_col menu_fixed">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
    <a href="<?php echo url::base() ?>login" class="site_title"><i class="fa fa-paw"></i> <span>Kiosk!</span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <div class="profile_pic">
        <img src="<?php echo $this->site['theme_url']?>images/user.png" alt="..." class="img-circle profile_img">
      </div>
      <div class="profile_info">
        <span>Welcome,</span>
        <h2><?php echo $this->sess_cus['name']; ?></h2>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    	<div class="menu_section">
    	<h3></h3>
    		<ul class="nav side-menu">
    			<li><a class="current-page" href="<?php echo url::base() ?>"><i class="fa fa-home"></i> <?php echo Kohana::lang('menu_lang.lbl_dashboard') ?></a></li>
    			<li><a><i class="fa fa-th-list"></i> <?php echo Kohana::lang('menu_lang.lbl_catalogs') ?> <span class="fa fa-chevron-down"></span></a>
    				<ul class="nav child_menu">
    					<li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_catalog') ?></a></li>
    					<li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_category') ?></a></li>
    					<li><a><?php echo Kohana::lang('menu_lang.lbl_inventory') ?><span class="fa fa-chevron-down"></span></a>
    						<ul class="nav child_menu">
    							<li class="sub_menu"><a href="#"><?php echo Kohana::lang('menu_lang.lbl_v_current') ?></a></li>
    							<li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_v_s_inventory') ?></a></li>
    							<li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_m_inventory') ?></a></li>
    							<li><a><?php echo Kohana::lang('menu_lang.lbl_order') ?><span class="fa fa-chevron-down"></span></a>
    								<ul class="nav child_menu">
    									<li class="sub_menu"><a href="#"><?php echo Kohana::lang('menu_lang.lbl_create') ?></a></li>
    									<li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_view') ?></a></li>
    									<li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_receive') ?></a></li>
    								</ul>
    							</li>
    							<li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_e_management') ?></a></li>
    						</ul>
    					</li>
    				</ul>
    			</li>
    			<li><a><i class="fa fa-users"></i> <?php echo Kohana::lang('menu_lang.lbl_employees') ?> <span class="fa fa-chevron-down"></span></a>
    				<ul class="nav child_menu">
    					<li><a href=""><?php echo Kohana::lang('menu_lang.lbl_employees') ?></a></li>
    					<li><a href=""><?php echo Kohana::lang('menu_lang.lbl_e_schedule') ?></a></li>
    					<li><a href=""><?php echo Kohana::lang('menu_lang.lbl_a_permissions') ?></a></li>
    				</ul>
    			</li>
    			<li><a><i class="fa fa-support"></i> <?php echo Kohana::lang('menu_lang.lbl_help') ?> <span class="fa fa-chevron-down"></span></a>
    				<ul class="nav child_menu">
    					<li><a href=""><?php echo Kohana::lang('menu_lang.lbl_manual') ?></a></li>
    					<li><a href=""><?php echo Kohana::lang('menu_lang.lbl_r_support') ?></a></li>
    				</ul>
    			</li>
    			<li><a><i class="fa fa-line-chart"></i> <?php echo Kohana::lang('menu_lang.lbl_marketing') ?> <span class="fa fa-chevron-down"></span></a>
    				<ul class="nav child_menu">
    					<li><a href=""><?php echo Kohana::lang('menu_lang.lbl_discount') ?></a></li>
    					<li><a href=""><?php echo Kohana::lang('menu_lang.lbl_r_program') ?></a></li>
    					<li><a href=""><?php echo Kohana::lang('menu_lang.lbl_email') ?></a></li>
    				</ul>
    			</li>
    			<li><a><i class="fa fa-newspaper-o"></i> <?php echo Kohana::lang('menu_lang.lbl_reports') ?> <span class="fa fa-chevron-down"></span></a>
    				<ul class="nav child_menu">
    					<li><a href=""><?php echo Kohana::lang('menu_lang.lbl_sales') ?></a></li>
    					<li><a href=""><?php echo Kohana::lang('menu_lang.lbl_products') ?></a></li>
    					<li><a href=""><?php echo Kohana::lang('menu_lang.lbl_customers') ?></a></li>
    					<li><a href=""><?php echo Kohana::lang('menu_lang.lbl_employees') ?></a></li>
    					<li><a href=""><?php echo Kohana::lang('menu_lang.lbl_admin') ?></a></li>
    				</ul>
    			</li>
    			<li><a><i class="fa fa-institution"></i> WareHouse <span class="fa fa-chevron-down"></span></a>
    				<ul class="nav child_menu">
    					<li><a href="">Inventory</a></li>
    					<li><a><?php echo Kohana::lang('menu_lang.lbl_order') ?><span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li class="sub_menu"><a href="#"><?php echo Kohana::lang('menu_lang.lbl_create') ?></a></li>
                                <li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_view') ?></a></li>
                                <li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_receive') ?></a></li>
                            </ul>
                        </li>
                        <li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_categories') ?></a></li>
                        <li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_e_management') ?></a></li>
    				</ul>
    			</li>
    			<li><a><i class="fa fa-users"></i> <?php echo Kohana::lang('menu_lang.lbl_customers') ?> <span class="fa fa-chevron-down"></span></a>
    				<ul class="nav child_menu">
    					<li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_customers') ?></a></li>
    					<li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_groups') ?></a></li>
    				</ul>
    			</li>
    			<li><a><i class="fa fa-bar-chart-o"></i> <?php echo Kohana::lang('menu_lang.lbl_accounting') ?> <span class="fa fa-chevron-down"></span></a>
    				<ul class="nav child_menu">
    					<li><a><?php echo Kohana::lang('menu_lang.lbl_reconciliations') ?><span class="fa fa-chevron-down"></span></a>
    						<ul class="nav child_menu">
    							<li class="sub_menu"><a href="#"><?php echo Kohana::lang('menu_lang.lbl_cashbox') ?></a></li>
    							<li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_dispenser') ?></a></li>
    						</ul>
    					</li>
    					<li><a><?php echo Kohana::lang('menu_lang.lbl_reimbursements') ?><span class="fa fa-chevron-down"></span></a>
    						<ul class="nav child_menu">
    							<li class="sub_menu"><a href="#"><?php echo Kohana::lang('menu_lang.lbl_cash') ?></a></li>
    							<li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_m_account') ?></a></li>
    						</ul>
    					</li>
    				</ul>
    			</li>
    			<li><a><i class="fa fa-cogs"></i> <?php echo Kohana::lang('menu_lang.lbl_settings') ?> <span class="fa fa-chevron-down"></span></a>
    				<ul class="nav child_menu">
    					<li><a><?php echo Kohana::lang('menu_lang.lbl_s_settings') ?><span class="fa fa-chevron-down"></span></a>
    						<ul class="nav child_menu">
    							<li class="sub_menu"><a href="#"><?php echo Kohana::lang('menu_lang.lbl_location') ?></a></li>
    							<li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_payment') ?></a></li>
    							<li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_tax') ?></a></li>
    						</ul>
    					</li>
    					<li><a><?php echo Kohana::lang('menu_lang.lbl_station_settings') ?><span class="fa fa-chevron-down"></span></a>
    						<ul class="nav child_menu">
    							<li class="sub_menu"><a href="#"><?php echo Kohana::lang('menu_lang.lbl_devices') ?></a></li>
    							<li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_sycn') ?></a></li>
    							<li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_api') ?></a></li>
    						</ul>
    					</li>
    					<li><a><?php echo Kohana::lang('menu_lang.lbl_import_export') ?> <span class="fa fa-chevron-down"></span></a>
    						<ul class="nav child_menu">
    							<li class="sub_menu"><a href="#"><?php echo Kohana::lang('menu_lang.lbl_catalogs') ?></a></li>
    							<li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_customers') ?></a></li>
    							<li><a href="#"><?php echo Kohana::lang('menu_lang.lbl_employees') ?></a></li>
    						</ul>
    					</li>
    				</ul>
    			</li>
    		</ul>
    	</div>
    </div>
      <!-- /sidebar menu -->

      <!-- /menu footer buttons -->
      <div class="sidebar-footer hidden-small">
		<div style="overflow: hidden;width: 100%;background: #172D44;text-align: right;">
			<a style="float: right;" href="<?php echo url::base()  ?>login/logout" data-toggle="tooltip" data-placement="top" title="Logout">
				<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
			</a>
		</div>
      </div>
      <!-- /menu footer buttons -->
    </div>
  </div>