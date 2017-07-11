<style>
.steped {background:#000; float:left; color:#fff; text-align:right; height:10px;}
  .step { background:#fff; float:left; color:#fff; text-align:right; height:10px;}
  .step_num {float:right; width:30px; border-radius:500px; line-height:30px; height:30px; border:#000 1px solid; text-align:center; color:#000; background:#fff; font-weight:bold}
  h1 {text-align:center; width:100%}
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
        	<div style="border-left: 5px solid #b3c7dd;height: 745px;border-right:#b3c7dd 5px solid;border-bottom:#b3c7dd 5px solid; display:table; width:99%; padding-bottom:15px;">
            <div style="padding-left:15%; display:table; width:70%;">
              <div style="width:60%; margin:0 auto; padding:0;">
                  <p style="width:100%; text-align:center"><h1>First Time Set-up Wizard</h1></p>
                  <div style="width:98%; border:#000 1px solid; background:#fff; height:10px; float:left; position:relative">
                      <div style="width:100%; height:10px; float:left;">
                          <div class="steped" style="width:15%;">.</div>
                            <div class="steped" style="width:14%;">.</div>
                            <div class="steped" style="width:14%;">.</div>
                            <div class="steped" style="width:14%;">.</div>
                            <div class="steped" style="width:14%;">.</div>
                            <div class="steped" style="width:14%;">.</div>
                            <div class="steped" style="width:15%;">.</div>
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
            	<span style="width:100%;  margin: 0 auto; text-align:center; display:table;fon-size:13px;font-weight:bold">
              <h1>Congratulations!</h1>
              <h1>Your account is set-up and ready to go.</h1>
            </span><br><br>
            <div style="  width: 275px;margin: 0 auto;">
              <form id="form_dashboard" action="<?php echo url::base() ?>create/sm_redi_dashboard" method="POST">
                <button  type="submit" id="check_dashboard" class="btn">
                  You will be taken to the dashboard in...
                </button>
                  <span id="hideMsg" style="position: absolute;top: 35%;left: 39%;font-size:100px">5</span>     
              </form>
            </div>
            
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
$(function(){
    var sec = 5
    var timer = setInterval(function() { 
       $('#hideMsg').text(sec--);
       if (sec == -1) {
        submit_dash();
          clearInterval(timer);
       } 
    }, 1000);
});
function submit_dash(){
  $('#form_dashboard').submit();
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



