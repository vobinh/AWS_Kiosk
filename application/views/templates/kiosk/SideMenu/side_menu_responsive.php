<div class="page-sidebar-wrapper">
	<!-- BEGIN HORIZONTAL RESPONSIVE MENU -->
	<div class="page-sidebar navbar-collapse collapse">
		<ul class="page-sidebar-menu" data-slide-speed="200" data-auto-scroll="true">
			<li class="cls-active cls-home">
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
	<!-- END HORIZONTAL RESPONSIVE MENU -->
</div>