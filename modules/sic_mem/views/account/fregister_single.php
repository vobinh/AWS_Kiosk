<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-65237317-1', 'auto');
  ga('send', 'pageview');
</script>
<span style="position: absolute;right: 0px;">
    <p style="text-align: right;margin-bottom: 2px;font-weight: bold;color: #000;"><?php if($this->sess_cus['name']) echo $this->sess_cus['name'];  ?></p>
    <p style="margin-top: 0px;margin-bottom: 5px;font-weight: bold;color: #000;"><?php if($this->sess_cus['email']) echo $this->sess_cus['email'];  ?></p>
    <button class="btn" onclick="window.location.href='<?php echo url::base() ?>login/logout'" style="width:100px;font-size:14px;float: right;" type="button">Log Out</button>
</span>
<div style="padding:100px 0 10px 0;text-align: center;">
    <img <?php if(!empty($this->site['site_logo_height'])){ ?> height="<?php echo $this->site['site_logo_height']?>" <?php } ?> <?php if(!empty($this->site['site_logo_width'])){ ?> width="<?php echo $this->site['site_logo_width']?>" <?php } ?> border="0" src="<?php echo linkS3 ?>site/<?php echo $this->site['site_logo']?>">
</div>
<div style="padding:0 0 200px 0; background:#fff; width:400px; margin:0 auto">
<table  style="width: 400px;border: 1px solid #000;padding: 10px;background-color: #fff;box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-webkit-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <p style="font-size:14px;margin-top: 0px;">
                <strong style="padding-bottom:5px;display:block">Payment was successful.</strong>
                <span>A copy of the log-in information has been sent to your <br>e-mail address.</span><br>
                Please click Next to continue configuring your account.
            </p>
        </td>
    </tr>
    <tr>
        <td align="center">
            <form action="<?php echo url::base() ?>create/smfregister_single" method="POST">
                <button  id="butn" type="submit" class="btn" style="width:100px;font-size:14px">Next</button>
            </form>
        </td>
    </tr>
</table>
</div>
<script>
$(function(){
    $(document).keypress(function (e) {
        if (e.which == 13) {
            window.location = "<?php echo url::base() ?>create/info_company";
        }
    });
    $('#butn').click(function(){
        window.location.href = '<?php echo url::base() ?>create/info_company';
        $('#loading').show(function(){
            $('#loading').fadeTo(5000,0);
            return false;
        });
    });
});
</script>