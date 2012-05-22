<aside>	
	<h2>Sorted by...</h2>
	<ul>
		<li><?php echo ($order=='new' and $direction=='desc')? anchor('mapres/new/asc', 'Newest') : anchor('mapres/new/desc', 'Newest'); ?></li>
		<li><?php echo ($order=='rate' and $direction=='desc')? anchor('mapres/rate/asc', 'Rating') : anchor('mapres/rate/desc', 'Rating'); ?></li>
		<li><?php echo ($order=='dw' and $direction=='desc')? anchor('mapres/dw/asc', 'Downloads') : anchor('mapres/dw/desc', 'Downloads'); ?></li>
		<li><?php echo ($order=='name' and $direction=='asc')? anchor('mapres/name/desc', 'Name') : anchor('mapres/name/asc', 'Name'); ?></li>
		<li><?php echo ($order=='author' and $direction=='asc')? anchor('mapres/author/desc', 'Author') : anchor('mapres/author/asc', 'Author'); ?></li>
	</ul>
	<br style="clear:both;" />
	<div style="text-align: center;margin-top:20px">
		<?php echo anchor('upload/mapres', 'Upload your own mapres!', 'class="button solid"'); ?>
	</div>
</aside>

<section id="content">
	<section id="mapres">
		<h2 style="margin-bottom: 10px;">Mapres</h2>
		
		<div id="info">
			<?php echo show_messages(); ?>
		</div>		
		
		<div id="list">
			<ul>
				<?php foreach($mapres as $entry): $entry->rate_sum = (int)$entry->rate_sum; ?>
					
					<li style="height:180px; font-weight: bold;">
						<div style="width:110px; height:64px">
							<img src="<?php echo base_url('uploads/mapres/previews/'.$entry->name.'.png'); ?>" alt="Mapres <?php echo $entry->name; ?>" />
						</div>
						<p><?php echo string_limiter($entry->name, 12); ?></p>
						<p style="font-size: 10px">
							from <?php echo anchor(uri_string().'#'.url_title($entry->username), string_limiter($entry->username,11), 'class="none solid"'); ?>
						</p>
						<br />
						<div style="font-size: 10px">
							<span style="float:left; margin-top: 2px;">Like: </span>
							<?php echo form_open(NULL, 'class="send_rate"', array('id' => $entry->id)); ?>
								<button name="rate" value="1" type="submit" class="icon">
								    <span class="icon color icon204"></span>
								</button>
								<button name="rate" value="0" type="submit" class="icon">
								    <span class="icon color icon203"></span>
								</button>
							<?php echo form_close(); ?>
						</div>
						<br class="clear" />
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
						<?php echo anchor('teedb/downloads/index/mapres/'.url_title($entry->name), 'Download', 'style="font-size: 10px"'); ?>
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