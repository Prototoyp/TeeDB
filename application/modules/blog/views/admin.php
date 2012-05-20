<div class="container-fluid">
  <div class="row-fluid">
    <div class="span3">
      <div class="well sidebar-nav">
        <ul class="nav nav-list">
          <li class="nav-header">News</li>
          <li <?php if(preg_match('#(^blog/admin/write)#', uri_string())) echo 'class="active"'; ?>>
          	<?php echo anchor('blog/admin/write', 'Write an article'); ?>
          </li>
          <li <?php if(preg_match('#(^blog/admin/edit)#', uri_string())) echo 'class="active"'; ?>>
          	<?php echo anchor('blog/admin/edit', 'Edit or delete an article'); ?>
          </li>
          <li class="nav-header">Comments</li>
          <li>...</li>
        </ul>
      </div><!--/.well -->
    </div><!--/span-->
    <div class="span9">
      <div class="hero-unit">
        <h1>Module Blog</h1>
        <p>
        	This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.
    		<br />
    	</p>
        <p><?php echo anchor('blog/admin/write', 'Write an article', 'class="btn btn-primary btn-large"'); ?></p>
      </div>
      <div class="row-fluid">
        <div class="span4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div><!--/span-->
        <div class="span4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div><!--/span-->
        <div class="span4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div><!--/span-->
      </div><!--/row-->
      <div class="row-fluid">
        <div class="span4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div><!--/span-->
        <div class="span4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div><!--/span-->
        <div class="span4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div><!--/span-->
      </div><!--/row-->
    </div><!--/span-->
  </div><!--/row-->

  <hr>

  <footer>
    <p>Part of Admin CI+</p>
  </footer>

</div><!--/.fluid-container-->