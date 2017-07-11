<style>
	div.validation{color: red;font-weight: bold;font-size: 11px;}
	.steped {background:#000; float:left; color:#fff; text-align:right; height:10px;}
	.step { background:#fff; float:left; color:#fff; text-align:right; height:10px;}
	.step_num {float:right; width:30px; border-radius:500px; line-height:30px; height:30px; border:#000 1px solid; text-align:center; color:#000; background:#fff; font-weight:bold}
	h1 {text-align:center; width:100%; font-size:18px;}
</style>
<div id="wrap_up_crp"></div>
<div class="dash">
<div class="dashmidd">
    	<div class="dash-right">
        	<div style="height:700px;border-right:#b3c7dd 5px solid;border-left:#b3c7dd 5px solid;border-bottom:#b3c7dd 5px solid; display:table; width:99%; padding-bottom:15px;">
            <div style="margin: auto;display:table; width:900px;">
            	<p style="width:100%; text-align:center"><h1>First Time Set-up Wizard</h1></p>
            	<div style="width:60%; margin:0 auto; padding:0;">
                	<div style="width:98%; border:#000 1px solid; background:#fff; height:10px; float:left; position:relative">
                    	<div style="width:100%; height:10px; float:left;">
                        	<div class="steped" style="width:15%;">.</div>
                            <div class="steped" style="width:14%;">.</div>
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
                <div style="width:100%; float:left; margin:20px 0 30px 0">
                <p style="width:100%; text-align:center; float:left; margin:0px 0"><h1>Add the name and license number of inspector(s)<br />working with you.</h1></p>
                </div>
            <form id="form_ins" action="<?php echo url::base() ?>create/sm_inspector" method="POST" enctype='multipart/form-data' style="width:100%; display:table">
            <?php if(!empty($mlist)){ foreach ($mlist as $key => $value) {?>
                <?php $key_deci=(int)$key + 1;  ?>
            <div id="div_<?php echo $value['id']; ?>" style="position: relative;text-align: center;width: 250px;margin: 0 auto;border: 1px solid #000;padding-top: 10px;background-color: #fff;box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-webkit-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);margin-top:2%">
                <table style="margin: auto;">
                    <tr>
                        <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 13px;" colspan="2">Inspector Name</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input autofocus  value="<?php echo !empty($value['ins_name'])?$value['ins_name']:''; ?>" type="text" name="name_ins[]" >
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 13px;" colspan="2">License Number</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input  value="<?php echo !empty($value['license'])?$value['license']:''; ?>" type="text" name="license[]">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 13px;" colspan="2">Signature</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <button type="button" onclick="showimagepreview_<?php echo $key_deci; ?>()" class="btn">Upload File…</button>
                            <p style="margin-bottom: 0px;margin-top: 0px;font-size: 11px;text-align: center;font-weight: bold;">Only image files are accepted. Uploading a non-image file will result in a black image.(PDF not accepted)</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php if(!empty($value['signature'])){ ?>
                             <span id="img_signature_<?php echo $key_deci; ?>" style="border:#999 1px solid;max-height:150px; display:inline-block; background:#fff; text-align:center">
                                <img style="width:200px"  src="<?php echo linkS3 ?>inspector/<?php echo !empty($value['signature'])?$value['signature']:''; ?>" alt="">
                                <input type="hidden" value="<?php echo !empty($value['signature'])?$value['signature']:''; ?>" name="image_sign[]">
                            </span>
                            <?php }else{ ?>
                                <span id="img_signature_<?php echo $key_deci; ?>" style="display:none;border:#999 1px solid;max-height:150px; background:#fff; text-align:center"></span>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
                
                <?php if($key != 0 ){ ?>
                    <span style="position: absolute;top: 2px;right: 2px;">
                        <img  class="change_close" onclick="delete_ins(<?php echo !empty($value['id'])?$value['id']:''; ?>)" style="width: 20px;cursor: pointer;" src="<?php echo url::base() ?>themes/icon/x_button_unlit.png" alt="">
                    </span> 
                <?php } ?>
            </div>
                <script>
                    function showimagepreview_<?php echo $key_deci; ?>() {  
                        var id_code='<?php echo $key_deci ?>';
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo url::base() ?>create/list_upload_crop',
                                data:{ id_code:id_code },
                                success: function (resp) { 
                                    $('#wrap_up_crp').html(resp);
                                    $( "#wrap_up_crp" ).dialog({
                                     draggable: false,
                                     modal: true,
                                     width:500,
                                     height:250,
                                     dialogClass: "no-close",
                                     autoOpen:true,
                                     title:"Image Crop"
                                 });
                                }
                            });      
                        }
                </script>
           <?php }}else{ ?>
                <div style="position: relative;text-align: center;width: 250px;margin: 0 auto;border: 1px solid #000;padding-top: 10px;background-color: #fff;box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-webkit-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);margin-top:2%">
                    <table style="margin:auto;">
                        <tr>
                            <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 14px;" colspan="2">Inspector Name</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input autofocus  value="<?php echo !empty($value['ins_name'])?$value['ins_name']:''; ?>" type="text" id="name_ins_start" name="name_ins[]" >
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 14px;" colspan="2">License Number</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input  value="<?php echo !empty($value['license'])?$value['license']:''; ?>" type="text" id="license_start" name="license[]">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 14px;" colspan="2">Signature</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <button type="button" class="btn" style="font-size:14px" onclick="showimagepreview_1()" class="btn">Upload File…</button>
                                <!-- <div class="fileUpload">
                                    <span>Upload...</span>
                                    <input onchange="showimagepreview_1(this)" name="signature[]" id="signature" type="file"  class="upload" />
                                </div>    --> 
                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 11px;text-align: center;font-weight: bold;">Only image files are accepted. Uploading a non-image file will result in a black image.(PDF not accepted)</p>
                            </td>
                        </tr>
                        <tr>
                            <td>                           
                                 <span id="img_signature_1" style="display:inline-block;border:#999 1px solid;max-height:150px; background:#fff; text-align:center"></span>
                            </td>
                        </tr>
                    </table>
                 <!-- <span style="position: absolute;top: 2px;right: 2px;"><img  class="change_close delete" style="width: 20px;cursor: pointer;" src="<?php //echo url::base() ?>themes/icon/x_button_unlit.png" alt=""></span>  -->
                </div>
                <script>
                    function showimagepreview_1() {  
                        var id_code='1';
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo url::base() ?>create/list_upload_crop',
                                data:{ id_code:id_code },
                                success: function (resp) { 
                                    $('#wrap_up_crp').html(resp);
                                    $( "#wrap_up_crp" ).dialog({
                                     draggable: false,
                                     modal: true,
                                     width:500,
                                     height:250,
                                     dialogClass: "no-close",
                                     autoOpen:true,
                                     title:"Image Crop"
                                 });
                                }
                            });      
                    }
                    $(function(){
                        $('#btn_submit').click(function(){

                            if( $('#name_ins_start').val().length === 0 ) {

                                //$('#btn_submit').attr("disabled", "disabled");
                                $.growl.error({ message: "You are required to add at least ONE inspector. If you do not have an inspector yet, simply enter your own name and a dummy license number as a placeholder, and you can edit it at a later date from Inspectors on the navigation bar." });
                                return false;
                            }else{

                                $("#btn_submit").removeAttr("disabled");

                            }
                        
                        });
                        
                    });
                </script>
           <?php } ?>
           <?php if(!empty($mlist)){ ?>
                <input type="hidden" value="<?php $count=count($mlist);echo $count; ?>" id="dem">
            <?php }else{ ?>
                <input type="hidden" value="1" id="dem">
            <?php } ?>
           <span id="add_inspectors">
                
            </span>
            <div style="text-align: center;margin-top: 3%;">
                <img id="img_add_ins" style="width:25px;margin-bottom: -8px;cursor: pointer;font-size:14px" src="<?php echo url::base() ?>themes/icon/Buttons/add_btn_unlit.png" alt=""> <span>Add another inspector...</span>
            </div>
            <div style="width: 202px;margin: 0 auto;margin-top: 2%;">
                <button style="width: 100px;font-size:14px" type="button" class="btn" onclick="window.location.href='<?php echo url::base() ?>create/info_company'" id="previous">Previous</button>
                <button style="width: 100px;float: right;font-size:14px" class="btn" id="btn_submit" type="submit">Next</button>
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

