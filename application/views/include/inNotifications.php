<?php if(isset($error_msg)) { ?>
	<script type="text/javascript">
		notification('danger','<?php echo $error_msg?>');
	</script>
<?php } ?>

<?php if(isset($success_msg)) { ?>
	<script type="text/javascript">
		notification('success','<?php echo $success_msg?>');
	</script>
<?php } ?>

<?php if(isset($info_msg)) { ?>
	<script type="text/javascript">
		notification('info','<?php echo $info_msg?>');
	</script>
<?php } ?>

<?php if(isset($warning_msg)) { ?>
	<script type="text/javascript">
		notification('warning','<?php echo $warning_msg?>');
	</script>
<?php } ?>