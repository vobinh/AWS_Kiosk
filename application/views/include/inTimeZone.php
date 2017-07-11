<select name="txt_store_timezone" class="form-control input-sm slt-select2">
	<option <?php echo (!empty($data['time_zone']) && $data['time_zone'] == 'utc')?'selected':''; ?> value="utc">(UTC) Coordinated Universal Time</option>
	<?php /* ?>
	<option <?php echo (!empty($data['time_zone']) && $data['time_zone'] == '-10:00')?'selected':''; ?> value="-10:00">(GMT -10:00) Hawaii</option>
	<option <?php echo (!empty($data['time_zone']) && $data['time_zone'] == '-09:00')?'selected':''; ?> value="-09:00">(GMT -09:00) Alaska</option>
	<option <?php echo (!empty($data['time_zone']) && $data['time_zone'] == '-08:00')?'selected':''; ?> value="-08:00">(GMT -08:00) Pacific Time (US &amp; Canada)</option>
	<option <?php echo (!empty($data['time_zone']) && $data['time_zone'] == '-07:00')?'selected':''; ?> value="-07:00">(GMT -07:00) Mountain Time (US &amp; Canada)</option>
	<option <?php echo (!empty($data['time_zone']) && $data['time_zone'] == '-06:00')?'selected':''; ?> value="-06:00">(GMT -06:00) Central Time (US &amp; Canada), Mexico City</option>
	<option <?php echo (!empty($data['time_zone']) && $data['time_zone'] == '-05:00')?'selected':''; ?> value="-05:00">(GMT -05:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
	<?php */ ?>
	<option <?php echo (!empty($data['time_zone']) && $data['time_zone'] == 'Alaskan Standard Time')?'selected':''; ?> value="Alaskan Standard Time">(UTC-09:00) Alaska</option>
	<option <?php echo (!empty($data['time_zone']) && $data['time_zone'] == 'Central Standard Time')?'selected':''; ?> value="Central Standard Time">(UTC-06:00) Central Time (US & Canada)</option>
	<option <?php echo (!empty($data['time_zone']) && $data['time_zone'] == 'Eastern Standard Time')?'selected':''; ?> value="Eastern Standard Time">(UTC-05:00) Eastern Time (US & Canada)</option>
	<option <?php echo (!empty($data['time_zone']) && $data['time_zone'] == 'Hawaiian Standard Time')?'selected':''; ?> value="Hawaiian Standard Time">(UTC-10:00) Hawaii</option>
	<option <?php echo (!empty($data['time_zone']) && $data['time_zone'] == 'Mountain Standard Time')?'selected':''; ?> value="Mountain Standard Time">(UTC-07:00) Mountain Time (US & Canada)</option>
	<option <?php echo (!empty($data['time_zone']) && $data['time_zone'] == 'Pacific Standard Time')?'selected':''; ?> value="Pacific Standard Time">(UTC-08:00) Pacific Time (US & Canada)</option>
</select>