<aside>	
	<h2>Sorted by...</h2>
	<ul>
		<li><?php echo ($order=='new' and $direction=='desc')? anchor('mods/new/asc', 'Newest') : anchor('mods/new/desc', 'Newest'); ?></li>
		<li><?php echo ($order=='rate' and $direction=='desc')? anchor('mods/rate/asc', 'Rating') : anchor('mods/rate/desc', 'Rating'); ?></li>
		<li><?php echo ($order=='name' and $direction=='asc')? anchor('mods/name/desc', 'Name') : anchor('mods/name/asc', 'Name'); ?></li>
		<li><?php echo ($order=='author' and $direction=='asc')? anchor('mods/author/desc', 'Author') : anchor('mods/author/asc', 'Author'); ?></li>
	</ul>
	<div class="large_button">
		<?php echo anchor('upload/mods', 'Upload your own mod!', 'class="button solid"'); ?>
	</div>
</aside>

<section id="content">
	<section id="mods">
		<h2>Mods</h2>
		
		<div id="info">
			<?php echo show_messages(); ?>
		</div>
			
		<ul class="list">
			<?php foreach($mods as $entry): $entry->rate_sum = (int)$entry->rate_sum; ?>
				
				<li style="width:313px">
					<figure>
						<figcaption style="float:right">
							<p><?php echo string_limiter($entry->name, 12); ?></p>
							<span>
								from <?php echo anchor(uri_string().'#'.$entry->username,  string_limiter($entry->username,11), 'class="none solid"'); ?>
							</span>
					
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
							
							<div class="modification">
								<?php if($entry->server): ?>
									<span class="mark">Server</span>
								<?php endif; ?>
								<?php if($entry->client): ?>
									<span class="mark">Client</span>
								<?php endif; ?>
							</div>
							
							<?php echo anchor($entry->link, 'Visit Mod-Site', 'target="_blank" style="font-size: 10px"'); ?>
						</figcaption>
						<div style="width:180px; height:180px;">
							<img src="<?php echo base_url('uploads/mods/'.$entry->name.'.png'); ?>" alt="Modification <?php echo $entry->name; ?>" />
						</div>
					</figure>
				</li>
				
			<?php endforeach; ?>
		</ul>
		
		<?php echo $this->pagination->create_links(); ?>
		
	</section>
</section>