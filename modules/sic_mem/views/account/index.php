<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<link rel="stylesheet" href="<?php echo url::base() ?>js/jquery.poshytip/tip-yellowsimple/tip-yellowsimple.css" type="text/css" />
<script type="text/javascript" src="<?php echo url::base() ?>js/jquery.poshytip/jquery.poshytip.js"></script>
<?php 
  $option_enterprise = $this->db->get('option_enterprise_general')->result_array(false);
  $setup_fee=0;
  $sub_fee=0;
  if(!empty($option_enterprise[0]['setup_fee']) || $option_enterprise[0]['subscription_fee']){
    $setup_fee=$option_enterprise[0]['setup_fee'];
    $sub_fee=$option_enterprise[0]['subscription_fee']*2;
      $total_enterprise=$setup_fee+$sub_fee;
  }
?>

<style>
.error{color: red;font-weight: bold;}
#error{color: red;font-weight: bold;}
#error_email{color: red;font-weight: bold;font-size: 11px;}
div.validation{color: red;font-weight: bold;font-size: 11px;}
#msform {text-align: center;}
#msform fieldset{background: white;box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-webkit-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 1px 1px 15px 1px rgba(0, 0, 0, 0.4);padding: 20px 30px;}
#msform fieldset:not(:first-of-type) {display: none;}
</style>
<span style="position: absolute;right: 10px;">

<button style="font-size:14px;width:100px;" onclick="javascript:location.href='/'" type="button" class="btn" value="Cancel">Home</button>
<button style="font-size:14px;width:100px;margin:10px;margin-left: 0px;" onclick="javascript:location.href='<?php echo url::base() ?>auth/login'" type="button" class="btn" value="Cancel">Log-In</button>

</span>
<div style="padding:100px 0 10px 0;text-align: center;">
	<img <?php if(!empty($this->site['site_logo_height'])){ ?> height="<?php echo $this->site['site_logo_height']?>" <?php } ?> <?php if(!empty($this->site['site_logo_width'])){ ?> width="<?php echo $this->site['site_logo_width']?>" <?php } ?> border="0" src="<?php echo linkS3 ?>site/<?php echo $this->site['site_logo']?>">
</div>

<form method="POST" action="<?php echo url::base() ?>create/smaccount" id="msform">
<input type="hidden" id="user_type" name="user_type">
<?php require_once('field_email.php'); ?>
<?php require_once('field_name.php'); ?>
<?php require_once('field_system.php'); ?>
<?php require_once('field_user_type.php'); ?>
<?php require_once('field_signle.php'); ?>
<?php require_once('field_enterprise.php'); ?>
</form>

<!-- form lua bao nhieu credit -->
<form style="display:none" action="" class="form_credit_cc" id="form_recharge_credit">
    <div style="float: left;margin-top: 0px;font-size: 15px;padding-left: 20px;">
      <table cellpadding="0" cellspacing="0" style="width:100%">
      <?php $option_signle = $this->db->get('option_single_credit')->result_array(false);?>
      <?php if(!empty($option_signle)){ foreach ($option_signle as $key => $value) { ?>       
          <tr>
            <td style="text-align:left">
              <input name="id_credit" class="credit_<?php echo $value['id']; ?>" <?php if($key == 0){ ?> checked="checked" <?php } ?>  type="radio" value="<?php echo $value['id']; ?>" style="width: 20px;height: 17px;float: left;margin-top: 1px;">
            </td>
            <td style="text-align:left">
              <?php echo $value['credit'] ?>
            </td>
            <td style="text-align:left">
              Credits - 
            </td>
            <td style="text-align:left">
              <?php echo '$'.number_format($value['price'],2); ?>
            </td>
          </tr>
        
      <?php }} ?>
      </table>
    </div>
    <div style="clear:both"></div>
    <div style="text-align:center">
        <button type="button" style="width: 90px;" onclick="open_form_recharge_credit_2()" class="btn">Next</button> 
    </div>
</form>

