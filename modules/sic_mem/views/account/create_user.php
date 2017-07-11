<script src="<?php echo $this->site['base_url']?>js/notification/jquery.growl.js"></script>
<link href='<?php echo url::base() ?>js/notification/jquery.growl.css' rel='stylesheet' />
<style>
    #error_email{
        color: red;
        font-size: 12px;
        display: none;
    }
    label.validation{
        color: red;
        font-size: 12px;
        font-weight: bold;
    }
</style>
<?php if($this->session->get('error_email_empty')){ ?>
  <script>
    $.growl.error({ message: "Email is required !" });
  </script>
  <?php $this->session->delete('error_email_empty') ?>
<?php } ?>
<script>
$(function(){
    $('#email_new').keyup(function(){
        var valu=$('#email_new').val();
        $.ajax({
                type: 'POST',
                url: '<?php echo url::base() ?>create/checkmail_sent',
                data: {val: valu},
                success: function (resp) {
                    if(resp !== ''){
                        $('#error_email').text(resp);
                        $('#error_email').fadeIn(200);
                        $('#btn_send_email').attr("disabled", "disabled");
                    }else{
                        $('#error_email').fadeOut(200);
                        $("#btn_send_email").removeAttr("disabled");
                    }
                }
        });
    });
});  
</script>
<div style="margin:0 auto; padding:0% 0 0 0; width:665px; display:table; text-align:justify; line-height:20px; font-size:13px;">
<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td align="center" style="padding:100px 0 20px 0">
            <?php if (!empty($this->site['site_logo'])) { ?>
              <a href="<?php echo url::base()?>">
                  <img <?php if(!empty($this->site['site_logo_height'])){ ?> height="<?php echo $this->site['site_logo_height']?>" <?php } ?> <?php if(!empty($this->site['site_logo_width'])){ ?> width="<?php echo $this->site['site_logo_width']?>" <?php } ?> border="0" src="<?php echo url::base()?>uploads/site/<?php echo $this->site['site_logo']?>">
              </a>
            <?php } ?>
        </td>
    </tr>
</table>
<span style="margin-left: 207px;">Welcome ! Looks like this is your first time logging-in.</span> <br><br>
You have purchased an Enterprise User license - meaning you can have up to two
simultaneous users using the system at a time. if you would lime to add more users,
you can purchase additional user licenses under Account Management after the initial set-up. <br>

    <span style="font-weight:bold;margin-left: 133px">You are the administration, and the first user. (user email@useremail.com)</span> <br>
    
Administrative tasks, such as <span style="font-weight:bold">billing, company information, and user management</span> are
handled on the administrator account (you) . In the event that your employee's user access from
your Account Management panel,and give the license to your new employee or partner.

Since you have two user licenses (one reserved for you, the administrator) you may use
the other license for your employee or partner. you can enter the email address for the
second user below - <span style="font-weight:bold">they will be using their own email and password to log-in to
your system.</span> the link and the information to set up the account will be sent to the email addess you send below
If you wish to do it later,you may click " I'll do it later " , and revisit this page under <span style="font-weight:bold">Account Management</span>
<p>Invite user to system</p>
<form id="form" action="<?php echo url::base() ?>login/smcreate_user" method="POST">
User E-mail:<input autofocus="autofocus" type="text" id="email_new" name="email_new"><span id="error_email"></span> <br>




  <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td>Termite Reports </td>
                        <td style="text-align: center;">Management Panel  </td>
                        <td> Invoices/Payments </td>
                        <td> Account Management  </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" value="1" name="termite_view" style="width:auto; margin:0" checked="checked"> <span>View</span>
                             <input type="checkbox" value="1" name="termite_edit" style="width:auto; margin:0"  checked="checked"> <span>Edit</span>
                        </td>
                        <td>
                            <input type="checkbox" value="1" name="management_accounting" style="width:auto; margin:0" checked="checked"> <span>Accounting</span>
                            <input type="checkbox" value="1" name="management_housekeeping" style="width:auto; margin:0"  checked="checked"> <span>Housekeeping</span>
                            <input type="checkbox" value="1" name="management_marketing" style="width:auto; margin:0" > <span>Marketing</span>
                        </td>
                        <td>
                            <input type="checkbox" value="1" name="invoices_view" style="width:auto; margin:0" checked="checked"> <span>View</span>
                            <input type="checkbox" value="1" name="invoices_post" style="width:auto; margin:0"  checked="checked"> <span>Post</span>
                            <input type="checkbox" value="1" name="invoices_edit" style="width:auto; margin:0" > <span>Edit</span>
                        </td>
                        <td>
                            <input type="checkbox" value="1" name="account_view" style="width:auto; margin:0" checked="checked"> <span>View</span>
                            <input type="checkbox" value="1" name="account_edit" style="width:auto; margin:0"  checked="checked"> <span>Edit</span>
                        </td>
                    </tr>
                </table>
    

<span style="width:100%; text-align:center; display:table; padding:20px;">
    <button style="width:160px;" id="btn_send_email" name="sent_email" value="sent_email" type="submit">Send Invitation</button>&nbsp;
    <button style="width:160px;" type="submit" name="sent_email" value="skip">I'll do it later</button>
</span>
</form>
</div>
<script>
    $(function(){
        $( "#form" ).validate({
            errorElement: 'label',
                  rules: {
                    email_new:{
                        email: true,
                    },

                  }
            });
    });
</script>
<script>
    $(function(){
        $(document).keypress(function (e) {
          if (e.which == 13) {
            $('#form').submit(function(){
                $('#loading').show(function(){
                    $('#loading').fadeTo(20000,0);
                    return false;
                });
            });
          }
        });
    });
$(function(){
    $('#butn').click(function(){
        $('#loading').show(function(){
                    $('#loading').fadeTo(20000,0);
                    return false;
                });
    });
});
</script>