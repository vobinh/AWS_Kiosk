<div style="padding-left: 10px;">
    <p style="font-weight:bold">Inactive Account</p>
    <p>Access to this account and its associated users have been frozen due to the following reason:</p>
    <p style="color:red">Credit card was declined for auto-pay.</p>
    <p>To reactivate subscription, click on the button below:</p>
    <div>
        <button <?php if($this->sess_cus['account_view'] == 1){?>onclick="account_management()"<?php }else{ ?>style="<?php echo block_color ?>"<?php }?> type="button" class="btn">Account Management</button>
    </div>
</div>