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
	
	<img src="assets/images/logo.png" alt="Logo">
	
	<h2>TeeDB update!</h2>
	
	<p>
		Last steps to a new version of TeeDB. Transfer old TeeDB data to new one.
	<p/>
	
	<br /><br />
	
	<h2>1. Usertransfer</h2>
	<br />
	
	<section id ="userchange">
		<h2>Change invalid username</h2>
		
		Check in the list below your username is not valid anymore.<br/>
		If so your are able to change your name here.<br/>
		<p class="info border"><span class="icon color icon112"></span>Only invalid username changes accepted!</p>
		
		<?php if(isset($success)): ?>			
		<?php echo ($success)? 
				'<p class="success color border">
					<span class="icon color icon101"></span>
					Username successful changed.
				</p>'
				 : 
				 validation_errors('<p class="error color border"><span class="icon color icon100"></span>','</p>'
			);
		?>
		<?php endif; ?>
		
		<?php echo form_open('upcoming'); ?>
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
		<h2>Data dismatched user signup rules</h2>
		<br />
		<table cellspacing="10">
			<thead>
				<tr>
					<th>#</th>
					<th>Username</th>
					<th>Reason</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=0; foreach($transfers as $entry): $i++; ?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $entry->username; ?></td>
					<td><?php echo $entry->error; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</section>
	
</div>