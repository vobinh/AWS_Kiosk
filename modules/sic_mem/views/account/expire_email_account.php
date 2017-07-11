<div style="padding:0 0 200px 0; background:#fff; width:400px; margin:0 auto">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center" style="padding:100px 0 20px 0">
            <?php if (!empty($this->site['site_logo'])) { ?>
              <a href="<?php echo url::base()?>">
                  <img <?php if(!empty($this->site['site_logo_height'])){ ?> height="<?php echo $this->site['site_logo_height']?>" <?php } ?> <?php if(!empty($this->site['site_logo_width'])){ ?> width="<?php echo $this->site['site_logo_width']?>" <?php } ?> border="0" src="<?php echo linkS3 ?>site/<?php echo $this->site['site_logo']?>">
              </a>
            <?php } ?>
        </td>
    </tr>

    <tr>
        <td style="text-align: center;font-size: 14px;">
        	This e-mail link more than 2 hours. it no longer functions.
        </td>
    </tr>
    <tr>
        <td align="center">
            <button type="button" onclick="window.location.href='<?php echo url::base() ?>'" style="width: 100px;" class="btn" value="Log-in">Home</button>
        </td>
    </tr>
</table>
</div>



