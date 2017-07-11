<script>
	$(function(){
		$( "#form" ).validate({
			errorElement:'label',
				  rules: {
				    pass:{
				    	required: true,
				    	minlength:4
				    },
				    confirm_pass:{
				    	required: true,
				    	equalTo: "#pass",
				    	minlength:4
				    }, 
				  }
			});
	});
</script>
<style>
	label.validation{
		margin-left: 133px;
		color: red;
		font-weight: bold;
		font-size: 11px;
		padding-bottom: 0px;
	}
</style>
<div style="margin:auto; display:table; text-align:justify; line-height:20px; font-size:14px;">
<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td align="center" style="padding-top: 100px;">
            <a href="<?php echo url::base(); ?>">
                <img <?php if(!empty($this->site['site_logo_height'])){ ?> height="<?php echo $this->site['site_logo_height']?>" <?php } ?> <?php if(!empty($this->site['site_logo_width'])){ ?> width="<?php echo $this->site['site_logo_width']?>" <?php } ?> border="0" src="<?php echo linkS3 ?>site/<?php echo $this->site['site_logo']?>">
            </a>
            <!-- <span style="text-indent:10px; display:table; width:100%; text-align:center">
            	<strong>Pest Control Company</strong>
            </span> -->
        </td>
    </tr>
</table>
<p style="text-align:center">Welcome, <span style="font-weight:bold"><?php if(!empty($member['member_email'])) echo $member['member_email']; ?></span></p>
<p></p>
<form id="form" action="<?php echo url::base() ?>create/smmember" method="POST">
	<input type="hidden" name="id" value="<?php if(!empty($member['uid'])) echo base64_encode($member['uid']); ?>">
    <table>
        <tbody>
            <tr>
                <td style="text-align: right;">
                    Log-in:
                </td>
                <td style="text-align: left;">
                    <?php if(!empty($member['member_email'])) echo $member['member_email']; ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: right;">
                    Password:
                </td>
                <td style="text-align: left;">
                    <input style="width:10em" autofocus="autofocus" type="password" name="pass" id="pass">
                </td>
            </tr>
            <tr>
                <td style="text-align: right;">
                    Confirm Password:
                </td>
                <td style="text-align: left;">
                    <input style="width:10em" type="password" name="confirm_pass" id="confirm_pass">
                </td>
            </tr>
            <tr>
                <td style="text-align: right;">
                    Name(Optional):
                </td>
                <td style="text-align: left;">
                    <input style="width:10em" type="text" name="name">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <button style="width: 150px;" class="btn" type="submit">Confirm</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>
</div>

<div style="font-size:14px;margin: auto;width: 750px;text-align: center;border: 1px solid #aaa;border-radius: 4px;padding-top: 5px;padding-bottom: 5px;">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td style="font-weight: bold;text-align: center;">Termite Reports</td>
        <td style="font-weight: bold;text-align: center;">Management Panel</td>
        <td style="font-weight: bold;text-align: center;">Invoices/Payments</td>
        <td style="font-weight: bold;text-align: center;">Account Management</td>
    </tr>
    <tr>
        <td style="text-align: center;">
            <input type="checkbox" style="width:13px" disabled <?php if(!empty($member['termite_view']) && $member['termite_view'] == "1"){?> checked="checked" <?php } ?> name="termite_view"> <span>View</span>
            <input type="checkbox" style="width:13px" disabled <?php if(!empty($member['termite_edit']) && $member['termite_edit'] == "1"){?> checked="checked" <?php } ?>  name="termite_edit"> <span>Edit</span>
        </td>
        <td style="text-align: center;">
            <input type="checkbox" style="width:13px" disabled  <?php if(!empty($member['management_accounting']) && $member['management_accounting'] == "1"){?> checked="checked" <?php } ?> name="management_accounting"> <span>Accounting</span>
            <input type="checkbox" style="width:13px" disabled  <?php if(!empty($member['management_housekeeping']) && $member['management_housekeeping'] == "1"){?> checked="checked" <?php } ?> name="management_housekeeping"> <span>Housekeeping</span>
            <input type="checkbox" style="width:13px" disabled  <?php if(!empty($member['management_marketing']) && $member['management_marketing'] == "1"){?> checked="checked" <?php } ?> name="management_marketing"> <span>Marketing</span>
        </td>
        <td style="text-align: center;">
            <input type="checkbox" style="width:13px" disabled  <?php if(!empty($member['invoices_view']) && $member['invoices_view'] == "1"){?> checked="checked" <?php } ?> name="invoices_view"> <span>View</span>
            <input type="checkbox" style="width:13px" disabled  <?php if(!empty($member['invoices_post']) && $member['invoices_post'] == "1"){?> checked="checked" <?php } ?> name="invoices_post"> <span>Post</span>
            <input type="checkbox" style="width:13px" disabled  <?php if(!empty($member['invoices_edit']) && $member['invoices_edit'] == "1"){?> checked="checked" <?php } ?> name="invoices_edit"> <span>Edit</span>
        </td>
        <td style="text-align: center;">
            <input type="checkbox" style="width:13px" disabled <?php if(!empty($member['account_view']) && $member['account_view'] == "1"){?> checked="checked" <?php } ?> name="account_view"> <span>View</span>
            <input type="checkbox" style="width:13px" disabled <?php if(!empty($member['account_edit']) && $member['account_edit'] == "1"){?> checked="checked" <?php } ?> name="account_edit"> <span>Edit</span>
        </td>
    </tr>
</table>
</div>