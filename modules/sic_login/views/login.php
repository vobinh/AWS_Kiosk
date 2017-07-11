<div class="content" id="wap-login">
    <!-- BEGIN LOGIN FORM -->
    <form id="frmLogin" class="login-form" action="<?php echo url::base() ?>login/sm_login" method="post">
        <h3 class="form-title">POS System</h3>
        <h3 class="form-title">Management Panel</h3>
          <div class="form-group">
              <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input class="form-control placeholder-no-fix" type="email" autocomplete="off" placeholder="Login e-mail" name="txt_email"/>
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="txt_pass"/>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue pull-right" style="min-width: 100px;">
                Login
            </button>
        </div>
        <div class="create-account">
            <button type="button" class="btn btn-sm default dark-stripe" id="forget-password">Password Reset</button>
            <button type="button" class="btn btn-sm default dark-stripe pull-right" id="btn-support">Contact Support</button>
        </div>
    </form>
    <!-- END LOGIN FORM -->

    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form class="forget-form" action="<?php echo url::base() ?>login/resetPass" method="post">
        <h3>Forget Password ?</h3>
        <p>
           Enter your e-mail address below to reset your password.
       </p>
        <div class="form-group">
            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email"/>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn">Back </button>
            <button type="submit" class="btn blue pull-right">Submit</button>
        </div>
    </form>
    <!-- END FORGOT PASSWORD FORM -->
</div>