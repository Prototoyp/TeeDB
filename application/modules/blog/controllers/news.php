<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends Request_Controller {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('date', 'text'));
		$this->load->library(array('pagination', 'form_validation', 'user/auth'));
		$this->load->model(array('blog/blog', 'blog/comment'));
		
		$this->lang->load(array('MY_date','user/user','blog/news'));
		$this->load->config('pagination');
		
		$this->template->set_layout_data('nav', array(
			'left_view' => 'nav_news',
			'news_titles' => $this->blog->get_latest_titles()
		));
	}
	
	/**
	 * News overview
	 */
	function index($from=0)
	{		
		//Init pagination
		$config['base_url'] = 'news/page/';
		$config['uri_segment'] = 3;
		$config['total_rows'] = $this->blog->count_news();
		$this->pagination->initialize($config);
		
		//Check input $form
		if( ! is_numeric($from) || $from < 0 || $from > $config['total_rows'])
		{
			$from = 0;
		}
		
		//Set limit
		$limit = $config['total_rows'] - $from; 
		$per_page = $this->config->item('per_page');
		if($limit >= $per_page)
		{
			$limit = $per_page;
		}
		
		//Set output
		$data = array();
		$data['news'] = $this->blog->get_latest($limit, $from, 'news.create', 'desc');
		
		$this->template->set_subtitle('News');
		$this->template->view('news', $data);
	}
	
	/**
	 * Show news by given title
	 */
	public function title($title, $from=0)
	{
		//Set output
		$data = array();
		$data['news'] = $this->blog->get_news($title);
		
		//Init pagination
		$config['base_url'] = 'news/title/'.$title;
		$config['total_rows'] = (isset($data['news']) && $data['news'])? $this->comment->count_comments($data['news']->id) : 0;
		$this->pagination->initialize($config);
		
		//Check input $form
		if( ! is_numeric($from) || $from < 0 || $from > $config['total_rows'])
		{
			$from = 0;
		}
		
		//Set limit
		$limit = $config['total_rows'] - $from; 
		$per_page = $this->config->item('per_page');
		if($limit >= $per_page)
		{
			$limit = $per_page;
		}
		
		if(isset($data['news']) && $data['news'])
		{
			$data['comments'] = $this->comment->get_comments($data['news']->id, $limit, $from);
		}
		
		$this->template->set_subtitle('News');
		$this->template->view('title', $data);
	}

	public function _post_title($title, $from=0)
	{
		if(count($this->_comment()) > 0)
		{
			$this->load->vars(array('jopi' => $this->lang->line('success_comment_post')));
			$this->template->add_success_msg($this->lang->line('success_comment_post'));
		}
		$this->title($title, $from);
	}
	
	public function _ajax_title()
	{
		$this->set_multi_ajax(TRUE);
		$this->_comment();
		$this->output->set_output($this->input->post('comment'));
	}
	
	private function _comment()
	{
		if($this->form_validation->run('comment') === TRUE)
		{
			$this->blog->setComment();
			return $this->input->post('comment');
		}
		
		return array();
	}
}