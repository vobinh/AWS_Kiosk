<style>
  .imageBox1
{
    position: relative;
    height: 150px;
    width: 461px;
    border:1px solid #aaa;
    background: #fff;
    overflow: hidden;
    background-repeat: no-repeat;
    cursor:move;
    margin: auto;
}

.imageBox1 .thumbBox1
{

  width: 190px;
  height: 40px;
  margin: auto;
  margin-top: 50px;
  border: 1px solid rgb(102, 102, 102);
  box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.5);
  background: none repeat scroll 0% 0% transparent;
}

.imageBox1 .spinner1
{
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    text-align: center;
    line-height: 400px;
    background: rgba(0,0,0,0.7);
}
.action1
{
  width: 100%;
  height: 30px;
  padding-top: 5px;
}

.zom_img1 {
  width: 32px;
  opacity: 0.5;
  filter: alpha(opacity=50);
  cursor: pointer;
 margin-right: 24px;
}
.zom_img1:hover {
  opacity: 1.0;
  filter: alpha(opacity=100);
}
#file{
    border: 2px solid #1A4A99;
    background-color: #afc4db;
}

.custom-file-upload-hidden1 {
    display: none;
    visibility: hidden;
    position: absolute;
    left: -9999px;
}

.file-upload-wrapper1 {
    position: relative; 
    padding-left: 5px;
    width: 225px;
}
.file-upload-input1 {
    color: #fff;
    font-size: 16px;
    padding: 11px 17px; 
    border: none;
    border-radius: 0px !important;
    background-color: #000;
    height: 24px !important;
    border: 2px solid #1A4A99 !important;
    border-left:none !important;
    float: none !important;
    width: 80px;
}
.file-upload-button1 {
    cursor: pointer; 
    display: inline-block; 
    color: #fff;
    font-size: 16px;
    padding: 11px 20px; 
    border: none;
    margin-left: -1px;  
    background-color: #000;
    height: 28px !important;
    float: left; /* IE 9 Fix */
    border: 2px solid #1A4A99 !important;
    border-right:none !important; 
    
}


</style>
<script>
function close_form_crop()
   {
    $( "#wrap_up_crp" ).dialog( "close" );
  }
</script>
<div  class="container">
    <div class="imageBox1">
        <div class="thumbBox1"></div>
        <div class="spinner1" style="display: none">Loading...</div>
        <div style="position: absolute;right: 0px;bottom: 35px;">
          <img class="zom_img1" style="float: right" src="<?php echo url::base() ?>themes/icon/zoom_in.png" id="btnZoomIn1" alt=""> <br>
          <img class="zom_img1" style="float: right" src="<?php echo url::base() ?>themes/icon/zoom_out.png" id="btnZoomOut1" alt="">
        </div>
    </div>  
</div>
<div class="action1">
          <input type="file" id="fileins" style="float:left; width: 250px">
          <button class="btn" id="btnCrop1" value="Crop" style="float: right;  width: 150px;margin-right: 5px;margin-top:-35px">Crop</button>
        </div>
        
<script type="text/javascript">
$(function(){
     var options =
        {
            imageBox: '.imageBox1',
            thumbBox: '.thumbBox1',
            spinner: '.spinner1',
            imgSrc: 'avatar.png'
        }
        var cropper;
        document.querySelector('#fileins').addEventListener('change', function(){
          var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
          if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
              $.growl.error({ message: "The file you are trying to upload is not an image file. Please ensure that the file you are trying to upload has an image file extension (.jpg, .png, .gif, etc…)." });
              $("#fileins").val('').clone(true);             
              return false;
          }
            var reader = new FileReader();
            reader.onload = function(e) {
                options.imgSrc = e.target.result;
                cropper = new cropbox(options);
            }
            reader.readAsDataURL(this.files[0]);
            $(this).files = [];
        })
        document.querySelector('#btnCrop1').addEventListener('click', function(){
            if($("#fileins").val() != ''){
              $('#loading_img').show();
              var img = cropper.getDataURL();
              //$('#img_signature').html('<img src="'+img+'">')
              document.querySelector('#img_signature_<?php echo !empty($id_code)?$id_code:''; ?>').innerHTML='';
              $('#img_signature_<?php echo !empty($id_code)?$id_code:''; ?>').show();
              document.querySelector('#img_signature_<?php echo !empty($id_code)?$id_code:''; ?>').innerHTML += '<img src="'+img+'">';
              close_form_crop();
              $.ajax({
                  type: 'POST',
                  url: '<?php echo url::base() ?>diagram/view_paint_inspector',
                  data: {image: img},
                  success: function (resp) { 
                     document.querySelector('#img_signature_<?php echo !empty($id_code)?$id_code:''; ?>').innerHTML += '<input type="hidden" value="'+resp+'" name="image_sign[]">';
                    $('#loading_img').hide();
                     //document.querySelector('.cropped').innerHTML += '<input name="" id="" value="'+resp+'" />';
                  }
              });
            }else{
              close_form_crop();
            }
        })
        document.querySelector('#btnZoomIn1').addEventListener('click', function(){
            cropper.zoomIn();
        })
        document.querySelector('#btnZoomOut1').addEventListener('click', function(){
            cropper.zoomOut();
        })
});
       
