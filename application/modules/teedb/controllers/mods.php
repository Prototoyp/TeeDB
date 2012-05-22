<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mods extends Request_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('pagination_type','string'));	
		$this->load->library('pagination');	
		$this->load->model(array('teedb/mod', 'teedb/rate'));
	}

	// --------------------------------------------------------------------
	
	/**
	 * Show all mods
	 * 
	 * @param string Order of entries. ENUM(new,rate,dw,name,author)
	 * @param string Sort by 'desc' or 'asc'
	 * @param integer Offset for shown entries
	 */
	
	function index($order='new', $direction='desc', $from=0)
	{
		//Validate user input order and direction
		list($order, $sort) = get_db_sort($order, 'modi');
		$direction = validate_direction($direction);
		
		//Init pagination
		$config = array();
		$config['base_url'] = base_url('mods/'.$order.'/'.$direction);
		$config['total_rows'] = $this->mod->count_mods();
		$this->pagination->initialize($config);
		
		//Validate user input  and get limitimit
		list($from, $limit) = validate_limit($from, $config['total_rows'], $this->config->item('per_page'));
		
		//Set output
		$data = array();
		$data['mods'] = $this->mod->get_mods($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		
		$this->template->set_subtitle('Mods');
		$this->template->view('mods', $data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Rate mods by form submit
	 */
	function _post_index($order='new', $direction='desc', $from=0)
	{
		if($this->_set_rate())
		{
			$rate = ($this->input->post('rate'))? 'top' : 'flop';
			$name = $this->mod->get_name($this->input->post('id'));
			$this->template->add_success_msg('Modification '.$name.' rated successful as '.$rate.'.');
		}
		
		$this->index($order, $direction, $from);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Rate mods by ajax form submit
	 */	 
	function _ajax_index()
	{
		$this->set_multi_ajax(TRUE);
		$this->output->set_output($this->_set_rate());
	}

	// --------------------------------------------------------------------
	
	/**
	 * Set rate for mods
	 */
	function _set_rate()
	{		
		if ($this->form_validation->run('rate_mod') === TRUE)
		{
			return $this->rate->set_rate(
				Rate::TYPE_MOD,
				$this->input->post('id'),
				$this->input->post('rate')
			);
		}
		
		return FALSE;
	}
}

/* End of file mods.php */
/* Location: ./application/modules/teedb/controllers/mods.php */