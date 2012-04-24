<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Skins extends Public_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('pagination');	
		$this->load->model('teedb/skin');
		$this->load->config('pagination');
	}
	
	/**
	 * Show all skins
	 * 
	 * @param string Order by ENUM(new,rate,dw,name,author)
	 * @param string Sort by 'desc' or 'asc'
	 * @param integer Offset skin-entries
	 */
	function index($order='new', $direction='desc', $from=0)
	{
		//Check input $order
		switch($order){
			case 'new': $sort = 'skin.create'; break;
			case 'rate': $sort = 'SUM(rate.value)'; break;
			case 'dw': $sort = 'skin.downloads'; break;
			case 'name': $sort = 'skin.name'; break;
			case 'author': $sort = 'user.name'; break;
			default: $order = 'new'; $sort = 'skin.create';
		}
		
		//Check input $direction
		switch($direction){
			case 'desc': break;
			case 'asc': break;
			default: $direction = 'desc';
		}
		
		//Init pagination
		$config = array();
		$config['base_url'] = base_url('/skins/'.$order.'/'.$direction);
		$config['total_rows'] = $this->skin->count_skins();
		$this->pagination->initialize($config);
		
		//Check input $form
		if(!is_numeric($from) || $from < 0 || $from > $config['total_rows'])
			$from = 0;
		
		//Set limit
		$limit = $config['total_rows'] - $from; 
		if($limit >= $this->config->item('per_page')){
			$limit = $this->config->item('per_page');
		}
		
		//Set output
		$data = array();
		$data['skins'] = $this->skin->get_skins($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		
		$this->template->set_subtitle('Skins');
		$this->template->view('skins', $data);
	}

	function skins($order='new', $direction='desc', $from=0)
	{
		$data = $this->_input_request('skinname', $this->skin, $this->config->item('upload_path_skins'));
		
		list($limit, $sort) = $this->_sort($order, $direction, $from, 'skin', $this->skin->count_my_skins(), 10);
		
		$data['uploads'] = $this->skin->get_my_skins($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'skins';
		
		$this->template->set_subtitle('My skins');
		$this->template->view('image_edit', $data);
	}
	
	function _sort(&$order, &$direction, &$from, $type='skin', $count=0, $per_page=20)
	{
		if($type == 'mod') $type = 'modi';
		
		//Check input $order
		switch($order){
			case 'new': $sort = $type.'.create'; break;
			case 'rate': $sort = 'SUM(rate.value)'; break;
			case 'dw': $sort = $type.'.downloads'; break;
			case 'name': $sort = $type.'.name'; break;
			case 'author': $sort = 'user.name'; break;
			default: $order = 'new'; $sort = $type.'.create';
		}
		
		if($type == 'modi') $type = 'mod';
		
		//Check input $direction
		switch($direction){
			case 'desc': break;
			case 'asc': break;
			default: $direction = 'desc';
		}
		
		if($type == 'mapres') $type = 'mapre';
		
		//Init pagination
		$config['base_url'] = 'teedb/myteedb/'.plural($type).'/'.$order.'/'.$direction;
		$config['total_rows'] = $count;
		$config['per_page'] = $per_page;
		$config['num_links'] = 5;
		$config['uri_segment'] = 6;
		$config['cur_tag_open'] = '<span id="cur">';
		$config['cur_tag_close'] = '</span>';
		$this->pagination->initialize($config);
		
		//Check input $form
		if(!is_numeric($from) || $from<0 || $from > $config['total_rows'])
			$from=0;
		
		//Set limit
		$limit = $config['total_rows'] - $from; 
		if($limit >= $config['per_page']){
			$limit = $config['per_page'];
		}
		
		return array($limit, $sort);
	}

	function _input_request($input_name, $table, $path)
	{
		if(!$this->input->post('id'))
			return;
		
		$data = array();
		$old_name = $table->get_name($this->input->post('id'));
		
		if($this->input->post('change') && $this->_name_validate($input_name, $table->get_table()) === TRUE)
		{
			$table->change_name(
				$this->input->post('id'), 
				$this->input->post($input_name)
			);
			
			rename(
				$path.'/'.$old_name.'.png',
				$path.'/'.$this->input->post($input_name).'.png'
			);
			rename(
				$path.'/previews/'.$old_name.'.png',
				$path.'/previews/'.$this->input->post($input_name).'.png'
			);
			
			$data['changed'] = $old_name;
		}
		
		if($this->input->post('delete'))
		{
			$data['delete'] = $old_name;
		}
		
		if($this->input->post('delete2'))
		{
			$table->remove($this->input->post('id'));
			unlink($path.'/'.$old_name.'.png');
			unlink($path.'/previews/'.$old_name.'.png');
		}
		
		return $data;
	}

	function _name_validate($input, $type)
	{
		$this->form_validation->set_rules('id', 'skin-ID', 'trim|required|is_natural_no_zero');
		$this->form_validation->set_rules($input, $input, 'trim|required|alpha_numeric|min_length[3]|max_length[32]|unique['.$type.'.name]');

		return $this->form_validation->run();
	}
}

/* End of file skins.php */
/* Location: ./application/modules/teedb/controllers/skins.php */