<aside>	
	<h2>View my...</h2>
	<ul>
		<?php if($type != 'demos'): ?><li><?php echo anchor('teedb/myteedb/demos', 'Demos'); ?></li><?php endif; ?>
		<?php if($type != 'gameskins'): ?><li><?php echo anchor('teedb/myteedb/gameskins', 'Gameskins'); ?></li><?php endif; ?>
		<?php if($type != 'mapres'): ?><li><?php echo anchor('teedb/myteedb/mapres', 'Mapres'); ?></li><?php endif; ?>
		<?php if($type != 'maps'): ?><li><?php echo anchor('teedb/myteedb/maps', 'Maps'); ?></li><?php endif; ?>
		<?php if($type != 'mods'): ?><li><?php echo anchor('teedb/myteedb/mods', 'Mods'); ?></li><?php endif; ?>
		<?php if($type != 'skins'): ?><li><?php echo anchor('teedb/myteedb/skins', 'Skins'); ?></li><?php endif; ?>
	</ul>
	<br style="clear:both;" />
	<h2>Sorted by...</h2>
	<ul>
		<li><?php echo ($order=='new' and $direction=='desc')? anchor('teedb/myteedb/skins/new/asc', 'Newest') : anchor('teedb/myteedb/skins/new/desc', 'Newest'); ?></li>
		<li><?php echo ($order=='name' and $direction=='asc')? anchor('teedb/myteedb/skins/name/desc', 'Name') : anchor('teedb/myteedb/skins/name/asc', 'Name'); ?></li>
	</ul>
	<br style="clear:both;" />
	<div style="text-align: center;margin-top:20px">
		<?php echo anchor('teedb/upload/'.$type, 'Upload more '.$type.'!', 'class="button solid"'); ?>
	</div>
</aside>

<section id="content">
	<section id="skins">
		<h2 style="margin-bottom: 10px;">My <?php echo ucfirst($type); ?></h2>
		
		<div id="info">		
			<?php if(isset($delete) && isset($delete_id)): ?>
				<p class="info border"><span class="icon color icon112"></span>
					Are you really sure you want to remove the skin <?php echo $delete; ?>?
				</p>
			<?php endif; ?>
			<?php 
				echo (isset($changed) && $changed)? 
					'<p class="success color border">
						<span class="icon color icon101"></span>
						Skin '.$changed.' changed successful to '.$this->input->post(singular($type).'name').'.
					</p>'
					 : 
					 (isset($delete) && !isset($delete_id))?
					'<p class="success color border">
						<span class="icon color icon101"></span>
						Skin '.$delete.' successful removed
					</p>'
					 :
					 validation_errors('<p class="error color border"><span class="icon color icon100"></span>','</p>'
				);
			?>
		</div>
		
		<div id="list">
			<ul>
				<?php foreach($uploads as $entry): ?>
					
					<li style="height: 245px">
						<?php echo form_open(null, null, array('id' => $entry->id)); ?>
							<img src="<?php echo base_url('uploads/'.$type.'/previews/'.$entry->name.'.png'); ?>" alt="Preview of <?php echo $type.' '.$entry->name; ?>" />
							<p>
								<span style="text-align: left;font-size: 10px">Change name:</span><br />
								<?php echo form_input(singular($type).'name',$entry->name, 'style="width: 97px; background-color: #A16E36 !important; color: #543F24"'); ?><br />
							</p>
							<br />
							<p style="text-align: left;font-size: 10px">
									<strong>Filesize:</strong> <?php echo round(@filesize('uploads/'.$type.'/'.$entry->name.'.png')/1000); ?> kB<br />
									<?php echo relative_time($entry->create); ?><br />
									<br />
									<span style="margin-top: 2px;">Likes: </span>
							</p>
							<div class="rate">
								<?php $prec = ($entry->rate_count > 0)? round($entry->rate_sum/$entry->rate_count)*90 : 50; ?>
								<div class="like" style="color: #3B2B1C; width: <?php echo ($prec >= 10)? $prec : 10; ?>px">
									<?php echo (int) $entry->rate_sum; ?>
								</div>
								<div class="dislike" style="color: #FFC96C; width: <?php echo ($prec >= 10)? (100-$prec) : 90; ?>px">
									<?php echo $entry->rate_count-$entry->rate_sum; ?>
								</div>
							</div>
							<br />
							<?php echo form_submit('change', 'Change name', 'style="font-size:10px" class="leight"'); ?>
							<br />
							<?php if(isset($delete_id) && $entry->id == $delete_id): ?>
								<?php echo form_submit('really_delete', 'Yes, delete this', 'style="font-size:10px" class="leight"'); ?>								
							<?php else: ?>
								<?php echo form_submit('delete', 'Delete skin', 'style="font-size:10px" class="leight"'); ?>
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