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
		<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css'); ?>">
	    <style type="text/css">
	      body {
	        padding-top: 40px;
	      }
	    </style>
    <?php endif; ?>	

	<link rel="stylesheet" href='<?php echo base_url('assets/css/style.css'); ?>'>
	<style>
	  	body{
			color: #3A2B1B;
			background-color: #A16E36;
	  	}
	  	#wrapper{
	  		text-align: center;
	  		margin: auto; 
	  		position: relative; 
	  		width: 800px
	  	}
	  	table{
	  		width: 800px;
	  	}
	  	th{ 
	  		background-color: #3B2B1C; 
	  		color: #A16E36; 
	  	}
	  	td{ 
	  		background-color: #543F24; 
	  		color: #FFC96C;
	  	}
	
		h2{	
			color: #A16E36;
			margin: 30px 0px;
			background-color: #543f24;
			border: 5px solid #543f24;
			border-radius: 6px;	
			-moz-border-radius: 6px; 
			-webkit-border-radius: 6px;
			padding: 0 20px;
		}
	</style>
	
	<script src="<?php echo base_url('assets/js/vendor/modernizr-2.5.3.min.js'); ?>"></script>
</head>
<body class="light">
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
	
	<div id="wrapper">
		
		<img src="assets/images/logo.png" alt="Logo">
		
		<h2>We are sorry, TeeDB is currently under construction. Check back soon!</h2>
		
	</div>
	
	<script>
		var _gaq=[['_setAccount','<?php echo $google_analytic_id; ?>'],['_gat._anonymizeIp'],['_trackPageview']];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
		g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));
	</script>

</body>
</html>