<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feed extends CI_Controller {
	
	/**
	 * Constructor
	 */
    function __construct()
    {
        parent::__construct();
		
        $this->load->helper(array('url', 'date', 'xml'));
    	$this->load->library('template');
    	$this->load->model('blog/blog');
    }
    
    function index()
    {
        $data['encoding'] = 'utf-8';
        $data['feed_name'] = $this->template->header_data['title'];
        $data['feed_url'] = base_url('feed');
        $data['page_description'] = $this->template->header_data['description'];
        $data['page_language'] = 'en-ca';
        
        $data['news'] = $this->blog->get_latest(10);
        
		$this->output->set_header("Content-Type: application/rss+xml");
        $this->load->view('rss', $data);
    }
}

/* End of file feed.php */
/* Location: ./application/controllers/feed.php */