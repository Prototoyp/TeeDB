<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Demos extends Public_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('pagination');
		$this->load->model('teedb/demo');
		$this->load->config('pagination');
	}
	
	function index($order='new', $direction='desc', $from=0)
	{
		//Check input $order
		switch($order){
			case 'new': $sort = 'demo.create'; break;
			case 'rate': $sort = 'SUM(rate.value)'; break;
			case 'dw': $sort = 'demo.downloads'; break;
			case 'name': $sort = 'demo.name'; break;
			case 'author': $sort = 'user.name'; break;
			default: $order = 'new'; $sort = 'demo.create';
		}
		
		//Check input $direction
		switch($direction){
			case 'desc': break;
			case 'asc': break;
			default: $direction = 'desc';
		}
		
		//Init pagination
		$config = array();
		$config['base_url'] = 'demos/'.$order.'/'.$direction;
		$config['total_rows'] = $this->demo->count_demos();
		$this->pagination->initialize($config);
		
		//Check input $form
		if(!is_numeric($from) || $from<0 || $from > $config['total_rows'])
			$from=0;
		
		//Set limit
		$limit = $config['total_rows'] - $from; 
		if($limit >= $this->config->item('per_page')){
			$limit = $this->config->item('per_page');
		}
		
		//Set output
		$data = array();
		$data['demos'] = $this->demo->get_demos($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		
		$this->template->set_subtitle('Demos');
		$this->template->view('demos', $data);
	}
}

/* End of file skins.php */
/* Location: ./application/modules/teedb/controllers/skins.php */