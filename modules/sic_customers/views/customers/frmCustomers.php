<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Add New Customer'; ?>
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form id="frm-customers" action="<?php echo url::base() ?>customers/save/<?php echo !empty($type)?$type:1; ?>" method="post" class="form-horizontal">
				<div class="form-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="font-size: 12px;color: red;text-align:right" class="control-label col-lg-12" style="">
									<i style="font-size: 10px;" class="fa fa-asterisk" aria-hidden="true"></i> Required field
								</label>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-4 col-md-5" style="text-align: left;">Unique Customer No.</label>
								<div class="col-lg-8 col-md-7 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_cus_no" class="form-control input-sm intOnly" value="<?php echo !empty($data['tdCust'])?$data['tdCust']:''; ?>" placeholder="">
									</div>
									<div class="customers-error">
										<span style='display: block;' class="cus-help-block">Customer number must be unique. <span class="data-code">123</span> already exists. </span>
										<button type="button" class="btn btn-sm green" onclick="nextCode(<?php echo !empty($type)?$type:1; ?>)">Fix Invalid Values</button>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_cus_first_name" value="<?php echo !empty($data['tdFirstName'])?$data['tdFirstName']:''; ?>" class="form-control input-sm input-one" placeholder="First">
									</div>
								</div>
								<div class="col-md-9 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_cus_last_name" value="<?php echo !empty($data['tdLastName'])?$data['tdLastName']:''; ?>" class="form-control input-sm" placeholder="Last">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_cus_address" value="<?php echo !empty($data['tdAddress'])?$data['tdAddress']:''; ?>" class="form-control input-sm" placeholder="Street Address">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12 in-group">
									<input type="text" name="txt_cus_address2" value="<?php echo !empty($data['tdAddress2'])?$data['tdAddress2']:''; ?>" class="form-control input-sm" placeholder="Street Address 2">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_cus_city" value="<?php echo !empty($data['tdCity'])?$data['tdCity']:''; ?>" class="form-control input-sm input-one" placeholder="City">
									</div>
								</div>
								<div class="col-md-6 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_cus_state" value="<?php echo !empty($data['tdState'])?$data['tdState']:''; ?>" class="form-control input-sm" placeholder="State / Province">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_cus_zip" value="<?php echo !empty($data['tdZip'])?$data['tdZip']:''; ?>" class="form-control input-sm input-one intOnly" placeholder="Postal / Zip Code">
									</div>
								</div>
								<div class="col-md-6">
									<select name="txt_cus_country" class="form-control input-sm">
										<option <?php echo (!empty($data['tdCountry']) && $data['tdCountry'] == 'USA')?'selected':''; ?>  value="USA">USA</option>
										<option <?php echo (!empty($data['tdCountry']) && $data['tdCountry'] == 'UK')?'selected':''; ?> value="UK">UK</option>
										<option <?php echo (!empty($data['tdCountry']) && $data['tdCountry'] == 'France')?'selected':''; ?> value="France">France</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6">
									<div style="float: left;width: 30%;display:none">
										<div class="input-icon input-icon-sm right">
											<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
											<input  name="txt_cus_code_phone" type="text" value="<?php echo !empty($data['tdAreaCode'])?$data['tdAreaCode']:''; ?>" class="form-control input-sm input-one" placeholder="Area Code">
										</div>
									</div>
									<span style="float: left;width:5%;text-align: center;line-height: 28px;display:none"><b>-</b></span>
									<div style="float: left;width:100%;" class="in-group">
										<div class="input-icon input-icon-sm right">
											<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
											<input  name="txt_cus_phone" type="text" value="<?php echo !empty($data['tdPhone'])?$data['tdPhone']:''; ?>" class="form-control input-sm input-one" placeholder="Phone Number">
										</div>
									</div>
								</div>
								<div class="col-md-6 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_cus_email" value="<?php echo !empty($data['tdEmail'])?$data['tdEmail']:''; ?>" class="form-control input-sm" placeholder="E-mail address">
									</div>
									<input type="hidden" name="txt_date_add" value="<?php echo !empty($data['tdDate'])?$data['tdDate']:date('m/d/Y'); ?>">
								</div>
							</div>
							<?php if(!empty($this->sess_cus['admin_level']) && $this->sess_cus['admin_level'] == 1 && !empty($this->sess_cus['storeId']) && base64_decode($this->sess_cus['storeId']) == '0'){ ?>
								<div class="form-group">
									<div class="col-lg-12">
										<select name="txt_cus_store" class="form-control input-sm txt_cus_store">
											<option value="">Please select store</option>
											<?php if(!empty($store)){ foreach ($store as $key => $st) { ?>
												<option <?php echo (!empty($data['tdStoreID']) && $data['tdStoreID'] == $st['store_id'])?'selected':''; ?> <?php echo (!empty($data['tdStoreID']) && $data['tdStoreID'] != $st['store_id'])?'disabled':'' ?> value="<?php echo $st['store_id'] ?>"><?php echo $st['store']; ?></option>
											<?php }} ?>
										</select>
									</div>
								</div>
							<?php } ?>
						</div>
						<!--/span-->
						<div class="col-md-6">
							<div class="form-group">
								<div class="col-md-12">
									<h4 class="title-form">Payment Information</h4>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<div class="input-icon input-icon-sm">
										<i class="fa fa-user"></i>
										<input type="text" name="txt_cus_card_name" value="<?php echo !empty($data['infoPayment']['pName'])?$data['infoPayment']['pName']:''; ?>" class="form-control input-sm" placeholder="Cardholder's Name">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<div class="input-icon input-icon-sm">
										<i class="fa fa-credit-card"></i>
										<input type="text" name="txt_cus_card_num" value="<?php echo !empty($data['infoPayment']['pCard'])?$data['infoPayment']['pCard']:''; ?>" class="form-control input-sm" placeholder="Card Number">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<h5 class="title-form">Expiry</h5>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-4">
									<div class="input-group date date-picker input-one" data-date="" data-date-format="mm/yyyy" data-date-viewmode="years" data-date-minviewmode="months">
										<input type="text" name="txt_cus_card_date" value="<?php echo !empty($data['infoPayment']['pDate'])?$data['infoPayment']['pDate']:''; ?>" class="form-control input-sm" readonly placeholder="MM/YYYY">
										<span class="input-group-btn">
											<button class="btn default btn-sm" type="button"><i class="fa fa-calendar"></i></button>
										</span>
									</div>
								</div>
								<div class="col-md-8">
									<input style="float: left;width: 35%;" name="txt_cus_card_cvc" type="text" value="<?php echo !empty($data['infoPayment']['pCVC'])?$data['infoPayment']['pCVC']:''; ?>" class="form-control input-sm" placeholder="Area Code">
									<span style="float: right;width:65%;text-align: right;line-height: 28px;"><b><i class="fa fa-lock"></i> 128-bit secured</b></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<textarea class="form-control" name="txt_cus_card_note" rows="3" placeholder="Notes"><?php echo !empty($data['tdNote'])?$data['tdNote']:''; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<h5 class="title-form">Points</h5>
									<input type="text" value="<?php echo !empty($data['tdPoint'])?$data['tdPoint']:'0'; ?>" readonly class="form-control input-sm" placeholder="Account Balance">
								</div>
							</div>
						</div>
						<!--/span-->
					</div>
					<!--/row-->
				</div>
				<div class="form-actions right">
					<input type="hidden" id="txt_account_id" name="txt_account_id"  value="<?php echo !empty($data['tdAccID'])?$data['tdAccID']:''; ?>">
					<input type="hidden" id="txt_ecus_no"  value="<?php echo !empty($data['tdCust'])?$data['tdCust']:''; ?>">
					<input type="hidden" id="txt_type" name="txt_type" value="<?php echo !empty($type)?$type:1; ?>">
					<input type="hidden" name="txt_hd_id" value="<?php echo !empty($data['tdID'])?$data['tdID']:''; ?>">
					<input type="hidden" id="txt_cus_store_id" value="<?php echo !empty($data['tdStoreID'])?$data['tdStoreID']:''; ?>">
					<?php 
						$role = $this->mPrivileges; 
						if($role == 'FullAccess' || (is_array($role) && substr($role['customers'], -1) == '1')): ?>
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
	_init_Add_Customers();
	<?php if($role == 'NoAccess' || (is_array($role) && substr($role['customers'], -1) == '0')){ ?>
		$(document).ready(function() {
			$('#frm-customers').attr('action', 'javascript:void(0);');
		});
	<?php } ?>
</script>