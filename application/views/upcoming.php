<style>
  	body{
		color: #3A2B1B;
		background-color: #A16E36;
		font-size: 100%;
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
	
	<section id ="update">
		<header><h2>TeeDB update! - Usertransfer</h2></header>
		
		<article style="text-align: left">
			<br />	
			Last steps to a new version of TeeDB. Transfer old TeeDB data to new one.<br />
			<br />			
			TeeDB has a lot of new rules to validate data.<br/>
			Thats why not all data from the old database can be transfered.<br/>
			<br/>
			To transfer the most of the old data and as simple as impossible the transfer is going step by step.<br/>
			<br/>
			For now: Usertransfer<br/>
			<br/>
			All accounts 
			
			<strong>Clear usernames!</strong> Means no more names like "!.,~^MyNam€~,.!" .<br />
			<br />
			Check in the list below if your username is invalid.<br/>
			If so, you are able to change your username <?php echo anchor('upcoming/change_username', 'here'); ?>.<br/>
			<br/>
			<u>Notice:</u> Only username changes for the users in the list are accepted.
			<br/><br/><br/><br/>
			<strong>Some stats about the usertransfer:</strong><br/>
			<br/>
			<strong>Count:</strong> 2250<br>
			<strong>Transfered:</strong> 1350 (60%)<br/>
			<strong>Invalid:</strong> 210 (9%)<br/>
			- Invalid (No uploads): 146 (6%)<br/>
			- Invalid (Has uploads): 64 (3%)<br/>
			<strong>Not activated/ Deleted:</strong> 690 (31%)<br/>
			<br/>
			<img src="http://chart.apis.google.com/chart?cht=p&chs=500x250&chd=t:60,6,3,31&chtt=Usertransfer&chl=Transfered|Invalid (No uploads)|Invalid (Has uploads)|Not activated/ Deleted" /><br />
		</article>
	</section>
	<br/><br/>
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
					<td><?php echo htmlspecialchars($entry->username); ?></td>
					<td><?php echo $entry->error; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</section>
	
</div>