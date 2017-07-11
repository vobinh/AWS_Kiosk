<link rel="stylesheet" href="<?php echo url::base()?>js/jquery.poshytip/tip-yellowsimple/tip-yellowsimple.css" type="text/css" />
<script type="text/javascript" src="<?php echo url::base()?>js/jquery.poshytip/jquery.poshytip.js"></script>

<style>
    div.validation{color: red;font-weight: bold;font-size: 11px;}
    .steped {background:#000; float:left; color:#fff; text-align:right; height:10px;}
    .step { background:#fff; float:left; color:#fff; text-align:right; height:10px;}
    .step_num {float:right; width:30px; border-radius:500px; line-height:30px; height:30px; border:#000 1px solid; text-align:center; color:#000; background:#fff; font-weight:bold}
    h1 {text-align:center; width:100%; font-size:18px;}
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
            <div style="border-right:#b3c7dd 5px solid;border-left:#b3c7dd 5px solid;border-bottom:#b3c7dd 5px solid; display:table; width:99%; padding-bottom:15px;height:700px">
            <div style="margin: auto;display:table; width:900px;">
                 <p style="width:100%; text-align:center"><h1>First Time Set-up Wizard</h1></p> 
                 <div style="width:60%; margin:0 auto; padding:0;">
                    <div style="width:98%; border:#000 1px solid; background:#fff; height:10px; float:left; position:relative">
                        <div style="width:100%; height:10px; float:left;">
                            <div class="steped" style="width:15%;">.</div>
                            <div class="step" style="width:14%;">.</div>
                            <div class="step" style="width:14%;">.</div>
                            <div class="step" style="width:14%;">.</div>
                            <div class="ste" style="width:14%;">.</div>
                             <div class="step" style="width:14%;">.</div>
                            <div class="step" style="width:15%;">.</div>
                        </div>
                    </div>
                    <div style="width:100%;float:left; position:relative; top:-22px;S">
                        <div style="width:15%; float:left;">
                            <div class="step_num">1</div>
                        </div>
                        <div style="width:15%; float:left;">
                            <div class="step_num">2</div>
                        </div>
                        <div style="width:15%; float:left;">
                            <div class="step_num">3</div>
                        </div>
                        <div style="width:15%; float:left;">
                            <div class="step_num">4</div>
                        </div>
                        <div style="width:15%; float:left;">
                            <div class="step_num">5</div>
                        </div>
                        <div style="width:15%; float:left;">
                            <div class="step_num">6</div>
                        </div> 
                    </div>
                </div> 
                <div style="clear:both"></div>
                 <div style="width:100%">
                    <p style="width:100%; text-align:center; float:left; margin:0px 0"><h1>Looks like this is your first time logging in.</h1></p>
                    <p style="width:100%; text-align:center; float:left; margin:0px 0"><h1>Tell us about your company.</h1></p>
                </div> 
                <form id="form" action="<?php echo url::base() ?>create/sminfo_company" enctype='multipart/form-data' method="POST" style="margin: 0 auto;width: 800px;border: 1px solid #000;background-color: #fff;padding: 10px;-webkit-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4)">
                <table width="700px;" border="0" cellspacing="0" cellpadding="0" align="center" style="margin:0 auto; padding:0">
                  <tr>
                    <td valign="top" width="50%">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                         <tr>
                            <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 14px;" colspan="2">Company Name</td>
                        </tr>
                        
                        <tr>
                            <td colspan="2"><input style="width: 96%;" value="<?php if(!empty($member['company_name']))echo $member['company_name']; ?>" id="company_name" autofocus="autofocus" type="text" name="company_name"></td>
                        </tr>
                        <tr>
                            <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 14px;" colspan="2">Address</td>
                        </tr>
                        <tr>
                            <td colspan="2"><input style="width: 96%;" value="<?php if(!empty($member['company_address']))echo $member['company_address']; ?>" type="text" name="company_address"></td>
                        </tr>
                        <tr>
                            <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 14px;" colspan="2">Address2</td>
                        </tr>
                        <tr>
                            <td colspan="2"><input style="width: 96%;" value="<?php if(!empty($member['company_address_2']))echo $member['company_address_2']; ?>" type="text" name="company_address2"></td> 
                          </tr>
                          <tr>
                            <td>
                            <label>
                                <span style="float:left; width:38%;font-weight:bold;  text-align: center;font-size:14px">City</span>
                                <span style="float:left; width:33%;font-weight:bold;  text-align: center;padding-right: 26px;margin-left: -16px;font-size:14px">State</span>
                                <span style="float:left; width:16%;font-weight:bold;  text-align: center;font-size:14px">Zip</span>
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
                            <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 14px;" colspan="2">Primary Company E-mail</td>  
                        </tr>  
                        <tr>
                            <td colspan="2">
                                <input style="width: 96%;" id="company_email" name="company_email" value="<?php if(!empty($member['company_contact_email']))echo $member['company_contact_email']; ?>" type="text">
                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 11px;font-weight: bold;">E-mail address to be used when e-mailing termite reports.</p>
                                <p style="margin-top: 0px;font-size: 11px;font-weight: bold;">If blank, user login e-mail will be used.</p>
                            </td>
                        </tr>  
                        </table>

                    </td>
                    <td valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">                          
                        <tr>
                            <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 14px;;" colspan="2">Telephone Number</td>
                        </tr>
                        <tr>
                            <td colspan="2"><input style="width: 96%;" onkeypress="return isNumberKey(event)" value="<?php if(!empty($member['telephone']))echo $member['telephone']; ?>" type="text" id="txt_telephone_re" name="telephone"></td>
                        </tr>
                        <tr>
                            <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 14px;;" colspan="2">Alt.Telephone Number</td>
                        </tr>
                        <tr>
                            <td colspan="2"><input style="width: 96%;" onkeypress="return isNumberKey(event)" value="<?php if(!empty($member['alt_telephone']))echo $member['alt_telephone']; ?>" type="text" id="txt_alt_telephone_re" name="alt_telephone"></td>
                        </tr>
                        <tr>
                            <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 14px;" colspan="2">Fax Number</td>
                        </tr>
                        <tr>
                            <td colspan="2"><input style="width: 96%;" value="<?php if(!empty($member['fax']))echo $member['fax']; ?>" type="text" id="txt_fax_re" name="fax"></td>
                        </tr>
                        <tr>
                            <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 14px;" colspan="2">Company License Number</td>
                        </tr>
                        <tr>
                            <td colspan="2"><input style="width: 96%;" value="<?php if(!empty($member['company_license']))echo $member['company_license']; ?>" type="text" id="txt_license_number" name="license_number" title="<div style='text-align: center;'>Enter the full license number including <br/> letters if applicable (e.g. PR1234, not 1234)<div/>"></td>
                        </tr>
                        <tr>
                            <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 14px;" colspan="2">Company Logo</td>
                        </tr>
    
                        <tr>
                        <td colspan="2" style="text-align: center;">
                                <!-- <input onchange="showimagepreview(this)" name="company_logo_menu" id="company_logo_menu" type="file" style="display:none"  > -->
                                <button onclick="show_crop_company_register()" style="width: 100px;height: 38px;margin: 0 auto;" type="button" class="btn">Upload File…</button> 
                                
                                <button onclick="list_company_adv_register()" style="width: 100px;height: 38px;margin: 0 auto;" type="button" class="btn">Advanced...</button>
                                <br> <span id="namefile"></span>
                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 11px;text-align: left;font-weight: bold;">Only image files are accepted. Uploading a non-image file will result in a black image.(PDF not accepted)</p>
                            </td> 
                        </tr>
                        <tr>
                            <td style=" text-align: center;">
                                <span id="image_company_menu">
                                    <?php if(!empty($member['company_logo'])){ ?>
                                        <img style="margin-bottom: 10px;" src="<?php echo linkS3 ?>company/<?php echo $member['company_logo'] ?>" alt="">
                                        <input type="hidden" value="<?php echo $member['company_logo'] ?>" name="image_company">
                                    <?php } ?>
                                </span>
                            </td>
                        </tr>
                        </table>
                    </td>
                  </tr>
                </table>

                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                   <tr>
                        <td colspan="2" align="center"><button class="btn" style="width:100px;font-size:14px" id="butn" name="login" type="submit" value="Save">Continue</button></td>
                    </tr>
                    
                </table>
            </form>
            
            </div>
            </div>
        </div>

<div class="dash-left" style="text-align:right">
    <p style="text-align: right;margin-bottom: 2px;font-weight: bold;color: #000;"><?php if($this->sess_cus['name']) echo $this->sess_cus['name'];  ?></p>
    <p style="margin-top: 0px;margin-bottom: 5px;font-weight: bold;color: #000;"><?php if($this->sess_cus['email']) echo $this->sess_cus['email'];  ?></p>
    <button class="btn" onclick="window.location.href='<?php echo url::base() ?>login/logout'" style="width:100px;font-size:14px;float: right;" type="button">Log Out</button>
</div>

</div>
</div>
<div style="display:none;" id="wrap_crop_company_register"></div>
<div style="display:none;" id="wrap_company_adv_register"></div> 
<script type="text/javascript">
function show_crop_company_register() {
    $.ajax({
        type: 'POST',
        url: '<?php echo url::base() ?>create/list_crop_company_register',
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
$(function(){
    $("#company_email").on("keydown", function (e) {return e.which !== 32;});
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
    $('#butn').click(function(){
        $('#loading').show(function(){
            $('#loading').fadeTo(5000,0);
            return false;
        });
    });
});
</script>
<!-- press enter -->




