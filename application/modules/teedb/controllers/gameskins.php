<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gameskins extends Public_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('pagination');
		$this->load->model('teedb/gameskin');
		$this->load->config('pagination');
	}
	
	function index($order='new', $direction='desc', $from=0)
	{
		//Check input $order
		switch($order){
			case 'new': $sort = 'gameskin.create'; break;
			case 'rate': $sort = 'SUM(rate.value)'; break;
			case 'dw': $sort = 'gameskin.downloads'; break;
			case 'name': $sort = 'gameskin.name'; break;
			case 'author': $sort = 'user.name'; break;
			default: $order = 'new'; $sort = 'gameskin.create';
		}
		
		//Check input $direction
		switch($direction){
			case 'desc': break;
			case 'asc': break;
			default: $direction = 'desc';
		}
		
		//Init pagination
		$config = array();
		$config['base_url'] = 'gameskins/'.$order.'/'.$direction;
		$config['total_rows'] = $this->gameskin->count_gameskins();
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
		$data['gameskins'] = $this->gameskin->get_gameskins($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		
		$this->template->set_subtitle('Gameskins');
		$this->template->view('gameskins', $data);
	}
}

/* End of file mapres.php */
/* Location: ./application/modules/teedb/controllers/mapres.php */