<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Add New Employees'; ?>
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form id="frm-employees" action="<?php echo url::base() ?>employees/save" method="post" class="form-horizontal">
				<div class="form-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label style="font-size: 12px;color: red;" class="control-label col-lg-12" style="text-align: right;">
									<i style="font-size: 10px;" class="fa fa-asterisk" aria-hidden="true"></i> Required field
								</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-lg-4 col-md-5" style="text-align: left;">Unique Employee No.</label>
								<div class="col-lg-8 col-md-7 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_empl_no" class="form-control input-sm intOnly" value="<?php echo !empty($data['access_no'])?$data['access_no']:''; ?>" placeholder="">
									</div>
									<div class="customers-error">
										<span style='display: block;' class="cus-help-block">Employee number must be unique. <span class="data-code"></span> already exists. </span>
										<button type="button" class="btn btn-sm green" onclick="nextCode()">Fix Invalid Values</button>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-4 col-md-5 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_empl_first_name" value="<?php echo !empty($data['first_name'])?$data['first_name']:''; ?>" class="form-control input-sm input-one" placeholder="First">
									</div>
								</div>
								<div class="col-lg-8 col-md-7 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_empl_last_name" value="<?php echo !empty($data['name'])?$data['name']:''; ?>" class="form-control input-sm" placeholder="Last">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12 in-group">
									<input type="text" name="txt_empl_address" value="<?php echo !empty($data['address'])?$data['address']:''; ?>" class="form-control input-sm" placeholder="Street Address">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12 in-group">
									<input type="text" name="txt_empl_address2" value="<?php echo !empty($data['address2'])?$data['address2']:''; ?>" class="form-control input-sm" placeholder="Street Address 2">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 in-group">
									<input type="text" name="txt_empl_city" value="<?php echo !empty($data['city'])?$data['city']:''; ?>" class="form-control input-sm input-one" placeholder="City">
								</div>
								<div class="col-md-6 in-group">
									<input type="text" name="txt_empl_state" value="<?php echo !empty($data['state'])?$data['state']:''; ?>" class="form-control input-sm" placeholder="State / Province">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 in-group">
									<input type="text" name="txt_empl_zip" value="<?php echo !empty($data['zip'])?$data['zip']:''; ?>" class="form-control input-sm input-one intOnly" placeholder="Postal / Zip Code">
								</div>
								<div class="col-md-6">
									<select name="txt_empl_country" class="form-control input-sm">
										<option <?php echo (!empty($data['country']) && $data['country'] == 'USA')?'selected':''; ?>  value="USA">USA</option>
										<option <?php echo (!empty($data['country']) && $data['country'] == 'UK')?'selected':''; ?> value="UK">UK</option>
										<option <?php echo (!empty($data['country']) && $data['country'] == 'France')?'selected':''; ?> value="France">France</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6">
									<div style="float: left;width: 30%;display:none">
										<input  name="txt_empl_code_phone" type="text" value="<?php echo !empty($data['area_code'])?$data['area_code']:''; ?>" class="form-control input-sm input-one" placeholder="Area Code">
									</div>
									<span style="float: left;width:5%;text-align: center;line-height: 28px;display:none"><b>-</b></span>
									<div style="float: left;width:100%;" class="in-group">
										<input  name="txt_empl_phone" type="text" value="<?php echo !empty($data['phone'])?$data['phone']:''; ?>" class="form-control input-sm input-one" placeholder="Phone Number">
									</div>
								</div>
								<div class="col-md-6 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_empl_email" value="<?php echo !empty($data['email'])?$data['email']:''; ?>" class="form-control input-sm" placeholder="E-mail address">
									</div>
									<input type="hidden" name="txt_date_add" value="<?php echo !empty($data['tdDate'])?$data['tdDate']:date('m/d/Y'); ?>">
								</div>
							</div>
						</div>
						<!--/span-->
						<div class="col-md-6">
							<div class="form-group">
								<div class="col-md-12">
									<textarea class="form-control" name="txt_empl_note" rows="3" placeholder="Notes"><?php echo !empty($data['note'])?$data['note']:''; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12 in-group">
									<span style="font-size: 16px;padding-bottom: 5px;display: inline-block;">Employee Login PIN</span>
									<input type="password" name="txt_empl_pin" value="" class="form-control input-sm intOnly" placeholder="Enter the PIN that the employee will use to log in.">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12 in-group">
									<span style="font-size: 16px;padding-bottom: 5px;display: inline-block;">Barcode</span>
									<div class="input-group">
								      	<input type="text" class="form-control input-sm intOnly" name="txt_empl_barcode" value="<?php echo !empty($data['barcode'])?$data['barcode']:''; ?>" placeholder="Barcode">
								      	<span class="input-group-btn">
								        	<button class="btn btn-sm green btn-generate" type="button">Generate</button>
								      	</span>
								    </div>
								</div>
							</div>
							<?php if(!empty($this->sess_cus['admin_level']) && $this->sess_cus['admin_level'] == 1 && !empty($this->sess_cus['storeId']) && base64_decode($this->sess_cus['storeId']) == '0'){ ?>
								<div class="form-group">
									<div class="col-md-6">
										<span style="font-size: 16px;padding-bottom: 5px;display: inline-block;">Store</span>
										<select name="txt_empl_store" class="form-control input-sm txt_empl_store">
											<option value="">Please select store</option>
											<?php if(!empty($store)){ foreach ($store as $key => $st) { ?>
												<option <?php echo (!empty($data['store_id']) && $data['store_id'] == $st['store_id'])?'selected':''; ?> <?php echo (!empty($data['store_id']) && $data['store_id'] != $st['store_id'])?'disabled':'' ?> value="<?php echo $st['store_id'] ?>"><?php echo $st['store']; ?></option>
											<?php }} ?>
										</select>
									</div>
								</div>
							<?php } ?>
							<div class="form-group">
								<div class="col-md-12 in-group">
									<span style="font-size: 16px;display: block;">
										Device Access Permission
									</span>
									<span style="font-size: 12px;padding-bottom: 5px;display: block;">
										Determine which actions the employee can perform while clocked in:
									</span>
									<span style="display: block;">
										<input type="checkbox" class="chk_level level_1" value="1"> Toggle between Kiosk and POS
									</span>
									<span style="display: block;">
										<input type="checkbox" class="chk_level level_3" value="3"> Close application
									</span>
									<span style="display: block;">
										<input type="checkbox" class="chk_level level_5" value="5"> Access device management panel
									</span>
								</div>
							</div>
						</div>
						<!--/span-->
					</div>
					<!--/row-->
				</div>
				<div class="form-actions right">
					<input type="hidden" name="txt_hd_id" value="<?php echo !empty($data['access_id'])?$data['access_id']:''; ?>">
					<input type="hidden" id="txt_access_no" value="<?php echo !empty($data['access_no'])?$data['access_no']:''; ?>">
					<input type="hidden" id="txt_access_store" value="<?php echo !empty($data['store_id'])?$data['store_id']:''; ?>">
					<input type="hidden" id="txt_empl_level" name="txt_empl_level" value="<?php echo !empty($data['level'])?$data['level']:'0'; ?>">
					<?php $role = $this->mPrivileges; 
					if($role == 'FullAccess' || (is_array($role) && substr($role['employees_employees'], -1) == '1')): ?>
						<button style="min-width: 150px;" type="submit" class="btn green">Save</button>
					<?php else: ?>
						<button style="min-width: 150px;" type="button" class="btn green" disabled>Save (Read only)</button>
					<?php endif ?>
					<button style="min-width: 150px;" type="button" class="btn default toggle-page-quick">Cancel</button>
				</div>
			</form>
			<!-- END FORM-->
		</div>
	</div>
