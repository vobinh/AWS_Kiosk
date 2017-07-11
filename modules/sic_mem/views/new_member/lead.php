<style>
div.validation{color: red;font-weight: bold;font-size: 11px;}
.steped {background:#000; float:left; color:#fff; text-align:right; height:10px;}
.step { background:#fff; float:left; color:#fff; text-align:right; height:10px;}
.step_num {float:right; width:30px; border-radius:500px; line-height:30px; height:30px; border:#000 1px solid; text-align:center; color:#000; background:#fff; font-weight:bold}
h1 {text-align:center; width:100%; font-size:18px;}
#add_search_lead_filter input{width: 97%;border-radius: 12px;margin-left:0;}
#add_search_lead_filter{float: none; text-align: center;padding-top: 10px;}
#add_search_lead th { white-space: nowrap; padding: 2px 15px 2px 2px;}
#add_search_lead td { white-space: nowrap; padding: 2px 15px 2px 2px;}
table#add_search_lead tr.list_report_header {background: #ccc;border: #aaa 1px solid;line-height: 26px;font-weight: bold;}
.sorting_1{background-color: transparent !important;}
tr.odd:hover{background-color: #00CCFF !important;}
tr.even:hover{background-color: #00CCFF !important;}
</style>

<script>
    function isNumberKey(evt)
  {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57))
  return false;

  return true;
  }
</script>
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
                            <div class="ste" style="width:14%;">.</div>
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
                <div style="width:100%; float:left; margin:15px 0 15px 0">
                <p style="width:100%; text-align:center; float:left; margin:0px 0"><h1>Next, let's review the lead sources function.</h1></p>
                <p style="width:100%; text-align:center; float:left; margin:0px 0"><h1>
                	With every inspection report, you have the option of noting the "lead source",<br />so you could view how you get most of your customers in the Management<br />
                    Panel. The system already gives you a list of common sources, but if you<br />
                    would like to add your own entries, you can do so here.
                </h1></p>
                <p style="width:100%; text-align:center; float:left; margin:0px 0"><h1>If you're not sure what to do, click "Next" and we can do this later.</h1></p>
                </div>

        <div style="width: 400px;margin: 0 auto;border: 1px solid #000; display:table;padding:0 10px;background-color: #fff;box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-webkit-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);" >
          <div id="add_tag_ins" >
              <div id="export_chemical_id">
                  <table width="100%" id="add_search_lead" class="display" cellspacing="0" width="100%" style="margin: auto auto auto 0;">
                      <thead>
                          <tr class="list_report_header" style="background-color: rgb(226, 226, 226);">
                              <th class='no-sort' style="padding: 2px 0px;"><input style="width:20px; display:table; float:left;margin-left: 10px;" type="checkbox" id="check_about_all"></th>
                              <th style="text-align: left;font-size:14px">Lead Source</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php 
                          if(!empty($mlist)){
                              foreach ($mlist as $key=>$value) {
                      ?>
                          <tr>
                              <td class='no-sort' style="padding: 2px 0px;">
                                  <input type="checkbox" onclick="" style="width:20px; display:table; float:left;margin-left: 10px;" name="check_ins" class="checkbox_about_us" value="<?php echo $value['id'] ?>">
                              </td>
                              <td style="font-size:14px;padding-left: 13px;">
                                  <?php  echo $value['name'] ?>
                              </td>
                          </tr>
                      <?php }} ?>
                      </tbody>
                  </table>
               </div>
            </div>
          <p class="error_ins_tag" style="color:#F00; width:100%; text-align:center"></p>
          <p style="display: table; width: 100%; text-align: center;">
            <input type="text" id="name_about_us" name="name_about_us" style="height:26px; line-height:28px; float:left; margin:0;width: 278px;border-radius: 0;">&nbsp;<button style="width: 108px;float:left;" onclick="add_new()" class="btn"  type="button">Add New</button>
          </p>
          <p style="width:100%; display:table;text-align:center">
            <button style="width:99%" class="btn" onclick="delete_list_about_us()"   type="button">Delete Selected...</button>&nbsp
          </p>
        </div>
    <form action="<?php echo url::base() ?>create/sm_lead" method="POST">
     <div style="margin-top: 2% !important;width: 202px;margin: 0 auto;">
           <button style="width:100px;font-size:14px" class="btn" onclick="window.location.href='<?php echo url::base() ?>create/fr'" type="button">Previous</button>
           <button style="width:100px;float: right;font-size:14px" class="btn"  type="submit">Next</button>
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
<div id="dialog-confirm"></div>
<script>
    function add_new(){
        var name_about_us = $('#name_about_us').val();
        if(name_about_us == ''){
            $.growl.error({ message: "Input empty!" });
            return false;
        }else{

            $.ajax({
                url: '<?php echo url::base() ?>report/check_us_add/'+name_about_us,
                type: 'POST',
                dataType: 'json',
            })
            .always(function(data) {

                if(data == true){
                    //alert(1);
                    $.growl.error({ message: "Name exist!" });
                }else{
                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        url: '<?php echo url::base() ?>report/check_us_add_default',
                        data: {name_about_us: name_about_us},
                        success: function (resp) { 
                           if(resp === true){
                            //alert(2);
                                $.growl.error({ message: "Name exist!" });
                           }else{
                                $.ajax({
                                    type: 'POST',
                                    dataType: 'JSON',
                                    url: '<?php echo url::base() ?>report/save_about_us',
                                    data: {name_about_us: name_about_us},
                                    success: function (resp) { 
                                    location.reload(); 
                                        //add_about_us(resp,name_about_us);
                                        //list_about_us('asc');
                                        //$('#about_us_infomation').val(name_about_us);
                                        name_about_us = $('#name_about_us').val('');
                                    }
                                });
                           }
                        }
                    });
                     
                }
            });
        }
    }
    $(document).ready(function() {
        $('#check_about_all').click(function() {  //on click 
            var c = this.checked;
            $('.checkbox_about_us:checkbox').prop('checked',c);
        });
    });
    function delete_list_about_us(){
         var checkValues = $('.checkbox_about_us:checked').map(function(){
                return $(this).val();
            }).get();
        $("#dialog-confirm").html("Are you sure you want to delete this record ?");
        $("#dialog-confirm").dialog({
            resizable: false,
            modal: true,
            title: "Delete",
            width : 400, 
            buttons: {
                "Yes": function () {
                    $(this).dialog('close');
                    $.ajax({
                            type: 'POST',
                            url: '<?php echo url::base() ?>report/delete_list_about_us',
                            data: {ids: checkValues},
                            success: function (resp) {
                              //var t = JSON.parse(resp);
                              //$('div#row_'+t).fadeOut('slow');
                              location.reload();
                            }
                    });
                },
                "No": function () {
                $(this).dialog('close');
                //return false;
                }
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

<script type="text/javascript">
  $(document).ready(function() {
      var table_data = $('#add_search_lead').dataTable({
          "scrollY": "250px",
          "paging": false,
          "scrollX": false,
          "info": false,
          "columnDefs": [{ 
            targets: 'no-sort', 
            orderable: false,
          }],
          "columns": [
                    { "width": "5%" },
                    { "width": "95%" },
                  ],
          "oLanguage": { 
            "sSearch": "" ,
      },
      "initComplete": function () {
        $('#export_chemical_id input').attr({
          'placeholder': 'Showing All',
          'results': 'results'
        });
              var api = this.api();
              api.order([ 1, 'asc' ]).draw();
          }
      });
  });
</script>

