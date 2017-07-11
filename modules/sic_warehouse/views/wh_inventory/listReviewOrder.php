<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'View Order'; ?>
				<span style="display: block; font-size: 14px;">Below is the list of previously placed orders. Once you receive the orders, mark the entries as Complete to automatically generate inventory entries with the automatically assigned lot number. Expiration dates will be set by adding "Shelf Life" value for the item (configured from Inventory Registry) to the date of completion.</span>
			</div>
		</div>
		<form id="frmViewOrder" action="<?php echo url::base() ?>catalogs/savePlaceOrder" method="POST" accept-charset="utf-8">
		<div class="portlet-body form wap-place-order">
			<div class="row">
				<div class="col-md-12" style="text-align: right;">
					<div class="btn-group">
						<button type="button" class="btn btn-fit-height" data-toggle="dropdown" data-delay="1000" data-close-others="true">
						Action On Selected <i class="fa fa-angle-down"></i>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li>
								<a href="javascript:void(0)" class="review-ascomplete"><i class="fa fa-trash-o"></i> Mark As Complete</a>
							</li>
							<li>
								<a href="javascript:void(0)" class="review-delete"><i class="fa fa-trash-o"></i> Delete</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="javascript:void(0)" class="review-csv"><i class="fa fa-file-excel-o"></i> Export to CSV</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="table-responsive table-datatable filter-hidden" style="position: relative;">
				<table class="table table-striped review_order" id="tb-place-order" width="100%" style="margin: auto auto auto 0;">
					<thead>
						<tr>
							<th>
								<input type="checkbox" class="chk-all chk_unifrm">
							</th>
							<th style="white-space: nowrap;vertical-align: middle;">
								Icon
							</th>
							<th style="white-space: nowrap;vertical-align: middle;">
								Category
							</th>
							<th style="white-space: nowrap;vertical-align: middle;">
								Item Name
							</th>
							<th style="white-space: nowrap;vertical-align: middle;">
								SKU#
							</th>
							<th style="white-space: nowrap;vertical-align: middle;">
								Payment
							</th>
							<th style="white-space: nowrap;vertical-align: middle;">
								Qty Ordered
							</th>
							<th style="white-space: nowrap;vertical-align: middle;">
								Date Ordered
							</th>
							<th style="white-space: nowrap;vertical-align: middle;">
								Lot #
							</th>
							<th style="white-space: nowrap;vertical-align: middle;">
								Order Status
							</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
				<div style="float: left;padding: 10px;padding-top: 0;">
					<div>
						<input type="checkbox" class="chk_unifrm" name="complete_view_order"> <span>Hide completed orders</span>
					</div>
					<div>
						<input type="checkbox" class="chk_unifrm" name="auto_delete"> <span>Automatically delete completed orders after 10 days</span>
					</div>
				</div>
				<div style="text-align: right;padding-bottom: 10px;font-size: 16px;font-weight: 600;">
					Total Cost: $<span class="lb-total"><?php echo number_format(!empty($total)?$total:0,2); ?></span>
				</div>
			</div>
			<div class="form-actions right">
				<button style="min-width: 150px;" type="button" onclick="frmViewOrder.checkReload()" class="btn default toggle-page-quick">Close</button>
			</div>
		</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	var frmViewOrder = function(){
		var tbPlaceOrder, frm;
		var reload = 0;
		var initInput = function(){
			frm = $('#frmViewOrder');
			Kiosk.initUniform('.chk_unifrm');
			$(".decimal").inputmask('decimal',{rightAlign: true});
		};

		var initEvent = function(){
			$('input[name="complete_view_order"]', frm).change(function() {
				var datatable    = tbPlaceOrder.getDataTable();
				var tablewrapper = tbPlaceOrder.getTableWrapper();
				var table        = tbPlaceOrder.getTable();
				if($(this).is(':checked')){
					tbPlaceOrder.setAjaxParam('hide-complete', 1);
				}else{
	    			tbPlaceOrder.setAjaxParam('hide-complete', 0);
				}
				datatable.ajax.reload();
			});

			$('input[name="auto_delete"]', frm).change(function() {
				var datatable    = tbPlaceOrder.getDataTable();
				var tablewrapper = tbPlaceOrder.getTableWrapper();
				var table        = tbPlaceOrder.getTable();
				if($(this).is(':checked')){
					tbPlaceOrder.setAjaxParam('auto-delete', 1);
				}else{
	    			tbPlaceOrder.setAjaxParam('auto-delete', 0);
				}
				datatable.ajax.reload();
			});

			$('.review-ascomplete', frm).click(function(event) {
				var selected = tbPlaceOrder.getSelectedID();
				if(selected.length > 0){
					bootbox.confirm({
			            message: 'Are you sure you want to Mark As Complete?',
			            title: 'Mark As Complete',
			            buttons: {
			              cancel: {
			                label: "No",
			                className: "default btn-no"
			              },confirm: {
			                label: "Yes",
			                className: "green btn-yes"
			              }
			            },callback: function(result) {
			            	if(result){
			            		frmViewOrder.markAsComplete(selected);
		                    }
		                }
			        });
				}else{
					$.bootstrapGrowl("No record selected.", { 
			           	type: 'danger' 
			        });
				}
			});

			$('.review-delete', frm).click(function(event) {
				var selected = tbPlaceOrder.getSelectedID();
				if(selected.length > 0){
					frmViewOrder.delOrder(selected);
				}else{
					$.bootstrapGrowl("No record selected.", { 
			           	type: 'danger' 
			        });
				}
			});

			$('.review-csv', frm).click(function(event) {
				var selected = tbPlaceOrder.getSelectedID();
				if(selected.length > 0){
					frmViewOrder.export(selected);
				}else{
					$.bootstrapGrowl("No record selected.", { 
			           	type: 'danger' 
			        });
				}
			});
		};

		return {
			init: function(){
				initInput();
				initEvent();
				frmViewOrder.loadData();
			},
			loadData: function(){
				tbPlaceOrder = new Datatable();
				tbPlaceOrder.init({
					src: $("#tb-place-order"),
					wapHeight: "389px",
					dataTable: {
						paging: false,
						ordering: false,
						bInfo : false,
						serverSide: true,
						ordering: false,
						scrollX: true,
						scrollY: '345px',
						"ajax":{
							"url" : "<?php echo url::base()?>warehouse/jsViewOrder",
						},
						"columns": [{
			                "data": null,
			                "class": "",
			                "orderable": false,
			                "render": function ( data, type, full, meta ) {
			                    return "<input type='checkbox' class='item-select' name='chk_customer[]' value='"+full.tdID+"'>";
			                }
			            },{
			                "data": null,
			                "class": "slt-row",
			                "orderable": false,
			                "render": function ( data, type, full, meta ) {
			                	if(full.tdIcon){
			                		return "<div class='icon-catalog'><img style='width:32px;height:32px' src='<?php echo $this->hostGetImg ?>?files_id="+full.tdIcon+"' alt=''></div>";
			                	}else{
			                		return "<div class='icon-catalog'></div>";
			                	}
			                }
			            },{
			            	"class": "slt-row",
			                "data": "tdCategory",
			                "orderable": false
			            },{
			            	"class": "slt-row",
			                "data": "tdName",
			                "orderable": false
			            },{
			            	"class": "slt-row",
			                "data": "tdSKU",
			                "orderable": false
			            },{
			            	"class": "slt-row",
			                "data": "tdPayment",
			                "orderable": false
			            },{
			            	"class": "slt-row",
			                "data": "tdQty",
			                "orderable": false
			            },{
			            	"class": "slt-row",
			                "data": "tdDate",
			                "orderable": false
			            },{
			            	"class": "slt-row",
			                "data": "tdLot",
			                "orderable": false
			            },{
			            	"class": "slt-row",
			                "data": null,
			                "orderable": false,
			                "render": function ( data, type, full, meta ) {
			                	var flag = true;
			                	var _str = '';
			                	if(full.tdComplete && full.tdComplete == 0){
			                		var _str = '<a style="text-align: left;min-width: 11.3em;border: 1px solid rgb(97, 97, 97);background-color: rgb(97, 97, 97);color: #fff;padding: 6px;padding-bottom: 3px;padding-top: 3px;" href="javascript:;" class="btn btn-md">';
									_str +=	'<span><i style="font-size: 20px;position: relative;top: 2px;" class="fa fa-check-circle" aria-hidden="true"></i></span>';
									_str +=	'<span>&nbsp;Complete</span>';
									_str +=	'</a>';
			                	}else if(full.tdComplete && full.tdComplete == 1){
			                		var _str = '<a onclick="frmViewOrder.markAsComplete(\''+full.tdID+'\')" style="text-align: left;min-width: 11.3em;border: 1px solid rgb(76, 175, 80);color: #fff;padding: 6px;padding-bottom: 3px;padding-top: 3px;" href="javascript:;" class="btn btn-md green">';
									_str +=	'<span><i style="font-size: 20px;position: relative;top: 2px;" class="fa fa-check-circle" aria-hidden="true"></i></span>';
									_str +=	'<span>&nbsp;Mark as Complete</span>';
									_str +=	'</a>';
									_str += '<a href="javascript:;" disabled class="btn btn-sm red btn-delete">';
									_str +=	'<i class="fa fa-times"></i>';
									_str +=	'</a>';
									flag = false;
			                	}else if(full.tdComplete && full.tdComplete == 2){
			                		var _str = '<a style="text-align: left;min-width: 11.3em;border: 1px solid rgb(97, 97, 97);background-color: rgb(97, 97, 97);color: #fff;padding: 6px;padding-bottom: 3px;padding-top: 3px;" href="javascript:;" class="btn btn-md">';
									_str +=	'<span><i style="font-size: 20px;position: relative;top: 2px;" class="fa fa-check-circle" aria-hidden="true"></i></span>';
									_str +=	'<span>&nbsp;Waiting For a Reply</span>';
									_str +=	'</a>';
			                	}else if(full.tdComplete && full.tdComplete == 3){
			                		var _str = '<a style="text-align: left;min-width: 11.3em;border: 1px solid rgb(97, 97, 97);background-color: rgb(97, 97, 97);color: #fff;padding: 6px;padding-bottom: 3px;padding-top: 3px;" href="javascript:;" class="btn btn-md">';
									_str +=	'<span><i style="font-size: 20px;position: relative;top: 2px;" class="fa fa-check-circle" aria-hidden="true"></i></span>';
									_str +=	'<span>&nbsp;Warehouse Reject</span>';
									_str +=	'</a>';
			                	}
			                	if(flag){
			                		_str += '<a href="javascript:;" onclick="frmViewOrder.delOrder(\''+full.tdID+'\')" class="btn btn-sm red btn-delete">';
									_str +=	'<i class="fa fa-times"></i>';
									_str +=	'</a>';
			                	}
			                	return _str;
			                }
			            }],
			           	footerCallback: function ( row, data, start, end, display ) {
			            	var response = this.api().ajax.json();
							$('.lb-total').text(response['total']);
							if(response['countDelete'] > 0){
								$.bootstrapGrowl(response['countDelete']+" items deleted.", { 
					            	type: 'success' 
					            });
							}
			            }
					}
				});
			},
			markAsComplete: function(id_warehose_order){
	        	Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>warehouse/markAsComplete',
					type: 'POST',
					dataType: 'json',
					data: {
						'w_id': id_warehose_order
					},
				})
				.done(function(data) {
					if(parseInt(data['msg']) > 0){
						reload++;
						$.bootstrapGrowl(data['msg']+" items Mark Complete.", { 
			            	type: 'success' 
			            });
					}else{
						$.bootstrapGrowl(data['msg']+" items Mark Complete.", { 
			            	type: 'danger' 
			            });
					}

					$('.chk-all:checkbox', frm).prop('checked',false);
					Kiosk.updateUniform('.chk-all', frm);
					tbPlaceOrder.clearSelectedID();
					var datatable    = tbPlaceOrder.getDataTable();
					var tablewrapper = tbPlaceOrder.getTableWrapper();
					var table        = tbPlaceOrder.getTable();
					datatable.ajax.reload();
					Kiosk.unblockUI();
				})
				.fail(function() {
					$.bootstrapGrowl("Could not complete request.", { 
			        	type: 'danger' 
			        });
					Kiosk.unblockUI();
				});
	        },
	        delOrder: function(id_warehose_order){
	        	bootbox.confirm({
		            message: "Are you sure you want to delete this record ?",
		            title: "Delete",
		            buttons: {
		              cancel: {
		                label: "No",
		                className: "default btn-no"
		              },confirm: {
		                label: "Yes",
		                className: "green btn-yes"
		              }
		            },callback: function(result) {
		            	if(result){	
		            		Kiosk.blockUI();
							$.ajax({
								url: '<?php echo url::base() ?>warehouse/del_warehouse_order',
								type: 'POST',
								dataType: 'json',
								data: {w_id: id_warehose_order},
							})
							.done(function(data) {
								if(parseInt(data['msg']) > 0){
									$.bootstrapGrowl(data['msg']+" items deleted.", { 
						            	type: 'success' 
						            });
								}else{
									$.bootstrapGrowl(data['msg']+" items deleted.", { 
						            	type: 'danger' 
						            });
								}
								$('.chk-all:checkbox', frm).prop('checked',false);
								Kiosk.updateUniform('.chk-all', frm);
								tbPlaceOrder.clearSelectedID();
								var datatable    = tbPlaceOrder.getDataTable();
								var tablewrapper = tbPlaceOrder.getTableWrapper();
								var table        = tbPlaceOrder.getTable();
								datatable.ajax.reload();
								Kiosk.unblockUI();
							})
							.fail(function() {
								Kiosk.unblockUI();
								$.bootstrapGrowl("Could not complete request.", { 
						        	type: 'danger' 
						        });
								
							});
		                }
		            }
		        });
	        },
	        export: function(id){
	        	if(id.length > 0){
	        		$('<form>', {
					    "id": "exportMenu",
					    "html": '<input type="hidden" id="txt_id_selected" name="txt_id_selected" value="' + id + '" />',
					    "action": '<?php echo url::base() ?>warehouse/exportOrder',
					    "method": 'post'
					}).appendTo(document.body).submit();
				}else{
					$.bootstrapGrowl("No record selected.", { 
			           	type: 'danger' 
			        });
				}
	        },
	        checkReload: function (){
				if(reload > 0){
					inventoryWarehouse.reloadData();
					reload = 0;
				}
			}
		}
	}();

	$(document).ready(function() {
		frmViewOrder.init();
	});
</script>