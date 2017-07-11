<head>
    <meta charset="utf-8"/>
    <title><?php echo !empty($this->sess_cus)?base64_decode($this->sess_cus['sltLocation']):'Restaurant name' ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <?php 
        header('Access-Control-Allow-Origin: *');  
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
    ?>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $this->site['base_url'] ?>plugins/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $this->site['base_url'] ?>plugins/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $this->site['base_url'] ?>plugins/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->site['base_url'] ?>plugins/global/plugins/Croppie/croppie.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->site['base_url'] ?>plugins/global/plugins/Croppie/demo/demoC.css"/>

    <link rel="stylesheet" type="text/css" href="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->site['base_url'] ?>plugins/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/scroller/1.4.2/css/scroller.bootstrap.min.css"/>
   
    <!-- END PAGE LEVEL STYLES -->

    <!-- BEGIN THEME STYLES -->
    <link href="<?php echo $this->site['base_url'] ?>plugins/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $this->site['base_url'] ?>plugins/global/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $this->site['theme_url']?>layout/css/layout.css" rel="stylesheet" type="text/css"/>
    <link id="style_color" href="<?php echo $this->site['theme_url']?>layout/css/themes/darkblue.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $this->site['theme_url']?>layout/css/custom.css" rel="stylesheet" type="text/css"/>
    <?php echo !empty($cssKiosk)?$cssKiosk:''; ?>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="<?php echo url::base() ?>favicon.ico"/>
</head>
