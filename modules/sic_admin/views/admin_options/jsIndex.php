<script type="text/javascript">
	var pageOptions = function(){
		var wapData;
		var tbData;
		var handleInput = function(){

		};

		var handleEvent = function(){
			
		};

		var handleValidate = function(){

		};

		var handlePrivilegesEvent = function(){
			$('input[name="txt_acc_r"]').click(function(event) {
				var c = this.checked;
				$('.cls-acc-r:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-acc-r');
			});
			$('input[name="txt_acc_w"]').click(function(event) {
				var c = this.checked;
				$('.cls-acc-w:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-acc-w');
			});

			$('input[name="txt_operations_r"]').click(function(event) {
				var c = this.checked;
				$('.cls-operations-r:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-operations-r');
			});
			$('input[name="txt_operations_w"]').click(function(event) {
				var c = this.checked;
				$('.cls-operations-w:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-operations-w');
			});

			$('input[name="txt_marketing_r"]').click(function(event) {
				var c = this.checked;
				$('.cls-marketing-r:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-marketing-r');
			});
			$('input[name="txt_marketing_w"]').click(function(event) {
				var c = this.checked;
				$('.cls-marketing-w:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-marketing-w');
			});

			$('input[name="txt_reports_r"]').click(function(event) {
				var c = this.checked;
				$('.cls-reports-r:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-reports-r');
			});
			$('input[name="txt_reports_w"]').click(function(event) {
				var c = this.checked;
				$('.cls-reports-w:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-reports-w');
			});

			$('input[name="txt_employees_r"]').click(function(event) {
				var c = this.checked;
				$('.cls-employees-r:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-employees-r');
			});
			$('input[name="txt_employees_w"]').click(function(event) {
				var c = this.checked;
				$('.cls-employees-w:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-employees-w');
			});

			$('input[name="txt_settings_r"]').click(function(event) {
				var c = this.checked;
				$('.cls-settings-r:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-settings-r');
			});
			$('input[name="txt_settings_w"]').click(function(event) {
				var c = this.checked;
				$('.cls-settings-w:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-settings-w');
			});
		};

		return {
			init: function(){
				Kiosk.initUniform('input[type="checkbox"]');
				handlePrivilegesEvent();
			},
		}
	}();

	$(document).ready(function() {
		pageOptions.init();
	});
</script>