<aside>	
	<h2>View my...</h2>
	<ul>
		<li><?php echo anchor('myteedb/demos', 'Demos'); ?></li>
		<li><?php echo anchor('myteedb/gameskins', 'Gameskins'); ?></li>
		<li><?php echo anchor('myteedb/mapres', 'Mapres'); ?></li>
		<li><?php echo anchor('myteedb/maps', 'Maps'); ?></li>
		<li><?php echo anchor('myteedb/skins', 'Skins'); ?></li>
	</ul>
	<br style="clear:both;" />
	<h2>Sorted by...</h2>
	<ul>
		<li><?php echo ($order=='new' and $direction=='desc')? anchor('myteedb/mods/new/asc', 'Newest') : anchor('myteedb/mods/new/desc', 'Newest'); ?></li>
		<li><?php echo ($order=='rate' and $direction=='desc')? anchor('myteedb/mods/rate/asc', 'Rating') : anchor('myteedb/mods/rate/desc', 'Rating'); ?></li>
		<li><?php echo ($order=='dw' and $direction=='desc')? anchor('myteedb/mods/dw/asc', 'Downloads') : anchor('myteedb/mods/dw/desc', 'Downloads'); ?></li>
		<li><?php echo ($order=='name' and $direction=='asc')? anchor('myteedb/mods/name/desc', 'Name') : anchor('myteedb/mods/name/asc', 'Name'); ?></li>
	</ul>
	<br style="clear:both;" />
	<div style="text-align: center;margin-top:20px">
		<?php echo anchor('teedb/upload/mods', 'Upload more mods!', 'class="button solid"'); ?>
	</div>
</aside>

<section id="content">
	<section id="mods">
		<h2 style="margin-bottom: 10px;">My Mods</h2>
		
		<div id="info">		
			<?php if(isset($delete) && isset($delete_id)): ?>
				<p class="info border"><span class="icon color icon112"></span>
					Are you really sure you want to remove the mod <?php echo $delete; ?>?
				</p>
			<?php endif; ?>
			<?php 
				echo (isset($changed) && $changed)? 
					'<p class="success color border">
						<span class="icon color icon101"></span>
						Mod '.$changed.' changed successful.
					</p>'
					 : 
					 ((isset($delete) && !isset($delete_id))?
					'<p class="success color border">
						<span class="icon color icon101"></span>
						Mod '.$delete.' successful removed
					</p>'
					 : '');
				echo validation_errors('<p class="error color border"><span class="icon color icon100"></span>','</p>'
				);
			?>
		</div>
		
		<div id="list">
			<ul>
				<?php foreach($uploads as $entry): ?>
					
					<li style="height: 370px">
						<?php echo form_open_multipart(null, null, array('id' => $entry->id)); ?>
							<img style="float:left" src="<?php echo base_url('uploads/mods/'.$entry->name.'.png'); ?>" alt="Mod <?php echo $entry->name; ?>" />
							<div style="float:left; padding-left:16px;">
								<p>
									<span style="text-align: left;font-size: 10px">Change name:</span><br />
									<?php echo form_input('modname',$entry->name, 'style="width: 97px; background-color: #A16E36 !important; color: #543F24"'); ?><br />
								</p>
								<br />
								<p style="text-align: left;font-size: 10px">
									<strong>Filesize:</strong> <?php echo round(@filesize('uploads/mods/'.$entry->name.'.png')/1000); ?> kB<br />
									<?php echo relative_time($entry->create); ?><br />
									<br />
									<span style="margin-top: 2px;">Likes: </span>
								</p>
								<div class="rate">
									<?php $prec = ($entry->rate_count > 0)? round($entry->rate_sum/$entry->rate_count)*90 : 50; ?>
									<div class="like" style="color: #3B2B1C; width: <?php echo ($prec >= 10)? $prec : 10; ?>px">
										<?php echo $entry->rate_sum; ?>
									</div>
									<div class="dislike" style="color: #FFC96C; width: <?php echo ($prec >= 10)? (100-$prec) : 90; ?>px">
										<?php echo $entry->rate_count-$entry->rate_sum; ?>
									</div>
								</div>
								<br />
								<p style="text-align: left;font-weight: normal">
									<label for="has">Modified:</label>
									<br />
									<?php echo form_checkbox('server','server',$entry->server); ?> <span class="solid">Server</span>
									<br />
									<?php echo form_checkbox('client','client',$entry->client); ?> <span class="solid">Client</span>
								</p>
							</div>
							<br class="clear" />
							<p style="text-align: left;">
								<span style="text-align: left;font-size: 10px">Change link:</span><br />
								<?php echo form_input('link',$entry->link, 'style="width: 300px; background-color: #A16E36 !important; color: #543F24"'); ?>
								<br/><br/>
								<span style="text-align: left;font-size: 10px">Change screenshot:</span><br />
								<?php echo form_upload('file', NULL, 'style="width: 300px; background-color: #A16E36 !important; color: #543F24"'); ?>
								<p style="text-align: left;font-size: 10px">
									Resized to 180x180. For a good result we recommend to upload an image with same height as wide.
								</p>
							</p>
							<br />
							<?php echo form_submit('change', 'Save changes', 'style="font-size:10px" class="leight"'); ?>
							<?php if(isset($delete_id) && $entry->id == $delete_id): ?>
								<?php echo form_submit('really_delete', 'Yes, delete this', 'style="font-size:10px" class="leight"'); ?>								
							<?php else: ?>
								<?php echo form_submit('delete', 'Delete modification', 'style="font-size:10px" class="leight"'); ?>
							<?php endif; ?>
						<?php echo form_close(); ?>
					</li>
					
				<?php endforeach; ?>
				<br class="clear" />
				<div style="width:680px; text-align: center; margin-top:15px">
					<?php echo $this->pagination->create_links(); ?>
				</div>
			</ul>
			<br class="clear" />
		</div>
		
	</section>
</section>