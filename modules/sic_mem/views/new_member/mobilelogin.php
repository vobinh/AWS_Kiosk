<script src="<?php echo $this->site['base_url']?>js/notification/jquery.growl.js"></script>
<link href='<?php echo url::base() ?>js/notification/jquery.growl.css' rel='stylesheet' />
<style>
    div.validation{
        color: red;
        font-weight: bold;
        font-size: 11px;
    }
    table#table_contact thead tr td {
        border-right: 1px solid #000;
        border-bottom: 1px solid #000;
    }
    table#table_contact tbody tr td {
        border-right: 1px solid #000;
        border-bottom: 1px solid #000;
    }
</style>
<div id="loading_send_email" style="display: none;position: fixed;left: 0;right: 0;top: 0;z-index: 10000;background-color: rgba(128, 128, 128, 0.7);height: 100%;width: 100%;">
    <div style="top: 50%;left: 50%;position: absolute;">
    <img src="<?php echo url::base() ?>themes/client/styleSIC/index/pics/loading.gif" alt="">
    </div>
</div>
<div style="display:none;margin: 0 auto;float: right;  padding-top: 10px;padding-bottom: 10px;" id="log_out_mobile">
    <span id="email_mobile" style="display: inline;font-weight: bold;font-size: 14px;"></span>
    <a href="javascript:void(0)" style="color: red;font-size: 14px;padding-left: 10px;text-decoration: none;" id="btn_log_out">Log-out</a>
</div>
<form action="<?php echo url::base() ?>mobile/smlogin"  method="POST" id="form">
<div style="padding:0 0 200px 0; background:#fff; width:236px; margin:0 auto">
<table width="100%" border="0"  cellspacing="0" cellpadding="0">
    <tr>
        <td align="center" style="padding:100px 0 20px 0">
        <a href="<?php echo url::base() ?>"><img border="0" src="<?php echo url::base() ?>uploads/site/1412043079logo.png"></a>
        </td>
    </tr>
    <tr>
        <td align="center">
            <label>E-mail</label>
            <input autofocus="autofocus" type="text" id="email" name="email">
        </td>
    </tr>
    <tr>
        <td align="center">
            <label>Password</label>
            <input type="password" id="pass" name="pass">
        </td>
    </tr>
    <tr>
        <td align="center">
            <button type="button" id="login" value="Log-in">Log-in</button>
        </td>
    </tr>
</table>
</div>
</form>
<table cellspacing="0" cellpadding="0" id="table_contact" style="width:100%;display:none;  border: 1px solid #000;  border-left: 2px solid #000;  border-top: 2px solid #000;margin: 7px;">
    <thead>
        <tr  style="background-color:#E2E2E2">
            <td>Name</td>
            <td>address</td>
            <td>address 2</td>
            <td>city</td>
            <td>State</td>
            <td>Company</td>
            <td>Zip</td>
            <td>phone_home</td>
            <td>phone_mobile</td>
            <td>phone_work</td>
            <td>fax</td>
            <td>email</td>
        </tr>
    </thead>
    <tbody id="add_contact">

    </tbody>
</table>

<script>
$(function(){
    $(document).keypress(function (e) {
      if (e.which == 13) {
       var valu=$('#email').val();
       var pass=$('#pass').val();
       if(valu === ""){
            $('#loading').show(function(){
                $('#loading').fadeTo(5000,0);
            });
       }else{
             $('#login').click();
       }
      }
    });
});
$(function(){
    $('#login').click(function(){
        $('#form').submit();
        // var email=$('#email').val();
        // var pass=$('#pass').val();
        // $.ajax({
        //     type: 'POST',
        //     dataType: 'JSON',
        //     url: '<?php echo url::base() ?>mobile/smlogin',
        //     data: {email: email,pass: pass},
        //     success: function (resp) { 
        //         // console.log(resp);
        //         // document.write(resp);
        //         //$('#add_contact').append(resp);
        //         // if(resp['check'] == true){                 
        //         //     $('#email_mobile').text(resp['email']);
        //         //     //load_contact(resp['refer_user_id']);
        //         // }else{
        //         //      $.growl.error({ message: "Login Fail !" });
        //         // }
        //     }
        // });
    });
});
function load_contact(refer_id){
    $('#loading_send_email').show();
    $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: '<?php echo url::base() ?>mobile/list_contact',
            data:{ refer_id:refer_id },
            success: function (data) {
                document.write(data);
                $('#form').hide();
                $('#table_contact').show();
                $('#log_out_mobile').show();
                // $.each(data, function(i, item) {                    
                //     $('#add_contact').append(
                //         '<tr>'+
                //             '<td>'+item['name']+'</td>'+
                //             '<td>'+item['address']+'</td>'+
                //             '<td>'+item['address_2']+'</td>'+
                //             '<td>'+item['city']+'</td>'+
                //             '<td>'+item['state']+'</td>'+
                //             '<td>'+item['title']+'</td>'+
                //             '<td>'+item['zip']+'</td>'+
                //             '<td>'+item['phone_home']+'</td>'+
                //             '<td>'+item['phone_mobile']+'</td>'+
                //             '<td>'+item['phone_work']+'</td>'+
                //             '<td>'+item['fax']+'</td>'+
                //             '<td>'+item['email']+'</td>'+
                //         '</tr>'
                //     );
                // });
                $('#loading_send_email').hide();
            }
    });
}
$(function(){
    $('#btn_log_out').click(function(){
        $('#form').show();
        $('#table_contact').hide();
        $('#log_out_mobile').hide();
        $('#add_contact').empty();
        $('#email').val('');
        $('#pass').val('');
    });
});
</script>