<script>
function delete_ins(id){
    $.ajax({
        type: 'POST',
        url: '<?php echo url::base() ?>create/delete_ins',
        data: {id: id},
        success: function (resp) {
            //alert(resp);
            //location.reload();
            $('div#div_'+resp).fadeOut();
            $('div#div_'+resp).remove();
        }
    });
}

$(function(){
    $("body").on("click", ".delete", function (e) {
        $(this).parent("span").parent("div").remove();   
    });
    $('#img_add_ins').click(function(){
        var dem=$('#dem').val();
        var id_code=parseInt(dem) + 1;
        $('#dem').val(id_code);
        $('#add_inspectors').append(
            '<div style="position: relative;text-align: center;width: 250px;margin: 0 auto;border: 1px solid #000;padding-top: 10px;background-color: #fff;box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-webkit-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);margin-top:2%">'+
                '<table style="margin:auto;">'+
                    '<tr>'+
                        '<td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 14px;" colspan="2">Inspector Name</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td colspan="2">'+
                            '<input  name="name_ins[]" type="text" >'+
                        '</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 14px;" colspan="2">License Number</td>'+
                    '</tr>'+
                    '<tr>'+
                       '<td colspan="2">'+
                            '<input  name="license[]" type="text" >'+
                        '</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td style="padding:0 5px;text-align: center;font-weight:bold;  font-size: 14px;" colspan="2">Signature</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td colspan="2" style="text-align: center;">'+
                        '<button type="button" class="btn" style="font-size:14px" onclick="showimagepreview_'+id_code+'()" class="btn">Upload File…</button>'+
                        // '<div class="fileUpload">'+
                        //         '<span>Upload...</span>'+
                        //         '<input    name="signature[]"  type="file" id="inputFile_'+id_code+'"  class="upload" />'+
                        // '</div>'+
                        '<p style="margin-bottom: 0px;margin-top: 0px;font-size: 11px;text-align: center;font-weight: bold;">Only image files are accepted. Uploading a non-image file will result in a black image.(PDF not accepted)</p>'+
                        '</td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td>'+
                    // '<img id="imgprvw_'+id_code+'" style="width:200px;display:none" src="#" alt="">'+
                    '<span id="img_signature_'+id_code+'" style="display:none;border:#999 1px solid;max-height:150px; display:inline-block; background:#fff; text-align:center"></span>'+
                    '</td>'+    
                    '</tr>'+
                '</table>'+
                '<span style="position: absolute;top: 2px;right: 2px;"><img  class="change_close delete" style="width: 20px;cursor: pointer;" src="<?php echo url::base() ?>themes/icon/x_button_unlit.png" alt=""></span>'+
                '<script type=\"text/javascript\">'+                  
                   // '$(function(){'+
                   //      '$("#inputFile_'+id_code+'").change(function () {'+

                   //          'readURL(this,'+id_code+');'+
                   //  '});'+
                   // '});'+ 
                    'function showimagepreview_'+id_code+'(){'+  
                        '$.ajax({'+
                            "type: 'POST',"+
                            "url: '<?php echo url::base() ?>create/list_upload_crop',"+
                            "data:{ id_code:"+id_code+" },"+
                            'success: function (resp) {'+ 
                                "$('#wrap_up_crp').html(resp);"+
                                "$( '#wrap_up_crp' ).dialog({"+
                                 'draggable: false,'+
                                 'modal: true,'+
                                 'width:500,'+
                                 'height:250,'+
                                 'dialogClass: "no-close",'+
                                 'autoOpen:true,'+
                                 'title:"Image Crop"'+
                             '});'+
                            '}'+
                        '});'+      
                    '}'+
               '<'+'/script>'+
            '</div>'
        );
    });
});

function readURL(input,id_code) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#imgprvw_'+id_code).css('display','inline-block');
            $('#imgprvw_'+id_code).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

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

function isNumberKey(evt){

  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57))
  return false;
  return true;

}
</script>



