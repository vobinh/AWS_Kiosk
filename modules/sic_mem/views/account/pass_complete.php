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
        </td>
    </tr>
</table>
<p style="color: #000;font-weight: bold;font-size: 20px;">
    Your account has been activated. Please log-in.
</p>
<div style="text-align:center">
    <button style="width: 100px;" class="btn" type="button" onclick="window.location.href='<?php echo url::base() ?>'">Home</button>
</div>


