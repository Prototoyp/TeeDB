<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Skins extends Request_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('pagination_type','string'));
		$this->load->library('pagination');	
		$this->load->model(array('teedb/skin', 'teedb/rate'));
		
		$this->load->config('pagination');	
	}

	// --------------------------------------------------------------------
	
	/**
	 * Show all skins
	 * 
	 * @param string Order of entries. ENUM(new,rate,dw,name,author)
	 * @param string Sort by 'desc' or 'asc'
	 * @param integer Offset for shown entries
	 */
	function index($order='new', $direction='desc', $from=0)
	{
		//Validate user input order and direction
		list($order, $sort) = get_db_sort($order, 'skin');
		$direction = validate_direction($direction);
		
		//Init pagination
		$config = array();
		$config['base_url'] = base_url('skins/'.$order.'/'.$direction);
		$config['total_rows'] = $this->skin->count_skins();
		$this->pagination->initialize($config);
		
		//Validate user input  and get limitimit
		list($from, $limit) = validate_limit($from, $config['total_rows'], $this->config->item('per_page'));
		
		//Set output
		$data = array();
		$data['skins'] = $this->skin->get_skins($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		
		$this->template->set_subtitle('Skins');
		$this->template->view('skins', $data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Rate skins by form submit
	 */
	function _post_index($order='new', $direction='desc', $from=0)
	{
		if($this->_set_rate())
		{
			$rate = ($this->input->post('rate'))? 'top' : 'flop';
			$name = $this->skin->get_name($this->input->post('id'));
			$this->template->add_success_msg('Skin '.$name.' rated successful as '.$rate.'.');
		}
		
		$this->index($order, $direction, $from);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Rate skins by ajax form submit
	 */	 
	function _ajax_index()
	{
		$this->set_multi_ajax(TRUE);
		$this->output->set_output($this->_set_rate());
	}

	// --------------------------------------------------------------------
	
	/**
	 * Set rate for skins
	 */
	function _set_rate()
	{		
		if ($this->form_validation->run('rate_skin') === TRUE)
		{
			return $this->rate->set_rate(
				Rate::TYPE_SKIN,
				$this->input->post('id'),
				$this->input->post('rate')
			);
		}
		
		return FALSE;
	}
}

/* End of file skins.php */
/* Location: ./application/modules/teedb/controllers/skins.php */