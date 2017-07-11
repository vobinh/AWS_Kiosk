<!DOCTYPE html>
<html lang="en">
	<!-- BEGIN HEAD -->
	<?php include('Header/header.php'); ?>
	<!-- BEGIN HEADER -->

<body class="page-header-fixed page-quick-sidebar-over-content page-full-width">
	<div class="page-quick">
		<div class="page-quick-wap">
			
		</div>
	</div>
	
	<?php include('SideMenu/side_menu.php'); ?>
	<!-- END HEADER -->
	<div class="clearfix"></div>

	<!-- BEGIN CONTAINER -->
	<div class="page-container">
		<!-- BEGIN SIDEBAR -->
		<?php include('SideMenu/side_menu_responsive.php'); ?>
		<!-- END SIDEBAR -->
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<!-- BEGIN PAGE CONTENT-->
				<?php include('Content/content.php'); ?>
				<!-- END PAGE CONTENT-->
			</div>
		</div>
		<!-- END CONTENT -->
	</div>
	<!-- END CONTAINER -->

	<!-- BEGIN FOOTER -->
	<?php include('Footer/footer.php'); ?>
	<!-- END FOOTER -->
<div class="kiosk-dialog" id='' style="display:none;"><div class="page-quick-wap-s"></div></div>

<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script type="text/javascript" src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/select2/select2.min.js"></script>

<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/clockface/js/clockface.js"></script>
<script type="text/javascript" src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js"></script>
<script type="text/javascript" src="http://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/scroller/1.4.2/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/Croppie/croppie.js" type="text/javascript"></script>
<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/Croppie/demo/demoC.js" type="text/javascript"></script>

<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<script src="<?php echo $this->site['base_url'] ?>plugins/global/scripts/kiosk.js" type="text/javascript"></script>
<script src="<?php echo $this->site['theme_url']?>layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo $this->site['theme_url']?>layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo $this->site['theme_url']?>pages/scripts/index.js" type="text/javascript"></script>
<script src="<?php echo $this->site['theme_url']?>pages/scripts/components-dropdowns.js"></script>
<script src="<?php echo $this->site['base_url'] ?>plugins/global/scripts/datatable.js"></script>
<script type="text/javascript" src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script>
	jQuery(document).ready(function() {
		$(document).ajaxComplete(function(e, xhr, settings){
		    if(xhr.status === 302){
		       window.location.reload();
		    }
		});
		$(document).keyup(function(e) {
		  	if (e.keyCode == 27){
		  		var btnMain = $('.toggle-page-quick').last();
		  		if(btnMain.length > 0 && $('.page-quick-open').length > 0 && $('.close-kioskDialog').length <= 0){
		  			$(btnMain).trigger('click');
		  		}else{
		  			var btnDialog = $('.close-kioskDialog:visible').last();
		  			if(btnDialog.length > 0){
		  				$(btnDialog).trigger('click');
		  			}
		  		}
		  	}
		});

	   	Kiosk.init();
		Layout.init();
		ComponentsDropdowns.init();
		uploadIMG.init('<?php echo url::base() ?>admin_administrators/getFrmUpload');

		$(document).on('click', '.toggle-page-quick', function(event) {
			event.preventDefault();
			toogleQuick();
		});

		var _urlActive = '<?php echo $this->uri->segment(1) ?>';
		if(_urlActive != '' && _urlActive == 'admin_customers'){
			$('.cls-active').removeClass('active');
			$('.cls-customers').addClass('active');
		}else if(_urlActive != '' && _urlActive == 'admin_options'){
			$('.cls-active').removeClass('active');
			$('.cls-options').addClass('active');
		}
		else{
			$('.cls-active').removeClass('active');
			$('.cls-administrators').addClass('active');
		}

		<?php echo !empty($jsreadyKiosk)?$jsreadyKiosk:''; ?>
	});
</script>
<?php echo !empty($jsKiosk)?$jsKiosk:''; ?>

<?php include_once kohana::find_file('views/include', 'inNotifications'); ?>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>