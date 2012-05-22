<style>
  	body{
		color: #3A2B1B;
		background-color: #A16E36;
  	}
  	#wrapper{
  		text-align: center;
  		margin: auto; 
  		position: relative; 
  		width: 800px
  	}
  	table{
  		width: 800px;
  	}
  	th{ 
  		background-color: #3B2B1C; 
  		color: #A16E36; 
  	}
  	td{ 
  		background-color: #543F24; 
  		color: #FFC96C;
  	}

	h2{	
		color: #A16E36;
		margin: 10px, 0px;
		background-color: #543f24;
		border: 5px solid #543f24;
		border-radius: 6px;	
		-moz-border-radius: 6px; 
		-webkit-border-radius: 6px;
		padding: 0 20px;
	}
</style>
	
<div id="wrapper">
	
	<a class="none" href="<?php echo base_url(); ?>">
		<img src="assets/images/logo.png" alt="Logo">
	</a>
	
	<section id ="userchange">
		<h2>Usertransfer - Change invalid username</h2>
		
		<p class="info border"><span class="icon color icon112"></span>Only invalid username changes accepted!</p>
		
		<?php if(isset($success) && $success): ?>			
		<?php echo '<p class="success color border">
						<span class="icon color icon101"></span>
						Username successful changed.
					</p>';
		?>
		<?php endif; ?>
		<?php echo validation_errors('<p class="error color border"><span class="icon color icon100"></span>','</p>'); ?>
		
		<?php echo form_open('upcoming/change_username'); ?>
			<p>
				<label for="username">Username (before):</label>
				<?php echo form_input('username',set_value('username')); ?>
				<br /><br />
				<label for="password">Password:</label>
				<?php echo form_password('password'); ?>
				<br /><br />
				<label for="new_username">New username:</label>
				<?php echo form_input('new_username',set_value('new_username')); ?>
				<br /><br /><br />
				<?php echo form_submit('new_user','Change username'); ?><br />
			</p>
		<?php echo form_close(); ?>
	
	<br /><br />
	</section>
	
	<section id="data">
		<h2>Username changes</h2>
		<br />
		<table cellspacing="10">
			<thead>
				<tr>
					<th>#</th>
					<th>Username</th>
					<th>Changed to...</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=0; foreach($transfers as $entry): $i++; ?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $entry->username; ?></td>
					<td><?php echo $entry->name; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</section>
	
</div>