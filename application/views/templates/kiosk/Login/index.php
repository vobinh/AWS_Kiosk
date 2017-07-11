<!DOCTYPE html>
<html lang="en">
    <!-- HEADER -->
    <?php include('Header/header.php'); ?>
    <!-- END HEADER -->

    <!-- BODY -->
    <body class="login">
        <div class="page-quick">
            <div class="page-quick-wap">
                
            </div>
        </div>
        <div class="menu-toggler sidebar-toggler"></div>

        <!-- PAGE CONTENT -->
        <?php include('Content/content.php'); ?>
        <!-- END PAGE CONTENT -->

        <!-- JAVASCRIPTS -->
        <script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js"></script>
        <script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->site['base_url'] ?>plugins/global/scripts/kiosk.js" type="text/javascript"></script>
        <script src="<?php echo $this->site['theme_url']?>layout/scripts/layout.js" type="text/javascript"></script>
        <script src="<?php echo $this->site['theme_url']?>layout/scripts/demo.js" type="text/javascript"></script>
        <script src="<?php echo $this->site['theme_url']?>pages/scripts/login-soft.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/ckeditor.4.6/ckeditor.js"></script>
        <script>
            function toogleQuick(){
                $('body').toggleClass('page-quick-open'); 
            }

            function getTimeZone() {
                var offset = new Date().getTimezoneOffset(), o = Math.abs(offset);
                return (offset < 0 ? "+" : "-") + ("00" + Math.floor(o / 60)).slice(-2) + ":" + ("00" + (o % 60)).slice(-2);
            }

            jQuery(document).ready(function() {
                var sTime = '<?php echo $this->clientTimeZone ?>';
                var lTime = getTimeZone();
                if(sTime.length == 0 || sTime != lTime){
                    $.ajax({
                        type: "post",
                        url: "<?php url::base() ?>login/setTimeZone",
                        data: { 'timeZone': lTime },
                        success: function(){
                            location.reload();
                        }
                    });
                }
                Kiosk.init();
                Layout.init();
                Login.init();
                Demo.init();
                $(document).on('click', '.toggle-page-quick', function(event) {
                    event.preventDefault();
                    toogleQuick();
                });
                $.backstretch([
                    "<?php echo $this->site['theme_url']?>pages/media/bg/1.jpg"
                    ], {
                      fade: 1000,
                      duration: 8000
                });
                <?php echo !empty($jsreadyKiosk)?$jsreadyKiosk:''; ?>
            });
        </script>
        <?php echo !empty($jsKiosk)?$jsKiosk:''; ?>
        <!-- END JAVASCRIPTS -->
    </body>
    <!-- END BODY -->
</html>