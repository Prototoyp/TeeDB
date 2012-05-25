<aside>	
	<h2>Sorted by...</h2>
	<ul>
		<li><?php echo ($order=='new' and $direction=='desc')? anchor('maps/new/asc', 'Newest') : anchor('maps/new/desc', 'Newest'); ?></li>
		<li><?php echo ($order=='rate' and $direction=='desc')? anchor('maps/rate/asc', 'Rating') : anchor('maps/rate/desc', 'Rating'); ?></li>
		<li><?php echo ($order=='dw' and $direction=='desc')? anchor('maps/dw/asc', 'Downloads') : anchor('maps/dw/desc', 'Downloads'); ?></li>
		<li><?php echo ($order=='name' and $direction=='asc')? anchor('maps/name/desc', 'Name') : anchor('maps/name/asc', 'Name'); ?></li>
		<li><?php echo ($order=='author' and $direction=='asc')? anchor('maps/author/desc', 'Author') : anchor('maps/author/asc', 'Author'); ?></li>
	</ul>
	<div class="large_button">
		<?php echo anchor('upload/maps', 'Upload your own maps!', 'class="button solid"'); ?>
	</div>
</aside>

<section id="content">
	<section id="maps">
		<h2>Maps</h2>
		
		<div id="info">
			<?php echo show_messages(); ?>
		</div>
		
		<ul class="list">
			<?php foreach($maps as $entry): $entry->rate_sum = (int)$entry->rate_sum; ?>
				
				<li style="width:200px">
					<figure>
						<img src="<?php echo base_url('assets/images/nopic_map.png'); ?>" alt="Map <?php echo $entry->name; ?>" height="80" />
						<figcaption>
							<p><?php echo string_limiter($entry->name, 12); ?></p>
							<span>
								from <?php echo anchor(uri_string().'#'.$entry->username,  string_limiter($entry->username,11), 'class="none solid"'); ?>
							</span>
						</figcaption>
					</figure>
					
					<div style="float:left;">
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
					</div>
					
					<?php echo anchor('download/skin/'.url_title($entry->name), 'Download', 'style="font-size:10px;float:left;margin:27px 0 0 22px"'); ?>
				</li>
				
			<?php endforeach; ?>
		</ul>
		
		<?php echo $this->pagination->create_links(); ?>
		
	</section>
</section>