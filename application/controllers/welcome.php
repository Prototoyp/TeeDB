<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends Public_Controller {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('date');
		$this->load->model(array('blog/blog', 'user/user', 'teedb/skin', 'teedb/common'));
	}
	
	/**
	 * Welcome default page
	 * 
	 * Shows ...
	 * - the latest news and latest news titles
	 * - stats of teedb and users
	 * - random skin in front of the header
	 * 
	 */
	public function index()
	{
		//Newstitles & latest news
		$data['news_titles'] = $this->blog->get_latest_titles();
		$data['news'] = $this->blog->get_latest(1);
		
		if(is_array($data['news']) && isset($data['news'][0])){			
			$data['news'] =  $data['news'][0];
		}
		
		//Calculate chartbar values
		$data['stats'] = array();
		$stats = $this->common->get_stats();
		$width = 178; //Width of full chart bar
		$min = 20; //Min width by 0%
		$sum = array_sum($stats) - $stats['users'];
		foreach($stats as $key => $count){
			if($key == 'users')
			{
				$data['stats']['users'] = $count;
				break;
			}
			$data['stats'][$key]['procent'] = ($count > 0)? round($count/$sum * 100) : 0;
			($data['stats'][$key]['width'] = round($data['stats'][$key]['procent'] * $width / 100)) >= $min OR $data['stats'][$key]['width'] = $min;
		}
		
		$data['last_user'] = $this->user->get_last_user();
		$data['last'] = $this->common->get_last(15);
		
		$this->template->set_layout_data('nav', array('large' => TRUE, 'randomtee' => $this->skin->get_random()));
		$this->template->view('welcome', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */