<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Maps extends Request_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('pagination_type','string', 'rating'));
		$this->load->library('pagination');	
		$this->load->model(array('teedb/map', 'teedb/rate'));
		
		$this->load->config('pagination');	
	}

	// --------------------------------------------------------------------
	
	/**
	 * Show all maps
	 * 
	 * @param string Order of entries. ENUM(new,rate,dw,name,author)
	 * @param string Sort by 'desc' or 'asc'
	 * @param integer Offset for shown entries
	 */	
	function index($order='new', $direction='desc', $from=0)
	{
		//Validate user input order and direction
		list($order, $sort) = get_db_sort($order, 'map');
		$direction = validate_direction($direction);
		
		//Init pagination
		$config = array();
		$config['base_url'] = base_url('maps/'.$order.'/'.$direction);
		$config['total_rows'] = $this->map->count_maps();
		$config['per_page'] = 12;
		$this->pagination->initialize($config);
		
		//Validate user input  and get limitimit
		list($from, $limit) = validate_limit($from, $config['total_rows'], $config['per_page']);
		
		//Set output
		$data = array();
		$data['maps'] = $this->map->get_maps($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		
		$this->template->set_subtitle('Maps');
		$this->template->view('maps', $data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Rate maps by form submit
	 */
	function _post_index($order='new', $direction='desc', $from=0)
	{
		if($this->_set_rate())
		{
			$rate = ($this->input->post('rate'))? 'top' : 'flop';
			$name = $this->map->get_name($this->input->post('id'));
			$this->template->add_success_msg('Map '.$name.' rated successful as '.$rate.'.');
		}
		
		$this->index($order, $direction, $from);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Rate maps by ajax form submit
	 */	 
	function _ajax_index()
	{
		$this->set_multi_ajax(TRUE);
		$this->output->set_output($this->_set_rate());
	}

	// --------------------------------------------------------------------
	
	/**
	 * Set rate for maps
	 */
	function _set_rate()
	{		
		if ($this->form_validation->run('rate_map') === TRUE)
		{
			return $this->rate->set_rate(
				Rate::TYPE_MAP,
				$this->input->post('id'),
				$this->input->post('rate')
			);
		}
		
		return FALSE;
	}
}

/* End of file maps.php */
/* Location: ./application/modules/teedb/controllers/maps.php */