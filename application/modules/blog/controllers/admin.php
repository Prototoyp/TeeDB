<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Request_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('blog/blog');
		
		$this->template->set_subtitle('News-Admin');
	}
	
	function index()
	{
		$this->template->view('admin');
	}
	
	function write()
	{
		$this->template->view('admin/write');
	}
	
	function edit()
	{
		$this->template->view('admin');
	}
	
	function _post_write()
	{
		if($this->form_validation->run('news_article') === TRUE)
		{
			if($this->input->post('preview'))
			{
				$this->template->add_info_msg('Nothing here, yet.');
			}
			else 
			{
				$this->blog->add_news(
					$this->input->post('title'),
					$this->input->post('article'),
					$this->auth->get_id()
				);
				$this->template->add_success_msg('Newsarticle successful saved.');
			}
		}
		$this->write();
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/admin.php */