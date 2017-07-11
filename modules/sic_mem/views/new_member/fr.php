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
.title-fr{
  text-align: center;
  padding-top: 20px;
  font-size: 20px;
  font-weight: bold;
  color: #000;
  padding-bottom: 20px;
}
.title-options-fr{
  text-align: center;
  color: #000;
  font-weight: bold;
  font-size: 17px;
}

.title-options-fr-2{
  font-weight: bold;
  font-size: 13px;
  color: #000;
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
        	<div class="steped" style="width:10%;">.</div>
            <div class="steped" style="width:14%;">.</div>
            <div class="steped" style="width:17%;">.</div>
            <div class="steped" style="width:14%;">.</div>
            <div class="ste" style="width:14%;">.</div>
            <div class="step" style="width:14%;">.</div>
            <div class="step" style="width:15%;">.</div> 
        </div>
  </div>
  <div style="width:100%;float:left; position:relative; top:-22px; z-index:10000000000000">
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
<div style="clear:both"></div>
<div class="title-fr">
  Select your findings and recommendations codebook preferences.
</div>
<table style="width:80%;" align="center">
  <tr>
    <td style="width:40%;border:1px solid #000">
      <table style="width:100%;" align="center">
        <tr>
          <td class="title-options-fr">
          	 <button style="width: 150px;cursor: pointer;" onclick="window.location.href='<?php echo url::base() ?>create/sm_fr/Modular'" class="btn" type="button">Modular</button>
          </td>
        </tr>
        <tr>
          <td class="title-options-fr-2">
            Findings and recommendations are handled separately.
          </td>
        </tr>
        <tr>
          <td style="font-weight:bold;color:#000">
            Example:
          </td>
        </tr>
        <tr>
          <td>
            <div style="border:1px solid #000;background-color:#D1EEF3;color: #000;padding: 5px;margin-bottom: 5px;line-height: 18px;">
              <span><strong>Entry A:</strong></span> <br>
              <span>Finding: Sample finding text</span>
            </div>
            <div style="border:1px solid #000;background-color:#D1EEF3;color: #000;padding: 5px;line-height: 18px;">
              <span><strong>Entry B:</strong></span> <br>
              <span>Recommendations: Sample rec text</span>
            </div>
          </td>
        </tr>
      </table>
    </td>
    <td style="width:40%;border:1px solid #000;vertical-align: top;">
      <table style="width:100%;" align="center">
        <tr>
          <td class="title-options-fr">
           <button style="width: 150px;cursor: pointer;" onclick="window.location.href='<?php echo url::base() ?>create/sm_fr/Combined'" class="btn" type="button">Combined</button>
          </td>
        </tr>
        <tr>
          <td class="title-options-fr-2">
            Findings and recommendations are stored as singular combined entries.
          </td>
        </tr>
        <tr>
          <td style="font-weight:bold;color:#000">
            Example:
          </td>
        </tr>
        <tr>
          <td>
            <div style="border:1px solid #000;background-color:#D1EEF3;color: #000;padding: 5px;line-height: 18px;">
              <span><strong>Entry A:</strong></span> <br>
              <span>Finding: Sample finding text</span> <br>
              <span>Recommendations: Sample rec text</span>
            </div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:center">
      <button style="padding-left: 40px;padding-right: 40px;" type="button" onclick="window.location.href='<?php echo url::base() ?>create/chemical'" class="btn">Previous</button>
    </td>
  </tr>
</table>


  <div class="dash-left" style="text-align:right;position: absolute;top: 0px;right: 15px;">
    <p style="text-align: right;margin-bottom: 2px;font-weight: bold;color: #000;"><?php if($this->sess_cus['name']) echo $this->sess_cus['name'];  ?></p>
    <p style="margin-top: 0px;margin-bottom: 5px;font-weight: bold;color: #000;"><?php if($this->sess_cus['email']) echo $this->sess_cus['email'];  ?></p>
    <button class="btn" onclick="window.location.href='<?php echo url::base() ?>login/logout'" style="width:100px;font-size:14px;float: right;" type="button">Log Out</button>
  </div>




