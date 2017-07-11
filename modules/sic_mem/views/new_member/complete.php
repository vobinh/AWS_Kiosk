
<div style="margin:0 auto; padding:0% 0 0 0; width:42%; display:table; text-align:center; line-height:20px; font-size:14px;">
<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td align="center" style="padding:100px 0 20px 0">
            <a href="<?php echo url::base()?>">
                <img <?php if(!empty($this->site['site_logo_height'])){ ?> height="<?php echo $this->site['site_logo_height']?>" <?php } ?> <?php if(!empty($this->site['site_logo_width'])){ ?> width="<?php echo $this->site['site_logo_width']?>" <?php } ?> border="0" src="<?php echo linkS3 ?>site/<?php echo $this->site['site_logo']?>">
            </a>
<!--             <span style="text-indent:10px; display:table; width:100%; text-align:center">
            	<strong>Pest Control Company</strong>
            </span> -->
        </td>
    </tr>
</table>
<p>Congratulations, <span style="font-weight:bold"><?php if(!empty($email)) echo $email; ?></span>, your user account has been created.</p>
<p>A copy of your log-in information has been sent to your e-mail address.</p>
<span style="width:100%; text-align:center; display:table; padding:20px;">
<button type="button" class="btn" style="width:150px;" onclick="window.location.href='<?php echo url::base() ?>create/confirm_created/<?php if(!empty($email)) echo $email; ?>'">Confirm</button>
</span>
</div>