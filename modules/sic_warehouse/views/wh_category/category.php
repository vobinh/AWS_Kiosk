<div class="row">
	<div class="col-md-12 div-btn-top">
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>warehouse'">Registry</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>warehouse/inventory'" style="position: relative;">Inventory <span class="badge badge-danger lb-count-order" style="position: absolute;top: -12px;right: -5px;background-color: #ea111b;color: #fff;font-weight: bold;font-size: 17px !important;padding: 4px 8px;height: 26px;border-radius: 50px !important;"><?php echo !empty($this->countWHOrder)?$this->countWHOrder:0 ?> </span></button>
		<button type="button" class="btn btn-primary btn-lg" disabled >Category</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>warehouse/distribution'" style="position: relative;">Distribution <span class="badge badge-danger" style="position: absolute;top: -12px;right: -10px;background-color: #ea111b;color: #fff;font-weight: bold;font-size: 17px !important;padding: 4px 8px;height: 26px;border-radius: 50px !important;"><?php echo !empty($this->countOrder)?$this->countOrder:0 ?> </span></button>
		<!-- <button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>warehouse/analysis'">Analysis</button> -->
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered wap-content-category">
			<div class="portlet-title">
				<div class="caption">
					Category Management
				</div>
			</div>
			<div class="row" style="margin-bottom: 5px;">
				<div class="col-sm-8 col-sm-push-4">
					<div class="table-action">
						<button type="button" class="btn green btn-add-catalog" onclick="addCategory()">
							<i class="fa fa-plus"></i>&nbsp;Add Category
						</button>
						<div class="btn-group">
							<button type="button" class="btn btn-fit-height" data-toggle="dropdown" data-delay="1000" data-close-others="true">
							Action On Selected <i class="fa fa-angle-down"></i>
							</button>
							<ul class="dropdown-menu pull-right" role="menu">
								<li>
									<a href="javascript:void(0)" class="category-delete"><i class="fa fa-trash-o"></i>&nbsp;Delete</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="javascript:void(0)" class="category-csv" ><i class="fa fa-file-excel-o"></i>&nbsp;Export to CSV</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-sm-4 col-sm-pull-8">
					<div class="portlet-input">
						<div class="input-icon">
							<i class="icon-magnifier "></i>
							<input id="search" type="text" class="form-control" placeholder="search...">
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="portlet-body rgba_white" style="position: relative;">
				<div class="col-md-12" style="padding: 10px;padding: 10px;border-bottom: 1px solid #cecece;">
					<input type="checkbox" name="" class="chk-all" value="">
				</div>
				<div class="clearfix"></div>
				<div class="body-data-category" style="height: 351px;position: relative;padding-top: 10px;border-bottom: 1px solid #cecece; overflow-x: hidden;overflow-y: auto;">
					<?php if( !empty($dataCategory) ): ?>
						<?php foreach ($dataCategory as $key => $itemCategory): ?>
							<div class="col-lg-2 col-md-3 col-sm-6 wap-item-category">
								<div class="border add-catalog item-category">
									<p><input type="checkbox" class="item-select" name="" value="<?php echo !empty($itemCategory['sub_category_id'])?$itemCategory['sub_category_id']:''; ?>"> <span style="color:<?php echo (!empty($itemCategory['catalog_name']) && $itemCategory['catalog_name'] == 'Menu Item')?'#357ebd':'#ffa500'; ?>" class="item-size-15"><?php echo !empty($itemCategory['catalog_name'])?$itemCategory['catalog_name']:''; ?></span></p>
									<p class="item-size-15"><?php echo !empty($itemCategory['sub_category_name'])?$itemCategory['sub_category_name']:''; ?></p>
									<p class="item-size-15">? Added 3/15/2016 ?</p>
									<div class="total-item">
										<h3>0 Items</h3>
									</div>
								</div>
							</div>
						<?php endforeach ?>
					<?php endif ?>	
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-lg-2 col-md-3 col-sm-6 category-template" style="display: none;">
	<div class="border add-catalog item-category">
		<p>
			<input type="checkbox" class="item-select data-sub-id" name="" value="">&nbsp;
			<span class="item-size-15 data-name"></span>
		</p>
		<p class="item-size-15 img-inventory">
			<img class="in-img" width="32px" height="32px" src="" alt="">&nbsp;
			<span class="data-sub-name" style="font-weight: 600;"></span>
		</p>
		<p class="item-size-15 data-sub-date"></p>
		<div class="total-item">
			<h3 class="data-total"></h3>
		</div>
	</div>
</div>
<!-- include jsCategory.php  controller jsKiosk -->