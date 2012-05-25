<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mapres extends Request_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('pagination_type','string', 'rating'));
		$this->load->library('pagination');	
		$this->load->model(array('teedb/tileset', 'teedb/rate'));
		
		$this->load->config('pagination');	
	}

	// --------------------------------------------------------------------
	
	/**
	 * Show all map resources
	 * 
	 * @param string Order of entries. ENUM(new,rate,dw,name,author)
	 * @param string Sort by 'desc' or 'asc'
	 * @param integer Offset for shown entries
	 */
	function index($order='new', $direction='desc', $from=0)
	{
		//Validate user input order and direction
		list($order, $sort) = get_db_sort($order, 'mapres');
		$direction = validate_direction($direction);
		
		//Init pagination
		$config = array();
		$config['base_url'] = base_url('mapres/'.$order.'/'.$direction);
		$config['total_rows'] = $this->tileset->count_mapres();
		$this->pagination->initialize($config);
		
		//Validate user input  and get limitimit
		list($from, $limit) = validate_limit($from, $config['total_rows'], $this->config->item('per_page'));
		
		//Set output
		$data = array();
		$data['mapres'] = $this->tileset->get_mapres($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		
		$this->template->set_subtitle('Mapres');
		$this->template->view('tilesets', $data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Rate mapres by form submit
	 */
	function _post_index($order='new', $direction='desc', $from=0)
	{
		if($this->_set_rate())
		{
			$rate = ($this->input->post('rate'))? 'top' : 'flop';
			$name = $this->tileset->get_name($this->input->post('id'));
			$this->template->add_success_msg('Map resource '.$name.' rated successful as '.$rate.'.');
		}
		
		$this->index($order, $direction, $from);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Rate mapres by ajax form submit
	 */	 
	function _ajax_index()
	{
		$this->set_multi_ajax(TRUE);
		$this->output->set_output($this->_set_rate());
	}

	// --------------------------------------------------------------------
	
	/**
	 * Set rate for mapres
	 */
	function _set_rate()
	{		
		if ($this->form_validation->run('rate_mapres') === TRUE)
		{
			return $this->rate->set_rate(
				Rate::TYPE_MAPRES,
				$this->input->post('id'),
				$this->input->post('rate')
			);
		}
		
		return FALSE;
	}
}

/* End of file mapres.php */
/* Location: ./application/modules/teedb/controllers/mapres.php */