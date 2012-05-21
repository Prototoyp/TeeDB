<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php echo (isset($title))? $title : 'Set title in config file.'; ?></title>
	<meta name="description" content="<?php echo (isset($description))? $description : 'Set description in config file.'; ?>">
	<meta name="author" content="<?php echo (isset($author))? $author : 'Set author in config file.'; ?>">

	<meta name="viewport" content="width=device-width,initial-scale=1">
	
	<base href="<?php echo base_url(); ?>">

	<link rel="alternate" type="application/rss+xml" href="<?php echo base_url('feed'); ?>" title="RSS feed for <?php echo (isset($title))? $title : 'Set title in config file.'; ?>">
	
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/favicon.ico'); ?>">
	<link rel="apple-touch-icon" type="image/x-icon" href="<?php echo base_url('assets/apple-touch-icon.png'); ?>">
	
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css'); ?>">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>

	<script src="<?php echo base_url('assets/js/vendor/modernizr-2.5.3.min.js'); ?>"></script>
</head>
<body screen_capture_injected="true">
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->