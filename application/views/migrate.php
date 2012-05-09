<div class="container">

  <div class="hero-unit">
    <h1>Migration Center</h1>
    <p>
    	This is a controller to build up database tables or setup userdatas full automaticly by CI.<br />
    	To use migration you have to enable Migratetion in the config file.<br />
    	For product you should disable migration after setting up the page.<br />
    	<br />
    	<strong>Enviroment:</strong> <?php echo ((ENVIRONMENT == ' product')? '<span style="color:red">' : '<span style="color:green">').ENVIRONMENT.'</span>'; ?><br />       	
    	Migration status: <?php echo ($enabled)? '<span style="color:green">TRUE</span>' : '<span style="color:red">FALSE</span>'; ?><br />
    	<br />
    	Active version: <?php echo $current; ?><br />
    	<strong>Recommended version: <?php echo $config; ?></strong>
    </p>
  </div>
  
  <div class="row">
  	<div class="span12">
	    <?php echo show_messages(); ?>
	    <?php if(isset($feedback)) echo $feedback; ?>
    </div>
  </div>

  <?php if(isset($feedback)): ?>
  	<hr>
  <?php endif; ?>

  <div class="row">
    <div class="span4">
      <h2>Migrate to config</h2>
       <p>
       	Migrate to recommended version defined in migration config file.<br />
       	<br />
       	Recommended version: <?php echo $config; ?>
       </p>
      <p><?php echo anchor('migrate/current', 'Migrate to config', 'class="btn btn-primary"'); ?></p>
   </div>
    <div class="span4">
      <h2>Migrate to version</h2>
      <p>Choose the migration file in the dropdown menu you want to migrate to.</p>
      <?php echo form_open('migrate/version', 'class="well"'); ?>
      	<?php echo form_dropdown('version', $versions, $current, 'class="span3"'); ?>
      	<?php echo form_submit('version_migrate', 'Migrate to version', 'class="btn"'); ?>
      <?php echo form_close(); ?>
    </div>
    <div class="span4">
      <h2>Migrate to latest version</h2>
       <p>
       	Migrate to the latest migration file. This could be cause problems when using higher versions as recommended.<br />
       	<br />
       	Latest version: <?php echo $latest; ?>
       </p>
      <p><?php echo anchor('migrate/latest', 'Migrate to latest', 'class="btn"'); ?></p>
    </div>
  </div>

  <hr>

  <footer>
    <p>Part of Admin CI+ Center</p>
  </footer>

</div> <!-- /container -->