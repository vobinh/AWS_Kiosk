<script src="<?php echo url::base() ?>js/live/src/jquery.quicksearch.js"></script>
<style>
div.validation{color: red;font-weight: bold;font-size: 11px;}
.steped {background:#000; float:left; color:#fff; text-align:right; height:10px;}
.step { background:#fff; float:left; color:#fff; text-align:right; height:10px;}
.step_num {float:right; width:30px; border-radius:500px; line-height:30px; height:30px; border:#000 1px solid; text-align:center; color:#000; background:#fff; font-weight:bold}
h1 {text-align:center; width:100%; font-size:18px;}
#add_search_chemical_filter input{width: 650px;border-radius: 12px;margin-top: 12px}
#add_search_chemical_filter{float: none; text-align: center;}
#add_search_chemical_wrapper th { white-space: nowrap; padding: 2px 15px 2px 2px;}
#add_search_chemical_wrapper td { white-space: nowrap; padding: 5px;}
table#add_search_chemical tr.list_report_header {background-color: rgb(226, 226, 226);border: #aaa 1px solid;line-height: 26px;font-weight: bold;}
#form_new_chemical td{padding: 0;}
.sorting_1{
  background-color: transparent !important;
}
tr.odd:hover{
  background-color: #00CCFF !important;
}
tr.even:hover{
  background-color: #00CCFF !important;
}
table.conditions_export tr td{
  color: #000;
  font-weight: bold;
}
#wap_chemical_import{
  padding: 10px;
}
</style>
<!-- CHEMICAL -->
<div style="display:none" id="frm_exp_chemical">
    <p style="font-size: 18px;color: #000;font-weight: bold;margin-bottom: 0px;margin-top: 0px;text-align:center">Choose your export format:</p>
    <table class="conditions_export" align="center" cellspacing="0" cellpadding="0" style="width:71%;margin-top: 10px;margin-bottom: 10px;">
        <tr><td><input checked="checked" name="conditions_export_chemical" value="all_chemical" id="slt_all_chemical" style="width:16px" type="radio"> Export all</td></tr>
        <tr><td><input name="conditions_export_chemical" value="selected_chemical" id="slt_selected_chemical" style="width:16px" type="radio"> Export selected only</td></tr>
        <tr><td><input name="conditions_export_chemical" value="default_chemical" style="width:16px" type="radio"> Export default entries only</td></tr>
        <tr><td><input name="conditions_export_chemical" value="custom_chemical" style="width:16px" type="radio"> Export custom entries only</td></tr>
    </table>
    <p style="text-align: center;margin-bottom: 5px;margin-top: 0px;">
        <button style="width: 120px;" type="button" class="btn" id='exp_chemical_html'>HTML</button>
        <button style="width: 120px;" type="button" class="btn" id='exp_chemical_xls'>XLS</button>
        <button style="width: 120px;" type="button" class="btn close_exp_chemical">Close</button>
    </p>
</div>
<div id="dialog-confirm"></div>
<div class="dash">
<div class="dashmidd">
  <div class="dash-right">
    <div style="border-right:#b3c7dd 5px solid;border-left:#b3c7dd 5px solid;border-bottom:#b3c7dd 5px solid; display:table; width:99%; padding-bottom:15px;">
      <div style="margin: auto;display:table; width:900px;">
<p style="width:100%; text-align:center"><h1>First Time Set-up Wizard</h1></p>
<div style="width:60%; margin:0 auto; padding:0;">
	<div style="width:98%; border:#000 1px solid; background:#fff; height:10px; float:left; position:relative">
    	<div style="width:100%; height:10px; float:left;">
        	<div class="steped" style="width:15%;">.</div>
            <div class="steped" style="width:10%;">.</div>
            <div class="steped" style="width:17%;">.</div>
            <div class="step" style="width:14%;">.</div>
            <div class="ste" style="width:14%;">.</div>
           <!--  <div class="step" style="width:14%;">.</div>
            <div class="step" style="width:15%;">.</div> -->
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
<div style="width:100%; float:left; margin:20px 0 25px 0">
<p style="width:100%; text-align:center; float:left; margin:0px 0"><h1>Let's review the pesticide codebook.</h1></p>
<p style="width:100%; text-align:center; float:left; margin:0px 0"><h1>The codebook allows you to assign codes for frequently-used pesticides for<br />quick reference.</h1></p>
<p style="width:100%; text-align:center; float:left; margin:0px 0"><h1>We have a few already in the database - see if your pesticide of choice is<br />already in there. If not, click "New Entry" to add your pesticides.</h1></p>
<p style="width:100%; text-align:center; float:left; margin:0px 0"><h1>If you're not sure what to do, click "Next" and we can do this later.</h1></p>             
</div>
<div style="border: 1px solid #000;padding: 5px; display:table;padding-bottom:0px;background-color: #fff;box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-webkit-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);"> 
  <form target="_blank" enctype="multipart/form-data" id="export_chemical_id" action="<?php echo url::base() ?>report/export_chemical" method="POST" style="width:100%; display:table">
    <div style="width: 100%;">
          <table  width="100%" id="add_search_chemical"  class="display" cellspacing="0" width="100%" style="margin: auto auto auto 0;">
              <thead>
                  <tr class="list_report_header" style="background-color: rgb(226, 226, 226);">
                    <th class='no-sort' style="padding: 2px 0px;">
                      <span style="cursor: pointer;width:25px;height: 25px;display: block;background-size: 25px 25px;float:left; margin-right:5px;"></span>
                    </th>
                    <th class='no-sort' style="padding: 2px 0px;" align="center"><input style="width:14px"  id="all_chemical"  type="checkbox" /></th>
                    <th style="font-size:14px" align="center">Code</th>
                    <th style="font-size:14px" align="center">Pesticide Name</th>
                    <th style="font-size:14px;width: 200px !important;" align="center">Unit of Measurement</th>
                    <th style="font-size:14px" align="center">EPA Reg#</th>
                    <th style="font-size:14px" align="center">Vendor</th>
                    <th style="font-size:14px" align="center">Hazard</th>
                    <th style="font-size:14px" align="center">Class</th>
                    <th style="font-size:14px" align="center">Type</th>
                  </tr>
              </thead>
              <tbody>
            <?php if(!empty($mlist)){ ?>
            <?php  foreach ($mlist as $key => $value) { ?>
            <tr id="row_<?php echo $value['id'] ?>" class="row<?php if($key%2 == 0) echo 2 ?> hover_chemical">
              <td align="center" class='no-sort' style="padding: 2px 0px;">
                <span onclick="edit_chemical(<?php echo $value['id'] ?>)" class="btn_pen" style="cursor: pointer;width:25px;height: 25px;display: block;background-size: 25px 25px;float:left; margin-right:5px;"></span>
              </td>
              <td align="center" class='no-sort' style="padding: 2px 0px;">
                <input  style="width:14px;" name="chemical[]" value="<?php echo $value['id'] ?>" class="chemical"  type="checkbox">
              </td>
              <td align="center"><span class="sd" style="cursor:pointer" ><?php echo $value['code'] ?></span></td>
              <td style="font-size:14px" align="center"><span  style="cursor:pointer" ><?php echo $value['pesticide_name'] ?></span></td>
              <td style="font-size:14px" align="center"><span  style="cursor:pointer" ><?php echo $value['unit'] ?></span></td>
              <td style="font-size:14px" align="center"><span  style="cursor:pointer" ><?php echo $value['epa'] ?></span></td>
              <td style="font-size:14px" align="center"><span  style="cursor:pointer" ><?php echo $value['vendor'] ?></span></td>
              <td style="font-size:14px" align="center"><span  style="cursor:pointer" ><?php echo $value['hazard'] ?></span></td>
              <td style="font-size:14px" align="center"><span  style="cursor:pointer" ><?php echo $value['class'] ?></span></td>
              <td style="font-size:14px" align="center"><?php echo  $value['type']; ?></td>
            </tr>
            <?php } }?>
               </tbody>
          </table>
    </div>
    <div class="listbtn">
        <table sty width="100%">
            <tr>
                <td align="center" style="">
                    <span style="float: left;">
                        <button style="width:100px;font-size:14px"  class="new_chemical btn" class="btn" type="button">New Entry...</button>
                    </span>
                    <span style="float: right;">
                        <button class="btn" style="font-size:14px"  type="button" id="exp_chemical">Export List...</button> 
                        <button id="import_chemical" style="width:100px;font-size:14px" class="btn" type="button">Import List...</button> 
                        <button class="btn" style="font-size:14px" onclick="delete_list_chemical()" type="button">Delete Selected...</button>&nbsp;
                    </span>
                </td>
            </tr>
        </table>
    </div> 
    <div id="exp_chemical_div"></div>  
    <input type="hidden" id="export_conditions_chemical" name="export_conditions_chemical" value="all_chemical">     
    </form>
</div>
<form action="<?php echo url::base()  ?>create/sm_chemical" method="POST">
  <div style="margin-top: 2% !important;width: 202px;margin: 0 auto;">
    <button style="width:100px;font-size:14px"  class="btn" onclick="window.location.href='<?php echo url::base() ?>create/inspector'" type="button">Previous</button>
    <button style="width:100px;float: right;font-size:14px" class="btn"   type="submit">Next</button>
  </div>
  </div>
  </div>
</form>
</div>
  <div class="dash-left" style="text-align:right">
  	<p style="text-align: right;margin-bottom: 2px;font-weight: bold;color: #000;"><?php if($this->sess_cus['name']) echo $this->sess_cus['name'];  ?></p>
    <p style="margin-top: 0px;margin-bottom: 5px;font-weight: bold;color: #000;"><?php if($this->sess_cus['email']) echo $this->sess_cus['email'];  ?></p>
    <button class="btn" onclick="window.location.href='<?php echo url::base() ?>login/logout'" style="width:100px;font-size:14px;float: right;" type="button">Log Out</button>
  </div>
</div>
<input type="hidden" id="update_chemical">
<form id="form_new_chemical" style="display:none" method="POST" action="<?php echo url::base()  ?>report/save_new_contact">
  <div style="text-align: center;display:none;color: rgb(93, 69, 218);background-color:rgb(224, 247, 190);padding: 5px;" id="error_chemical">Code exists !</div>
                <input type="hidden" id="code_chemical_hide">
                <div style="padding:0 10px;">
                <table cellpadding="0" style="padding-left: 10px;" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td>
                        <span style="width:100%; display:table">
                            <span style="width:50%; display:table; float:left; line-height:20px;">Code</span>
                            <span style="width:50%; display:table; float:left; line-height:20px;">Unit of Measurement</span>
                        </span>
                        <span style="width:100%; display:table">
                            <span style="width:50%; display:table; float:left"><input onkeyup="check_code()" style="width:90%" type="text" id="code_chemical" name="code_chemical"></span>
                            <span style="width:50%; display:table; float:left"><input style="width:90%" type="text" id="unit" name="unit"></span>
                        </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Pesticide Name</td>
                    </tr>
                    <tr> <td>
                        <input style="width:95%" id="pesticide_name" type="text" name="pesticide_name">
                        </td>
                    </tr>
                    <tr>
                        <td>EPA Reg#</td>
                    </tr>
                    <tr> <td>
                        <input style="width:95%" id="epa" type="text" name="epa">
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <span style="width:100%; display:table">
                            <span style="width:33%; display:table; float:left; line-height:20px;">Vendor</span>
                            <span style="width:33%; display:table; float:left; line-height:20px;">Hazard</span>
                            <span style="width:33%; display:table; float:left; line-height:20px;">Class</span>
                        </span>
                        <span style="width:100%; display:table">
                            <span style="width:33%; display:table; float:left">
                                <input id="vendor" style="width:85%" type="text" name="vendor">
                            </span>
                            <span style="width:33%; display:table; float:left">
                                <select style="width: 125px;" name="hazard" id="hazard">
                                    <option value="">-----</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                                <!-- <input id="hazard" style="width:85%" type="text" name="hazard"> -->
                            </span>
                            <span style="width:33%; display:table; float:left">
                                <select style="width: 125px;" name="class_chemical" id="class_chemical">
                                    <option value="1 - Danger">1-Danger</option>
                                    <option value="2 - Warning">2-Warning</option>
                                    <option value="3 - Caution">3-Caution</option>
                                </select>
                                <!-- <input id="class_chemical" style="width:88%" type="text" name="class_chemical"> -->
                            </span>
                        </span>
                        </td>
                    </tr>                   
                </table>    
            <span style="width:100%; padding:10px 0; text-align:center; display:table">
                <button style="width:100px" type="button" class="btn" id="commit_chemical" onclick="save_chemical()" >Save</button>&nbsp;
                <button style="width:100px" id="btn_contact_list" onclick="close_new_chemical()"  class="button b-close btn" type="button">Cancel</button>
            </span>
            </div>   
</form>

<form enctype="multipart/form-data" style="display:none" id="frm_download_chemical" method="POST" action="<?php echo url::base()  ?>contact/download_template">
    <input type="hidden" name="txt_name_bucket" value="template/chemical">
    <input type="hidden" name="txt_name_file" value="list_pesticide_chemical_template.xls">
</form>

<script type="text/javascript">
  $(function(){
    $('input:radio[name="conditions_export_chemical"]').change(function(){
        var fr_op = $(this).val();
        $('#export_conditions_chemical').val(fr_op);
    });
  });
  $(document).ready(function() {
    $('#exp_chemical').click(function(){
        $( "#frm_exp_chemical" ).dialog({
          draggable: false,
          modal: true,
          dialogClass: "no-close",
          width: "auto",
          height: "auto",
          autoOpen:true,
          title:"Export Chemical"
        });
        if($('.chemical:checked').length > 0){
          $('#slt_selected_chemical').click();
        }else{
          $('#slt_all_chemical').click();
        }
    });
    $('.close_exp_chemical').click(function(){
        $( "#frm_exp_chemical" ).dialog( "close" );
        $('#exp_chemical_div').empty();
    });
    $('#frm_exp_chemical').bind('dialogclose', function(event, ui) {
       $('#exp_chemical_div').empty();
    });
    $('#exp_chemical_xls').click(function(){
      $("#export_chemical_id").removeAttr('target');
        $('#exp_chemical_div').empty();
        $( "#export_chemical_id" ).submit();
    });
    $('#exp_chemical_html').click(function(){
      $("#export_chemical_id").attr("target","_blank");
        $('#exp_chemical_div').append(
            "<input type='hidden' name='exp_html_chemical' value='exp_html_chemical'>"
        );
        $( "#export_chemical_id" ).submit();
    });
    $('#btn_download_chemical').click(function() {
       $('#frm_download_chemical').submit();
    });
  });
  $(document).ready(function() {
      var table_data = $('#add_search_chemical').dataTable({
          "scrollY": "300px",
          "paging": false,
          "scrollX": false,
          "info": false,
          "columnDefs": [{ 
            targets: 'no-sort', 
            orderable: false,
          }],
          "oLanguage": { 
            "sSearch": "" ,
      },
      "initComplete": function () {
        $('#export_chemical_id input').attr({
          'placeholder': 'Showing All',
          'results': 'results'
        });
              var api = this.api();
              api.order([ 2, 'asc' ]).draw();
          }
      });
  });
$(function(){
  $('input#id_search').quicksearch('table#add_search_chemical tbody tr');
  $('.new_chemical').click(function(){
    $( "#form_new_chemical" ).dialog({
      draggable: false,
      resizable: false,
      modal: true,
      dialogClass: "no-close",
      width: "auto",
      height: 290,
      autoOpen:true,
      title:"New Pesticide/Chemical Codes"
    });
    code_chemical=$('#code_chemical').val('');
    unit=$('#unit').val('');
    pesticide_name=$('#pesticide_name').val('');
    epa=$('#epa').val('');
    vendor=$('#vendor').val('');
    hazard=$('#hazard').val('');
    class_chemical=$('#class_chemical').val('');
    update_chemical=$('#update_chemical').val('');
  });    
});
function close_new_chemical(){
    $( "#form_new_chemical" ).dialog( "close" );
}
function save_chemical(){
  var code_chemical   = $('#code_chemical').val();
  if(code_chemical == ''){
    $.growl.error({ message: "Code empty !" });
    return false;
  }
  var unit            = $('#unit').val();
  var pesticide_name  = $('#pesticide_name').val();
  var epa             = $('#epa').val();
  var vendor          = $('#vendor').val();
  var hazard          = $('#hazard').val();
  var class_chemical  = $('#class_chemical').val();
  var update_chemical = $('#update_chemical').val();
  var code_old_hide   =$('#code_chemical_hide').val();

  if(code_chemical == code_old_hide){
    $.ajax({
      type: 'POST',
      url: '<?php echo url::base() ?>report/save_chemical',
      data: {update_chemical: update_chemical,code_chemical: code_chemical,unit: unit,pesticide_name: pesticide_name,epa: epa,vendor: vendor,hazard: hazard,class_chemical: class_chemical,},
      success: function (resp) {
        close_new_chemical();
        location.reload();
      }
    });
  }else{
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: '<?php echo url::base() ?>report/check_code_chemical',
      data: {code: code_chemical},
      success: function (resp) {                      
          if(resp['message'] === 'true'){
              $.growl.error({ message: "Code exists !" });
          }else{
              $.ajax({
                type: 'POST',
                url: '<?php echo url::base() ?>report/save_chemical',
                data: {update_chemical: update_chemical,code_chemical: code_chemical,unit: unit,pesticide_name: pesticide_name,epa: epa,vendor: vendor,hazard: hazard,class_chemical: class_chemical,},
                success: function (resp) {
                  close_new_chemical();
                  location.reload();
                }
              });             
          }                       
      }
    });
  }  
}
function delete_list_chemical(){

     var checkValues = $('.chemical:checked').map(function(){
            return $(this).val();
      }).get();
     $("#dialog-confirm").html("Are you sure you want to delete this record ?");
        $("#dialog-confirm").dialog({
            resizable: false,
            draggable: false,
            modal: true,
            title: "Delete",
            dialogClass: "no-close",
            width : 400,
            buttons: {
                "Yes": function () {
                    $(this).dialog('close');
                    $.ajax({
                            type: 'POST',
                            url: '<?php echo url::base() ?>report/delete_list_chemical',
                            data: {ids: checkValues},
                            success: function (resp) {
                                var t = JSON.parse(resp);
                                $.each(t, function (key, value) {                                    
                                  $('tr#row_'+value).fadeOut('slow');
                                });  
                            }
                    });
                },
                "No": function () {
                $(this).dialog('close');
                }
            }
         });
      

}
$(document).ready(function() {
    $('#all_chemical').click(function() {  //on click 
        var c = this.checked;
        $('.chemical:checkbox').prop('checked',c);
    });
    
});
$(function(){
  $('#import_chemical').click(function(){
        $( "#wap_chemical_import" ).dialog({
            draggable: false,
            resizable: false,
            modal: true,
            height: "auto",
            dialogClass: "no-close",
            width: 500,
            autoOpen:true,
            title:"Import Pesticide/Chemical Codes"
        });
    });    
});
function close_import_chemical(){
    $( "#wap_chemical_import" ).dialog( "close" );

}
$(function(){
        var options = { 
    beforeSend: function(){
        $('#loading_img').show();
        $("#progress_import_chemical").show();
        //clear everything
        $("#bar_import_chemical").width('0%');
        $("#message_import_chemical").html("");
        $("#percent_import_chemical").html("0%");
    },
    uploadProgress: function(event, position, total, percentComplete) 
    {
        $("#bar_import_chemical").width(percentComplete+'%');
        $("#percent_import_chemical").html(percentComplete+'%');

    
    },
    success: function() 
    {
        $("#bar_import_chemical").width('100%');
        $("#percent_import_chemical").html('100%');

    },
    complete: function(response) 
    {
        $('#loading_img').hide();
        console.log(response.responseText);
        if(response.responseText == 'error'){
          $('#error_import_chemical').fadeIn('slow');
          setTimeout( "jQuery('#error_import_chemical').fadeOut('slow');",4000 );
        }else{
          location.reload();
        }
        
        
    },
    error: function()
    {
        $('#loading_img').hide();
        $("#message_import_chemical").html("");

    }
     
}; 
        $("#wap_chemical_import").ajaxForm(options);
    });
