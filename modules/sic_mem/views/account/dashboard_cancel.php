<?php
	$this->db->where('refer_user_id',$this->sess_cus['refer_user_id']);
	$this->db->where('account_type',0);
    $member_license = $this->db->get('member_license')->result_array(false);
?>
<div style="padding-left: 10px;">
    <p style="font-weight:bold">Inactive Account</p>
    <p>Access to this account and its associated users have been frozen due to the following reason:</p>
    <p style="color:red">Subscription cancelled (Account frozen on the last day of previous billing cycle, <?php echo !empty($member_license[0]['cancel_subscription_date'])?$member_license[0]['cancel_subscription_date']:0;?>)</p>
    <p>To reactivate subscription, click on the button below:</p>
    <div>
        <button <?php if($this->sess_cus['account_view'] == 1){?>onclick="account_management()"<?php }else{ ?>style="<?php echo block_color ?>"<?php }?> type="button" class="btn">Account Management</button>
    </div>
</div>