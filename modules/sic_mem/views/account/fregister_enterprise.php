
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
<div class="dash">	
  <div class="dashmidd">
    <div style="display:table; width:100%; padding-bottom:15px;">
    	<div style="width:100%; display:table; padding:30px 0; text-align:center">
        	<?php if (!empty($this->site['site_logo'])) { ?>
          <a href="<?php echo url::base()?>">
              <img <?php if(!empty($this->site['site_logo_height'])){ ?> height="<?php echo $this->site['site_logo_height']?>" <?php } ?> <?php if(!empty($this->site['site_logo_width'])){ ?> width="<?php echo $this->site['site_logo_width']?>" <?php } ?> border="0" src="<?php echo linkS3 ?>site/<?php echo $this->site['site_logo']?>">
          </a>
        <?php } ?>
      </div>
      <div style="display: table;line-height: 18px;width: 460px;margin: auto;border: 1px solid #000;padding: 10px;background-color: #fff;box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);">               
        <span style="  width: 100%;text-align: center;display: table;font-size:14px">
            Payment was successful. Your credit card on file will automatically be <br/>
            charged every 30 days for the number of users active in the system.<br/><br/>
            
            A copy of the log-in information has been sent to your e-mail address. <br>
            Please click "Next" to set up your company information.
        </span>
  			<div style="width:100%; display:table; padding:15px 0; text-align:center">
          <button class="btn" style="width:100px;font-size:14px" id="button" onclick="location.href='<?php echo url::base() ?>create/smfregister_single'" type="button" value="Next">Next </button> 
        </div>
      </div>
    </div>
  </div>
</div>

<script>
	$(function(){
		$(document).keypress(function (e) {
		  if (e.which == 13) {
		    window.location = "<?php echo url::base() ?>create/smfregister_single";
		  }
	});
	});
</script>