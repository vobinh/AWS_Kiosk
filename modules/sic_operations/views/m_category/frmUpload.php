<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Crop Image.'; ?>
			</div>
		</div>
		<div class="portlet-body form">
			<div class="demo-wrap upload-demo">
                <div class="row">
                	<div class="col-md-12">
                        <div class="upload-msg">
                            Upload a file to start cropping
                        </div>
                        <div class="upload-demo-wrap">
                            <div id="upload-demo"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="actions" style="text-align: center;">
                            <a class="btn green file-btn">
                                <span>Upload</span>
                                <input type="file" id="upload" value="Choose a file" accept="image/*" />
                            </a>
                            <button class="upload-result btn red">Crop</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions right">
				<button type='button' class='btn btn-close-crop close-kioskDialog'>close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		var hostAPIUpload = '<?php echo url::base() ?>catalogs/sendImg'; //'<?php echo url::base() ?>catalogs/sendDataImg';
		var storeAPI      = '<?php echo !empty($this->sess_cus["storeId"])?base64_decode($this->sess_cus["storeId"]):"0" ?>';
		DemoC.init(hostAPIUpload, storeAPI);
	});
</script>