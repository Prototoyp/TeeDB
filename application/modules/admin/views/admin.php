<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="i-bar"></span>
        <span class="i-bar"></span>
        <span class="i-bar"></span>
      </a>
      <?php echo anchor('admin#', 'Dashboard', 'class="brand"'); ?>
      <div class="nav-collapse">
        <ul class="nav">
          <li class="active"><?php echo anchor('admin#', 'Home'); ?></li>
          <li><?php echo anchor('admin#about', 'About'); ?></li>
          <li><?php echo anchor('admin#contact', 'Contact'); ?></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>

<div class="container">

  <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Welcome to CI+</h1>
        <p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
        <p><a class="btn btn-primary btn-large">Learn more &raquo;</a></p>
      </div>

  <!-- Example row of columns -->
  <div class="row">
    <div class="span4">
      <h2>Heading</h2>
       <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
      <p><a class="btn" href="#">View details &raquo;</a></p>
    </div>
    <div class="span4">
      <h2>Heading</h2>
       <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
      <p><a class="btn" href="#">View details &raquo;</a></p>
   </div>
    <div class="span4">
      <h2>Heading</h2>
      <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
      <p><a class="btn" href="#">View details &raquo;</a></p>
    </div>
  </div>

  <hr>

  <footer>
    <p>&copy; Company 2012</p>
  </footer>

</div> <!-- /container -->