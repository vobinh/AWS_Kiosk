<style type="text/css">
  table.table_form_card tr td{
    padding: 0px;
  }
</style>
<form style="padding-top: 2%;padding-bottom: 2%;text-align:center" class="form_card" method="POST"    id="form_nap_card">
    <table class="table_form_card" width="100%" >
      <tr>
        <td>
          <input onkeypress="return isNumberKey(event)" type="text" id="card_number" data-stripe="number" name="card_number" placeholder="Credit Card Number">
        </td>
      </tr>
      <tr>
        <td>
          <input onkeypress="return isNumberKey(event)" maxlength="2" placeholder="--Month--"  name="month" style="width:95px;float: none;" data-stripe="exp-month" type="text"> 
          /
          <input onkeypress="return isNumberKey(event)" maxlength="4" placeholder="--Year--" name="year" data-stripe="exp-year" style="width:95px;float: none;" type="text"> 
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
      <button style="width: 110px;" id="cofirm_enter" class="btn" type="submit">Confirm</button>
      <button style="width: 110px;float: right;margin-right: 16px" class="btn" type="button" id="cancel_card_enterprise">Cancel</button>
  </div>
</form>
<?php 
  $key_card = $this->db->get('key_card')->result_array(false); 
?>
<script type="text/javascript">
function isNumberKey(evt){
   var charCode = (evt.which) ? evt.which : event.keyCode
   if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;

   return true;
}

Stripe.setPublishableKey("<?php echo !empty($key_card[0]['publishable_key'])?$key_card[0]['publishable_key']:''; ?>");
var stripeResponseHandler = function(status, response) {
  var $form = $('#form_nap_card');
  if (response.error) {
    $('#loading_img').hide();
    $('#cofirm_enter').attr('disabled',false);
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
      var data1=$('#msform').serialize();
      $(function() {
        $.ajax({
          type: "POST",
          dataType:"JSON",
          url: "<?php echo url::base() ?>ajax_progress/save_card",
          data: {data:data,data1:data1},
          success: function(resp){
            if(resp['message'] == true){                 
              window.location.href="<?php echo url::base() ?>create/fregister_enterprise";
            }else{
              $('#cofirm_enter').attr('disabled',false);
              $.growl.error({ message: ""+resp['message']+"" });
              $('#loading_img').hide();
              return false;
            } 
          }
        });
      });
  return false;
  }
};
jQuery(function($) {
  $('#cofirm_enter').on('click', function(e) {
  $('#loading_img').show();
  var $form = $('#form_nap_card');
  $('#cofirm_enter').attr('disabled',true);
  Stripe.card.createToken($form, stripeResponseHandler);
  return false;
  });
});
$(function(){
  $('#cancel_card_enterprise').click(function(){
    $( "#wrapcard_enterprise" ).dialog( "close" );
  });
});
</script>