var cropbox = function(options){
    var el = document.querySelector(options.imageBox),
    obj =
    {
        state : {},
        ratio : 1,
        options : options,
        imageBox : el,
        thumbBox : el.querySelector(options.thumbBox),
        spinner : el.querySelector(options.spinner),
        image : new Image(),
        getDataURL: function ()
        {
            var width = this.thumbBox.clientWidth,
                height = this.thumbBox.clientHeight,
                canvas = document.createElement("canvas"),
                dim = el.style.backgroundPosition.split(' '),
                size = el.style.backgroundSize.split(' '),
                dx = parseInt(dim[0]) - el.clientWidth/2 + width/2,
                dy = parseInt(dim[1]) - el.clientHeight/2 + height/2,
                dw = parseInt(size[0]),
                dh = parseInt(size[1]),
                sh = parseInt(this.image.height),
                sw = parseInt(this.image.width);

            canvas.width = width;
            canvas.height = height;
            var context = canvas.getContext("2d");
            context.drawImage(this.image, 0, 0, sw, sh, dx, dy, dw, dh);
            var imageData = canvas.toDataURL('image/png');
            return imageData;
        },
        getBlob: function()
        {
            var imageData = this.getDataURL();
            var b64 = imageData.replace('data:image/png;base64,','');
            var binary = atob(b64);
            var array = [];
            for (var i = 0; i < binary.length; i++) {
                array.push(binary.charCodeAt(i));
            }
            return  new Blob([new Uint8Array(array)], {type: 'image/png'});
        },
        zoomIn: function ()
        {
            this.ratio*=1.1;
            setBackground();
        },
        zoomOut: function ()
        {
            this.ratio*=0.9;
            setBackground();
        }
    },
    attachEvent = function(node, event, cb)
    {
        if (node.attachEvent)
            node.attachEvent('on'+event, cb);
        else if (node.addEventListener)
            node.addEventListener(event, cb);
    },
    detachEvent = function(node, event, cb)
    {
        if(node.detachEvent) {
            node.detachEvent('on'+event, cb);
        }
        else if(node.removeEventListener) {
            node.removeEventListener(event, render);
        }
    },
    stopEvent = function (e) {
        if(window.event) e.cancelBubble = true;
        else e.stopImmediatePropagation();
    },
    setBackground = function()
    {
        var w =  parseInt(obj.image.width)*obj.ratio;
        var h =  parseInt(obj.image.height)*obj.ratio;

        var pw = (el.clientWidth - w) / 2;
        var ph = (el.clientHeight - h) / 2;

        el.setAttribute('style',
                'background-image: url(' + obj.image.src + '); ' +
                'background-size: ' + w +'px ' + h + 'px; ' +
                'background-position: ' + pw + 'px ' + ph + 'px; ' +
                'background-repeat: no-repeat');
    },
    imgMouseDown = function(e)
    {
        stopEvent(e);

        obj.state.dragable = true;
        obj.state.mouseX = e.clientX;
        obj.state.mouseY = e.clientY;
    },
    imgMouseMove = function(e)
    {
        stopEvent(e);

        if (obj.state.dragable)
        {
            var x = e.clientX - obj.state.mouseX;
            var y = e.clientY - obj.state.mouseY;

            var bg = el.style.backgroundPosition.split(' ');

            var bgX = x + parseInt(bg[0]);
            var bgY = y + parseInt(bg[1]);

            el.style.backgroundPosition = bgX +'px ' + bgY + 'px';

            obj.state.mouseX = e.clientX;
            obj.state.mouseY = e.clientY;
        }
    },
    imgMouseUp = function(e)
    {
        stopEvent(e);
        obj.state.dragable = false;
    },
    zoomImage = function(e)
    {
        var evt=window.event || e;
        var delta=evt.detail? evt.detail*(-120) : evt.wheelDelta;
        delta > -120 ? obj.ratio*=1.1 : obj.ratio*=0.9;
        setBackground();
    }

    obj.spinner.style.display = 'block';
    obj.image.onload = function() {
        obj.spinner.style.display = 'none';
        setBackground();

        attachEvent(el, 'mousedown', imgMouseDown);
        attachEvent(el, 'mousemove', imgMouseMove);
        attachEvent(document.body, 'mouseup', imgMouseUp);
        var mousewheel = (/Firefox/i.test(navigator.userAgent))? 'DOMMouseScroll' : 'mousewheel';
        attachEvent(el, mousewheel, zoomImage);
    };
    obj.image.src = options.imgSrc;
    attachEvent(el, 'DOMNodeRemoved', function(){detachEvent(document.body, 'DOMNodeRemoved', imgMouseUp)});

    return obj;
};

