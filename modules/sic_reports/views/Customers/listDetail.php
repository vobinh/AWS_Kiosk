<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'View Order'; ?>
				<span style="display: block;font-size: 14px;padding-top: 5px;font-weight: 600;">
					Customer: <?php echo $userName ?>
				</span>
			</div>
		</div>
		<form id="frmViewOrder" action="<?php echo url::base() ?>catalogs/savePlaceOrder" method="POST" accept-charset="utf-8">
		<div class="portlet-body form wap-place-order">
			<div class="table-responsive table-datatable filter-hidden" style="position: relative;">
				<table class="table table-striped review_order" id="tb-detail-order" width="100%" style="margin: auto auto auto 0;">
					<thead>
						<tr>
							<th style="white-space: nowrap;vertical-align: middle; width:10%;">
								
							</th>
							<th style="white-space: nowrap;vertical-align: middle;">
								Date
							</th>
							<th style="white-space: nowrap;vertical-align: middle;">
								Tax
							</th>
							<th style="white-space: nowrap;vertical-align: middle;">
								Total
							</th>
						</tr>
					</thead>
					<tbody>
					<?php
						if(!empty($listData)){ 
							foreach ($listData as $key => $value) { ?>
							<tr id="<?php echo $value['order_id'] ?>">
								<td class="details-control">
									<button type="button" type="button" class="btn default btn-sm green">Detail</button>
								</td>
								<td>
									<?php echo !empty($value['regidate'])?date('m/d/Y H:i:s',strtotime($value['regidate'])):'' ?>
								</td>
								<td>
									$<?php echo !empty($value['tax'])?number_format($value['tax'],2,'.',''):'0.00' ?>
								</td>
								<td>
									$<?php echo !empty($value['amount'])?number_format($value['amount'],2,'.',''):'0.00' ?>
								</td>
							</tr>
						<?php }} ?>
					</tbody>
				</table>
			</div>
			<div class="form-actions right">
				<button style="min-width: 150px;" type="button" class="btn default toggle-page-quick">Close</button>
			</div>
		</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	var listDetails = function() {
		var tbCustomers;
		var wapCustomers;
		function getDetail (callback) {
			var tlId = callback.data().DT_RowId;
			$.ajax({
	            url: '<?php echo url::base() ?>reports/getDetailOrder',
	            type: 'post',
	            data:{
	            	'idOrder': tlId,
	            	'mainTax': callback.data()[2],
	            	'mainTotal': callback.data()[3],
	            },
	            beforeSend: function () {
	                Kiosk.blockUI({
	                    overlayColor: 'none',
	                    cenrerY: true,
	                });
	            }
	        })
            .done(function (data) {
                callback.child(data).show();
                Kiosk.unblockUI();
            })
            .fail(function () {
                callback('Error').show();
                Kiosk.unblockUI();
            });
		};

		var loadCustomers = function (){
			tbCustomers = $("#tb-detail-order").DataTable({
				'info' : false,
				"ordering": false,
				"scrollX": true,
				"scrollY": '360px',
				"paging": false
			});
			var detailRows = [];
			$('#tb-detail-order tbody').on( 'click', 'tr td.details-control button', function () {
				var btn = $(this);
				var tr  = btn.closest('tr');
				var row = tbCustomers.row( tr );
	           	if(row.child.isShown()){
		           	btn.removeClass('red').addClass('green').text('Detail');
		            row.child.hide();
		        }else{
		           btn.removeClass('green').addClass('red').text('Close');
		           getDetail(row);
		        }
			});
		};
				
		return {
	        init: function () {
	            loadCustomers();
	        },
	        get: function(){
				return tbCustomers;
			}
	    };
	}();

	$(document).ready(function() {
		listDetails.init();
	});
</script>