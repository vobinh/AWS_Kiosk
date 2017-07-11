<div class="col-md-12">
	<p>Tax</p>
	<div class="table-responsive cls-table">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th class="cls-center" width="20%">Type</th>
					<?php if(!empty($listData['usingDate'])): ?>
						<?php $total = array(); ?>
						<?php foreach ($listData['usingDate'] as $key => $value): ?>
							<?php $total[$key] = 0; ?>
							<th class="cls-center">
								<?php echo !empty($value)?$value:'' ?>
							</th>
						<?php endforeach ?>
					<?php endif ?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th class="cls-center">Tax</th>
					<?php if(!empty($listData['dataTax'])): ?>
						<?php foreach ($listData['dataTax'] as $key => $value): ?>
								<th class="cls-center">
									<?php 
										echo !empty($value)?number_format($value, 2, '.', ''):'0.00';
									?>
								</th>
						<?php endforeach ?>
					<?php else: ?>
						<th class="cls-center">
							0.00
						</th>
					<?php endif ?>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="portlet-body cls-chart display-none">
		<div id="site_activities_loading">
			<img src="<?php echo $this->site['theme_url']?>layout/img/loading.gif" alt="loading"/>
		</div>
		<div id="site_activities_content" class="display-none">
			<div id="site_activities" class="site_activities" style="min-height: 300px;">
			</div>
		</div>
	</div>
</div>