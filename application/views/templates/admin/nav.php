<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<?php echo anchor('', $site_title, 'class="brand"'); ?>
			<div class="nav-collapse collapse">
				<ul class="nav">
					<li <?php if(preg_match('#(^admin)#', uri_string())) echo 'class="active"'; ?>>
						<?php echo anchor('admin','Dashboard'); ?>
					</li>
					<li <?php if(preg_match('#(^migrate)#', uri_string())) echo 'class="active"'; ?>>
						<?php echo anchor('migrate','Migrate'); ?>
					</li>          
					<?php foreach($modules as $module => $has_admin_support): ?>
						<li <?php if(preg_match('#(^'.$module.'/admin)#', uri_string())) echo 'class="active"'; ?>>
							<?php echo anchor((($has_admin_support)? $module.'/admin' : uri_string().'#'), $module); ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</div>