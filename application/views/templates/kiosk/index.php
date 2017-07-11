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
<!-- Chart -->
<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/amcharts/amcharts/dataloader.min.js" type="text/javascript"></script>
<!-- END Chart -->
<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>

<script type="text/javascript" src="http://momentjs.com/downloads/moment.js"></script>

<script>
    $(document).ready(function() {  
        window._store_id_scription = "<?php echo base64_decode($this->sess_cus['storeId']) ?>";
    });
</script>
<script>
	jQuery(document).ready(function() {
		$(document).ajaxComplete(function(e, xhr, settings){
		    if(xhr.status === 302){
		        window.location.reload();
		    }
		});
		console.log(new Date().getTimezoneOffset());
		var sTime = '<?php echo $this->clientTimeZone ?>';
        var lTime = getTimeZone();
        if(sTime.length == 0 || sTime != lTime){
        	notification('info','Update Client Time Zone. Waiting...');
        	Kiosk.blockUI();
            $.ajax({
                type: "post",
                url: "<?php url::base() ?>login/setTimeZone",
                data: { 'timeZone': lTime },
                success: function(){
                    location.reload();
                }
            }).always(function() {
            	Kiosk.unblockUI();
            });
            
            
        }

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
		autoLogout.init();
		uploadIMG.init('<?php echo url::base() ?>catalogs/getFrmUpload');

		<?php if($this->session->get('updateTax')){ ?>
			Kiosk.blockUI();
			$.ajax({
				url: '<?php echo url::base() ?>settings/getUpdateTax',
				type: 'GET'
			})
			.done(function(data) {
				$('.page-quick-wap').width('50%').html(data);
				toogleQuick();
				Kiosk.unblockUI();
			})
			.fail(function() {
				Kiosk.unblockUI();
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			});
		<?php } ?>
		
		$(document).on('click', '.toggle-page-quick', function(event) {
			event.preventDefault();
			toogleQuick();
		});

		var _urlActive = '<?php echo $this->uri->segment(1) ?>';
		if(_urlActive != ''){
			$('.cls-active').removeClass('active');
			$('.cls-'+_urlActive).addClass('active');
		}else{
			$('.cls-active').removeClass('active');
			$('.cls-home').addClass('active');
		}

		<?php echo !empty($jsreadyKiosk)?$jsreadyKiosk:''; ?>
	});
	function getTimeZone() {
	  	var offset = new Date().getTimezoneOffset(), o = Math.abs(offset);
	  	return (offset < 0 ? "+" : "-") + ("00" + Math.floor(o / 60)).slice(-2) + ":" + ("00" + (o % 60)).slice(-2);
	}
	var autoLogout = function(){
		var timer;
		var timeoutSession;
		var flag = true;
		function startSessionTimer(){
			clearTimeout(timer);
			timer = setTimeout(function() {
				flag = false;
				$.ajax({
					url: '<?php echo url::base() ?>login/logout',
					type: 'POST',
					data:{
						'auto': true
					},
					dataType: 'json',
				})
				.done(function(data) {
					bootbox.dialog({
			            message: "You were logged out of your account due to inactivity. Please refresh to log in again.",
			            title: "Message",
			            closeButton: false,
			            buttons: {
			            	confirm: {
				                label: "Refresh",
				                className: "green btn-yes",
					            callback: function() {
									window.location = '<?php echo url::base() ?>';
				                }
				            }
			            }
			        });
				})
				.fail(function() {
					$.bootstrapGrowl("Could not complete request.", { 
		            	type: 'danger' 
		            });
				});
                
            }, timeoutSession);
		};

		function deplay(){
			$(document).on('keyup mouseup mousemove touchend touchmove', function(e) {
				if(flag){
					startSessionTimer();
				}
			});
		};

		return {
			init: function(){
				timeoutSession = '<?php echo !empty($this->sess_cus["close_session"])?$this->sess_cus["close_session"]:"15i" ?>';
				if(timeoutSession == 'never'){
					return false;
				}
				var type = timeoutSession.substring(timeoutSession.length - 1);
				var num = timeoutSession.substring(0,timeoutSession.length - 1);
				if(type == 'i'){
					timeoutSession = num * 60000;
				}else{
					timeoutSession = num * (60000 * 60);
				}
				startSessionTimer();
				deplay();
			}
		};
	}();
</script>
<?php echo !empty($jsKiosk)?$jsKiosk:''; ?>

<?php include_once kohana::find_file('views/include', 'inNotifications'); ?>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>