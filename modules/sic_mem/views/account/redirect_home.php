<div style="padding:100px 0 10px 0;text-align: center;">
    <img <?php if(!empty($this->site['site_logo_height'])){ ?> height="<?php echo $this->site['site_logo_height']?>" <?php } ?> <?php if(!empty($this->site['site_logo_width'])){ ?> width="<?php echo $this->site['site_logo_width']?>" <?php } ?> border="0" src="<?php echo linkS3 ?>site/<?php echo $this->site['site_logo']?>">
</div>
<div style="padding:0 0 200px 0; background:#fff; width:550px; margin:0 auto">
<table width="100%" style="border: 1px solid #000;background-color: #fff;padding: 0px;box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-webkit-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);padding-bottom: 10px;padding-top: 10px;" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td style="text-align: center;font-size: 15px;font-weight:bold;color:#000">
        	E-mail containing the password reset page has been sent to <?php echo !empty($email)?$email:''; ?> <br>
            Please allow a few minutes for the e-mail to pop up in your inbox.
        </td>
    </tr>
    <tr>
    	<td style="text-align: center;font-size: 15px;font-weight:bold;color:#000">
    		Please make sure to check the Spam Folder of your e-mail.
    	</td>
    </tr>
    <tr>
        <td align="center">
            <button type="button" onclick="window.location.href='<?php echo url::base() ?>'" style="width: 100px;" class="btn" value="Log-in">Home</button>
        </td>
    </tr>
</table>
</div>



