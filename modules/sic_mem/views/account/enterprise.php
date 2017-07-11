<?php 
  $option_enterprise = $this->db->get('option_enterprise_general')->result_array(false);
  $setup_fee=0;
  $sub_fee=0;
  if(!empty($option_enterprise[0]['setup_fee']) || $option_enterprise[0]['subscription_fee']){
    $setup_fee=$option_enterprise[0]['setup_fee'];
    $sub_fee=$option_enterprise[0]['subscription_fee']*2;
      $total_enterprise=$setup_fee+$sub_fee;
  }
?>
<script type="text/javascript" src="<?php echo url::base() ?>js/stripe.js"></script>
<div id="loading_send_card" style="display: none;position: fixed;left: 0;right: 0;top: 0;z-index: 10000;background-color: rgba(128, 128, 128, 0.7);height: 100%;width: 100%;">
    <div style="top: 50%;left: 50%;position: absolute;">
    <img src="<?php echo url::base() ?>themes/client/styleSIC/index/pics/loading.gif" alt="">
    </div>
</div>
<style>
    table.table_form_card td{
        padding: 0 !important;
        text-align: center;
        font-size: 12px;
    }
    table.table_form_card input{
        font-size: 12px;
    }
</style>
<span  style="position: absolute;right: 10px;">
    <form action="<?php echo url::base() ?>login/delete">
       <button class="btn" style="width:100px;margin:10px" type="submit">Cancel</button>
    </form>
</span>
<div class="dash">  
    <div class="dashmidd">
          <div style="display:table; width:100%; padding-bottom:15px;">
          <div style="width:100%; display:table; padding:30px 0; text-align:center">
              <?php if (!empty($this->site['site_logo'])) { ?>
              <a href="<?php echo url::base()?>">
                  <img <?php if(!empty($this->site['site_logo_height'])){ ?> height="<?php echo $this->site['site_logo_height']?>" <?php } ?> <?php if(!empty($this->site['site_logo_width'])){ ?> width="<?php echo $this->site['site_logo_width']?>" <?php } ?> border="0" src="<?php echo linkS3 ?>site/<?php echo $this->site['site_logo']?>">
              </a>
            <?php } ?><br />
            </div>
            <div style="width:100%; display:table; line-height:18px;">
                <div style="width:25%; float:left; padding-left:10%">
                  <p style="text-align:center;padding-right:40px; font-size:16px;"><strong>Enterprise</strong></p>
                    <span style="font-weight:bold;font-size:14px">
                    Enterprise model is designed for
                    companies who generate reports on 
                    a regular basis.The model also 
                    allows for simultaneous 
                    connections from multiple users.</span><br/><br/>
        
                    <span style="display:table; font-size:14px;">
                    - Multiple users can log-in to the system simultaneously.<br/>
        
                    - Monthly subscription-based.<br/>
        
                    - More economical for companies who generate
                    a large number of reports on a regular basis.
                    </span>
                </div>
                <div style="width:63%; float:left; padding-left:2%;font-size:14px;">
                  You have selected the Enterprise payment plan <br/><br/>
                    Basic Enterprise users receive two user licenses, meaning you can <br/>
                    have up to two simultaneous users online at the same time.If you wish <br/>
                    to add more, you can do so later after you log-in.<br/><br/><br/>
        
                    <table style="font-size:14px;width:60%;border:1px solid #000" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="text-align:center;border-bottom:1px solid #000">Item</td>
                            <td style="text-align:center;border-bottom:1px solid #000">Unit Cost</td>
                            <td style="text-align:center;border-bottom:1px solid #000">Qty</td>
                            <td style="text-align:center;border-bottom:1px solid #000">Cost</td>
                            <td style="text-align:center;border-bottom:1px solid #000">Frequency</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">Account Activation Free</td>
                            <td style="text-align:center;">$<?php echo !empty($option_enterprise[0]['setup_fee'])?$option_enterprise[0]['setup_fee']:'0'; ?></td>
                            <td style="text-align:center;">1</td>
                            <td style="text-align:center;">$<?php echo !empty($option_enterprise[0]['setup_fee'])?$option_enterprise[0]['setup_fee']:'0'; ?></td>
                            <td style="text-align:center;">One-time</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">Subscription (2 User licenses)</td>
                            <td style="text-align:center;">$<?php echo !empty($option_enterprise[0]['subscription_fee'])?$option_enterprise[0]['subscription_fee']*2:'0'; ?></td>
                            <td style="text-align:center;">1</td>
                            <td style="text-align:center;">$<?php echo !empty($option_enterprise[0]['subscription_fee'])?$option_enterprise[0]['subscription_fee']*2:'0'; ?></td>
                            <td style="text-align:center;">Every 30 days</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">Total due today</td>
                            <td></td>
                            <td></td>
                            <td style="text-align:center;">$<?php  echo !empty($total_enterprise)?$total_enterprise:'0'; ?></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
            </div>
        </div>
</div>
<form id="form" action="<?php echo url::base() ?>account/epayment" style="text-align:center; padding:10px 0; display:table; width:100%">
    <button  onclick="window.history.back()" style="width:100px" type="button" class="btn" value="Back">Back</button>&nbsp;
    <button type="button" id="card" style="width:100px" class="btn" value="Next">Next</button>
</form>

