<aside>	
	<h2>Sorted by...</h2>
	<ul>
		<li><?php echo ($order=='new' and $direction=='desc')? anchor('mods/new/asc', 'Newest') : anchor('mods/new/desc', 'Newest'); ?></li>
		<li><?php echo ($order=='rate' and $direction=='desc')? anchor('mods/rate/asc', 'Rating') : anchor('mods/rate/desc', 'Rating'); ?></li>
		<li><?php echo ($order=='name' and $direction=='asc')? anchor('mods/name/desc', 'Name') : anchor('mods/name/asc', 'Name'); ?></li>
		<li><?php echo ($order=='author' and $direction=='asc')? anchor('mods/author/desc', 'Author') : anchor('mods/author/asc', 'Author'); ?></li>
	</ul>
	<br style="clear:both;" />
	<div style="text-align: center;margin-top:20px">
		<?php echo anchor('upload/mods', 'Upload your own mod!', 'class="button solid"'); ?>
	</div>
</aside>

<section id="content">
	<section id="mods">
		<h2 style="margin-bottom: 10px;">Mods</h2>
		
		<div id="info">
			<?php echo show_messages(); ?>
		</div>
			
		<div id="list">
			<ul>
				<?php foreach($mods as $entry): $entry->rate_sum = (int)$entry->rate_sum; ?>
					
					<li>
						<img style="float:left" src="<?php echo base_url("uploads/mods/$entry->name"); ?>.png" alt="Mod <?php echo $entry->name; ?>" />
						<div style="float:left; padding-left:16px;">
							<p><?php echo $entry->name; ?></p>
							<p style="font-size: 10px">
								from <?php echo anchor(uri_string().'#'.url_title($entry->username), $entry->username, 'class="none solid"'); ?>
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
							<?php if($entry->server): ?>
								<span class="mark">Server</span>
							<?php endif; ?>
							<?php if($entry->client): ?>
								<span class="mark">Client</span>
							<?php endif; ?>
							<br/><br/>
							<?php echo anchor($entry->link, 'Visit Mod-Site', 'target="_blank" style="font-size: 10px"'); ?>						
						</div>
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