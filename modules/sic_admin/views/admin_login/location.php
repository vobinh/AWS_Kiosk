<div class="content" id="wap-login">
    <form id="frmLocation" class="login-form">
        <h3 class="form-title-location">POS System</h3>
        <h3 class="form-title-location">Management Panel</h3>
        <h3 class="form-title-location-name">
            Welcome, <?php echo $this->sess_cus['name'] ?>
        </h3>
        <h3 class="form-title-location">Select your location</h3>
        <div class="form-actions">
            <div class="form-group">
                <a type="button" href="<?php echo url::base() ?>login/option/<?php echo base64_encode('Addministrator') ?>" class="btn blue" style="min-width: 100%;">
                    Addministrator Panel
                </a>
            </div>
            <?php //echo kohana::Debug($store); ?>
            <?php if(!empty($store['store'])): ?>
                <?php foreach ($store['store'] as $key => $itemStore): ?>
                    <div class="form-group">
                        <a type="button" href="<?php echo url::base() ?>login/option/<?php echo base64_encode($itemStore['id']) ?>" class="btn blue" style="min-width: 100%;">
                            <?php echo $itemStore['name']; ?>
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