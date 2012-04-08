<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * NOTICE OF LICENSE
 * 
 * Licensed under the Academic Free License version 3.0
 * 
 * This source file is subject to the Academic Free License (AFL 3.0) that is
 * bundled with this package in the files license_afl.txt / license_afl.rst.
 * It is also available through the world wide web at this URL:
 * http://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

class News extends Request_Controller {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('date');
		$this->load->library(array('pagination', 'form_validation', 'user/auth'));
		
		$this->load->model(array('blog/blog', 'blog/comment'));
	}
	
	/**
	 * News overview
	 */
	function index($order='new', $direction='desc', $from=0)
	{
		//Check input $order
		switch($order){
			case 'new': $sort = 'news.create'; break;
			case 'rate': $sort = 'SUM(rate.value)'; break;
			case 'dw': $sort = 'news.downloads'; break;
			case 'name': $sort = 'news.name'; break;
			case 'author': $sort = 'user.name'; break;
			default: $order = 'new'; $sort = 'news.create';
		}
		
		//Check input $direction
		switch($direction){
			case 'desc': break;
			case 'asc': break;
			default: $direction = 'desc';
		}
		
		//Init pagination
		$config['base_url'] = 'blog/news/index/'.$order.'/'.$direction;
		$config['total_rows'] = $this->blog->count_news();
		$config['per_page'] = 5;
		$config['num_links'] = 5;
		$config['uri_segment'] = 6;
		$config['cur_tag_open'] = '<span id="cur">';
		$config['cur_tag_close'] = '</span>';
		$this->pagination->initialize($config);
		
		//Check input $form
		if(!is_numeric($from) || $from<0 || $from > $config['total_rows'])
			$from=0;
		
		//Set limit
		$limit = $config['total_rows'] - $from; 
		if($limit >= $config['per_page']){
			$limit = $config['per_page'];
		}
		
		//Set output
		$data = array();
		$data['news'] = $this->blog->get_latest($limit, $from, $sort, $direction);
		$data['news_titles'] = $this->blog->get_latest_titles();
		$data['direction'] = $direction;
		$data['order'] = $order;
		
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
		$data['news_titles'] = $this->blog->get_latest_titles();
		$data['news'] = $this->blog->get_news($title);
		
		//Init pagination
		$config['base_url'] = 'blog/news/title/'.$title;
		$config['total_rows'] = (isset($data['news']) && $data['news'])? $this->comment->count_comments($data['news']->id) : 0;
		$config['per_page'] = 5;
		$config['num_links'] = 8;
		$config['uri_segment'] = 5;
		$config['cur_tag_open'] = '<span id="cur">';
		$config['cur_tag_close'] = '</span>';
		$this->pagination->initialize($config);
		
		//Check input $form
		if(!is_numeric($from) || $from<0 || $from > $config['total_rows'])
			$from=0;
		
		//Set limit
		$limit = $config['total_rows'] - $from; 
		if($limit >= $config['per_page']){
			$limit = $config['per_page'];
		}
		
		if(isset($data['news']) && $data['news']){
			$data['comments'] = $this->comment->get_comments($data['news']->id, $limit, $from);
		}
		
		$this->template->set_subtitle('News');
		$this->template->view('title', $data);
	}

	public function _post_title($title, $from=0)
	{
		$this->_comment();
		$this->title($title, $from);
	}
	
	public function _ajax_title()
	{
		$this->set_multi_ajax(TRUE);
		$this->output->set_output($this->_comment());
	}
	
	private function _comment()
	{
		if(!$this->auth->logged_in())
		{
			$this->form_validation->add_message('You have to login.');
		}

		if($this->form_validation->run('comment') === TRUE)
		{
			$this->blog->setComment();
			return $this->input->post('comment');
		}
		
		return array();
	}
}