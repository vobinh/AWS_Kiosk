var DemoC = (function() {
	var hostAPIUpload, storeAPI = '';
	var iWidth  = 120;
	var iHeight = 110;
	function demoUpload() {
		var $uploadCrop;

		function readFile(input) {
 			if (input.files && input.files[0]) {
	            var reader = new FileReader();
	            
	            reader.onload = function (e) {
					$('.upload-demo').addClass('ready');
	            	$uploadCrop.croppie('bind', {
	            		url: e.target.result
	            	}).then(function(){
	            		//console.log('jQuery bind complete');
	            	});
	            	
	            }
	            
	            reader.readAsDataURL(input.files[0]);
	        }
	        else {
		        $.bootstrapGrowl("Sorry - you're browser doesn't support the FileReader API.", { 
	            	type: 'danger' 
	            });
		    }
		}

		$uploadCrop = $('#upload-demo').croppie({
			viewport: {
				width: iWidth,
				height: iHeight,
				type: 'square'
			},
			boundary: {
		        width: 250,
		        height: 250
		    },
			enableExif: true
		});

		$('#upload').on('change', function () { 
			readFile(this); 
		});

		$('.upload-result').on('click', function (ev) {
			Kiosk.blockUI();
			$uploadCrop.croppie('result', {
				type: 'canvas',
				size: 'viewport'
			}).then(function (resp) {
				var blobBin = atob(resp.split(',')[1]);
				var array = [];
				for(var i = 0; i < blobBin.length; i++) {
				    array.push(blobBin.charCodeAt(i));
				}
				var file = new Blob([new Uint8Array(array)], {type: 'image/png'});
				var data = new FormData();
				data.append('uploadfile', file);
				data.append('store_id', storeAPI);
				$.ajax({
				    type: 'POST',
				    url: hostAPIUpload, //"<?php echo url::base() ?>catalogs/sendImg",
				    data: data,
				    crossDomain: true,
				    processData: false,
				    contentType: false,
				    dataType : 'json',
				    success: function(response) {
				    	if(response != null && response.responseMsg == 'Success'){
				    		$.bootstrapGrowl("Upload Success.", { 
				            	type: 'success' 
				            });

				    		$('#uploadfilehd').val(response.data[0]['file_id']);

				    		if($('.img-preAPI').length){
								var img = $('.img-preAPI');
								img.attr("src",resp);
								img.prev('a').show();
							}

							if($('.btn-close-crop').length){
								$('.btn-close-crop').click();
							}
				    	}else{
				    		$.bootstrapGrowl("Could not complete request.", { 
				            	type: 'danger' 
				            });
				    	}
				    	Kiosk.unblockUI();
				    }
			   	}).fail(function() {
					Kiosk.unblockUI();
					$.bootstrapGrowl("Could not complete request.", { 
		            	type: 'danger' 
		            });
				});
			});
		});
	}

	function init(urlAPI, storeId, Width, Height) {
		hostAPIUpload = urlAPI;
		storeAPI      = storeId;
		if(storeAPI == '0'){
			storeAPI = $('#slt_store_active').val();
		}
		if(Width){
			iWidth = Width;
		}

		if(Height){
			iHeight = Height;
		}
		demoUpload();
	}

	return {
		init: function(urlAPI, storeId, Width, Height){
			init(urlAPI, storeId, Width, Height)
		}
	};
})();


// Full version of `log` that:
//  * Prevents errors on console methods when no console present.
//  * Exposes a global 'log' function that preserves line numbering and formatting.
(function () {
  	var method;
  	var noop = function () { };
  	var methods = [
      'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
      'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
      'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
      'timeStamp', 'trace', 'warn'
  	];
  	var length = methods.length;
  	var console = (window.console = window.console || {});
 
  	while (length--) {
    	method = methods[length];
 
    	// Only stub undefined methods.
    	if (!console[method]) {
        	console[method] = noop;
    	}
  	}
 
 
  	if (Function.prototype.bind) {
   		window.log = Function.prototype.bind.call(console.log, console);
  	}
  	else {
    	window.log = function() { 
      		Function.prototype.apply.call(console.log, console, arguments);
    	};
  	}
})();