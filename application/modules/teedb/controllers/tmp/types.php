<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Types extends Request_Controller {
	
	private $types_pural = array(
									'skin' => 'skins',
									'mapres' => 'mapres'
								);

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('pagination_type');	
		$this->load->library('pagination');	
		$this->load->model('teedb/rate');
		
		$this->load->config('pagination');	
	}

	// --------------------------------------------------------------------
	
	/**
	 * Show all skins
	 * 
	 * @param string Order by ENUM(new,rate,dw,name,author)
	 * @param string Sort by 'desc' or 'asc'
	 * @param integer Offset skin-entries
	 */
	function index($type = 'skin', $order='new', $direction='desc', $from=0)
	{
		//FIXME: Check type
		
		$this->load->model('teedb/'.$type, 'type');
		
		//Validate user input order and direction
		list($order, $sort) = get_db_sort($order, $type);
		$direction = validate_direction($direction);
		
		//Init pagination
		$config = array();
		$config['base_url'] = base_url($this->types_pural[$type].'/'.$order.'/'.$direction);
		$config['total_rows'] = $this->type->count_all();
		$this->pagination->initialize($config);
		
		//Validate user input from and get limit
		list($from, $limit) = validate_limit($from, $config['total_rows'], $this->config->item('per_page'));
		
		//Set output
		$data = array();
		$data['skins'] = $this->type->get_all($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		
		$this->template->set_subtitle(ucfirst($this->types_pural[$type]));
		$this->template->view($this->types_pural[$type], $data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Rate skins by form submit
	 */
	function _post_index($type = 'skin', $order='new', $direction='desc', $from=0)
	{
		$this->load->model('teedb/'.$type, 'type');
		
		if($this->_set_rate())
		{
			$rate = ($this->input->post('rate'))? 'top' : 'flop';
			$name = $this->type->get_name($this->input->post('id'));
			$this->template->add_success_msg('Skin '.$name.' rated successful as '.$rate.'.');
		}
		
		$this->index($type, $order, $direction, $from);
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