</script>
<script type="text/javascript">
(function($) {

          // Browser supports HTML5 multiple file?
          var multipleSupport = typeof $('<input/>')[0].multiple !== 'undefined',
              isIE = /msie/i.test( navigator.userAgent );
          $.fn.customFile = function() {
            return this.each(function() {
              var $file = $(this).addClass('custom-file-upload-hidden1'), // the original file input
                  $wrap = $('<div class="file-upload-wrapper1">'),
                  $input = $('<input type="text" class="file-upload-input1" readonly />'),
                  // Button that will be used in non-IE browsers
                  $button = $('<button type="button" class="file-upload-button1 btn">Browse…</button>'),
                  // Hack for IE
                  $label = $('<label class="file-upload-button1" for="'+ $file[0].id +'">Browse…</label>');

              // Hide by shifting to the left so we
              // can still trigger events
              $file.css({
                position: 'absolute',
                left: '-9999px'
              });

              $wrap.insertAfter( $file )
                .append( $input,$file , ( isIE ? $label : $button ) );

              // Prevent focus
              $file.attr('tabIndex', -1);
              $button.attr('tabIndex', -1);

              $button.click(function () {
                $file.focus().click(); // Open dialog
              });

              $file.change(function() {

                var files = [], fileArr, filename;

                // If multiple is supported then extract
                // all filenames from the file array
                if ( multipleSupport ) {
                  fileArr = $file[0].files;
                  for ( var i = 0, len = fileArr.length; i < len; i++ ) {
                    files.push( fileArr[i].name );
                  }
                  filename = files.join(', ');

                // If not supported then just take the value
                // and remove the path to just show the filename
                } else {
                  filename = $file.val().split('\\').pop();
                }

                $input.val( filename ) // Set the value
                  .attr('title', filename) // Show filename in title tootlip
                  .focus(); // Regain focus

              });

              $input.on({
                blur: function() { $file.trigger('blur'); },
                keydown: function( e ) {
                  if ( e.which === 13 ) { // Enter
                    if ( !isIE ) { $file.trigger('click'); }
                  } else if ( e.which === 8 || e.which === 46 ) {
                    $file.replaceWith( $file = $file.clone( true ) );
                    $file.trigger('change');
                    $input.val('');
                  } else if ( e.which === 9 ){ // TAB
                    return;
                  } else { // All other keys
                    return false;
                  }
                }
              });

            });

          };

          // Old browser fallback
          if ( !multipleSupport ) {
            $( document ).on('change', 'input.customfile', function() {

              var $this = $(this),
                  // Create a unique ID so we
                  // can attach the label to the input
                  uniqId = 'customfile_'+ (new Date()).getTime(),
                  $wrap = $this.parent(),

                  // Filter empty input
                  $inputs = $wrap.siblings().find('.file-upload-input1')
                    .filter(function(){ return !this.value }),

                  $file = $('<input type="file" id="'+ uniqId +'" name="'+ $this.attr('name') +'"/>');
              setTimeout(function() {
                if ( $this.val() ) {
                  if ( !$inputs.length ) {
                    $wrap.after( $file );
                    $file.customFile();
                  }
                } else {
                  $inputs.parent().remove();
                  $wrap.appendTo( $wrap.parent() );
                  $wrap.find('input').focus();
                }
              }, 1);

            });
          }

}(jQuery));

$('#fileins').customFile();
</script>