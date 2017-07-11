<div class="dash">
<div class="dashmidd">
    	<div class="dash-right">
        	<div style="border-right:#aaa 1px solid;border-bottom:#aaa 1px solid; display:table; width:99%; padding-bottom:15px;">
            <div style="width:100%; display:table; padding:100px 0 20px 0; text-align:center">
            	<a href="http://webtos.websolutions.vn/"><img border="0" src="http://webtos.websolutions.vn/uploads/site/1412043079logo.png"></a><br />
                <span style="text-indent:10px; display:table; width:100%; text-align:center"><strong>Pest Control Company</strong></span>
            </div>
            <div style="display:table; width:100%; text-align:center; height:500px;">
               <p>
                Congratulations ! Your account is all set-up and ready to go. <br>
                Click " <span style="font-weight:bold">Finish</span> " to be taken to user selection sreen.
            </p>
            <button onclick="javascript:location.href='<?php echo url::base() ?>login/dashboard'" type="button" value="Finish">Finish</button>
            </div>
            </div>
        </div>
    <div class="dash-left" style="text-align:right">
    	<span>
		<p><?php if($this->session->get('member_lname')) echo $this->session->get('member_lname');  ?></p>
		<a href="<?php echo url::base() ?>login/logout">Log Out</a>
		</span>
    </div>
</div>
</div>
<script>
	$(function(){
		$(document).keypress(function (e) {
		  if (e.which == 13) {
		    window.location = "<?php echo url::base() ?>login/dashboard";
		  }
	});
	});
</script>