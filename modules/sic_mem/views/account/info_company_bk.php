<style>
	div.validation{color: red;font-weight: bold;font-size: 11px;}
</style>
<div class="dash">
<div class="dashmidd">
    	<div class="dash-right">
        	<div style="border-right:#aaa 1px solid;border-bottom:#aaa 1px solid; display:table; width:99%; padding-bottom:15px;">
            <div style="padding-left:15%; display:table; width:85%; padding-top:30px;">
            	<span style="width:100%; text-align:center; display:table">
                Welcome! Looks like this is your first time logging-in. <br>
                Let's help you set up so you can start writting reports right away. <br>
                Don't worry if you are unable to provide all of the required information. <br>
                You can revisit this page later and fill them in.</span><br><br>
                <form id="form" action="<?php echo url::base() ?>login/sminfo_company" method="POST" style="padding-left:0%;">
                <div style="width:50%; float:left;">
                <table cellpadding="0" cellspacing="0" border="0" width="53%">
                    <tr>
                        <td colspan="2">Company Name</td>
                    </tr>
                    
                    <tr>
                        <td colspan="2"><input value="<?php if(!empty($member['company_name']))echo $member['company_name']; ?>" id="company_name" autofocus="autofocus" type="text" name="company_name"></td>
                        <td>&nbsp;&nbsp;<span style="color:red">(*)</span></td>
                    </tr>
                    <tr>
                        <td colspan="2">Address</td>
                    </tr>
                    <tr>
                        <td colspan="2"><input value="<?php if(!empty($member['company_address']))echo $member['company_address']; ?>" type="text" name="company_address"></td>
                        <td>&nbsp;&nbsp;<span style="color:red">(*)</span></td>
                    </tr>
                    <tr>
                        <td colspan="2">Address2</td>
                    </tr>
                    <tr>
                        <td colspan="2"><input value="<?php if(!empty($member['company_address_2']))echo $member['company_address_2']; ?>" type="text" name="company_address2"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        <label>
                        	<span style="float:left; width:33%">City</span>
                        	<span style="float:left; width:26%">State</span>
                        	<span style="float:left; width:16%">Zip</span>
                        </label>
                        <input type="text" value="<?php if(!empty($member['city']))echo $member['city']; ?>" name="city" style="width:27%">&nbsp;
                        <select name="state" id="" style="width:25%">
                            <option value="">------</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'AL'){ ?> selected="selected" <?php }} ?> value="AL">AL</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'AK'){ ?> selected="selected" <?php }} ?> value="AK">AK</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'AZ'){ ?> selected="selected" <?php }} ?> value="AZ">AZ</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'AR'){ ?> selected="selected" <?php }} ?> value="AR">AR</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'CA'){ ?> selected="selected" <?php }} ?> value="CA">CA</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'CO'){ ?> selected="selected" <?php }} ?> value="CO">CO</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'CT'){ ?> selected="selected" <?php }} ?> value="CT">CT</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'DE'){ ?> selected="selected" <?php }} ?> value="DE">DE</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'DC'){ ?> selected="selected" <?php }} ?> value="DC">DC</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'FL'){ ?> selected="selected" <?php }} ?> value="FL">FL</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'GA'){ ?> selected="selected" <?php }} ?> value="GA">GA</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'HI'){ ?> selected="selected" <?php }} ?> value="HI">HI</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'ID'){ ?> selected="selected" <?php }} ?> value="ID">ID</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'IL'){ ?> selected="selected" <?php }} ?> value="IL">IL</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'IN'){ ?> selected="selected" <?php }} ?> value="IN">IN</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'IA'){ ?> selected="selected" <?php }} ?> value="IA">IA</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'KS'){ ?> selected="selected" <?php }} ?> value="KS">KS</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'KY'){ ?> selected="selected" <?php }} ?> value="KY">KY</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'LA'){ ?> selected="selected" <?php }} ?> value="LA">LA</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'ME'){ ?> selected="selected" <?php }} ?> value="ME">ME</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'MD'){ ?> selected="selected" <?php }} ?> value="MD">MD</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'MA'){ ?> selected="selected" <?php }} ?> value="MA">MA</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'MI'){ ?> selected="selected" <?php }} ?> value="MI">MI</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'MN'){ ?> selected="selected" <?php }} ?> value="MN">MN</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'MS'){ ?> selected="selected" <?php }} ?> value="MS">MS</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'MO'){ ?> selected="selected" <?php }} ?> value="MO">MO</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'MT'){ ?> selected="selected" <?php }} ?> value="MT">MT</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'NE'){ ?> selected="selected" <?php }} ?> value="NE">NE</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'NV'){ ?> selected="selected" <?php }} ?> value="NV">NV</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'NH'){ ?> selected="selected" <?php }} ?> value="NH">NH</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'NJ'){ ?> selected="selected" <?php }} ?> value="NJ">NJ</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'NM'){ ?> selected="selected" <?php }} ?> value="NM">NM</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'NY'){ ?> selected="selected" <?php }} ?> value="NY">NY</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'NC'){ ?> selected="selected" <?php }} ?> value="NC">NC</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'ND'){ ?> selected="selected" <?php }} ?> value="ND">ND</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'OH'){ ?> selected="selected" <?php }} ?> value="OH">OH</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'OK'){ ?> selected="selected" <?php }} ?> value="OK">OK</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'OR'){ ?> selected="selected" <?php }} ?> value="OR">OR</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'PA'){ ?> selected="selected" <?php }} ?> value="PA">PA</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'RI'){ ?> selected="selected" <?php }} ?> value="RI">RI</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'SC'){ ?> selected="selected" <?php }} ?> value="SC">SC</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'SD'){ ?> selected="selected" <?php }} ?> value="SD">SD</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'TN'){ ?> selected="selected" <?php }} ?> value="TN">TN</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'TX'){ ?> selected="selected" <?php }} ?> value="TX">TX</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'UT'){ ?> selected="selected" <?php }} ?> value="UT">UT</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'VT'){ ?> selected="selected" <?php }} ?> value="VT">VT</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'VA'){ ?> selected="selected" <?php }} ?> value="VA">VA</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'WA'){ ?> selected="selected" <?php }} ?> value="WA">WA</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'WV'){ ?> selected="selected" <?php }} ?> value="WV">WV</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'WI'){ ?> selected="selected" <?php }} ?> value="WI">WI</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'WY'){ ?> selected="selected" <?php }} ?> value="WY">WY</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'PR'){ ?> selected="selected" <?php }} ?> value="PR">PR</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'VI'){ ?> selected="selected" <?php }} ?> value="VI">VI</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'MP'){ ?> selected="selected" <?php }} ?> value="MP">MP</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'GU'){ ?> selected="selected" <?php }} ?> value="GU">GU</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'AS'){ ?> selected="selected" <?php }} ?> value="AS">AS</option>
                            <option <?php if(!empty($member['state'])){ if($member['state'] == 'PW'){ ?> selected="selected" <?php }} ?> value="PW">PW</option>
                        </select>
                        <input type="text" value="<?php if(!empty($member['zip']))echo $member['zip']; ?>" name="zip" style="width:25%">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">E-mail</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="text" disabled value="<?php if($this->session->get('member_email')) echo $this->session->get('member_email');?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Telephone Number</td>
                    </tr>
                    <tr>
                        <td colspan="2"><input value="<?php if(!empty($member['telephone']))echo $member['telephone']; ?>" type="text" name="telephone"></td>
                        <td>&nbsp;&nbsp;<span style="color:red">(*)</span></td>
                    </tr>
                    <tr>
                        <td colspan="2">Alt.Telephone Number</td>
                    </tr>
                    <tr>
                        <td colspan="2"><input value="<?php if(!empty($member['alt_telephone']))echo $member['alt_telephone']; ?>" type="text" name="alt_telephone"></td>
                    </tr>
                    <tr>
                        <td colspan="2">Fax Number</td>
                    </tr>
                    <tr>
                        <td colspan="2"><input value="<?php if(!empty($member['fax']))echo $member['fax']; ?>" type="text" name="fax"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><button id="butn" type="submit" value="Save">Save</button></td>
                    </tr>
                </table>
                </div>
                <div style="width:50%; float:left;">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td colspan="2">Company License Number</td>
                    </tr>
                    <tr>
                        <td colspan="2"><input value="<?php if(!empty($member['company_license']))echo $member['company_license']; ?>" type="text" name="license_number"></td>
                    </tr>
                </table>
                </div>
            </form>
            </div>
            </div>
        </div>
    <div class="dash-left" style="text-align:right">
    	<p><?php if($this->session->get('member_lname')) echo $this->session->get('member_lname');  ?></p>
			<a style="color:red" href="<?php echo url::base() ?>login/logout">Log Out</a>
    </div>
</div>
<script>
$(function(){
	$( "#form" ).validate({
	  rules: {
	    company_name:{
	    	required: true,
	    }, 
	    company_address:{
	    	required: true,
	    },
	    telephone:{
	    	required: true,
	    	number: true
	    },
	    alt_telephone:{
	    	number: true
	    },
	    fax:{
	    	number: true
	    },
	    license_number:{
	    	number: true
	    },
	  }
	});

});
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



