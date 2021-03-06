<aside>	
	<h2>Wrong upload form?</h2>
	<ul>
		<?php if($type != 'demos'): ?><li><?php echo anchor('upload/demos', 'Demo form'); ?></li><?php endif; ?>
		<?php if($type != 'gameskins'): ?><li><?php echo anchor('upload/gameskins', 'Gameskin form'); ?></li><?php endif; ?>
		<?php if($type != 'mapres'): ?><li><?php echo anchor('upload/mapres', 'Mapres form'); ?></li><?php endif; ?>
		<?php if($type != 'maps'): ?><li><?php echo anchor('upload/maps', 'Map form'); ?></li><?php endif; ?>
		<?php if($type != 'mods'): ?><li><?php echo anchor('upload/mods', 'Mod form'); ?></li><?php endif; ?>
		<?php if($type != 'skins'): ?><li><?php echo anchor('upload/skins', 'Skin form'); ?></li><?php endif; ?>
	</ul>
	<h2>Change uploads?</h2>
	<ul>
		<li><?php echo anchor('myteedb', 'My TeeDB'); ?></li>
	</ul>
</aside>

<section id="content">
	<section id="uploader">		
		<h2><?php echo ($type == 'mapres')? 'Mapres' : ucfirst(singular($type)); ?> upload</h2>
		
		<?php if($type == 'mods'): ?>
			<p class="info border"><span class="icon color icon112"></span>
				For security reason you are only allowed to share a link instead of uploading.
			</p>
		<?php endif; ?>
		
		<div id="info">
			<?php echo show_messages(); ?>
		</div>
		
		<?php echo form_open_multipart('upload/'.$type, array('id' => 'upload'), array('type' => $type)); ?>
		
			
			<?php if($type != 'mods'): ?>
				<?php echo form_upload('file[]', null, 'multiple'); ?>
				<?php echo form_submit('upload', 'Upload'); ?>
			<?php else: ?>
				<div style="margin: 20px 0;">
					<div style="float: left;">
						<label for="name">Modification-name:</label><br />
						<?php echo form_input('modname',set_value('modname'), 'style="width:321px"'); ?>
					</div>
					<div style="float: left;width:323px; margin-left:20px;height: 46px">
						<label for="has">Modified:</label><br />
						<div style="width: 50%; float:left">
							<?php echo form_checkbox('server',set_value('server', 'server')); ?> <span class="solid">Server</span>
						</div>
						<div style="width: 50%; float:left">
							<?php echo form_checkbox('client',set_value('client', 'client')); ?> <span class="solid">Client</span>
						</div>
					</div>
					<div style="float: left">
						<label for="link">Link:</label><br />
						<?php echo form_input('link',set_value('link'), 'style="width:321px"'); ?>
					</div>
					<div style="float: left;margin-left: 20px;width:333px;height: 46px">
						<label for="file">Screenshot:</label><br />				
						<?php echo form_upload('file', NULL, 'style="width:321px"'); ?>
						<br/>
						<span style="font-size: 10px">
							Resized to 180x180. For a good result we recommend to upload an image with same height as wide.
						</span>
					</div>
					<br style="clear:left" />
				</div>
				<?php echo form_submit('upload', 'Submit'); ?>
			<?php endif; ?>
		
		<?php echo form_close(); ?>
		
		<div id="list">
			<ul>
				<?php if(isset($uploads)): ?>
					<?php foreach($uploads as $file): ?>
						<li>
							<div style="width:110px; height:64px">
								<img src="<?php echo $file['preview']; ?>" alt="<?php echo $file['raw_name']; ?> preview" width="64" height="64" />
							</div>
							<p>
								<?php echo $file['raw_name']; ?>
							</p>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
			<br class="clear" />
		</div>
	</section>
</section>