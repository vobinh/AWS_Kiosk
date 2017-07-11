<div style="padding:100px 0 10px 0;text-align: center;">
    <img <?php if(!empty($this->site['site_logo_height'])){ ?> height="<?php echo $this->site['site_logo_height']?>" <?php } ?> <?php if(!empty($this->site['site_logo_width'])){ ?> width="<?php echo $this->site['site_logo_width']?>" <?php } ?> border="0" src="<?php echo linkS3 ?>site/<?php echo $this->site['site_logo']?>">
</div>
<form action="<?php echo url::base() ?>create/cf_password" method="POST" id="form">
<div style="padding:0 0 200px 0; background:#fff; width:400px; margin:0 auto">
<table width="100%" style="border: 1px solid #000;background-color: #fff;padding: 0px;box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-webkit-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);padding-bottom: 10px;padding-top: 10px;" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="2" style="font-size: 14px;font-weight: bold;text-align: center;">
            Please assign a new password for your account:
        </td>
    </tr>
    <tr>
        <td style="text-align: center;padding-left: 40px;"  colspan="2">
            <?php echo !empty($email)?$email:''; ?>
            <input type="hidden" name="email" value="<?php echo !empty($email)?$email:''; ?>">
        </td>
    </tr>
    <tr>
        <td>Password:</td>
        <td><input id="password" name="password" type="password"></td>
    </tr>
    <tr>
        <td>Confirm Password:</td>
        <td><input id="cf_password" name="cf_password" type="password"></td>
    </tr>
    <tr>
        <td style="text-align: center;" colspan="2">
            <button style="width: 200px;" type="button" id="confirm" class="btn">Confirm</button>
        </td>
    </tr>
</table>
</div>
</form>

<script type="text/javascript">
$('#confirm').click(function(){
  var pass=$('#password').val();
  var fpass=$('#cf_password').val();
  if(pass === ''){
    $.growl.error({ message: "Password is required." });
    return false;
  }
  if(fpass === ''){
    $.growl.error({ message: "Confirm Password is required." });
    return false;
  }
  if(pass !== ''){
    if(pass.length < 4){
      $.growl.error({ message: "Please enter at least 4 characters." });
      return false;
    }
  }
  if(pass !== fpass){
    $.growl.error({ message: "Please enter the same value again." });
    return false;
  }
  $('#form').submit();
});
</script>