<!-- FORM CARD -->
<form style="display:none;  padding-top: 2%;padding-bottom: 2%;" class="form_card" method="POST"   action="<?php echo url::base() ?>account/save_card" id="form_nap_card">
    <table class="table_form_card" width="100%" >
      <tr>
        <td>
          <input  type="text" id="card_number" data-stripe="number" name="card_number" placeholder="Credit Card Number">
        </td>
      </tr>
      <tr>
        <td>
           <input placeholder="--Month--"  name="month" style="width:95px;float: none;" data-stripe="exp-month" type="text"> 
          /
           
       <input placeholder="--Year--" name="year" data-stripe="exp-year" style="width:95px;float: none;" type="text"> 
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="card_name" data-stripe="name" style='float: none;' placeholder="Name on Credit Card">
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="address_1" data-stripe="address_line1" style='float: none;' placeholder="Address 1">
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="address_2" data-stripe="address_line2" style='float: none;' placeholder="Address 2">
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" style='float: none;' data-stripe="address_city" name="city" placeholder="City">
        </td>
      </tr>
      <tr>
        <td>
          <?php $state=$this->db->get('state')->result_array(false); ?>
           <select style='float: none;width:107px' data-stripe="address_state" name="state" id="">
            <?php if(!empty($state)){ foreach ($state as $value) { ?>
              <option value="<?php echo $value['state_code'] ?>"><?php echo $value['state_code'] ?></option>
            <?php }} ?>
          </select>
          <input style='float: none;width:104px' data-stripe="address_zip" name="zip" type="text" placeholder="Zip Code">
        </td>
      </tr>
      <tr>
        <td>
          <select style="width:89%;float: none"  name="place" data-stripe="address_country" id="">
              <option value="United States">United States</option>
        </select>
        </td>
      </tr>
    </table>
    <!-- <input type="hidden" value="<?php //echo $this->sess_cus['id']; ?>|register" name="mem_id" data-stripe="address_country" > -->
    <input type="hidden" value="<?php if(!empty($id_credit)) echo $id_credit; ?>" name="code_credit" id="code_credit">
  <div style="margin-left: 16px;">
      <button style="width: 110px;" id="cofirm" class="btn" type="submit">Confirm</button>
      <button style="width: 110px;float: right;margin-right: 16px" class="btn" type="button" id="cancel_card">Cancel</button>
  </div>
</form>
<!-- press enter -->
<script>
$(function(){
    $('#card').click(function(){      
         $( "#form_nap_card" ).dialog({
            draggable: false,
            modal: true,
            dialogClass: "no-close",
            width: 260,
            autoOpen:true,
            title:"Credit Card",
            open : function(event, ui) { 
                $('html').attr('data-scrollTop', $(document).scrollTop()).css('overflow', 'hidden');
                $(this).dialog('option','position',{ my: 'center', at: 'center', of: window });
            },
            close : function(event, ui) { 
                var scrollTop = $('html').css('overflow', 'auto').attr('data-scrollTop') || 0;
                if( scrollTop ) $('html').scrollTop( scrollTop ).attr('data-scrollTop','');
            }
        });   
    });
    // close card
    $('#cancel_card').click(function(){
        $( ".form_card" ).dialog( "close" );
    });
});
</script>
<?php 
  $key_card = $this->db->get('key_card')->result_array(false); 
?>
<script type="text/javascript">
Stripe.setPublishableKey("<?php echo !empty($key_card[0]['publishable_key'])?$key_card[0]['publishable_key']:''; ?>");
var stripeResponseHandler = function(status, response) {
  var $form = $('#form_nap_card');
  if (response.error) {
    $.growl.error({ message: response.error.message });
  } else {
      var token = response.id;       
      var payment_date=response.created;
      var card_number=response['card']['last4'];
      var month_exp=response['card']['exp_month'];
      var year_exp=response['card']['exp_year'];
      var payment_type=response['card']['brand'];
      var cardname=response['card']['name'];
      $form.append($('<input type="hidden" name="stripeToken" />').val(token));
      $form.append($('<input type="hidden" name="payment_date" />').val(payment_date));
      $form.append($('<input type="hidden" name="card_number_last4" />').val(card_number));
      $form.append($('<input type="hidden" name="month_exp" />').val(month_exp));
      $form.append($('<input type="hidden" name="year_exp" />').val(year_exp));
      $form.append($('<input type="hidden" name="payment_type" />').val(payment_type));
      $form.append($('<input type="hidden" name="card_name_tripe" />').val(cardname));
      var data=$('#form_nap_card').serialize(); 
      $(function() {
        $('#loading_send_card').show();
        $.ajax({
          type: "POST",
          dataType:"JSON",
          url: "<?php echo url::base() ?>account/save_card",
          data: data,
          success: function(resp){
            if(resp['message'] == true){
              $('#cancel_card').click();
              $.growl.notice({ message: "Success" });                 
              window.location.href="<?php echo url::base() ?>account/epayment";
            }else{
              $.growl.error({ message: ""+resp['message']+"" });
              $('#loading_send_card').hide();
              return false;
            } 
          }
        });
      });
  return false;
  }
};
jQuery(function($) {
  $('#cofirm').on('click', function(e) {
  var $form = $('#form_nap_card');
  Stripe.card.createToken($form, stripeResponseHandler);
  return false;
  });
});
  </script>