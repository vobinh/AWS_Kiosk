<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-65237317-1', 'auto');
  ga('send', 'pageview');
</script>
<fieldset id="enter_field" style="text-align: center;width: 810px;margin: auto;padding:0px;padding-bottom: 10px;">
<table>
	<tr>
		<td>
			<div style="width:100%; display:table; line-height:18px;">
                <div style="width:35%; float:left; padding-left:0%;text-align: left;margin-top: -15px;">
                  <p style="text-align:center;padding-right:40px; font-size:16px;"><strong>Enterprise</strong></p>
                    <span style="font-weight:bold;font-size:14px">
                    Enterprise model is designed for
                    companies who generate reports on 
                    a regular basis.The model also 
                    allows for simultaneous 
                    connections from multiple users.</span><br/><br/>
        
                    <span style="display:table; font-size:14px;">
                    - Multiple users can log-in to the system simultaneously.<br/>
        
                    - Monthly subscription-based.<br/>
        
                    - More economical for companies who generate
                    a large number of reports on a regular basis.
                    </span>
                </div>
                <div style="width:63%; float:left; padding-left:2%;font-size:14px;text-align: left;">
                  You have selected the Enterprise payment plan <br/><br/>
                    Basic Enterprise users receive two user licenses, meaning you can <br/>
                    have up to two simultaneous users online at the same time.If you wish <br/>
                    to add more, you can do so later after you log-in.<br/><br/><br/>
        
                    <table style="font-size:14px;width:100%;border:1px solid #000" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="text-align:center;border-bottom:1px solid #000">Item</td>
                            <td style="text-align:center;border-bottom:1px solid #000">Unit Cost</td>
                            <td style="text-align:center;border-bottom:1px solid #000">Qty</td>
                            <td style="text-align:center;border-bottom:1px solid #000">Cost</td>
                            <td style="text-align:center;border-bottom:1px solid #000">Frequency</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">Account Activation Fee</td>
                            <td style="text-align:center;">$<?php echo !empty($option_enterprise[0]['setup_fee'])?$option_enterprise[0]['setup_fee']:'0'; ?></td>
                            <td style="text-align:center;">1</td>
                            <td style="text-align:center;">$<?php echo !empty($option_enterprise[0]['setup_fee'])?$option_enterprise[0]['setup_fee']:'0'; ?></td>
                            <td style="text-align:center;">One-time</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">Subscription (2 User licenses)</td>
                            <td style="text-align:center;">$<?php echo !empty($option_enterprise[0]['subscription_fee'])?$option_enterprise[0]['subscription_fee']*2:'0'; ?></td>
                            <td style="text-align:center;">1</td>
                            <td style="text-align:center;">$<?php echo !empty($option_enterprise[0]['subscription_fee'])?$option_enterprise[0]['subscription_fee']*2:'0'; ?></td>
                            <td style="text-align:center;">Every 30 days</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">Total due today</td>
                            <td></td>
                            <td></td>
                            <td style="text-align:center;">$<?php  echo !empty($total_enterprise)?$total_enterprise:'0'; ?></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
            </div>
		</td>
	</tr>
</table>
<button  style="font-size:14px;width:100px" class="btn previous_enter action-button" type="button" value="previous">Previous</button>
<button class="btn card_enterprise" type="button"  style="font-size:14px;width:100px">Next</button>
</fieldset>

