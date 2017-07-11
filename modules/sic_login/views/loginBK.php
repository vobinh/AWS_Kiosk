<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $this->site['site_title']?><?php echo !empty($this->site['site_slogan'])?' | '.$this->site['site_slogan']:''?></title>

    <!-- Bootstrap -->
    <link href="<?php echo $this->site['base_url'] ?>plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo $this->site['base_url'] ?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo $this->site['base_url'] ?>plugins/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo $this->site['base_url'] ?>plugins/animate.css/animate.min.css" rel="stylesheet">
    <link href="<?php echo $this->site['base_url'] ?>plugins/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="<?php echo $this->site['base_url'] ?>plugins/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="<?php echo $this->site['base_url'] ?>plugins/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo $this->site['theme_url']?>css/custom.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
          <form name="frmLogin" id="frmLogin" action="<?php echo url::base() ?>login/sm_login" method="post" novalidate>
              <h1>Login Form</h1>
              <div class="form-login">
                <input type="email" class="form-control" name="txt_email" placeholder="Email" data-validate-linked="email" required="required" />
              </div>
              <div class="form-login">
                <input type="password" class="form-control" name="txt_pass" placeholder="Password" required="required" />
              </div>
              <div>
                <button class="btn btn-default submit" type="submit">Log in</button>
                <a class="reset_pass" href="#">Lost your password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> <?php echo $this->site['site_name'] ?></h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form>
              <h1>Create Account</h1>
              <div class="form-login">
                <input type="text" class="form-control" placeholder="Username" required="" />
              </div>
              <div class="form-login">
                <input type="email" class="form-control" placeholder="Email" required="" />
              </div>
              <div class="form-login">
                <input type="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <a class="btn btn-default submit" href="index.html">Submit</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> <?php echo $this->site['site_name'] ?></h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
    <!-- jQuery -->
    <script src="<?php echo $this->site['base_url'] ?>plugins/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo $this->site['base_url'] ?>plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo $this->site['base_url'] ?>plugins/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo $this->site['base_url'] ?>plugins/nprogress/nprogress.js"></script>
    <!-- validator -->
    <script src="<?php echo $this->site['base_url'] ?>plugins/validator/jquery.validate.min.js"></script>
    <script src="<?php echo $this->site['base_url'] ?>plugins/validator/additional-methods.min.js"></script>
    <!-- PNotify -->
    <script src="<?php echo $this->site['base_url'] ?>plugins/pnotify/dist/pnotify.js"></script>
    <script src="<?php echo $this->site['base_url'] ?>plugins/pnotify/dist/pnotify.buttons.js"></script>
    <script src="<?php echo $this->site['base_url'] ?>plugins/pnotify/dist/pnotify.nonblock.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo $this->site['theme_url']?>js/custom.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {   
            var frmLogin = $('#frmLogin');
            frmLogin.validate({
                errorElement: 'span',
                errorClass: 'help-block help-block-error',
                focusInvalid: true,
                ignore: "",
                messages: {
                    select_multi: {
                        maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                        minlength: jQuery.validator.format("At least {0} items must be selected")
                    }
                },
                rules: {
                    txt_email: {
                        required: true,
                        email: true
                    },
                    txt_pass: {
                        required: true
                    },
                },
                highlight: function (element) {
                    $(element)
                        .closest('.form-login').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element)
                        .closest('.form-login').removeClass('has-error');
                },
                success: function (label) {
                    label
                        .closest('.form-login').removeClass('has-error');
                },submitHandler: function (form) {}
            });

            $('#frmLogin').submit(function(e){
                e.preventDefault();
                var $form = $(this);
                if(! $form.valid()) return false;
                NProgress.start();
                $.ajax({
                    url: this.action,
                    type: this.method,
                    dataType: 'json',
                    data: $form.serialize(),
                })
                .done(function(data) {
                    if(data.msc){
                        window.location.href = '<?php echo url::base() ?>';
                        NProgress.done();
                    }else{
                        new PNotify({
                            title: 'Login failed',
                            text: 'Please check your e-mail and password.',
                            type: 'error',
                            hide: true,
                            delay: 3000,
                            styling: 'bootstrap3'
                        });
                        NProgress.done();
                    }
                })
                .fail(function() {
                    new PNotify({
                        title: 'Login failed',
                        text: 'Could not complete request. Please check your internet connection',
                        hide: true,
                        delay: 3000,
                        styling: 'bootstrap3'
                    });
                    NProgress.done();
                });
            });
        });
    </script>
  </body>
</html>
