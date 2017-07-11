<style>
	#hidden{
		display: none;
	}
</style>
<div style="padding:0 0 200px 0; background:#fff; width:236px; margin:0 auto">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center" style="padding:100px 0 20px 0">
        <a href="http://webtos.websolutions.vn/"><img border="0" src="http://webtos.websolutions.vn/uploads/site/1412043079logo.png"></a>
        </td>
    </tr>
    <tr>
        <td align="center">
          <span style="position: absolute;right: 10px;">
                <p><?php if($this->session->get('member_lname')) echo $this->session->get('member_lname'); ?></p>
                <a href="<?php echo url::base() ?>login/logout">Log Out</a>
        </span>
         
        <div style="width:100%; display:table ">
            <div style="width:50px; float:left;">
			<?php if(!empty($info_member['image'])){ ?>
            <img width="50" height="50" class="img" style="float:left" src="<?php echo url::base() ?>uploads/member/<?php echo $info_member['image'] ?>" alt="">
            <?php } ?>
            </div>
            <span class="img" style="line-height:50px; display:table; float:left; padding-left:10px; width:70%; text-align:left" ><?php if(!empty($info_member['user_name'])){ echo $info_member['user_name']; } ?> [Admin]</span>
        </div>
        
        <div id="hidden">
            <form action="<?php echo url::base() ?>login/smslectUser" method="POST">
                PIN: <input autofocus="autofocus" style="width:55%" type="password" name="pass">
                <input style="display:none;" name="email" type="text" value="<?php if(!empty($info_member['user_name'])){ echo $info_member['user_name']; } ?>">
                <button type="submit" value="OK">OK</button>
            </form>
        </div>  
        </td>
    </tr>
    <tr>
        <td align="center">
        <?php 
			if(!empty($mem_of_enter)){
				foreach ($mem_of_enter as $key => $value) {
		?>
				<div style="margin-bottom:10px !important; width:100%; display:table ">
            		<div style="width:50px; float:left;">
					<?php if(!empty($value['image'])){ ?>
						<img width="50" height="50" style="float:left" src="<?php echo url::base() ?>uploads/member/<?php echo $value['image'] ?>" class="img<?php echo $value['uid'] ?>"  alt="">
					<?php } ?>
                    </div>
					<span class="img<?php echo $value['uid'] ?>" style="line-height:50px; display:table; float:left; padding-left:10px; width:70%; text-align:left">
					 <?php
						 if($value['user_name']!= NULL){
							 echo $value['user_name'];
						 }else{
						 	echo "";
						 }
					  ?>
					  </span>			
				</div>
				<div style="display:none" id="hidden<?php echo $value['uid'] ?>">
					<form action="<?php echo url::base() ?>login/smslectUser" method="POST">
						PIN: <input autofocus="autofocus" style=" width:55%" type="password" name="pass">
						<input name="email" style="display:none;" type="text" value="<?php echo $value['user_name']  ?>">
						<button type="submit" value="OK">OK</button>
					</form>
				</div>
		
				<script>
					$(function(){
						$(".img"+<?php echo $value['uid'] ?>).click(function() {
							$( "#hidden"+<?php echo $value['uid'] ?> ).toggle( "slow" );
						});
					});
				</script>
		<?php 		
				}
			}
		?>
        </td>
    </tr>
</table>
</div>
 <script>
$(function(){
	$( ".img" ).click(function() {
	  $( "#hidden" ).toggle( "slow" );
	});
});
</script>