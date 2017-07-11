<style>
	div.validation{color: red;font-weight: bold;font-size: 11px;}
	.steped {background:#000; float:left; color:#fff; text-align:right; height:10px;}
	.step { background:#fff; float:left; color:#fff; text-align:right; height:10px;}
	.step_num {float:right; width:30px; border-radius:500px; line-height:30px; height:30px; border:#000 1px solid; text-align:center; color:#000; background:#fff; font-weight:bold}
	h1 {text-align:center; width:100%; font-size:18px;}
</style>
<script type="text/javascript" src="<?php echo url::base()?>js/jquery.validate/jquery.validate.js"></script>
<script>
    function isNumberKey(evt)
  {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57))
  return false;

  return true;
  }
</script>
<style>
    label.validation{
        color: red;
        font-weight: bold;
        position: absolute;
        top: 12px;
        right: 0;
        width: 208px;
    }
</style>
<div class="dash">
<div class="dashmidd">
    	<div class="dash-right">
        	<div style="border-left: 5px solid #b3c7dd;border-right:#b3c7dd 5px solid;border-bottom:#b3c7dd 5px solid; display:table; width:99%; padding-bottom:15px;">
            <div style="margin: auto;display:table; width:900px;">
            	<p style="width:100%; text-align:center"><h1>First Time Set-up Wizard</h1></p>
            	<div style="width:60%; margin:0 auto; padding:0;">
                	<div style="width:98%; border:#000 1px solid; background:#fff; height:10px; float:left; position:relative">
                    	<div style="width:100%; height:10px; float:left;">
                        	<div class="steped" style="width:15%;">.</div>
                            <div class="steped" style="width:14%;">.</div>
                            <div class="steped" style="width:14%;">.</div>
                            <div class="steped" style="width:14%;">.</div>
                            <div class="steped" style="width:14%;">.</div>
                            <div class="steped" style="width:15%;">.</div>
                            <div class="step" style="width:15%;">.</div>
                        </div>
                    </div>
                    <div style="width:100%;float:left; position:relative; top:-22px;z-index:10000000000000">
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
                <div style="width:100%; float:left; margin:20px 0 30px 0">
                <p style="width:100%; text-align:center; float:left; margin:0px 0"><h1>
                	You have an Enterprise license, meaning you can have at least one another person accessing the system at the same time.
                </h1></p>
                <p style="width:100%; text-align:center; float:left; margin:0px 0"><h1>You are the administrator, and the first user (user email@email.com).</h1></p>
                <p style="width:100%; text-align:center; float:left; margin:0px 0"><h1>If you'd like, you could invite a second user (e.g. employee/partner) to use the system with you by entering the e-mail address of the recipient below, and assign privileges.</h1></p>
                <p style="width:100%; text-align:center; float:left; margin:0px 0"><h1>
                	If you would rather do this later, click "I'll do it later", and you can revisit this page under "Account Management".
                </h1></p>
                </div>                
          <form action="<?php echo url::base() ?>create/sm_sec_enterprise" id="form_sent_email_sec" method="POST" style="width:100%; display:table">
            <div style="  margin: 0 auto;width:700px;  border: 1px solid #000;padding: 27px;background-color: #fff;box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-webkit-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 14px;" colspan="2">User E-mail</td>
                    </tr>
                    
                    <tr>
                        <td style="  text-align: center;  position: relative;" colspan="2">
                            <input style="width: 200px;"   autofocus="autofocus" id="email_new" type="text" name="email_new">
                            <span style="position: absolute;  top: 12px;right: 0;color: red;font-weight: bold;" id="error_email"></span>
                        </td>
                    </tr>
                     <tr>
                        <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 14px;" colspan="2">User Privileges</td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td style="font-size:14px">Termite Reports </td>
                        <td style="font-size:14px">Management Panel  </td>
                        <td style="font-size:14px"> Invoices/Payments </td>
                        <td style="font-size:14px"> Account Management  </td>
                    </tr>
                    <tr>
                        <td>
                             <span style ="line-height: 20px;height: 15px;font-size:14px"><input type="checkbox" style="width:15px;height: 15px;" checked="checked" name="termite_view">View</span> </br>
                             <span style ="line-height: 20px;height: 15px;font-size:14px"><input type="checkbox" style="width:15px;height: 15px;" checked="checked" name="termite_edit">Edit</span>
                        </td>
                        <td>
                             <span style ="line-height: 20px;height: 15px;font-size:14px"><input type="checkbox" style="width:15px;height: 15px;" checked="checked" name="management_accounting">Accounting</span> <br/>
                             <span style ="line-height: 20px;height: 15px;font-size:14px"><input type="checkbox" style="width:15px;height: 15px;" checked="checked" name="management_housekeeping">Housekeeping</span> <br/>
                             <span style ="line-height: 20px;height: 15px;font-size:14px"><input type="checkbox" style="width:15px;height: 15px;" checked="checked" name="management_marketing">Marketing</span>
                        </td>
                        <td>
                             <span style ="line-height: 20px;height: 15px;font-size:14px"><input type="checkbox" style="width:15px;height: 15px;" checked="checked" name="invoices_view">View</span> </br>
                             <span style ="line-height: 20px;height: 15px;font-size:14px"><input type="checkbox" style="width:15px;height: 15px;" checked="checked" name="invoices_post">Post</span> </br>
                             <span style ="line-height: 20px;height: 15px;font-size:14px"><input type="checkbox" style="width:15px;height: 15px;" checked="checked" name="invoices_edit">Edit</span>
                        </td>
                        <td>
                             <span style ="line-height: 20px;height: 15px;font-size:14px"><input type="checkbox" style="width:15px;height: 15px;" name="account_view">View</span> </br>
                             <span style ="line-height: 20px;height: 15px;font-size:14px"><input type="checkbox" style="width:15px;height: 15px;" name="account_edit">Edit</span>
                        </td>
                    </tr>
                </table>
            </div>
            <input type="hidden" name="sent_email" id="sent_email">
            <div style="  margin-top: 1% !important;width: 370px;margin: 0 auto;">
                <button style="width:180px;font-size:14px" class="btn" id="btn_send_email"  type="button">Send Invitation</button>
                <button style="width:180px;font-size:14px" class="btn"   type="submit">I'll do it later</button>
            </div>
            <div style="  width: 200px;margin: 0 auto;margin-top: 1% !important;">
                <button style="width:158px;font-size:14px" class="btn" onclick="window.location.href='<?php echo url::base() ?>create/lead'" type="button">Previous</button>
            </div>
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
<div id="dialog-confirm" style="text-align: center;padding-top: 10px;"></div>
<script>
$(function(){
    $('#btn_send_email').click(function(){
        var email_new=$('#email_new').val();
        if(email_new == ''){
            $.growl.error({ message: "Email is required" });
            return false;
        }else{
            $.ajax({
                type: 'POST',
                url: '<?php echo url::base() ?>create/checkmail_sent',
                data: {val: email_new},
                success: function (resp) {
                    if(resp !== ''){
                        $.growl.error({ message: ""+resp+"" });
                    }else{
                        if($('.validation:not(.validation:hidden)').length == 0){
                            $("#dialog-confirm").html("An invitation will be sent to "+"<span style='font-weight: bold;color: #000;'>"+email_new+"</span>");
                            $("#dialog-confirm").dialog({
                                resizable: false,
                                draggable: false,
                                modal: true,
                                dialogClass: "no-close",
                                title: "Message",
                                width : 400, 
                                buttons: {
                                    "Confirm": function () {
                                        $('#sent_email').val('sent_email');
                                        $('#form_sent_email_sec').submit();
                                        $(this).dialog('close');
                                    },
                                    "Cancel": function () {
                                        $(this).dialog('close');
                                        return false;
                                    }
                                }
                            });
                        } 
                    }
                }
            });
        }      
    });
});  
</script>




