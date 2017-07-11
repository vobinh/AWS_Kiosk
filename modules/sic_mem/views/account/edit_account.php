<?php 
  /*get config s3*/
  $s3_config = $this->db->get('s3_config')->result_array(false); 

  $s3_key    = !empty($s3_config[0]['key'])?$s3_config[0]['key']:'';
  $s3_secret = !empty($s3_config[0]['secret'])?$s3_config[0]['secret']:'';
  $s3_bucket = !empty($s3_config[0]['main_bucket'])?$s3_config[0]['main_bucket']:'';
  /*end get config s3*/

  require Kohana::find_file('vendor/aws','aws-autoloader');
  use Aws\S3\S3Client;
  use Aws\S3\Exception\S3Exception;

  // Instantiate the S3 client with your AWS credentials
  $s3Client = S3Client::factory(array(
     'key'    => $s3_key,
     'secret' => $s3_secret
  ));
?>
<style type="text/css" media="screen">
  #tbl_info_edit td{padding: 0 5px;}
  #tbl_info_edit tr{padding: 0 5px;}
  #tbl_pass_edit td{padding: 0 5px;}
  #tbl_pass_edit tr{padding: 0 5px;}
</style>

<table style="width:100%">
  <tr>
    <td style="width:30%;">
      <span style="font-size: 25px;color: #000;font-weight: bold;">My Profile</span>
    </td>
  </tr>
</table>


<div style="width:100%; display:table;">
  <form enctype="multipart/form-data"  id="form" action="<?php echo url::base() ?>account/sm_edit" method="POST">
    <table style="width:100%">
      <tr>
        <td style="vertical-align: top;">
          <fieldset style="min-height: 300px;">
            <legend style="color: #000;font-weight: bold;font-size: 15px;">User Information</legend>
              <table id="tbl_info_edit" border="0" align="center" >
                  <tr>
                      <td style="text-align: right;">First Name:</td>
                      <td><input value="<?php if(!empty($info_member['member_fname'])) echo $info_member['member_fname']; ?>" id="member_fname" autofocus="autofocus" type="text" name="member_fname"></td>
                  </tr>
                  <tr>
                      <td style="text-align: right;">Last Name:</td>
                      <td><input value="<?php if (!empty($info_member['member_lname'])) echo $info_member['member_lname']; ?>"  id="member_lname"  type="text" name="member_lname"></td>
                  </tr>
                <tr>
                    <td style="text-align: right;padding-bottom: 10px;padding-top: 10px;">Email:</td>
                    <td>
                    <input type="text" name="txt_email" value="<?php if(!empty($info_member['member_email'])) echo $info_member['member_email']; ?>"/>
                    <!-- <span style="font-weight: bold;color: black;"><?php //if(!empty($info_member['member_email'])) echo $info_member['member_email']; ?></span></td> -->
                </tr>  
                <tr>
                    <td style="text-align: right;padding-top: 7px;vertical-align:top">Image:</td>
                    <td>
                     <div style="background-color: #1a4a99;color: #fff;border-radius: 5px;width: 225px;line-height: 4px;padding-top: 14px;height: 17px;text-align: center;font-size: 10pt;font-weight: bold;cursor: pointer;">Upload image 
                     <input id="uploadFile" style="opacity:0;width: 225px;margin-top: -12px;width: 273px;cursor: pointer;" type="file"  name="image">
                     </div>
                     </td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    <?php if(!empty($info_member['image'])){ ?>
                      <div id="imagePreview" style="margin: auto;overflow: hidden;position: relative;">
                          <?php 
                          $check_img = $s3Client->doesObjectExist($s3_bucket, "customers/".(!empty($info_member['image'])?$info_member['image']:'0'));
                          if($check_img == '1'){ ?>   
                            <img style="width: 225px;height: 100px;" src="<?php echo linkS3 ?>customers/<?php echo $info_member['image']; ?>">  
                            <span class="btn_close delete_image_ajax_user" style="cursor: pointer;width:25px;height: 25px;display: block;background-size: 25px 25px;position: absolute;top: 0px;right: 0px;"></span>
                          <?php }?>
                      </div> 
                    <?php }else{ ?>
                      <div id="imagePreview" style="margin: auto;overflow: hidden;position: relative;"></div>
                    <?php } ?> 
                    <p style="width: 220px;margin-bottom: 0px;margin-top: 0px;font-size: 11px;text-align: center;font-weight: bold;color: #000;">Only image files are accepted. Uploading a non-image file will result in a black image.(PDF not accepted)</p>
                  </td>
                </tr>             
              </table>
            </fieldset>
        </td>
        <td style="vertical-align: top;width: 50%;">
           <fieldset style="min-height: 300px;">
            <legend style="color: #000;font-weight: bold;font-size: 15px;">Change Password:</legend>
                <table id="tbl_pass_edit" border="0" align="center" style="margin-top: 75px;">
                    <tr>
                        <td align="right">Old password:</td>
                        <td>&nbsp;<input type="password" name="old_pass" id="txt_old_pass"></td>
                    </tr>
                    <tr>
                        <td align="right">New password:</td>
                        <td>&nbsp;<input type="password" name="new_pass" id="txt_new_pass"></td>
                    </tr>
                    <tr>    
                        <td align="right">Confirm new password:</td>
                        <td>&nbsp;<input type="password" name="fnew_pass" id="txt_fnew_pass"></td>
                    </tr>
                </table>
              </fieldset>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <div style="width:100%; display:table; text-align:center; padding:15px 0">
            <button style="width: 110px;" id="btn_edit_account" class="btn" type="button" value="Save">Save</button>
          </div>
        </td>
      </tr>
    </table>
	</form> 
