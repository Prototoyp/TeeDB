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
 		<div class="row-fluid">
        	<div class="span8">

				<h1>Write an new article</h1>
		      
				<?php echo show_messages(); ?>
			      
				<?php echo form_open('blog/admin/write', 'class="well"'); ?>
					<label>Title</label>
					<?php echo form_input('title',set_value('title'), 'class="span12"'); ?>
					<label>Article</label>
					<?php echo form_textarea('article',set_value('article'), 'class="span12"'); ?>
					<br />
					<?php echo form_submit('preview','Preview article', 'class="btn"'); ?>
					<?php echo form_submit('submit','Publish article', 'class="btn btn-primary"'); ?>
				<?php echo form_close(); ?>	
				
			</div>
        	<div class="span4">
        		<h1>Markup language</h1>
			 	<p>
			 		Use this form to create an new article.<br />
			 		You can use our markup language with the following syntax.
			 	</p>
		 		<ul>
		 			<li>Text between <strong>*stars*</strong> are highlighted as bold.</li>
		 			<li>Text between <em>_underline_</em> are written in italics.</li>
		 			<li>Text between <span style="text-decoration: line-through;">-hypen-</span> are crossed out.</li>
		 		</ul>
		 	</div>	
		</div>
    </div><!--/span-->
   
  </div><!--/row-->

  <hr>

  <footer>
    <p>Part of Admin CI+</p>
  </footer>

</div><!--/.fluid-container-->