<?php if(!isset($large) OR !$large): ?>
	</section><!-- Closing the #center section -->
		
	<div class="image_border open">
		<div class="center trans_border open"></div>
	</div>
	
	<div class="wrapper dark">
		<div class="center transition min"></div>
	</div>
<?php endif; ?>

<div class="image_border close">
	<div class="center trans_border close"></div>
</div>

<footer id="main" class="wrapper light">
	<p class="center" style="padding: 0">
		TeeDB &copy; Copyright 2008 - <?php echo date("Y"); ?> All rights reserved | <?php echo anchor('privacy_policy', 'Privacy policy'); ?> | Page rendered in {elapsed_time} seconds
	</p>
</footer>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo base_url('assets/js/vendor/jquery-1.7.2.min.js'); ?>"><\/script>')</script>

<!-- scripts concatenated and minified via ant build script-->
<script src="assets/js/plugins.js"></script>
<script src="assets/js/jquery.form.js"></script>
<script src="assets/js/jquery.adslider.js"></script>
<script src="assets/js/jquery.nav.js"></script>
<script src="assets/js/main.js"></script>
<!-- end scripts-->

<script>
	var _gaq=[['_setAccount','<?php echo $google_analytic_id; ?>'],['_gat._anonymizeIp'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

</body>
</html>