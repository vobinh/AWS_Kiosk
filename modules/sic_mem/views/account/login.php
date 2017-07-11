<div style="position: absolute;bottom: 0;right: 15px;">
  <button onclick="window.location.href='<?php echo url::base() ?>create/forgot_password'" class="btn" type="buton">I forgot my password</button>
</div>
<span style="position: absolute;right: 10px;">
<button style="font-size:14px;width:100px;" onclick="javascript:location.href='/'" type="button" class="btn" value="Cancel">Home</button>
<button  onclick="javascript:location.href='<?php echo url::base() ?>create/account'" style="width: 100px;margin: 10px;margin-left: 0px;" class="btn" type="button" value="Cancel">New Account</button>
</span>
<div style="padding:100px 0 10px 0;text-align: center;">
  <img <?php if(!empty($this->site['site_logo_height'])){ ?> height="<?php echo $this->site['site_logo_height']?>" <?php } ?> <?php if(!empty($this->site['site_logo_width'])){ ?> width="<?php echo $this->site['site_logo_width']?>" <?php } ?> border="0" src="<?php echo linkS3 ?>site/<?php echo $this->site['site_logo']?>">
</div>
<form action="<?php echo url::base() ?>auth/smlogin" method="POST" id="form">
<div style="padding:0 0 200px 0; background:#fff;">
<table  style="width: 400px;margin: auto;background-color: #fff;box-shadow: 0px 0px 14px 0px rgba(0, 0, 0, 0.4);padding-bottom: 10px;padding-top: 10px;" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <label style="font-size:14px;text-align:center">E-mail</label>
            <input autofocus="autofocus" type="text" id="email" name="email">
        </td>
    </tr>
    <tr>
        <td align="center">
            <label style="font-size:14px;text-align:center">Password</label>
            <input type="password" id="pass" name="pass">
        </td>
    </tr>
    <tr>
        <td align="center">
            <button type="button" style="width: 100px;" id="login" class="btn" value="Log-in">Log-in</button>
        </td>
    </tr>
</table>
</div>
</form>
<script>
    $(function(){
        $(document).keypress(function (e) {
          if (e.which == 13) {       
            $('#login').click();
          }
        });
  $('#login').click(function(){
    var pass=$('#pass').val();
    var valu=$('#email').val();
    if(valu === ''){
      $.growl.error({ message: "E-mail is required." });
      return false;
    }
    if(IsEmail(valu)==false){
      $.growl.error({ message: "Please enter a valid email address." });
      return false;
    }
    if(pass === ''){
      $.growl.error({ message: "Password is required." });
      return false;
    }
    $.ajax({
      type: 'POST',
      url: '<?php echo url::base() ?>ajax_progress/login_ajax',
      data: {email: valu,pass: pass},
      success: function (resp) {
        if(resp === 'success'){
          $('#form').submit();
        }else{
          $.growl.error({ message: "Login failed. Please check your e-mail and password." });
        }
      }
    });
  });
});
function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
</script>