</div>

<script type="text/javascript">
function reset_form_element (e) {
    e.wrap('<form>').parent('form').trigger('reset');
    e.unwrap();
}
$(function() {
    $("#uploadFile").on("change", function()
    {
        var val = $("#uploadFile").val();
        if(val != ''){
          if (!val.match(/(?:gif|jpg|png|bmp|jpeg|JPG|JPEG|GIF|BMP|GIF)$/)) {
            $.growl.error({ message: "The file you are trying to upload is not an image file. Please ensure that the file you are trying to upload has an image file extension (.jpg, .png, .gif, etc…)." });
            reset_form_element( $('#uploadFile') );
            e.preventDefault();
            return false;
          }
        }
      
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader){
          alert('no support');
          return false; // no file selected, or no FileReader support
        } 
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                $("#imagePreview").empty().html("<img style='width: 225px;height: 100px;' src='"+this.result+"'><span class='btn_close delete_image_user' style='float:right;cursor: pointer;width:25px;height: 25px;display: block;background-size: 25px 25px;position: absolute;top: 0px;right: 0px;'></span>");
                $("#image_user_left").empty().html("<img width='100%' height='100px' src='"+this.result+"'>");
                $('td#td_fisrt').html("<img width='100%' height='100px' src='"+this.result+"'>");
            }
        }
    });
    $(document).on( "click", ".delete_image_user", function() {
        $('#imagePreview').empty();
        $('#image_user_left').empty();
        $('td#td_fisrt').empty();
    });
    $('.delete_image_ajax_user').click(function(){
      $.ajax({
        type: 'POST',
        url: '<?php echo url::base() ?>account/delete_image_ajax_user',  
        success: function (data) {
           if(data === 'success'){
              $('#imagePreview').empty();
              $('#image_user_left').empty();
              $('td#td_fisrt').empty();
           }else{
              $.growl.error({ message: "Delete Fail." });
           }
        }
      });
    });
});
</script>  
<script type="text/javascript">
$('#txt_old_pass').poshytip({
  content: 'Please enter your old password.',
  className: 'tip-yellowsimple',
  showOn: 'none',
  alignTo: 'target',
  alignX: 'right',
  alignY: 'center',
  offsetX: 5,
  showTimeout: 100
});
$('#txt_new_pass').poshytip({
  content: 'Please enter your new password.',
  className: 'tip-yellowsimple',
  showOn: 'none',
  alignTo: 'target',
  alignX: 'right',
  alignY: 'center',
  offsetX: 5,
  showTimeout: 100
});
$('#txt_fnew_pass').poshytip({
  content: 'Please enter the same value again.',
  className: 'tip-yellowsimple',
  showOn: 'none',
  alignTo: 'target',
  alignX: 'right',
  alignY: 'center',
  offsetX: 5,
  showTimeout: 100
});
  $('#btn_edit_account').click(function(event) {
    var m_state = 1;
    if($('#txt_old_pass').val() != '' || $('#txt_new_pass').val() != '' || $('#txt_fnew_pass').val() != ''){
      if($('#txt_old_pass').val() == ''){
        $('#txt_old_pass').poshytip('update','Please enter your old password.');
        $('#txt_old_pass').poshytip('show');
        $('#txt_old_pass').poshytip('hideDelayed', 3000);
        m_state = 0;
      }
      if($('#txt_new_pass').val() == ''){
        $('#txt_new_pass').poshytip('update','Please enter your new password.');
        $('#txt_new_pass').poshytip('show');
        $('#txt_new_pass').poshytip('hideDelayed', 3000);
        m_state = 0;
      }
      if($('#txt_fnew_pass').val() == ''){
        $('#txt_fnew_pass').poshytip('update','Please enter the same value again.');
        $('#txt_fnew_pass').poshytip('show');
        $('#txt_fnew_pass').poshytip('hideDelayed', 3000);
        m_state = 0;
      }
      if($('#txt_old_pass').val() != ''){
        $.ajax({
          url: '<?php echo url::base()?>account/check_old_pass',
          type: 'POST',
          async: false,
          dataType: 'json',
          data: {'old_pass': $('#txt_old_pass').val()},
        })
        .done(function(data) {
          if(data == 0){
            $('#txt_old_pass').poshytip('update','Old Password invalid.');
            $('#txt_old_pass').poshytip('show');
            $('#txt_old_pass').poshytip('hideDelayed', 3000);
            m_state = 0;
          }
        })
        .fail(function() {
            $('#txt_old_pass').poshytip('update','Old Password invalid.');
            $('#txt_old_pass').poshytip('show');
            $('#txt_old_pass').poshytip('hideDelayed', 3000);
            m_state = 0;
        });
        
      }
      if($('#txt_new_pass').val() != '' && $('#txt_fnew_pass').val() != ''){
        if($('#txt_new_pass').val() != $('#txt_fnew_pass').val()){
          $('#txt_fnew_pass').poshytip('update','The Confirm Password Invalid.');
          $('#txt_fnew_pass').poshytip('show');
          $('#txt_fnew_pass').poshytip('hideDelayed', 3000);
          m_state = 0;
        }
      }
    }
    if(m_state == 1){
      $('#form').submit();
    }
  });
</script>