</div>
<script type="text/javascript">
	_init_load_frmemployees();
	$(document).ready(function() {
		Kiosk.initUniform('.chk_level');
		var _level = '<?php echo !empty($data["level"])?$data["level"]:0; ?>';
		switch(parseInt(_level)) {
		    case 1:
		        $('.level_1').prop('checked',true);
		        $('.level_3').prop('checked',false);
		        $('.level_5').prop('checked',false);
		        break;
		    case 3:
		        $('.level_1').prop('checked',false);
		        $('.level_3').prop('checked',true);
		        $('.level_5').prop('checked',false);
		        break;
		    case 4:
		       	$('.level_1').prop('checked',true);
		        $('.level_3').prop('checked',true);
		        $('.level_5').prop('checked',false);
		        break;
		    case 5:
		        $('.level_1').prop('checked',false);
		        $('.level_3').prop('checked',false);
		        $('.level_5').prop('checked',true);
		        break;
		    case 6:
		        $('.level_1').prop('checked',true);
		        $('.level_3').prop('checked',false);
		        $('.level_5').prop('checked',true);
		        break;
		    case 8:
		        $('.level_1').prop('checked',false);
		        $('.level_3').prop('checked',true);
		        $('.level_5').prop('checked',true);
		        break;
		    case 9:
		        $('.level_1').prop('checked',true);
		        $('.level_3').prop('checked',true);
		        $('.level_5').prop('checked',true);
		        break;
		    default:
		        $('.level_1').prop('checked',false);
		        $('.level_3').prop('checked',false);
		        $('.level_5').prop('checked',false);
		}
		Kiosk.updateUniform('.chk_level');

		$('.chk_level').click(function(event) {
			var _total = 0;
			$(".chk_level").each(function(index) {
				if($(this).is(':checked')){
					_total += parseInt($(this).val());
				}
			});
			$('#txt_empl_level').val(_total);
		});
	});
	<?php if($role == 'NoAccess' || (is_array($role) && substr($role['employees_employees'], -1) == '0')){ ?>
		$(document).ready(function() {
			$('#frm-employees').attr('action', 'javascript:void(0);');
		});
	<?php } ?>
</script>