<div id="wrapcard_enterprise"></div>
<div id="wrapcard"></div>

<script>
$(function(){
  $(document).keypress(function (e) {
    if (e.which == 13) {
       $('button.fir1:not(.fir1:hidden)').each(function(){
          $(this).click();
       });
    }
  });
});
$(function(){
    $('.card_enterprise').click(function(){  
       $.ajax({
            type: 'POST',
            url: '<?php echo url::base() ?>ajax_progress/list_card_enterprise',  
            success: function (data) {
               $('#wrapcard_enterprise').html(data);
               $('#wrapcard_enterprise').dialog({
                    draggable: false,
                    modal: true,
                    dialogClass: "no-close",
                    width: 260,
                    autoOpen:true,
                    title:"Credit Card",
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
    });
});


$(function(){
    $('.card').click(function(){      
         $( ".form_credit_cc" ).dialog({
            draggable: false,
            modal: true,
            resizable: false,
            dialogClass: "no-close",
            width: 260,
            autoOpen:true,
            title:"Select Amount"
        });   
    });     
});
function open_form_recharge_credit_2(){
  var data_dl=$('.form_credit_cc').serialize();
   $.ajax({
        type: 'POST',
        url: '<?php echo url::base() ?>ajax_progress/list_card_signle', 
        data:data_dl,  
        success: function (data) {
        	//console.log(data);
           $('#wrapcard').html(data);
           $('#wrapcard').dialog({
                draggable: false,
                modal: true,
                resizable: false,
                dialogClass: "no-close",
                width: 260,
                autoOpen:true,
                title:"Credit Card"
            });  
        }
    });
}

$(document).ready(function(){
var current_fs, next_fs, previous_fs; 
var left, opacity, scale; 
var animating; 
$(".next_signle").click(function() {
  if (animating) return false;
  animating = true;
  current_fs = $(this).parent().parent().parent().parent().parent().parent();
  next_fs = $('#single_field');
  next_fs.show();
  current_fs.animate({
    opacity: 0
  }, {
    step: function(now, mx) {
      scale = 1 - (1 - now) * 0.2;
      left = (now * 50) + "%";
      opacity = 1 - now;
      current_fs.css({
        'transform': 'scale(' + scale + ')'
      });
      next_fs.css({
        'left': left,
        'opacity': opacity
      });
    },
    duration: 800,
    complete: function() {
      current_fs.hide();
      animating = false;
    },
    easing: 'easeInOutBack'
  });
  $('#user_type').val(1);
});

$(".previous_system").click(function() {
  if (animating) return false;
  animating = true;

  current_fs = $(this).parent().parent().parent().parent().parent().parent();
  previous_fs = $('#system_field');
  previous_fs.show();
  current_fs.animate({
    opacity: 0
  }, {
    step: function(now, mx) {
      scale = 0.8 + (1 - now) * 0.2;
      left = ((1 - now) * 50) + "%";
      opacity = 1 - now;
      current_fs.css({
        'left': left
      });
      previous_fs.css({
        'transform': 'scale(' + scale + ')',
        'opacity': opacity
      });
    },
    duration: 800,
    complete: function() {
      current_fs.hide();
      animating = false;
    },
    easing: 'easeInOutBack'
  });
});


$(".previous_signle").click(function() {
  $('#user_type').val(' ');
  if (animating) return false;
  animating = true;

  current_fs = $(this).parent();
  previous_fs = $('#select_type_user');
  $('#select_type_user table').removeAttr("style");
  $('#select_type_user table').css({"width":'100%'});
  previous_fs.show();
  current_fs.animate({
    opacity: 0
  }, {
    step: function(now, mx) {
      scale = 0.8 + (1 - now) * 0.2;
      left = ((1 - now) * 50) + "%";
      opacity = 1 - now;
      current_fs.css({
        'left': left
      });
      previous_fs.css({
        'transform': 'scale(' + scale + ')',
        'opacity': opacity
      });
    },
    duration: 800,
    complete: function() {
      current_fs.hide();
      animating = false;
    },
    easing: 'easeInOutBack'
  });
});
$(".next_enter").click(function() {
  if (animating) return false;
  animating = true;

  current_fs = $(this).parent().parent().parent().parent().parent().parent();
  next_fs = $('#enter_field');
  next_fs.show();
  current_fs.animate({
    opacity: 0
  }, {
    step: function(now, mx) {
      scale = 1 - (1 - now) * 0.2;
      left = (now * 50) + "%";
      opacity = 1 - now;
      current_fs.css({
        'transform': 'scale(' + scale + ')'
      });
      next_fs.css({
        'left': left,
        'opacity': opacity
      });
    },
    duration: 800,
    complete: function() {
      current_fs.hide();
      animating = false;
    },
    easing: 'easeInOutBack'
  });
  $('#user_type').val(2);
});
$(".previous_enter").click(function() {
  $('#user_type').val(' ');
  if (animating) return false;
  animating = true;

  current_fs = $(this).parent();
  previous_fs = $('#select_type_user');
  $('#select_type_user table').removeAttr("style");
  $('#select_type_user table').css({"width":'100%'});
  previous_fs.show();
  current_fs.animate({
    opacity: 0
  }, {
    step: function(now, mx) {
      scale = 0.8 + (1 - now) * 0.2;
      left = ((1 - now) * 50) + "%";
      opacity = 1 - now;
      current_fs.css({
        'left': left
      });
      previous_fs.css({
        'transform': 'scale(' + scale + ')',
        'opacity': opacity
      });
    },
    duration: 800,
    complete: function() {
      current_fs.hide();
      animating = false;
    },
    easing: 'easeInOutBack'
  });
});

$(".previous").click(function() {
  if (animating) return false;
  animating = true;

  current_fs = $(this).parent();
  previous_fs = $(this).parent().prev();
  previous_fs.show();
  current_fs.animate({
    opacity: 0
  }, {
    step: function(now, mx) {
      scale = 0.8 + (1 - now) * 0.2;
      left = ((1 - now) * 50) + "%";
      opacity = 1 - now;
      current_fs.css({
        'left': left
      });
      previous_fs.css({
        'transform': 'scale(' + scale + ')',
        'opacity': opacity
      });
    },
    duration: 800,
    complete: function() {
      current_fs.hide();
      animating = false;
    },
    easing: 'easeInOutBack'
  });
});

// tootltip 
$(function(){ 
  $("#email").on("keydown", function (e) {
    return e.which !== 32;
  });
  $('#email').poshytip({
    className: 'tip-yellowsimple',
    showOn: 'focus',
    alignTo: 'target',
    alignX: 'right',
    alignY: 'center',
    offsetX: 5,
    showTimeout: 100
  });
  $('#pass').poshytip({
    className: 'tip-yellowsimple',
    showOn: 'focus',
    alignTo: 'target',
    alignX: 'right',
    alignY: 'center',
    offsetX: 5,
    showTimeout: 100
  });
  $('#fpass').poshytip({
    className: 'tip-yellowsimple',
    showOn: 'focus',
    alignTo: 'target',
    alignX: 'right',
    alignY: 'center',
    offsetX: 5,
    showTimeout: 100
  });
  $('#member_fname').poshytip({
      className: 'tip-yellowsimple',
      showOn: 'focus',
      alignTo: 'target',
      alignX: 'right',
      alignY: 'center',
      offsetX: 5,
      showTimeout: 100
  });
  $('#member_lname').poshytip({
      className: 'tip-yellowsimple',
      showOn: 'focus',
      alignTo: 'target',
      alignX: 'right',
      alignY: 'center',
      offsetX: 5,
      showTimeout: 100
  });
});
// end tooltip
//  check fieldset 1 valid
$('#email').focusout(function(){
	var valu=$('#email').val();
	$.ajax({
    type: 'POST',
    url: '<?php echo url::base() ?>create/checkMmail',
    data: {val: valu},
    success: function (resp) {
    	if(resp != ''){
     		$('#error_email').html(resp);
     		$('#field1').attr("disabled", "disabled");
     	}else{
     		$('#error_email').html(resp);
     		$("#field1").removeAttr("disabled");
     	}
    }
  });
});
$('#field1').click(function(){
  var pass=$('#pass').val();
  var fpass=$('#fpass').val();
  var valu=$('#email').val();

  if(IsEmail(valu)==false){
    $.growl.error({ message: "Please enter a valid email address." });
    return false;
  }
  if(pass === ''){
    $.growl.error({ message: "Password is required." });
    return false;
  }
  if(fpass === ''){
    $.growl.error({ message: "Confirm Password is required." });
    return false;
  }
  if(pass !== ''){
    if(pass.length < 4){
      $.growl.error({ message: "Please enter at least 4 characters." });
      return false;
    }
  }
  if(pass !== fpass){
    $.growl.error({ message: "Please enter the same value again." });
    return false;
  }
  $.ajax({
    type: 'POST',
    url: '<?php echo url::base() ?>create/checkMmail',
    data: {val: valu},
    success: function (resp) {
      if(resp != ''){
        return false;
      }else{
        if (animating) return false;
        animating = true;
        current_fs = $("#field1").parent();
        next_fs = $("#field1").parent().next();
        next_fs.show();
        current_fs.animate({
          opacity: 0
        }, {
          step: function(now, mx) {
            scale = 1 - (1 - now) * 0.2;
            left = (now * 50) + "%";
            opacity = 1 - now;
            current_fs.css({
              'transform': 'scale(' + scale + ')'
            });
            next_fs.css({
              'left': left,
              'opacity': opacity
            });
          },
          duration: 800,
          complete: function() {
            current_fs.hide();
            animating = false;
          },
          easing: 'easeInOutBack'
        });
      }
    }
  });

});
// end check fieldset 1

// check fieldset 2
$('#field2').click(function(){
  var member_fname=$('#member_fname').val();
  var member_lname=$('#member_lname').val();
  if(member_fname === ''){
    $.growl.error({ message: "First Name is required." });
    return false;
  }
  if(member_lname === ''){
    $.growl.error({ message: "Last Name is required." });
    return false;
  }

  if (animating) return false;
  animating = true;
  current_fs = $(this).parent();
  next_fs = $(this).parent().next();
  next_fs.show();
  current_fs.animate({
    opacity: 0
  }, {
    step: function(now, mx) {
      scale = 1 - (1 - now) * 0.2;
      left = (now * 50) + "%";
      opacity = 1 - now;
      current_fs.css({
        'transform': 'scale(' + scale + ')'
      });
      next_fs.css({
        'left': left,
        'opacity': opacity
      });
    },
    duration: 800,
    complete: function() {
      current_fs.hide();
      animating = false;
    },
    easing: 'easeInOutBack'
  });
});
// end check fieldset 2

// check fieldset 3
$('#field3').click(function(){
  var system=$('#check2').val();
  if ($('#check2').is(":checked")){
    if (animating) return false;
    animating = true;
    current_fs = $(this).parent();
    next_fs = $(this).parent().next();
    next_fs.show();
    current_fs.animate({
      opacity: 0
    }, {
      step: function(now, mx) {
        scale = 1 - (1 - now) * 0.2;
        left = (now * 50) + "%";
        opacity = 1 - now;
        current_fs.css({
          'transform': 'scale(' + scale + ')'
        });
        next_fs.css({
          'left': left,
          'opacity': opacity
        });
      },
      duration: 800,
      complete: function() {
        current_fs.hide();
        animating = false;
      },
      easing: 'easeInOutBack'
    });
  }else{
    $.growl.error({ message: "Please select the system you would like to set-up." });
    return false;
  }
  if(system === ''){
    
  }
});
// end check fieldset 3
});
function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
</script>

	


	

		


			

			
			
			

			


