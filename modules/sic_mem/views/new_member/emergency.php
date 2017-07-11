
<script>
function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
  return true;
}
</script>
<script>
jQuery(function($){
    $(".phone_emrgency").mask("(999) 999-9999");
});
</script>
<style>
  .wrapper {  
        margin: auto; 
        text-align: center; 
        position: relative;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
        max-width: 77%;
        width: auto;
        float: left;
    }
    .scrolls { 
        overflow-x: auto;
        overflow-y: hidden;
        height: auto;
        white-space:nowrap;
        border: 2px solid #AFC4DB;
        border-radius: 6px 6px 0px 0px;
        border-bottom:none; 
    } 
    span.group_emergency{
        padding: 3px;
        height: 26px;
        border: 1px solid #000;
        display: inline-block;
        margin: 6px;
        color: #000;
        font-weight: bold;
        cursor: pointer;
    }
    .group_emergency_active{
      background-color: #AFC4DB;
    }
    .group_emergency_non_active{
      background-color: #fff;
    }
	div.validation{color: red;font-weight: bold;font-size: 11px;}
	.steped {background:#000; float:left; color:#fff; text-align:right; height:10px;}
	.step { background:#fff; float:left; color:#fff; text-align:right; height:10px;}
	.step_num {float:right; width:30px; border-radius:500px; line-height:30px; height:30px; border:#000 1px solid; text-align:center; color:#000; background:#fff; font-weight:bold}
	h1 {text-align:center; width:100%; font-size:18px;}
</style>
<div class="dash">
    <div class="dashmidd">
    	<div class="dash-right">
        	<div style="border-right:#b3c7dd 5px solid;border-bottom:#b3c7dd 5px solid; display:table; width:99%; padding-bottom:15px;">
                <form id="form_emergency" style="margin: auto;" action="<?php echo url::base() ?>login/save_emergency" method="post">
                    <div style="display:table; width:100%;">
                    	<p style="width:100%; text-align:center"><h1>First Time Set-up Wizard</h1></p>
            	<div style="width:60%; margin:0 auto; padding:0;">
                	<div style="width:98%; border:#000 1px solid; background:#fff; height:10px; float:left; position:relative">
                    	<div style="width:100%; height:10px; float:left;">
                        	<div class="steped" style="width:15%;">.</div>
                            <div class="steped" style="width:14%;">.</div>
                            <div class="steped" style="width:14%;">.</div>
                            <div class="steped" style="width:14%;">.</div>
                            <div class="steped" style="width:14%;">.</div>
                            <div class="step" style="width:14%;">.</div>
                            <div class="step" style="width:15%;">.</div>
                        </div>
                    </div>
                    <div style="width:100%;float:left; position:relative; top:-22px; z-index:10000000000000">
                    	<div style="width:15%; float:left;">
                        	<div class="step_num">1</div>
                        </div>
                        <div style="width:14%; float:left;">
                        	<div class="step_num">2</div>
                        </div>
                        <div style="width:14%; float:left;">
                        	<div class="step_num">3</div>
                        </div>
                        <div style="width:14%; float:left;">
                        	<div class="step_num">4</div>
                        </div>
                        <div style="width:14%; float:left;">
                        	<div class="step_num">5</div>
                        </div>
                        <div style="width:15%; float:left;">
                        	<div class="step_num">6</div>
                        </div>
                    </div>
                </div>
                <div style="width:100%; float:left; margin:-20px 0 0px 0">
                <p style="width:100%; text-align:center; float:left; margin:0px 0"><h1>Almost done!</h1></p>
                <p style="width:100%; text-align:center; float:left; margin:0px 0"><h1>
                Termite/WDO operators are required to include 'emergency' numbers<br />
                with each report.
                Add the name of the party (e.g. Santa Clara County Health Dept.) and the<br />
                corresponding contact number below.
                </h1></p>
                <p style="width:100%; text-align:center; float:left; margin:0px 0"><h1>You can group multiple numbers into a single "group", so you could<br />include different sets of numbers for different counties / municipal<br />units.</h1></p>
                <p style="width:100%; text-align:center; float:left; margin:0px 0"><h1>If you would rather do this later, click "Next".</h1></p>
                </div>
                        <!-- PHAN EMERGENCY -->
                            <div style="margin:0 auto; width:574px; display:table;">
                            <div class="wrapper">
                                <div class="scrolls">
                                <?php if(!empty($group_emergency)){?>
                                    <?php foreach ($group_emergency as $key => $item_group) {?>
                                    <span id="wap_group_<?php echo $item_group['id']; ?>" class="group_emergency <?php if($key<1){ echo 'group_emergency_active'; }else{ echo 'group_emergency_non_active';}?>" onclick="fn_display_wap_emergency(<?php echo $item_group['id']; ?>)">
                                        <span class="btn_pen" onclick="edit_group(<?php echo $item_group['id']; ?>)" style="cursor: pointer;width:25px;height: 25px;display: block;background-size: 25px 25px;float:left; margin-right:5px;"></span>
                                        <span id="spn_group_name_<?php echo $item_group['id']; ?>" style="line-height: 26px;"><?php echo !empty($item_group['group_name'])?$item_group['group_name']:''; ?></span>
                                        <input type="hidden" id="txt_group_name_<?php echo $item_group['id']; ?>" name="txt_group_name[]" value="<?php echo !empty($item_group['group_name'])?$item_group['group_name']:''; ?>">
                                        <input type="hidden" name="txt_group_id[]" value="<?php echo !empty($item_group['id'])?$item_group['id']:''; ?>">
                                    </span>
                                    <?php }?>
                                <?php }else{?>
                                    <span id="wap_group_1" class="group_emergency group_emergency_active" onclick="fn_display_wap_emergency(1)">
                                        <span class="btn_pen" onclick="edit_group(1)" style="cursor: pointer;width:25px;height: 25px;display: block;background-size: 25px 25px;float:left; margin-right:5px;"></span>
                                        <span id="spn_group_name_1" style="line-height: 26px;">Group 1</span>
                                        <input type="hidden" id="txt_group_name_1" name="txt_group_name[]" value="Group 1">
                                        <input type="hidden" name="txt_group_id[]" value="1">
                                    </span>
                                <?php }?>
                                </div>
                            </div>
                            <p style="line-height: 25px; margin-bottom: 0px;  float: right;" >
                                <span class="add_fr_table_dialog btn_add" onclick="add_group()" style="float:left;cursor: pointer;width:25px;height: 25px;background-size: 25px 25px;margin-left:10px"></span>
                                <span style="display: inline-block;padding-left: 2px;font-size:14px">Add another group</span> 
                            </p>
                            <div id="wap_main_emergency" style="border: 2px solid #AFC4DB;margin-bottom: 10px;clear:both; width:570px; margin:0 auto">
                            <?php if(!empty($group_emergency)){?>
                                <?php foreach ($group_emergency as $key => $item_group) {?> 
                                    <?php 
                                        $this->db->where('group_id',$item_group['id']);
                                        $emergency = $this->db->get('emergency')->result_array(false);
                                    ?>
                                <div style="padding:10px; <?php if($key > 0) {echo 'display:none';}?>;font-size:14px" id="wap_group_emergency_<?php echo $item_group['id']; ?>" class="wap_data">
                                    <div style="height: 270px;overflow: auto;">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%" >
                                            <thead>
                                                <th></th>
                                                <th style="font-size: 14px;font-weight: bold; text-align: left;padding: 5px;">Name of Party</th>
                                                <th style="font-weight: bold;font-size: 14px;text-align: left;padding: 5px;">Phone Number</th>
                                            </thead>
                                            <tbody id="add_emergency_<?php echo $item_group['id']; ?>">
                                                <?php if(!empty($emergency)){ ?>
                                                <?php foreach ($emergency as $key_emergency => $value) { ?>
                                                <tr>
                                                    <td>
                                                        <span class="delete_emergency btn_close" style="cursor: pointer;width:25px;height: 25px;display: inline-block;background-size: 25px 25px;" ></span>
                                                    </td>
                                                    <td>
                                                        <input maxlength="35" name="name_<?php echo $item_group['id']; ?>[]" id="name" value="<?php echo $value['name']; ?>"  style="width: 225px;" type="text">
                                                    </td>
                                                    <td>
                                                        <input name="phone_<?php echo $item_group['id']; ?>[]" value="<?php echo $value['phone']; ?>" class="phone_emrgency" style="width: 225px;" type="text">
                                                    </td>
                                                </tr>
                                                <script>
                                                $(function(){
                                                    $("body").on("click", ".delete_emergency", function (e) {
                                                        $('#confirm_emergency').val('yes');
                                                        $(this).parent("td").parent("tr").remove();
                                                    }); 
                                                }); 
                                                </script>
                                                <?php } ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="  border-top: 2px solid #AFC4DB;padding-top: 10px;">
                                         <span onclick="add_emergency(<?php echo $item_group['id']; ?>)" class="btn_add" style="float:left;cursor: pointer;width:25px;height: 25px;display: block;background-size: 25px 25px;"></span>
                                        <span style="font-size: 15px;  line-height: 25px;">Add another entry</span>
                                    </div>
                                </div>
                                
                                <?php } ?>
                            <?php }else{ ?>
                                <div style="padding:10px;" id="wap_group_emergency_1" class="wap_data">
                                    <div style="height: 270px;overflow: auto;">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%" >
                                            <thead>
                                                <th></th>
                                                <th style="font-size: 15px;font-weight: bold; text-align: left;padding: 5px;">Name of Party</th>
                                                <th style="font-weight: bold;font-size: 15px;text-align: left;padding: 5px;">Phone Number</th>
                                            </thead>
                                            <tbody id="add_emergency_1">
                                                <tr>
                                                    <td>
                                                        <span class="delete_emergency btn_close" style="cursor: pointer;width:25px;height: 25px;display: inline-block;background-size: 25px 25px;" ></span>
                                                    </td>
                                                    <td>
                                                        <input maxlength="35" name="name_1[]" id="name" value=""  style="width: 225px;" type="text">
                                                    </td>
                                                    <td>
                                                        <input name="phone_1[]" value="" class="phone_emrgency" style="width: 225px;" type="text">
                                                    </td>
                                                </tr>
                                                <script>
                                                $(function(){
                                                    $("body").on("click", ".delete_emergency", function (e) {
                                                        $('#confirm_emergency').val('yes');
                                                        $(this).parent("td").parent("tr").remove();
                                                    }); 
                                                }); 
                                                </script>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="  border-top: 2px solid #AFC4DB;padding-top: 10px;">
                                         <span onclick="add_emergency(1)" class="btn_add" style="float:left;cursor: pointer;width:25px;height: 25px;display: block;background-size: 25px 25px;"></span>
                                        <span style="font-size: 14px;  line-height: 25px;">Add another entry</span>
                                    </div>
                                </div>
                            <?php }?>
                            </div>
                        	</div>
                        <!--END PHAN EMERGENCY -->
                        <div style="margin-top: 2% !important;width: 202px;margin: 0 auto;">
                          <button style="width:100px;font-size:14px" class="btn" onclick="window.location.href='<?php echo url::base() ?>login/lead'" type="button">Previous</button>
                          <button style="width:100px;float: right;font-size:14px" class="btn" type="submit">Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="dash-left" style="text-align:right">
        	<p><?php if($this->session->get('member_lname')) echo $this->session->get('member_lname');  ?></p>
           <!--  <a style="color:red" href="<?php //echo url::base() ?>login/logout">Log Out</a> -->
            <button class="btn" onclick="window.location.href='<?php echo url::base() ?>login/logout'" style="width:100px;font-size:14px;" type="button">Log Out</button>
        </div>
    </div>
</div>
<!-- phan emergency -->
<!--Edit Confirm delete GROUP -->
<div style="display:none" id="dialog_delete" title="Delete Group Emergency?">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete Group Emergency. Are you sure?</p>
</div>
<!--Edit GROUP -->
<div style="display:none;font-weight: bold;" id="dialog_edit">
    <div style="padding-top:15px;">
        <input type="hidden" id="txt_group_id_edit" name="txt_group_id_edit" value="" placeholder="Group Name">
        <input style="width: 255px;" type="text" id="txt_group_name_edit" name="txt_group_name_edit" value="" placeholder="Group Name">
        <button class="btn" id="btn_delete_group" style="width:110px;float: right;" type="button">Delete Group</button>
    </div>
    
    <div style="padding-top:15px;">
        <button class="btn" id="btn_update_group" style="width:110px;" type="button">Update</button>
        <button class="btn" style="width:110px;float: right;" onclick="fn_close_group_edit()" type="button">Cancel</button>
    </div>
</div>
<!-- ADD GROUP -->
<div style="display:none;font-weight: bold;text-align: center;" id="dialog_add">
    <input type="text" style="margin-top: 20px;" id="txt_group_name_add" name="txt_group_name_add" value="" placeholder="Group Name">
</div>
<!-- phan emergency -->
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

<script>
function add_emergency($id_group){
    $('#confirm_emergency').val('yes');
    $('#add_emergency_'+$id_group).append(
        '<tr>'+
        '<td>'+
        '<span class="delete_emergency btn_close" style="cursor: pointer;width:25px;height: 25px;display: inline-block;background-size: 25px 25px;" ></span>'+
        '</td>'+
        '<td>'+
        '<input maxlength="35" name="name_'+$id_group+'[]" style="width: 225px;" type="text">'+
        '</td>'+
        '<td>'+
        '<input name="phone_'+$id_group+'[]" class="phone_emrgency" style="width: 225px;" type="text">'+
        '</td>'+
        '<script type=\"text/javascript\">jQuery(function($){$(".phone_emrgency").mask("(999) 999-9999");}); <'+'/script>'+
        '</tr>'

        );
}
</script>
<!-- DELETE -->
<script>
$(function(){
    $("body").on("click", ".delete_emergency", function (e) {
        $(this).parent("td").parent("tr").remove();
    }); 
}); 


function load_list_group(){
    $.ajax({
        type: 'POST',
        url: '<?php echo url::base() ?>suggest/list_group_emergency',
        dataType: 'json',
        success: function (data) {
            $('#slt_group_emergency').empty();
            $("#slt_group_emergency").append('<option value="0">-----</option>');
            if(data != ''){
                var max_id = 0;
                $.each(data, function(i, item) {
                    $("#slt_group_emergency").append('<option value='+item.id+' >'+item.group_name+'</option>');
                    max_id = item.id;
                });
                $("#slt_group_emergency").val(max_id);
                $.ajax({
                    type: 'POST',
                    url: '<?php echo url::base() ?>suggest/get_content_emergency',  
                    data:{ valueSelected: max_id },
                    success: function (data) {
                      $('#content_emergency').html(data);
                  }
                });
            }
       }
    });
}

function load_data_group(){
    $.ajax({
        type: 'POST',
        url: '<?php echo url::base() ?>report/listemergency',  
        success: function (data) {
            $('#wap_emergency').html(data);
       }
    });
}
</script>

<script type="text/javascript">
    function add_group(){
        var ids = $('input[name="txt_group_id[]"]').map(function(){
            return $(this).val();
        }).get();

        var max_id = 0;
        if(ids != ''){
            //max_id = Math.max.apply(Math,ids);
            max_id = ids.length;
        }
        var txt_name = $("#txt_group_name_add");
        txt_name.val('Group '+(max_id+1));

        $("#dialog_add").dialog({
            draggable: false,
            resizable: false,
            modal: true,
            title: "Group Add",
            width : 300,
            height: 150,
            buttons: {
                "Ok": function() {
                    if(txt_name.val() == ''){
                        $.growl.error({ message: "Group Name Empty!"});
                    }else{
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo url::base() ?>suggest/add_group_emergency',
                            data: {id: (max_id + 1), name: txt_name.val()},
                            success: function (resp) { 
                              $('.scrolls').append(resp);

                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo url::base() ?>suggest/add_wap_emergency',
                            data: {id: (max_id + 1), name: txt_name.val()},
                            success: function (resp) { 
                              $('#wap_main_emergency').append(resp);
                              
                            }
                        });
                        $(this).dialog("close");
                    }
                },
                "Cancel": function() {
                    $(this).dialog("close");
                },
            }
        });
    }


    function fn_display_wap_emergency($key){
        $('.group_emergency').removeClass('group_emergency_active').addClass('group_emergency_non_active');
        $('#wap_group_'+$key).removeClass('group_emergency_non_active').addClass('group_emergency_active');
        
        $('.wap_data').hide();
        $('#wap_group_emergency_'+$key).show();
    }

    function fn_close_group_edit(){
         $( "#dialog_edit" ).dialog('close');
    }
    $('#btn_update_group').click(function(event) {
        var id_group = $('#txt_group_id_edit').val();
        var name_group = $('#txt_group_name_edit').val();
        if(name_group == ''){
            $.growl.error({ message: "Group Name Empty!"});
        }else{
            $('#spn_group_name_'+id_group).text(name_group);
            $('#txt_group_name_'+id_group).val(name_group);
            fn_close_group_edit();
        }
    });
    function edit_group($id){
        $('#txt_group_id_edit').val($id);
        $('#txt_group_name_edit').val($('#txt_group_name_'+$id).val());
        $( "#dialog_edit" ).dialog({
            draggable: false,
            modal: true,
            dialogClass: "no-close",
            width: 400,
            autoOpen:true,
            title:"Edit Group"
      });
    }
    $('#btn_delete_group').click(function(event) {
        var id_group = $('#txt_group_id_edit').val();
        $("#dialog_delete").dialog({
            draggable: false,
            resizable: false,
            modal: true,
            width : 300,
            buttons: {
                "Ok": function() {
                    $.ajax({
                        url: '<?php echo url::base()?>report/delete_group_id/'+id_group,
                        type: 'POST',
                        dataType: 'json',
                    })
                    .done(function(data) {
                        if(data){
                            $.growl.notice({ message: "Delete Success!"});
                            $('#wap_group_'+id_group).remove();
                            $('#wap_group_emergency_'+id_group).remove();

                            if($('#slt_group_emergency').length > 0){
                               $("#slt_group_emergency option[value="+id_group+"]").remove();
                            }
                            var ids = $('input[name="txt_group_id[]"]').map(function(){
                                return $(this).val();
                            }).get();

                            if(ids != '')
                                fn_display_wap_emergency(ids[0]);

                        }
                        else{
                            $.growl.error({ message: "Delete False!"});
                        }
                    });
                    fn_close_group_edit();
                    $(this).dialog("close");
                },
                "Cancel": function() {
                    $(this).dialog("close");
                },
            }
        });
    });
</script>
<!-- END ADD GROUP -->


