<div style="width:100%; display:table;">
    <div style="width:70%; float:left; padding-right:5px;padding-left: 5px;">
    <?php if(!empty($info)){ if($info['user_type'] != 1){  ?>  
        <div style="width:100%; display:table">
            <div style="width:100%; display:table; float:left;">
                <p style="margin-bottom: 5px;"><strong style="color:#000">Announcements</strong></p>
                <div  class="default-skin demo scrollable" <?php if($this->sess_cus['user_type'] != 1){ ?>style="min-height:187px; max-height:187px; text-align:left; border:#afc4db 4px solid; position:relative; overflow: hidden;"<?php }else{?>style="min-height:152px; max-height:150px; text-align:left; border:#afc4db 4px solid; position:relative; overflow: hidden;"<?php }?> >
                    <div style="padding:5px;" id="div_main_content_bulletin">
                     <?php if(!empty($info)){ 
                        if($info['user_type'] != 1){  ?> <!-- ko phai singer -->
                        <!-- Get data bulletin -->
                        <?php
                            $this->db->join('member',array('member.uid'=>'announcements.user_id'));
                            $this->db->where('announcements.refer_user_id', $this->sess_cus['refer_user_id']);
                            $this->db->orderby('date','desc');
                            $this->db->select('announcements.*','member.member_fname','member.member_lname');
                            $data_bulletin = $this->db->get('announcements')->result_array(false);
                            if(!empty($data_bulletin)){
                                foreach ($data_bulletin as $key => $item_bulletin) {
                        ?>
                            <div id="div_item_bulletin_<?php echo $item_bulletin['id'] ?>" style="margin-bottom: 5px;width: auto;overflow: hidden;border: 2px solid #AFC4DB;border-top-left-radius: 6px;border-top-right-radius: 6px;padding: 5px;">
                                <div style="width: 100%;overflow: hidden;border-bottom: 2px solid #AFC4DB;line-height: 26px;">
                                    <?php echo date('m/d/Y H:i A',$item_bulletin['date'])?> - <?php echo !empty($item_bulletin['member_fname'])?$item_bulletin['member_fname'].' ':''; ?><?php echo !empty($item_bulletin['member_lname'])?$item_bulletin['member_lname']:''; ?>
                                    <?php if($this->sess_cus['id'] == $item_bulletin['refer_user_id'] || $this->sess_cus['id'] == $item_bulletin['user_id']) {?>
                                    <span class="btn_pen" style="cursor: pointer;width:25px;height: 25px;display: block;background-size: 25px 25px;float:right;" onclick="fn_edit_bulletin(<?php echo $item_bulletin['id'] ?>)"></span>
                                    <?php }?>
                                </div>
                                <div>
                                    <p style="font-weight: bold;margin: 2px auto;line-height: 1.1em;">
                                        <?php echo !empty($item_bulletin['title'])?$item_bulletin['title']:''; ?>
                                    </p>
                                    <p style="margin: 2px auto;line-height: 1.1em;">
                                        <?php echo !empty($item_bulletin['content'])?$item_bulletin['content']:''; ?>
                                    </p>
                                </div>
                            </div>
                            <?php }}?> <!-- if data bulletin -->
                        <?php }} ?> <!-- if info -->
                    </div>
                     <span id="sp_btom"></span>                            
                </div>
                <div style="padding:5px 1% 5px 0; width:99%; float:right; text-align:right; background:#afc4db">
                 
                 <button class="btn" type="button" onclick="fn_open_bulletin()" style="margin:0">New Bulletin</button> 

                </div>
            </div>
        </div>
    <?php } } ?>
        <div style="width:100%; display:table">
        <p style="margin-bottom: 5px;"><strong style="color:#000">A&K Notifications</strong></p>
            <div class="default-skin demo scrollable" <?php if($this->sess_cus['user_type'] != 1){ ?>style="height:145px; text-align:left; border:#afc4db 4px solid; position:relative; overflow: hidden;" <?php }else{ ?> style="height:417px; text-align:left; border:#afc4db 4px solid; position:relative; overflow: hidden;" <?php } ?>>
                <span style=" padding:2%; display:table; width:96%">
                <?php if(!empty($m_notification)){?>
                 <?php foreach ($m_notification as $key_no => $m_notification) {?>

                    <label>
                    <?php echo $m_notification['date']; ?>  - <strong><?php echo $m_notification['title']; ?></strong><br />
                    <?php echo $m_notification['content']; ?>
                    </label>
                <?php }} else{?>
                    <label>---NO NOTIFICATION---</label>
                <?php } ?>
                </span>
            </div>
        </div>
    </div>
    <div id="wap_schedule" style="width:27%;float:right; padding-right:5px;">
        <p style="margin-bottom: 5px;"><strong>Today's Schedule</strong></p>
        <div style="height:385px; text-align:left; border:#afc4db 4px solid; position:relative; text-align:left">
            <p style="text-align:center;font-weight: bold;margin: 10px;" ><?php echo date('m/d/Y');?></p>
            <span style="border-top: 4px solid #afc4db;display: block;"></span>
            <div class="default-skin demo scrollable" style="height:285px; text-align:left; position:relative; text-align:left; overflow: hidden;">
                 <span style=" padding:2%; display:table; width:96%">
                    <table style="width: 100%;">
                        <tbody>
                            <?php if(!empty($mschedule)) {?>
                            <?php foreach ($mschedule as $value) {?>
                                <tr>
                                    <td style="width: 30%;">
                                        <span style="font-size: 13px"><?php echo $value['time_start'] ?></span>
                                    </td>
                                    <td style="border: 1px solid #<?php if($value['type_event'] == 2){echo '000';}else{echo isset($value['rgb'])?$value['rgb']:'000';} ?>;border-radius: 5px; background:#<?php echo isset($value['rgb'])?$value['rgb']:'fff';?>">
                                        <span style="font-size: 13px"><?php echo $value['content']?></span>
                                    </td>
                                </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                </span>
            </div>
           
            <div class="default-skin demo scrollable" style="padding:5px 2% 5px 15px; width:93%;text-align:right;border-top: 2px solid #808080;overflow: hidden;height: 40px;">
                <?php if(!empty($m_ins)) {?>
                <?php foreach ($m_ins as $value) {?>

                <div style="float: left; padding-right: 10px; height: 20px;">
                    <p class="circle" style="margin-top: 5px;margin-bottom: 5px;float: left; background:#<?php echo $value['rgb'] ?>"></p>
                    <span  style="float: left; line-height: 20px; padding-left: 5px;" ><b><?php echo $value['ins_name'] ?></b></span>
                </div>           
                <?php }} ?> 
            </div>
        </div>
        <div style="padding:5px 2% 5px 0;  background:#afc4db; float:right; width:98%; text-align:right;">
            <button class="btn" type="button" onclick="openCalendar()" style="margin:0"><a class="btn" style="color:#fff; text-decoration:none"  href="javascript:void(0)">View Calendar</a></button>
        </div>
    </div>
</div>
<!-- form new bulletin -->
<div id="div_add_bulletin" style="display:none;">
    <form id="form_bulletin" action="">
        <div>
            <?php 
                $this->db->where('member_id', $this->sess_cus['refer_user_id']);
                $company = $this->db->get('company')->result_array(false);
            ?>
            <p>From: <?php echo $this->sess_cus['name']; ?><?php echo !empty($company[0]['company_name'])?',&nbsp;'.$company[0]['company_name']:'';?>(<?php echo $this->sess_cus['email']; ?>)</p>
            <p>Title: <input id="txt_title_bulletin" name="txt_title_bulletin" style="width: 93%;  float: none;" type="text"></p>
            <textarea placeholder=""  name="txt_content_bullentin" id="txt_content_bullentin" cols="30" rows="10"></textarea>
        </div>
        <div style="margin-top: 5px;float: right;">
            <span>
                <button class="btn" type="button" onclick="save_bulletin()" style="width:90px">Save</button>
            </span>
            <span>
                <button class="btn" type="button" onclick="close_bulletin()" style="width:90px">Cancel</button>
            </span>
        </div>
    </form>
</div>
<!-- End form new bulletin -->

<!-- form new bulletin -->
<div id="div_edit_bulletin" style="display:none;">
    <form id="form_edit_bulletin" action="">
        <div>
            <?php 
                $this->db->where('member_id', $this->sess_cus['refer_user_id']);
                $company = $this->db->get('company')->result_array(false);
            ?>
            <p>From: <?php echo $this->sess_cus['name']; ?><?php echo !empty($company[0]['company_name'])?',&nbsp;'.$company[0]['company_name']:'';?>(<?php echo $this->sess_cus['email']; ?>)</p>
            <p>Title: <input id="txt_title_edit_bulletin" name="txt_title_edit_bulletin" style="width: 93%;  float: none;" type="text"></p>
            <textarea placeholder="" name="txt_edit_content_bullentin" id="txt_edit_content_bullentin" cols="30" rows="10"></textarea>
        </div>
        <div style="margin-top: 5px; width:100%;">
            <input type="hidden" name="txt_h_bulletin_id" id="txt_h_bulletin_id" value="">
            <span>
                <button class="btn" type="button" onclick="delete_bulletin()" style="width:100px">Delete</button>
            </span>
            <span style="float: right;">
                <button class="btn" type="button" onclick="edit_bulletin()" style="width:100px">Save</button>
                <button class="btn" type="button" onclick="close_edit_bulletin()" style="width:100px">Cancel</button>
            </span>
        </div>
    </form>
</div>
<div id="div_cf_delete_bulletin" title="Delete?" style="display:none;">
  <p style="margin:0 auto;"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete Bulletin. Are you sure?</p>
</div>
<!-- End form new bulletin -->


<script type="text/javascript">
    $(window).load(function () {
        $(".demo").customScrollbar();
    });

    function close_bulletin(){
        $('#div_add_bulletin').dialog('close');
    }
    function close_edit_bulletin(){
        $('#div_edit_bulletin').dialog('close');
    }
    function fn_open_bulletin(){
        $('#txt_title_bulletin').val('');
        $('#txt_content_bullentin').val('');
        CKEDITOR.replace('txt_content_bullentin',{toolbarGroups :[{ name: 'basicstyles', groups: [ 'basicstyles','undo','align']}],enterMode : CKEDITOR.ENTER_BR});
        $( "#div_add_bulletin" ).dialog({
            draggable: false,
            modal: true,
            dialogClass: "no-close",
            width: 700,
            height: 445,
            autoOpen:true,
            title:"Add Bulletin",
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

    function fn_edit_bulletin(id){
        $.ajax({
            url: '<?php echo url::base()?>login/get_bulletinID/'+id,
            type: 'GET',
            dataType: 'json',
        })
        .done(function(data) {
            if(data != 'false'){
                $('#txt_h_bulletin_id').val(data['id']);
                $('#txt_title_edit_bulletin').val(data['title']);
                $('#txt_edit_content_bullentin').val(data['content']);

                CKEDITOR.replace('txt_edit_content_bullentin',{toolbarGroups :[{ name: 'basicstyles', groups: [ 'basicstyles','undo','align']}],enterMode : CKEDITOR.ENTER_BR});
                $( "#div_edit_bulletin" ).dialog({
                    draggable: false,
                    modal: true,
                    dialogClass: "no-close",
                    width: 700,
                    height: 445,
                    autoOpen:true,
                    title:"Edit Bulletin",
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
        })
        .fail(function() {
            
        });
    }

    $('#div_edit_bulletin').bind('dialogclose', function(event) {
        CKEDITOR.instances.txt_edit_content_bullentin.destroy();
    });
    $('#div_add_bulletin').bind('dialogclose', function(event) {
        CKEDITOR.instances.txt_content_bullentin.destroy();
    });

    function delete_bulletin(){
        var id = $('#txt_h_bulletin_id').val();
        $( "#div_cf_delete_bulletin" ).dialog({
            resizable: false,
            modal: true,
            width:250,
            hieght:'auto',
            dialogClass: "no-close",
            buttons: {
                "Delete": function() {
                    $.ajax({
                        url: '<?php echo url::base()?>login/delete_bulletinID/'+id,
                        type: 'POST',
                        dataType: 'json',
                    })
                    .done(function(data) {
                       if(data != 'true'){
                            $('#div_item_bulletin_'+id).remove();
                            $(".demo").customScrollbar("resize", true);
                            //get_data_bulletin();
                            $.growl.notice({ message: "Delete data success!"});
                        }else{
                            $.growl.error({ message: "Delete data failed!"});
                        }
                        close_edit_bulletin();
                    })
                    .fail(function() {
                        $.growl.error({ message: "Delete data failed!"});
                        close_edit_bulletin();
                    });
                  $( this ).dialog( "close" );
                },
                Cancel: function() {
                  $( this ).dialog( "close" );
                }
            }
        });
    }

    function edit_bulletin(){
        CKEDITOR.instances.txt_edit_content_bullentin.updateElement();
        var title= $('#txt_title_edit_bulletin').val();
        var content = $('#txt_edit_content_bullentin').val();
        if(title =='' || content ==''){
            $.growl.error({ message: "Please enter full before update!" });
        }else{
            var data = $('#form_edit_bulletin').serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo url::base() ?>login/edit_bulletin',
                data: data,
                dataType:'json',
                success: function (resp) {
                    close_edit_bulletin();
                    if(resp != 'true'){
                        get_data_bulletin();
                        $.growl.notice({ message: "Update data success!"});
                    }else{
                        $.growl.error({ message: "Update data failed!"});
                    }
                }
            });  
        }
    }
    function save_bulletin(){
        CKEDITOR.instances.txt_content_bullentin.updateElement();
        var title= $('#title_bulletin').val();
        var content = $('#txt_content_bullentin').val();
        if(title =='' || content ==''){
            $.growl.error({ message: "Please enter full before save!" });
        }else{
            var data = $('#form_bulletin').serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo url::base() ?>login/save_bulletin',
                data: data,
                dataType:'json',
                success: function (resp) {
                    close_bulletin();
                    if(resp != 'false'){
                        get_data_bulletin();
                        $.growl.notice({ message: "Your bulletin has been posted!"});
                    }else{
                        $.growl.error({ message: "Save data failed!"});
                    }
                }
            });  
        }
    }

    function get_data_bulletin(){
        $.ajax({
            url: '<?php echo url::base()?>ajax_progress/get_data_bulletin',
            type: 'GET',
        })
        .done(function(data) {
            if(data != 'die')
                $('#div_main_content_bulletin').html(data);
            //else
            //    clearInterval(my_bulletin);
        })
        .fail(function() {
             $.growl.error({ message: "Get data failed!"});
        });
    }
   // var my_bulletin = setInterval(function(){ get_data_bulletin() }, 120000);//2i 120000

   
</script>