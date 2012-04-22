<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class MyTeeDB extends Request_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->library(array('user/auth', 'pagination','form_validation', 'session'));
		$this->load->helper(array('inflector', 'date'));
		$this->load->model(array('teedb/skin', 'teedb/mod', 'teedb/gameskin', 'teedb/tileset', 'teedb/demo', 'teedb/map'));
		
		$this->load->config('teedb/upload');
		$this->load->config('teedb/pagination');
		
		//User_Controller
		if(!$this->auth->logged_in())
		{
			redirect('user/login');
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * Show my stuff
	 */
	
	/**
	 * On default show my skins
	 */
	function index()
	{
		$this->skins();
	}
	
	function _post_index($order='new', $direction='desc', $from=0)
	{
		$this->_post_skins($order,$direction,$from);
	}

	// --------------------------------------------------------------------

	/**
	 * Skin form editing
	 */	
	public function _post_skins($order='new', $direction='desc', $from=0)
	{
		$data = array();
		
		if($this->form_validation->run('is_id') === TRUE)
		{
			//Name before renaming
			$old_name = $this->skin->get_name($this->input->post('id'));
			
			//Reset validation
			$this->form_validation->reset_validation();
			
			if($this->input->post('change'))
			{
				if($this->form_validation->run('my_skin') === TRUE)
				{
					//Rename skinfile
					if(!@rename($this->config->item('upload_path','skin').'/'.$old_name.'.png',
								$this->config->item('upload_path','skin').'/'.$this->input->post('skinname').'.png'))
					{
						$this->form_validation->add_message('An error occurred while trying to rename the file.');
					}
					//Rename preview file
					elseif(!@rename($this->config->item('preview_path','skin').'/'.$old_name.'.png',
									$this->config->item('preview_path','skin').'/'.$this->input->post('skinname').'.png'))
					{
						
						//Coudn't rename preview file? -> create new one
						if(!$this->skin_preview->create($old_name.'.png'))
						{
							$this->form_validation->add_message('Coundnt rename preview file.');
							$this->form_validation->add_message($this->skin_preview->error_msg);
						}
						else
						{
							if(file_exists($this->config->item('preview_path','skin').'/'.$old_name.'.png'))
							{
								@unlink($this->config->item('preview_path','skin').'/'.$old_name.'.png');
							}
						}
					}
					
					//Rename skin in DB
					$this->skin->change_name(
						$this->input->post('id'), 
						$this->input->post('skinname')
					);
					
					$data['changed'] = $old_name;
				}
			}
			elseif($this->input->post('delete'))
			{
				$this->session->set_userdata('delete_id', $this->input->post('id'));
				$data['delete'] = $old_name;
				$data['delete_id'] = $this->input->post('id');
			}
			elseif($this->input->post('really_delete'))
			{
				if($this->input->post('id') != $this->session->userdata('delete_id'))
				{
					$this->form_validation->add_message('Delete ID doesn\'t match confirm ID.');
				}
				else
				{
					$this->session->unset_userdata('delete_id');
					$this->skin->remove($this->input->post('id'));
					@unlink($this->config->item('upload_path','skin').'/'.$old_name.'.png');
					@unlink($this->config->item('preview_path','skin').'/'.$old_name.'.png');
					$data['delete'] = $old_name;
				}
				
			}
		}

		$this->load->vars($data);
		$this->skins($order, $direction, $from);
	}
	
	/**
	 * Show my skins
	 */
	public function skins($order='new', $direction='desc', $from=0)
	{
		list($limit, $sort) = $this->_sort($order, $direction, $from, 'skin', $this->skin->count_my_skins());
		
		$data['uploads'] = $this->skin->get_my_skins($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'skins';
		
		$this->template->set_subtitle('My skins');
		$this->template->view('image_edit', $data);
	}

	// --------------------------------------------------------------------

	function demos($order='new', $direction='desc', $from=0){
		list($limit, $sort) = $this->_sort($order, $direction, $from, 'demo', $this->demo->count_my_demos());
		
		$data = array();
		$data['skins'] = $this->demo->get_my_demos($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'demos';
		
		$this->template->set_subtitle('MyTeeDB');
		$this->template->view('myteedb', $data);
	}

	function gameskins($order='new', $direction='desc', $from=0)
	{
		$data = $this->_input_request('gameskinname', $this->skin, $this->config->item('upload_path_gameskins'));
		
		list($limit, $sort) = $this->_sort($order, $direction, $from, 'gameskin', $this->gameskin->count_my_gameskins(), 10);
		
		$data['uploads'] = $this->gameskin->get_my_gameskins($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'gameskins';
		
		$this->template->set_subtitle('My gameskins');
		$this->template->view('image_edit', $data);
	}

	function mapres($order='new', $direction='desc', $from=0)
	{
		$data = $this->_input_request('mapresname', $this->tileset, $this->config->item('upload_path_mapres'));
		
		list($limit, $sort) = $this->_sort($order, $direction, $from, 'mapres', $this->tileset->count_my_mapres(), 10);
		
		$data['uploads'] = $this->tileset->get_my_mapres($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'mapres';
		
		$this->template->set_subtitle('My mapres');
		$this->template->view('image_edit', $data);
	}

	function maps($order='new', $direction='desc', $from=0){
		list($limit, $sort) = $this->_sort($order, $direction, $from, 'map', $this->map->count_my_maps());
		
		$data = array();
		$data['skins'] = $this->map->get_my_maps($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'maps';
		
		$this->template->set_subtitle('MyTeeDB');
		$this->template->view('myteedb', $data);
	}

	function mods($order='new', $direction='desc', $from=0)
	{
		list($limit, $sort) = $this->_sort($order, $direction, $from, 'mod', $this->mod->count_my_mods());
		
		$data = array();
		$data['skins'] = $this->mod->get_my_mods($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'mods';
		
		$this->template->set_subtitle('MyTeeDB');
		$this->template->view('myteedb', $data);
	}
	
	function _sort($order, $direction, $from, $type='skin', $count=0)
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
		$config['base_url'] = 'myteedb/'.plural($type).'/'.$order.'/'.$direction;
		$config['total_rows'] = $count;
		$this->pagination->initialize($config);
		
		//Check input $form
		if(!is_numeric($from) || $from<0 || $from > $config['total_rows'])
			$from=0;
		
		//Set limit
		$limit = $config['total_rows'] - $from; 
		if($limit >= $this->config->item('per_page')){
			$limit = $this->config->item('per_page');
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