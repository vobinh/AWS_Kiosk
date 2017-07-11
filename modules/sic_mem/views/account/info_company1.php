<style>
	div.validation{color: red;font-weight: bold;font-size: 11px;}
</style>
<script type="text/javascript">
    jQuery(function($){
       $("#txt_alt_telephone_re").mask("(999) 999-9999");
       $("#txt_telephone_re").mask("(999) 999-9999");
       $("#txt_fax_re").mask("(999) 999-9999");

       $('#txt_license_number').poshytip({
            className: 'tip-yellowsimple',
            showOn: 'focus',
            alignTo: 'target',
            alignX: 'inner-left',
            offsetX: 0,
            offsetY: 5,
            showTimeout: 100
        });
    });
</script>
<script>
    function isNumberKey(evt){
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
      return true;
    }
</script>
<script type="text/javascript">
function showimagepreview(input) {
    if (input.files && input.files[0]) {
        var filerdr = new FileReader();
        filerdr.onload = function(e) {
            $('#imgprvw').css('display','inline-block');
            $('#imgprvw').attr('src', e.target.result);
        }
        filerdr.readAsDataURL(input.files[0]);
    }
}
</script>
<div class="dash">
<div class="dashmidd">
    	<div class="dash-right">
        	<div style="border-right:#b3c7dd 5px solid;border-bottom:#b3c7dd 5px solid; display:table; width:99%; padding-bottom:15px;">
            <div style="padding-left:15%; display:table; width:85%; padding-top:30px;">
            	<span style="width:100%;  margin: 0 auto; text-align:center; display:table;font-size:13px;font-weight:bold">
               Welcome! Looks like this is your first time logging in. <br> <br>

                Let's help you get set up so you can start writing reports right away. <br> <br>

                Tell us some details about your company. Don't worry if you can't fill out all the fields. You can revisit this page by going to "Company Info" once you're in the system.</span><br><br>
                <form id="form" action="<?php echo url::base() ?>login/sminfo_company" enctype='multipart/form-data' method="POST" style="padding-left:35%;">
                <table cellpadding="0" cellspacing="0" border="0" width="53%">
                    <tr>
                        <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 13px;" colspan="2">Company Name</td>
                    </tr>
                    
                    <tr>
                        <td colspan="2"><input style="width: 96%;" value="<?php if(!empty($member['company_name']))echo $member['company_name']; ?>" id="company_name" autofocus="autofocus" type="text" name="company_name"></td>
                    </tr>
                    <tr>
                        <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 13px;" colspan="2">Address</td>
                    </tr>
                    <tr>
                        <td colspan="2"><input style="width: 96%;" value="<?php if(!empty($member['company_address']))echo $member['company_address']; ?>" type="text" name="company_address"></td>
                    </tr>
                    <tr>
                        <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 13px;" colspan="2">Address2</td>
                    </tr>
                    <tr>
                        <td colspan="2"><input style="width: 96%;" value="<?php if(!empty($member['company_address_2']))echo $member['company_address_2']; ?>" type="text" name="company_address2"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        <label>
                        	<span style="float:left; width:38%;font-weight:bold;  text-align: center;">City</span>
                        	<span style="float:left; width:33%;font-weight:bold;  text-align: center;padding-right: 26px;margin-left: -16px;">State</span>
                        	<span style="float:left; width:16%;font-weight:bold;  text-align: center;">Zip</span>
                        </label>
                        <input type="text" value="<?php if(!empty($member['city']))echo $member['city']; ?>" name="city" style="width:30%">&nbsp;
                        <select name="state" id="" style="width:30%">
                            <?php if(!empty($list_state)){ ?>
                            <?php foreach ($list_state as $key => $value) { ?>
                            <option <?php if($value['state_code'] == 'CA'){?> selected="selected" <?php } ?> value="<?php echo $value['state_code']; ?>"><?php echo $value['state_code']; ?></option>

                            <?php }} ?>
                        </select>
                        <input type="text" value="<?php if(!empty($member['zip']))echo $member['zip']; ?>" onkeypress="return isNumberKey(event)" id="zip" name="zip" style="width:30%">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 13px;" colspan="2">Primary E-mail Address</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input style="width: 96%;" type="text" disabled value="<?php if($this->session->get('member_email')) echo $this->session->get('member_email');?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 13px;;" colspan="2">Telephone Number</td>
                    </tr>
                    <tr>
                        <td colspan="2"><input style="width: 96%;" onkeypress="return isNumberKey(event)" value="<?php if(!empty($member['telephone']))echo $member['telephone']; ?>" type="text" id="txt_telephone_re" name="telephone"></td>
                    </tr>
                    <tr>
                        <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 13px;;" colspan="2">Alt.Telephone Number</td>
                    </tr>
                    <tr>
                        <td colspan="2"><input style="width: 96%;" onkeypress="return isNumberKey(event)" value="<?php if(!empty($member['alt_telephone']))echo $member['alt_telephone']; ?>" type="text" id="txt_alt_telephone_re" name="alt_telephone"></td>
                    </tr>
                    <tr>
                        <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 13px;" colspan="2">Fax Number</td>
                    </tr>
                    <tr>
                        <td colspan="2"><input style="width: 96%;" value="<?php if(!empty($member['fax']))echo $member['fax']; ?>" type="text" id="txt_fax_re" name="fax"></td>
                    </tr>
                    <tr>
                        <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 13px;" colspan="2">Company License Number</td>
                    </tr>
                    <tr>
                        <td colspan="2"><input style="width: 96%;" value="<?php if(!empty($member['company_license']))echo $member['company_license']; ?>" type="text" name="license_number" id="txt_license_number" title="<div style='text-align: center;'>Enter the full license number including <br/> letters if applicable (e.g. PR1234, not 1234)<div/>"></td>
                    </tr>
                    <tr>
                        <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 13px;" colspan="2">Company Logo</td>
                    </tr>

                    <tr>
                    <td colspan="2" style="text-align: center;">
                            <!-- <input onchange="showimagepreview(this)" name="company_logo_menu" id="company_logo_menu" type="file" style="display:none"  > -->
                            <button onclick="show_crop_company_register()" style="width: 40%;background-color: #5BA6D3 !important;height: 38px;margin: 0 auto;" type="button" class="btn">Upload File…</button> 
                            
                            <button onclick="list_company_adv_register()" style="width: 40%;background-color: #5BA6D3 !important;height: 38px;margin: 0 auto;" type="button" class="btn">Advanced...</button>
                            <br> <span id="namefile"></span>
                        </td> 
                    </tr>
                    <tr>
                        <td style=" text-align: center;">
                            <span id="image_company_menu">
                                <?php if(!empty($member['company_logo'])){ ?>
                                    <img style="margin-bottom: 10px;" src="<?php echo url::base() ?>uploads/company/<?php echo $member['company_logo'] ?>" alt="">
                                    <input type="hidden" value="<?php echo $member['company_logo'] ?>" name="image_company">
                                <?php } ?>
                            </span>
                        </td>
                    </tr>
                    <!-- <tr>
                        <td colspan="2" style="text-align: center;"><p style=" font-size: 13px;font-weight: bold;"><span style="color:red">(*)</span>:Fields are not empty</p></td>
                    </tr> -->
                    <tr>
                        <td colspan="2" align="center"><button id="butn" name="login" type="submit" value="Save">Continue</button></td>
                    </tr>
                    
                </table>
            </form>
            
            </div>
            </div>
        </div>

    <div class="dash-left" style="text-align:right">
    	<p><?php if($this->session->get('member_lname')) echo $this->session->get('member_lname');  ?></p>
			<a style="color:red" href="<?php echo url::base() ?>login/logout">Log Out</a>
    </div>
