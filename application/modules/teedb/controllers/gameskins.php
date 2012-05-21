<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gameskins extends Request_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('pagination_type');	
		$this->load->library('pagination');	
		$this->load->model(array('teedb/gameskin', 'teedb/rate'));
		
		$this->load->config('pagination');	
	}

	// --------------------------------------------------------------------
	
	/**
	 * Show all gameskins
	 * 
	 * @param string Order of entries. ENUM(new,rate,dw,name,author)
	 * @param string Sort by 'desc' or 'asc'
	 * @param integer Offset for shown entries
	 */
	function index($order='new', $direction='desc', $from=0)
	{
		//Validate user input order and direction
		list($order, $sort) = get_db_sort($order, 'gameskin');
		$direction = validate_direction($direction);
		
		//Init pagination
		$config = array();
		$config['base_url'] = base_url('gameskins/'.$order.'/'.$direction);
		$config['total_rows'] = $this->gameskin->count_gameskins();
		$this->pagination->initialize($config);
		
		//Validate user input  and get limitimit
		list($from, $limit) = validate_limit($from, $config['total_rows'], $this->config->item('per_page'));
		
		//Set output
		$data = array();
		$data['gameskins'] = $this->gameskin->get_gameskins($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		
		$this->template->set_subtitle('Gameskins');
		$this->template->view('gameskins', $data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Rate gameskins by form submit
	 */
	function _post_index($order='new', $direction='desc', $from=0)
	{
		if($this->_set_rate())
		{
			$rate = ($this->input->post('rate'))? 'top' : 'flop';
			$name = $this->gameskin->get_name($this->input->post('id'));
			$this->template->add_success_msg('Gameskin '.$name.' rated successful as '.$rate.'.');
		}
		
		$this->index($order, $direction, $from);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Rate gameskins by ajax form submit
	 */	 
	function _ajax_index()
	{
		$this->set_multi_ajax(TRUE);
		$this->output->set_output($this->_set_rate());
	}

	// --------------------------------------------------------------------
	
	/**
	 * Set rate for gameskins
	 */
	function _set_rate()
	{		
		if ($this->form_validation->run('rate_gameskin') === TRUE)
		{
			return $this->rate->set_rate(
				Rate::TYPE_GAMESKIN,
				$this->input->post('id'),
				$this->input->post('rate')
			);
		}
		
		return FALSE;
	}
}

/* End of file gameskins.php */
/* Location: ./application/modules/teedb/controllers/gameskins.php */