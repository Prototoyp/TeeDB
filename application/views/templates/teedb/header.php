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
	
	<?php if($this->load->is_loaded('auth') && $this->auth->is_admin()): ?>
		<style type="text/css">
			body {
				padding-top: 40px;
			}
			.navbar-fixed-top a{
				background: none !important;
	      		border: 0 !important;
			}
	      	.navbar-fixed-top {
				position: fixed;
				top: 0;
				right: 0;
				left: 0;
				z-index: 1030;
			}
			.navbar .nav {
				position: relative;
				left: 0;
				display: block;
				float: left;
				list-style: none;
				padding: 0;
				margin: 10px 0;
			}
			.navbar {
				overflow: visible;
				margin-bottom: 18px;
				font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
				font-size: 13px;
				line-height: 18px;
				color: #333;
			}
			.navbar-fixed-top .navbar-inner {
				padding-left: 0;
				padding-right: 0;
				-webkit-border-radius: 0;
				-moz-border-radius: 0;
				border-radius: 0;
			}
			.navbar-inner {
				background-color: #2C2C2C;
				background-image: -moz-linear-gradient(top, #333, #222);
				background-image: -ms-linear-gradient(top, #333, #222);
				background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#333), to(#222));
				background-image: -webkit-linear-gradient(top, #333, #222);
				background-image: -o-linear-gradient(top, #333, #222);
				background-image: linear-gradient(top, #333, #222);
				background-repeat: repeat-x;
				filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#333333', endColorstr='#222222', GradientType=0);
				-webkit-border-radius: 4px;
				-moz-border-radius: 4px;
				border-radius: 4px;
				-webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25), inset 0 -1px 0 rgba(0, 0, 0, 0.1);
				-moz-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25), inset 0 -1px 0 rgba(0, 0, 0, 0.1);
				box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25), inset 0 -1px 0 rgba(0, 0, 0, 0.1);
			}
			.container {
				width: 940px;
				margin-left: auto;
				margin-right: auto;
			}
			.container::before, .container::after {
				display: table;
				content: "";
			}
			.container::after {
				clear: both;
			}
			.container::before, .container::after {
				display: table;
				content: "";
			}
			.navbar .brand {
				float: left;
				display: block;
				padding: 8px 20px 12px;
				margin-left: -20px;
				font-size: 20px;
				font-weight: 200;
				line-height: 1;
				color: white;
			}
			.collapse {
				-webkit-transition: height 0.35s ease;
				-moz-transition: height 0.35s ease;
				-ms-transition: height 0.35s ease;
				-o-transition: height 0.35s ease;
				transition: height 0.35s ease;
				position: relative;
				overflow: hidden;
				height: auto;
			}
			.navbar .nav > li {
				display: block;
				float: left;
				line-height: 18px;
			}
			.navbar .nav > li > a {
				float: none;
				padding: 10px 10px 11px;
				line-height: 19px;
				color: 	#999;
				text-decoration: none;
				text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
				font-weight: normal;
			}
			.navbar .nav > li > a:hover {
				background-color: transparent;
				color: white;
				text-decoration: none;
			}
	    </style>
    <?php endif; ?>	

	<link rel="stylesheet" href='<?php echo base_url('assets/css/style.css'); ?>'>
	
	<script src="<?php echo base_url('assets/js/vendor/modernizr-2.5.3.min.js'); ?>"></script>
</head>
<body class="light">
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->