function edit_chemical(id){
  $.ajax({
        type: 'POST',
        url: '<?php echo url::base() ?>create/check_default_chmical', 
        dataType: 'JSON',
        data:{id: id},  
        success: function (data) {
          if(data['message'] == true){
            $( "#form_new_chemical" ).dialog({
              draggable: false,
               modal: true,
              dialogClass: "no-close",
              width: "auto",
               height: 290,
              autoOpen:true,
              title:"New Pesticide/Chemical Codes"
            });
            $.ajax({
                type: 'POST',
                dataType:'JSON',
                url: '<?php echo url::base() ?>report/edit_chemical',
                data: {id: id},
                success: function (resp) {
                  code_chemical=$('#code_chemical').val(resp['code']);
                  $('#code_chemical_hide').val(resp['code']);
                  unit=$('#unit').val(resp['unit']);
                  pesticide_name=$('#pesticide_name').val(resp['pesticide_name']);
                  epa=$('#epa').val(resp['epa']);
                  vendor=$('#vendor').val(resp['epa']);
                  hazard=$('#hazard').val(resp['hazard']);
                  class_chemical=$('#class_chemical').val(resp['class']);
                  $('#update_chemical').val(id);
                }
            });
          }else{
            $.growl.error({ message: "You cannot edit default code." });
          }
        }
    });
  
}
</script>