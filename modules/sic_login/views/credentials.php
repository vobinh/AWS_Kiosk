<div class="content" id="wap-credentials" style="position: relative">
    <table style="width:100%;">
        <tbody>
            <tr>
                <td>
                    <!-- BEGIN LOGIN FORM -->
                    <form id="frmCredentials">
                        <h3 class="form-title-location">POS System</h3>
                        <h3 class="form-title-location">Management Panel</h3>
                        <h3 class="form-title-location-name">
                            <?php echo base64_decode($this->sess_cus['sltLocation']) ?>
                        </h3>
                        <h3 class="form-title-location">Select your login credentials</h3>
                        <div class="form-actions">
                            <?php if (!empty($dataUser)): ?>
                                <?php foreach ($dataUser as $key => $user): ?>
                                    <div class="form-group">
                                        <button type="button" data-value="<?php echo base64_encode($user['u_id']); ?>" data-key="<?php echo $key; ?>" class="btn blue setPin" style="min-width: 100%;">
                                        <?php if(strtolower($typeLogin) != 'admin'): ?>
                                            <?php echo ($user['u_level'] == 1)?"Restaurant Manager":$user['u_name']; ?>
                                        <?php else: ?>
                                            <?php echo ($user['u_level'] == 1)?$user['u_name'].' (Superadmin)':$user['u_name']; ?>
                                        <?php endif ?>
                                        </button>
                                        <div class="input-icon" style="display: none;">
                                            <i class="fa fa-lock"></i>
                                            <input class="form-control placeholder-no-fix txt-pin-<?php echo $key; ?>" type="password" autocomplete="off" placeholder="Enter PIN using the keypad or keyboard" name="txt_pin"/>
                                        </div>
                                        <div class="wap-pin"></div>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                        <div class="create-account" style="text-align: right;overflow: hidden;">
                            <input type="hidden" name="txt_type" class="cls-type" value="<?php echo $typeLogin ?>">
                            <a type="button" href="<?php echo url::base()  ?>login/logout" class="btn btn-sm default dark-stripe">Log Out</a>
                        </div>
                    </form>
                    <!-- END LOGIN FORM -->
                </td>
                <td class="td-pin" style="vertical-align: top;">
                    <div class="mobi-pin mobi-pin-md">
                            <div class="col-xs-4">
                                <button class="btn-pin" type="button">1</button>
                            </div>
                            <div class="col-xs-4">
                                <button class="btn-pin" type="button">2</button>
                            </div>
                            <div class="col-xs-4">
                                <button class="btn-pin" type="button">3</button>
                            </div>
                            <div class="col-xs-4">
                                <button class="btn-pin" type="button">4</button>
                            </div>
                            <div class="col-xs-4">
                                <button class="btn-pin" type="button">5</button>
                            </div>
                            <div class="col-xs-4">
                                <button class="btn-pin" type="button">6</button>
                            </div>
                            <div class="col-xs-4">
                                <button class="btn-pin" type="button">7</button>
                            </div>
                            <div class="col-xs-4">
                                <button class="btn-pin" type="button">8</button>
                            </div>
                            <div class="col-xs-4">
                                <button class="btn-pin" type="button">9</button>
                            </div>
                            <div class="col-xs-4">
                                <button class="btn-pin" type="button">0</button>
                            </div>
                            <div class="col-xs-8">
                                <button class="btn-pin" type="button">Confirm</button>
                            </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<!-- Template Pin Mobile -->
<div class="pin-main" style="display: none;">
    <div class="mobi-pin only-xs">
        <div class="col-xs-4">
            <button class="btn-pin" type="button">1</button>
        </div>
        <div class="col-xs-4">
            <button class="btn-pin" type="button">2</button>
        </div>
        <div class="col-xs-4">
            <button class="btn-pin" type="button">3</button>
        </div>
        <div class="col-xs-4">
            <button class="btn-pin" type="button">4</button>
        </div>
        <div class="col-xs-4">
            <button class="btn-pin" type="button">5</button>
        </div>
        <div class="col-xs-4">
            <button class="btn-pin" type="button">6</button>
        </div>
        <div class="col-xs-4">
            <button class="btn-pin" type="button">7</button>
        </div>
        <div class="col-xs-4">
            <button class="btn-pin" type="button">8</button>
        </div>
        <div class="col-xs-4">
            <button class="btn-pin" type="button">9</button>
        </div>
        <div class="col-xs-4">
            <button class="btn-pin" type="button">0</button>
        </div>
        <div class="col-xs-8">
            <button class="btn-pin" type="button">Confirm</button>
        </div>
    </div>
</div>
<!-- End Template Pin Mobile -->
<!-- Javascrip include controller login/credentials - jsreadyKiosk - JSReadycredentials.php -->