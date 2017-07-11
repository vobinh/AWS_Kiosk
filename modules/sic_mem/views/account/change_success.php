<div style="padding:100px 0 10px 0;text-align: center;">
    <img <?php if(!empty($this->site['site_logo_height'])){ ?> height="<?php echo $this->site['site_logo_height']?>" <?php } ?> <?php if(!empty($this->site['site_logo_width'])){ ?> width="<?php echo $this->site['site_logo_width']?>" <?php } ?> border="0" src="<?php echo linkS3 ?>site/<?php echo $this->site['site_logo']?>">
</div>
<div style="padding:0 0 200px 0; background:#fff; width:550px; margin:0 auto">
<table width="100%" style="border: 1px solid #000;background-color: #fff;padding: 0px;box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-webkit-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);padding-bottom: 10px;padding-top: 10px;" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td style="font-size: 23px;font-weight: bold;text-align: center;">
            Your password has been changed successfully. <br>
            Please log-in using your new password. 
            <div style="padding-top: 10px;">
            	<button onclick="window.location.href='<?php echo url::base() ?>auth/login'" style="width: 150px;" type="button" class="btn">Go to login</button>
            </div>
        </td>
    </tr>
</table>
</div>



