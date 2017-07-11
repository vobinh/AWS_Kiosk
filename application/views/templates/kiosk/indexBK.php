<!DOCTYPE html>
<html lang="en">
  <?php include('Header/header.php'); ?>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <?php include('SideMenu/side_menu.php'); ?>

        <!-- top navigation -->
        <?php include('TopMenu/top_menu.php'); ?>
        <!-- /top navigation -->

        <!-- page content -->
        <?php include('Content/content.php'); ?>
        <!-- /page content -->
        
        <!-- footer content -->
        <?php include('Footer/footer.php'); ?>
        <!-- /footer content -->
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
    <!-- jQuery custom content scroller -->
    <script src="<?php echo $this->site['base_url'] ?>plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
     <!-- validator -->
    <script src="<?php echo $this->site['base_url'] ?>plugins/validator/jquery.validate.min.js"></script>
    <script src="<?php echo $this->site['base_url'] ?>plugins/validator/additional-methods.min.js"></script>
    <!-- PNotify -->
    <script src="<?php echo $this->site['base_url'] ?>plugins/pnotify/dist/pnotify.js"></script>
    <script src="<?php echo $this->site['base_url'] ?>plugins/pnotify/dist/pnotify.buttons.js"></script>
    <script src="<?php echo $this->site['base_url'] ?>plugins/pnotify/dist/pnotify.nonblock.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo $this->site['theme_url']?>js/custom.js"></script>

    <?php echo !empty($jsKiosk)?$jsKiosk:''; ?>
  </body>
</html>