<div class="content" id="wap-login">
    <form id="frmLocation" class="login-form">
        <h3 class="form-title-location">POS System</h3>
        <h3 class="form-title-location">Management Panel</h3>
        <h3 class="form-title-location-name">
            Welcome, <?php echo $this->sess_cus['admin_first_name'],' ',$this->sess_cus['admin_name'] ?>
        </h3>
        <h3 class="form-title-location">Select a store Panel</h3>
        <div class="form-actions">
            <?php if(empty($dataStore)): ?>
            <div class="form-group">
                <span style="display: block;text-align: center;color: #fff;">
                   You do not have any stores. Please log into administrator panel, and create stores on Store Mgmt page.
                </span>
            </div>
            <?php else: ?>
                <?php foreach ($dataStore as $key => $value): ?>
                    <div class="form-group">
                        <a type="button" <?php echo (!empty($value['status']) && $value['status'] == 2)?"disabled":''  ?> href="<?php echo url::base() ?>login/option/<?php echo base64_encode($value['store_id']) ?>" class="btn blue" style="min-width: 100%;">
                            <?php if(empty($value['store'])): ?>
                                <?php echo !empty($value['s_first'])?$value['s_first']:'' ?>&nbsp;<?php echo !empty($value['s_last'])?$value['s_last']:'' ?>&nbsp;<?php echo (!empty($value['status']) && $value['status'] == 2)?"(Inactive)":'' ?>
                            <?php else: ?>
                                <?php echo !empty($value['store'])?$value['store']:'' ?>&nbsp;<?php echo (!empty($value['status']) && $value['status'] == 2)?"(Inactive)":'' ?>
                            <?php endif ?>
                        </a>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
        <div class="create-account" style="overflow: hidden;">
            <a type="button" href="<?php echo url::base()  ?>login/logout" class="btn btn-sm default dark-stripe pull-right">Log Out</a>
        </div>
    </form>
</div>