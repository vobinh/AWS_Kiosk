<script type="text/javascript" src="<?php echo url::base()?>js/jquery.validate/jquery.validate.js"></script>
<style>
    div.validation{color: red;font-weight: bold;font-size: 11px;}
</style>
<span  style="position: absolute;right: 10px;">
    <form action="<?php echo url::base() ?>login/delete">
       <button style="font-size:14px;width:100px;margin:10px" class="btn" type="submit">Cancel</button>
    </form>
</span>
<form method="POST" action="<?php echo url::base() ?>account/smaccount_name" id="form">
<div class="show">
<div style="padding:0 0 200px 0; background:#fff;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center" style="padding:100px 0 20px 0">
            <?php if (!empty($this->site['site_logo'])) { ?>
              <a href="<?php echo url::base()?>">
                  <img <?php if(!empty($this->site['site_logo_height'])){ ?> height="<?php echo $this->site['site_logo_height']?>" <?php } ?> <?php if(!empty($this->site['site_logo_width'])){ ?> width="<?php echo $this->site['site_logo_width']?>" <?php } ?> border="0" src="<?php echo linkS3?>site/<?php echo $this->site['site_logo']?>">
              </a>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td align="center">
        	
            <label style="font-size:14px">First Name</label>
            <input  id="member_fname" name="member_fname" autofocus="autofocus" type="text" 
             title="" />
            <div id="error_email"></div>
        </td>
    </tr>
    <tr>
        <td align="center">
            <label style="font-size:14px">Last Name</label>
            <input type="text" id="member_lname" name="member_lname" 
            	title="" />
        </td>
    </tr>
    <tr>
        <td align="center">
            <button id="bu" style="font-size:14px;width:100px" class="btn" type="submit" value="Next">Next</button>
        </td>
    </tr>
</table>
</div>
</form>
<script>
$(function(){
    $( "#form" ).validate({
      rules: {
        member_fname:{
            required: true,
        },
        member_lname:{
            required: true,
        }, 
      },
      messages:{
        member_fname:"First Name is required",
        member_lname:"Last Name is required",
      }
    });
    $(document).keypress(function (e) {
      if (e.which == 13) {
        $('#form').submit(function(){
            $('#loading').show(function(){
                $('#loading').fadeTo(5000,0);
                return false;
            });
        });
      }
    });
    $('#bu').click(function(){
        $('#loading').show(function(){
                    $('#loading').fadeTo(5000,0);
                    return false;
                });
    });
});
</script>