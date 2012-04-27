<aside>	
	<h2>View my...</h2>
	<ul>
		<li><?php echo anchor('myteedb/demos', 'Demos'); ?></li>
		<li><?php echo anchor('myteedb/gameskins', 'Gameskins'); ?></li>
		<li><?php echo anchor('myteedb/mapres', 'Mapres'); ?></li>
		<li><?php echo anchor('myteedb/mods', 'Mods'); ?></li>
		<li><?php echo anchor('myteedb/skins', 'Skins'); ?></li>
	</ul>
	<br style="clear:both;" />
	<h2>Sorted by...</h2>
	<ul>
		<li><?php echo anchor('myteedb/maps/new/'.(($order=='new' and $direction=='desc')? 'asc' : 'desc'), 'Newest'); ?></li>
		<li><?php echo anchor('myteedb/maps/rate/'.(($order=='rate' and $direction=='desc')? 'asc' : 'desc'), 'Newest'); ?></li>
		<li><?php echo anchor('myteedb/maps/dw/'.(($order=='dw' and $direction=='desc')? 'asc' : 'desc'), 'Newest'); ?></li>
		<li><?php echo anchor('myteedb/maps/name/'.(($order=='name' and $direction=='desc')? 'asc' : 'desc'), 'Newest'); ?></li>
	</ul>
	<br style="clear:both;" />
	<div style="text-align: center;margin-top:20px">
		<?php echo anchor('teedb/upload/maps', 'Upload more maps!', 'class="button solid"'); ?>
	</div>
</aside>

<section id="content">
	<section id="maps">
		<h2 style="margin-bottom: 10px;">My Maps</h2>
		
		<div id="info">		
			<?php echo show_messages(); ?>
		</div>
		
		<div id="list">
			<ul>
				<?php foreach($uploads as $entry): ?>
					
					<li style="height: 245px">
						<?php echo form_open(null, null, array('id' => $entry->id)); ?>
							<img src="<?php echo base_url('assets/images/nopic_map.png'); ?>" alt="Preview of map <?php echo $entry->name; ?>" />
							<p>
								<span style="text-align: left;font-size: 10px">Change name:</span><br />
								<?php echo form_input('mapname',$entry->name, 'style="width: 187px; background-color: #A16E36 !important; color: #543F24"'); ?><br />
							</p>
							<br />
							<p style="text-align: left;font-size: 10px">
								<strong>Filesize:</strong> <?php echo round(@filesize('uploads/maps/'.$entry->name.'.png')/1000); ?> kB<br />
								<?php echo relative_time($entry->create); ?><br />
							</p>
							<p style="text-align: left;font-size: 10px">
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
							<?php echo form_submit('change', 'Change name', 'style="font-size:10px; width:96px" class="leight"'); ?>
							<?php if(isset($delete_id) && $entry->id == $delete_id): ?>
								<?php echo form_submit('really_delete', 'Yes, delete this', 'style="font-size:10px; width:96px" class="leight"'); ?>								
							<?php else: ?>
								<?php echo form_submit('delete', 'Delete map', 'style="font-size:10px; width:96px" class="leight"'); ?>
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