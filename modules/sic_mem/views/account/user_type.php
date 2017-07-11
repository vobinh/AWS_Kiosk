<span  style="position: absolute;right: 10px;">
    <form action="<?php echo url::base() ?>login/delete">
       <button class="btn" style="width:100px;font-size:14px;margin:10px" type="submit">Cancel</button>
    </form>
</span>

<form action="<?php echo url::base() ?>account/smusertype" method="POST">
<div style="padding:0 0 200px 0; background:#fff; width:500px; margin:0 auto">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="3" align="center" style="padding:100px 0 0px 0">
        <?php if (!empty($this->site['site_logo'])) { ?>
                  <img <?php if(!empty($this->site['site_logo_height'])){ ?> height="<?php echo $this->site['site_logo_height']?>" <?php } ?> <?php if(!empty($this->site['site_logo_width'])){ ?> width="<?php echo $this->site['site_logo_width']?>" <?php } ?> border="0" src="<?php echo linkS3 ?>site/<?php echo $this->site['site_logo']?>">
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td colspan="3" align="center">
            <p style="font-size: 15px;font-weight: bold;">Choose your payment plan</p>
        </td>
    </tr>
    <tr>
        <td  style="vertical-align:top;border:1px solid #000;width:45%;font-size: 14px;padding-top: 15px;padding-bottom: 70px;">
            <div style="text-align:center">
                <button  class="btn" style="border-radius: 5px;text-align: center;width:100px;font-size:14px"  id="single" type="submit" value="single" name="btn">
                    Single
                </button>
            </div>
            <p style="font-weight: bold;font-size: 15px;margin-bottom: 0px;">Pay-as-you-go:</p>
            <p style="margin-top: 0px;">Purchase prepaid credits to create reports and use other functions. Simply recharge credits as needed.</p>
            <p style="font-weight: bold;font-size: 15px;margin-bottom: 0px;"><span>+</span> Notes:</p>
            <p style="margin-bottom: 0px;margin-top: 0px;"><span>-</span> No upfront cost</p>
            <p style="margin-bottom: 0px;margin-top: 0px;"><span>-</span> Single user accounts can only be logged in from one location at a time</p>
            <p style="margin-bottom: 0px;margin-top: 0px;"><span>-</span> Switch over to Enterprise mode anytime</p>
        </td>
        <td style="width: 1%;"></td>
        <td style="border:1px solid #000;width:45%;font-size: 14px;padding-top: 15px;padding-bottom: 70px;">
            <div style="text-align:center">
                <button  class="btn" style="border-radius: 5px;text-align: center;width:100px;font-size:14px"  id="enter" type="submit" value="enterprise" name="btn">
                    Enterprise
                </button>
            </div>
            <p style="font-weight: bold;font-size: 15px;margin-bottom: 0px;">Flat-rate Subscription:</p>
            <p style="margin-top: 0px;">Pay a flat monthly rate per user license with access to all of the application features.</p>
            <p style="font-weight: bold;font-size: 15px;margin-bottom: 0px;"><span>+</span> Notes:</p>
            <p style="margin-bottom: 0px;margin-top: 0px;"><span>-</span> Create and manage additional user accounts</p>
            <p style="margin-bottom: 0px;margin-top: 0px;"><span>-</span> Multiple logins (minimum two user licenses)</p>
            <p style="margin-bottom: 0px;margin-top: 0px;"><span>-</span> More economical for larger organizations who generate a large number of reports regularly</p>
        </td>
    </tr>
    <tr>
    	<td colspan="3" align="center" style="padding-top: 30px;">
        	<button class="btn" style="width:100px;font-size:14px" onclick="window.history.back()" type="button" value="Back">Back</button>
        </td>
    </tr>
</table>
</div>
</form>
<script>
    $(function(){
        $('#single').click(function(){
            $('#loading').show(function(){
                $('#loading').fadeTo(5000,0);
                return false;
            });
        });
    });

    $(function(){
        $('#enter').click(function(){
            $('#loading').show(function(){
                $('#loading').fadeTo(5000,0);
                return false;
            });
        });
    });
</script>