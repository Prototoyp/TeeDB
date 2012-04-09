<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mapres extends Public_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('pagination');	
		$this->load->model('teedb/tileset');
		$this->load->config('pagination');
	}
	
	function index($order='new', $direction='desc', $from=0)
	{
		//Check input $order
		switch($order){
			case 'new': $sort = 'mapres.create'; break;
			case 'rate': $sort = 'SUM(rate.value)'; break;
			case 'dw': $sort = 'mapres.downloads'; break;
			case 'name': $sort = 'mapres.name'; break;
			case 'author': $sort = 'user.name'; break;
			default: $order = 'new'; $sort = 'mapres.create';
		}
		
		//Check input $direction
		switch($direction){
			case 'desc': break;
			case 'asc': break;
			default: $direction = 'desc';
		}
		
		//Init pagination
		$config = array();
		$config['base_url'] = 'mapres/'.$order.'/'.$direction;
		$config['total_rows'] = $this->tileset->count_mapres();
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
		$data['mapres'] = $this->tileset->get_mapres($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		
		$this->template->set_subtitle('Mapres');
		$this->template->view('tilesets', $data);
	}
}

/* End of file mapres.php */
/* Location: ./application/modules/teedb/controllers/mapres.php */