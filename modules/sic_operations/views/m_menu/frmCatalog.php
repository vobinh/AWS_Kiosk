<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Add New Menu Item'; ?>
			</div>
		</div>
		<div class="portlet-body form">
			<div style="padding:10px;padding-top: 0;padding-bottom: 0;">
				<button type="button" onclick="Catalog.StandarItemMenu(this)" class="btn btn-primary btn-lg type_btn_menu">Standard Item</button>
				<button type="button" onclick="Catalog.ComboSetMenu(this)" class="btn btn-lg type_btn_menu">Combo Set</button>
			</div>
			<div id="frm_multiple_menu"></div>
		</div>
	</div>
</div>
