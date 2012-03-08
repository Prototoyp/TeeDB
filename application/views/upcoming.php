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
		Last steps to a new version of TeeDB. Translate old TeeDB data to new one.
	<p/>
	
	<h2>Data dismatched upload/signup rules:</h2>
	
	<table cellspacing="10">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Type</th>
				<th>Reason</th>
			</tr>
		</thead>
		<tbody>
			<?php $i=0; foreach($transfers as $entry): $i++; ?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $entry['name']; ?></td>
				<td><?php echo $entry['type']; ?></td>
				<td><?php echo $entry['reason']; ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
</div>