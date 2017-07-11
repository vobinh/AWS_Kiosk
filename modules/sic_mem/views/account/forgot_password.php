<div style="padding:100px 0 10px 0;text-align: center;">
    <img <?php if(!empty($this->site['site_logo_height'])){ ?> height="<?php echo $this->site['site_logo_height']?>" <?php } ?> <?php if(!empty($this->site['site_logo_width'])){ ?> width="<?php echo $this->site['site_logo_width']?>" <?php } ?> border="0" src="<?php echo linkS3 ?>site/<?php echo $this->site['site_logo']?>">
</div>
<form action="<?php echo url::base() ?>create/sm_forgot_pass" method="POST" id="form">
<div style="padding:0 0 200px 0; background:#fff; width:400px; margin:0 auto">
<table width="100%" style="border: 1px solid #000;background-color: #fff;padding: 0px;box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-webkit-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);padding-bottom: 10px;padding-top: 10px;" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>
        	<div style="padding-left: 2px;font-size:14px">
	        	<p style="margin: 0px;">Enter the e-mail address associated with your A1K1 account.</p>
	        	<p style="margin-top: 0px;text-align: center;">An e-mail containing a link will be sent to the e-mail address to allow you to reset your password.</p>
	        	<p style="text-align: center;">The password reset link will expire in 30 minutes.</p>
	        	<p style="text-align:center"><input name="email" id="email" style="width: 290px;" placeholder="E-mail address" type="text" ></p>
        	</div>
        </td>
    </tr>
    <tr>
        <td align="center">
            <button type="button" style="width: 100px;" onclick="window.location.href='<?php echo url::base() ?>'" class="btn">Home</button>
            <button type="button" style="width: 100px;" class="btn" id="btn_send_email" value="Log-in">Send</button>
        </td>
    </tr>
</table>
</div>
</form>
<script>
function check_email_exist(){
    var valu=$('#email').val();
    if(valu == ''){
        $.growl.error({ message: "Email is required" });
        return false;
    }else{
        $.ajax({
            type: 'POST',
            url: '<?php echo url::base() ?>create/checkmail_sent_exist',
            data: {val: valu},
            success: function (resp) {
                if(resp === ''){
                    $.growl.error({ message: "This e-mail does not exist in our system." });
                }else{
                    $('#form').submit();
                }
            }
        });
    } 
}
$(function(){ 
    $('#btn_send_email').click(function(){
        check_email_exist();
    })
});  
</script>


