<div class="content" id="wap-login">
    <form id="frm-change-pass" action="<?php echo url::base() ?>login/sm_change_pass" method="post">
        <h3 class="form-title-location">POS System</h3>
        <h3 class="form-title-location-name">
            Welcome, <?php echo $this->sess_cus['admin_first_name'], $this->sess_cus['admin_name'] ?>
        </h3>
        <h3 class="form-title-location" style="font-size: 14px;">You are required to change your password before continuing. Please enter your new password.</h3>
        <div class="form-group">
             <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" id="txt_pass" name="txt_pass"/>
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Confirm password" name="txt_pass_confirm"/>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue pull-right" style="min-width: 100px;">
                Confirm
            </button>
        </div>
        <div class="create-account" style="overflow: hidden;">
            <a type="button" href="<?php echo url::base()  ?>login/logout" class="btn btn-sm default dark-stripe pull-right">Log Out</a>
        </div>
    </form>
</div>