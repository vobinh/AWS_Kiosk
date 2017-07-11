<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
<?php 
  $option_signle = $this->db->get('option_single_credit')->result_array(false);
?>
<style>
    table.table_form_card td{padding: 0 !important;text-align: center;font-size: 12px;}
    table.table_form_card input{font-size: 12px;}
</style>
<span  style="position: absolute;right: 10px;">
    <form action="<?php echo url::base() ?>login/delete">
       <button type="submit" class="btn" style="width:100px;font-size:14px;margin:10px">Cancel</button>
    </form>
</span>
<div style="padding:0 0 200px 0; background:#fff; width:800px; margin:0 auto">
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
        <td align="center">
           <div style="width:250px; float:left; padding:0 20px; text-align:justify;font-size:14px">
           		<span style="width:100%; display:table; padding:0 0 20px 0; text-align:center;font-size:16px"><strong>Single User</strong> <br></span>
                <strong style="font-size:14px">Single user model is designed for 
                smaller companies - you pay as 
                you go - meaning, if you go for 
                weeks without a customer, you 
                don't have to pay a dime.</strong><br><br>
    
                - Single user model only allows one user to be
                using the system at a time. <br> <br>
                - Report are generated using prepaid credits
                similar to recharging a prepaid phone card.<br><br>
                -You have to option to switch over to Enterprise mode at any time!
           </div>
           <div style="width:460px; float:left; padding:0 20px; text-align:justify;font-size:14px">
           		You have selected the Single User payment plan. <br><br>
                Single users are only allowed one user to be using the system at a time. 
                Payment works much like a prepaid phone plan, where  the system is 
                "recharged" for credits to be used on reports and other functions.<br><br>
    
                You can recharge credits as you go at your own pace once your account 
                is set up. You may also upgrade to Enterprise User once your business 
                grows to the point where flat-rate subscription becomes more economical.<br><br>
                Clicking "Next" will prompt you will the credit purchase screen. Select how many credits you would like
                to purchase to get started.
           </div>
        </td>
    </tr>
    <tr>
        <td align="center" style="padding-top: 50px;">
            <form id="form" action="<?php echo url::base() ?>account/spayment">
            <button class="btn" style="width:100px;font-size:14px" onclick="window.history.back()" type="button" value="Back">Back</button>
            <button class="btn card" style="width:100px;font-size:14px" type="button" id="butn" value="Next">Next</button>
            </form>
        </td>
    </tr>
</table>
</div>
<!-- FORM CARD -->

<form style="display:none" action="" class="form_credit_cc" id="form_recharge_credit">
  <div style="text-align: center;">
    <p>
      <?php if(!empty($option_signle)){ foreach ($option_signle as $key => $value) { ?>
      <input name="id_credit" class="credit_<?php echo $value['id']; ?>" <?php if($key == 0){ ?> checked="checked" <?php } ?>  type="radio" value="<?php echo $value['id']; ?>" style="width: 62px;height: 17px;float: left;">
       <span style="margin-left: -15px;margin-top: 0px;font-size: 17px;margin-bottom: 10px;display: inline-block;">
        <?php echo $value['credit'] ?> Credits - <?php echo money_format('%(#10n',$value['price']); ?>
      </span> <br>
      <?php }} ?>
    </p>
    <div style="text-align:center">
    <button type="button" style="width: 90px;" onclick="open_form_recharge_credit_2()" class="btn">Next</button> 
  </div>
  </div>
</form>

<div id="wrapcard"></div>

<script type="text/javascript">

$(function(){
    $('.card').click(function(){      
         $( ".form_credit_cc" ).dialog({
            draggable: false,
            modal: true,
            resizable: false,
            dialogClass: "no-close",
            width: 260,
            autoOpen:true,
            title:"Select Amount"
        });   
    });     
});
function open_form_recharge_credit_2(){
  var data_dl=$('.form_credit_cc').serialize();
   $.ajax({
        type: 'POST',
        url: '<?php echo url::base() ?>account/list_card_signle', 
        data:data_dl,  
        success: function (data) {
           $('#wrapcard').html(data);
           $('#wrapcard').dialog({
                draggable: false,
                modal: true,
                resizable: false,
                dialogClass: "no-close",
                width: 260,
                autoOpen:true,
                title:"Credit Card"
            });  
        }
    });
}

	$("#backLink").click(function(event) {
        event.preventDefault();
        history.back(1);
	});

</script>