</div>
</div>
<div style="display:none;" id="wrap_crop_company_register"></div>
<div style="display:none;" id="wrap_company_adv_register"></div> 
<script type="text/javascript">
function show_crop_company_register() {
    $.ajax({
        type: 'POST',
        url: '<?php echo url::base() ?>login/list_crop_company_register',
        success: function (resp) { 
            $('#wrap_crop_company_register').html(resp);
            $( "#wrap_crop_company_register" ).dialog({
                 draggable: false,
                 modal: true,
                 width:500,
                 height:250,
                 dialogClass: "no-close",
                 autoOpen:true,
                 title:"Image Crop",
                 open : function(event, ui) { 
                    $('html').attr('data-scrollTop', $(document).scrollTop()).css('overflow', 'hidden');
                    $(this).dialog('option','position',{ my: 'center', at: 'center', of: window });
                },
                close : function(event, ui) { 
                    var scrollTop = $('html').css('overflow', 'auto').attr('data-scrollTop') || 0;
                    if( scrollTop ) $('html').scrollTop( scrollTop ).attr('data-scrollTop','');
                }
            });
        }
    });
}
function list_company_adv_register(){
    $.ajax({
        type: 'POST',
        url: '<?php echo url::base() ?>info/list_company_advanced',   
        success: function (data) {
           $('#wrap_company_adv_register').html(data);
           $( "#wrap_company_adv_register" ).dialog({
                dialogClass: "no-close",
                draggable: false,
                modal: true,
                width: 515,
                height: 'auto',
                autoOpen:true,
                title:"Advanced Logo Options",
                open : function(event, ui) { 
                    $('html').attr('data-scrollTop', $(document).scrollTop()).css('overflow', 'hidden');
                    $(this).dialog('option','position',{ my: 'center', at: 'center', of: window });
                },
                close : function(event, ui) { 
                    var scrollTop = $('html').css('overflow', 'auto').attr('data-scrollTop') || 0;
                    if( scrollTop ) $('html').scrollTop( scrollTop ).attr('data-scrollTop','');
                }
            });
        }
    });
}
</script>
<!-- press enter -->
<script>
    $(function(){
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



