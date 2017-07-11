<span  style="position: absolute;right: 10px;">
    <form action="<?php echo url::base() ?>login/delete">
	   <button type="submit" class="btn" style="width:100px;font-size:14px;margin:10px">Cancel</button>
    </form>
</span>
<form action="<?php echo url::base() ?>account/smsystem" id="form" method="POST">
<div style="padding:0 0 200px 0; background:#fff;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center" style="padding:100px 0 20px 0" colspan="2">
            <?php if (!empty($this->site['site_logo'])) { ?>
              <a href="<?php echo url::base()?>">
                  <img <?php if(!empty($this->site['site_logo_height'])){ ?> height="<?php echo $this->site['site_logo_height']?>" <?php } ?> <?php if(!empty($this->site['site_logo_width'])){ ?> width="<?php echo $this->site['site_logo_width']?>" <?php } ?> border="0" src="<?php echo linkS3?>site/<?php echo $this->site['site_logo']?>">
              </a>
            <?php } ?>
        </td>
    </tr>
    <tr>
    	<td align="center" colspan="2">
        <p style="width:275px;font-size:14px;margin: 0px auto;">
			Select the system you would like to set-up.
		</p>
        </td>
    </tr>
    <tr>
        <td>
        <p style="width:275px;font-size:14px;margin: 0px auto;">
            <input style="margin:0 auto; width:auto" disabled type="checkbox" value="1"  name="system"> Pest Management [Not yet available]
        </p>
        </td>
    </tr>
    <tr>

        <td>
        <p style="width:275px;font-size:14px;margin: 0px auto;">
            <input checked="true" id="check2" style="margin:0 auto; width:auto" type="checkbox" value="2"  name="system">WDO/Termite Management
        </p>
        </td>
    </tr>
    <tr>
        <td align="center" colspan="2">
            <button type="submit" id="butn" class="btn" style="width:100px;font-size:14px" value="Next">Next</button>
        </td>
    </tr>
</table>
</div>
</form>
 <script>
    $(function(){
        $(document).keypress(function (e) {
          if (e.which == 13) {
            $('#form').submit();
          }
        });
    });
     $(function(){
        $('#butn').click(function(){
            $('#loading').show(function(){
                        $('#loading').fadeTo(5000,0);
                        return false;
                    });
        });
    });
 </script>
 <script>
// $(function(){
//     $('#check1').click(function(){
//         $('#check1').prop('checked',true);
//         $('#check2').prop('checked',false);
//     });
//     $('#check2').click(function(){
//         $('#check2').prop('checked',true);
//         $('#check1').prop('checked',false);
//     });
// });
 </script>
