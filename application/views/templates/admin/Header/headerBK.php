<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $this->site['site_title']?><?php echo !empty($this->site['site_slogan'])?' | '.$this->site['site_slogan']:''?></title>

    <!-- Bootstrap -->
    <link href="<?php echo $this->site['base_url'] ?>plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo $this->site['base_url'] ?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo $this->site['base_url'] ?>plugins/nprogress/nprogress.css" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="<?php echo $this->site['base_url'] ?>plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>
    <link href="<?php echo $this->site['base_url'] ?>plugins/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="<?php echo $this->site['base_url'] ?>plugins/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="<?php echo $this->site['base_url'] ?>plugins/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo $this->site['theme_url']?>css/custom.css" rel="stylesheet">
    <?php echo !empty($cssKiosk)?$cssKiosk:''; ?>
</head>