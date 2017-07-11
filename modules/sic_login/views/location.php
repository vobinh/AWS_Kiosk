<div class="content" id="wap-login">
    <form id="frmLocation" class="login-form">
        <h3 class="form-title-location">POS System</h3>
        <h3 class="form-title-location">Management Panel</h3>
        <h3 class="form-title-location-name">
            Welcome, <?php echo $this->sess_cus['admin_first_name'],' ',$this->sess_cus['admin_name'] ?>
        </h3>
        <h3 class="form-title-location">Select your location</h3>
        <div class="form-actions">
            <div class="form-group">
                <a type="button" href="<?php echo url::base() ?>login/option/<?php echo base64_encode('Addministrator') ?>" class="btn blue" style="min-width: 100%;">
                    Administrator Panel
                </a>
                <span style="display: block;text-align: center;color: #fff;">
                    Log into administrator panel to manage stores, authenticated users, and central warehouse.
                </span>
            </div>
            <div class="form-group">
                <a type="button" href="<?php echo url::base() ?>login/option/<?php echo base64_encode('Store') ?>" class="btn blue" style="min-width: 100%;">
                    Store Management
                </a>
               <span style="display: block;text-align: center;color: #fff;">
                    Log into associated stores' management panels with full administrator privileges.
                </span>
            </div>
            
        </div>
        <div class="create-account" style="overflow: hidden;">
            <a type="button" href="<?php echo url::base()  ?>login/logout" class="btn btn-sm default dark-stripe pull-right">Log Out</a>
        </div>
    </form>
</div>