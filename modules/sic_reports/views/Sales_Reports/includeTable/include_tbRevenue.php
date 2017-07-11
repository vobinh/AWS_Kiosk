<div class="col-md-12">
	<p>Revenue</p>
	<div class="table-responsive cls-table">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th class="cls-center" width="20%">Menu Category</th>
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
			<?php if(!empty($listData['dataRevenue'])): ?>
				<?php foreach ($listData['dataRevenue'] as $key => $value): ?>
					<tr>
						<td class="cls-center"><?php echo $key ?></td>
						<?php if(!empty($listData['dataRevenue'])): $vt = 0; ?>
							<?php foreach ($value as $key => $item): ?>
								<td class="cls-center">
									<?php 
										echo !empty($item['totalPrice'])?number_format($item['totalPrice'], 2, '.', ''):'0.00';
										$total[$vt] += (!empty($item['totalPrice'])?$item['totalPrice']:0);
										$vt++;
									?>
								</td>
							<?php endforeach ?>
						<?php endif ?>
					</tr>
				<?php endforeach ?>
			<?php endif ?>
			<tr>
				<th class="cls-center">
					Total
				</th>
				<?php if(!empty($listData['usingDate'])): ?>
					<?php foreach ($listData['usingDate'] as $key => $value): ?>
						<th class="cls-center">
							<?php echo !empty($total[$key])?number_format($total[$key], 2, '.', ''):'0.00'; ?>
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
		<div id="site_activities_loading_2">
			<img src="<?php echo $this->site['theme_url']?>layout/img/loading.gif" alt="loading"/>
		</div>
		<div id="site_activities_content_2" class="display-none">
			<div id="site_activities_2" class="site_activities" style="min-height: 500px;">
			</div>
		</div>
	</div>
</div>