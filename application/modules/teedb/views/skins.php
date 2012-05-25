<aside>	
	<h2>Sorted by...</h2>
	<ul>
		<li><?php echo ($order=='new' and $direction=='desc')? anchor('skins/new/asc', 'Newest') : anchor('skins/new/desc', 'Newest'); ?></li>
		<li><?php echo ($order=='rate' and $direction=='desc')? anchor('skins/rate/asc', 'Rating') : anchor('skins/rate/desc', 'Rating'); ?></li>
		<li><?php echo ($order=='dw' and $direction=='desc')? anchor('skins/dw/asc', 'Downloads') : anchor('skins/dw/desc', 'Downloads'); ?></li>
		<li><?php echo ($order=='name' and $direction=='asc')? anchor('skins/name/desc', 'Name') : anchor('skins/name/asc', 'Name'); ?></li>
		<li><?php echo ($order=='author' and $direction=='asc')? anchor('skins/author/desc', 'Author') : anchor('skins/author/asc', 'Author'); ?></li>
	</ul>
	<div class="large_button">
		<?php echo anchor('upload/skins', 'Upload your own skins!', 'class="button solid"'); ?>
	</div>
</aside>

<section id="content">
	<section id="skins">
		<h2>Skins</h2>
		
		<div id="info">
			<?php echo show_messages(); ?>
		</div>
		
		<ul class="list">
			<?php foreach($skins as $entry): $entry->rate_sum = (int)$entry->rate_sum; ?>
				
				<li style="width:110px">
					<figure>
						<img src="<?php echo base_url('uploads/skins/previews/'.$entry->name.'.png'); ?>" alt="Skin <?php echo $entry->name; ?>" width="64" height="64" />
						<figcaption>
							<p><?php echo string_limiter($entry->name, 12); ?></p>
							<span>
								from <?php echo anchor(uri_string().'#'.$entry->username,  string_limiter($entry->username,11), 'class="none solid"'); ?>
							</span>
						</figcaption>
					</figure>
					
					<div class="rate_form">
						<span>Like: </span>
						<?php echo form_open(NULL, 'class="send_rate"', array('id' => $entry->id)); ?>
							<button name="rate" value="1" type="submit" class="icon">
							    <span class="icon color icon204"></span>
							</button>
							<button name="rate" value="0" type="submit" class="icon">
							    <span class="icon color icon203"></span>
							</button>
						<?php echo form_close(); ?>
					</div>
					
					<div class="rate">
						<?php $prec = get_precent($entry->rate_sum, $entry->rate_count); ?>
						<div class="like" style="color: #3B2B1C; width: <?php echo value_between($prec, 10, 90); ?>px">
							<?php echo $entry->rate_sum; ?>
						</div>
						<div class="dislike" style="color: #FFC96C; width: <?php echo value_between(100-$prec, 10, 90); ?>px">
							<?php echo $entry->rate_count-$entry->rate_sum; ?>
						</div>
					</div>
					
					<?php echo anchor('download/skin/'.url_title($entry->name), 'Download', 'style="font-size: 10px"'); ?>
				</li>
				
			<?php endforeach; ?>
		</ul>
		
		<?php echo $this->pagination->create_links(); ?>
		
	</section>
</section>