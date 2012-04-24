<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class MyTeeDB extends Request_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->library(array('user/auth', 'pagination','form_validation', 'session', 'image_lib', 'upload'));
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
			//Check id belongs to user and get name before renaming
			if(!$old_name = $this->skin->get_my_name($this->input->post('id')))
			{
				$this->form_validation->add_message('ID dosen\'t belong to you.');
			}
			else
			{
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
					$this->session->set_userdata('delete_skin_id', $this->input->post('id'));
					$data['delete'] = $old_name;
					$data['delete_id'] = $this->input->post('id');
				}
				elseif($this->input->post('really_delete'))
				{
					if($this->input->post('id') != $this->session->userdata('delete_skin_id'))
					{
						$this->form_validation->add_message('Delete ID doesn\'t match confirm ID.');
					}
					else
					{
						$this->session->unset_userdata('delete_skin_id');
						$this->skin->remove($this->input->post('id'));
						@unlink($this->config->item('upload_path','skin').'/'.$old_name.'.png');
						@unlink($this->config->item('preview_path','skin').'/'.$old_name.'.png');
						$data['delete'] = $old_name;
					}
					
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
		$this->template->view('my_images', $data);
	}

	// --------------------------------------------------------------------

	/**
	 * Demo form editing
	 */	
	public function _post_demos($order='new', $direction='desc', $from=0)
	{
		$data = array();
		
		if($this->form_validation->run('is_id') === TRUE)
		{
			//Check id belongs to user and get name before renaming
			if(!$old_name = $this->demo->get_my_name($this->input->post('id')))
			{
				$this->form_validation->add_message('ID dosen\'t belong to you.');
			}
			else
			{
				//Reset validation
				$this->form_validation->reset_validation();
				
				if($this->input->post('change'))
				{
					if($this->form_validation->run('my_demos') === TRUE)
					{
						//Rename demofile
						if(!@rename($this->config->item('upload_path','demo').'/'.$old_name.'.png',
									$this->config->item('upload_path','demo').'/'.$this->input->post('demoname').'.png'))
						{
							$this->form_validation->add_message('An error occurred while trying to rename the file.');
						}
						//Rename preview file
						elseif(!@rename($this->config->item('preview_path','demo').'/'.$old_name.'.png',
										$this->config->item('preview_path','demo').'/'.$this->input->post('demoname').'.png'))
						{
							
							//Coudn't rename preview file? -> create new one
							if(FALSE && !$this->demo_preview->create($old_name.'.png'))
							{
								$this->form_validation->add_message('Coundnt rename preview file.');
								$this->form_validation->add_message($this->demo_preview->error_msg);
							}
							else
							{
								//FIXME: uncomment when map builder works
								// if(file_exists($this->config->item('preview_path','demo').'/'.$old_name.'.png'))
								// {
									// @unlink($this->config->item('preview_path','demo').'/'.$old_name.'.png');
								// }
							}
						}
						
						//Rename gameskin in DB
						$this->tileset->change_name(
							$this->input->post('id'), 
							$this->input->post('demoname')
						);
						
						$data['changed'] = $old_name;
					}
				}
				elseif($this->input->post('delete'))
				{
					$this->session->set_userdata('delete_demo_id', $this->input->post('id'));
					$data['delete'] = $old_name;
					$data['delete_id'] = $this->input->post('id');
				}
				elseif($this->input->post('really_delete'))
				{
					if($this->input->post('id') != $this->session->userdata('delete_demo_id'))
					{
						$this->form_validation->add_message('Delete ID doesn\'t match confirm ID.');
					}
					else
					{
						$this->session->unset_userdata('delete_demo_id');
						$this->demo->remove($this->input->post('id'));
						@unlink($this->config->item('upload_path','demo').'/'.$old_name.'.png');
						@unlink($this->config->item('preview_path','demo').'/'.$old_name.'.png');
						$data['delete'] = $old_name;
					}
					
				}
			}
		}

		$this->load->vars($data);
		$this->demos($order, $direction, $from);
	}

	function demos($order='new', $direction='desc', $from=0){
		list($limit, $sort) = $this->_sort($order, $direction, $from, 'demo', $this->demo->count_my_demos());
		
		$data = array();
		$data['uploads'] = $this->demo->get_my_demos($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'demos';
		
		$this->template->set_subtitle('My demos');
		$this->template->view('my_images', $data);
	}

	// --------------------------------------------------------------------

	/**
	 * Gameskin form editing
	 */	
	public function _post_gameskins($order='new', $direction='desc', $from=0)
	{
		$data = array();
		
		if($this->form_validation->run('is_id') === TRUE)
		{
			//Check id belongs to user and get name before renaming
			if(!$old_name = $this->gameskin->get_my_name($this->input->post('id')))
			{
				$this->form_validation->add_message('ID dosen\'t belong to you.');
			}
			else
			{
				//Reset validation
				$this->form_validation->reset_validation();
				
				if($this->input->post('change'))
				{
					if($this->form_validation->run('my_gameskin') === TRUE)
					{
						//Rename gameskinfile
						if(!@rename($this->config->item('upload_path','gameskin').'/'.$old_name.'.png',
									$this->config->item('upload_path','gameskin').'/'.$this->input->post('gameskinname').'.png'))
						{
							$this->form_validation->add_message('An error occurred while trying to rename the file.');
						}
						//Rename preview file
						elseif(!@rename($this->config->item('preview_path','gameskin').'/'.$old_name.'.png',
										$this->config->item('preview_path','gameskin').'/'.$this->input->post('gameskinname').'.png'))
						{
							
							//Coudn't rename preview file? -> create new one
							$configResize['source_image'] = $this->config->item('preview_path','gameskin').'/'.$old_name.'.png';
							$configResize['new_image'] = $this->config->item('preview_path', 'gameskin');
							$configResize['width'] = 110;
							$configResize['height'] = 64;
							
							$this->image_lib->initialize($configResize);
							
							if(!$this->image_lib->resize())
							{
								$this->form_validation->add_message('Coundnt rename preview file.');
								$this->form_validation->add_message($this->image_lib->error_msg);
							}
							else
							{
								if(file_exists($this->config->item('preview_path','gameskin').'/'.$old_name.'.png'))
								{
									@unlink($this->config->item('preview_path','gameskin').'/'.$old_name.'.png');
								}
							}
						}
						
						//Rename gameskin in DB
						$this->gameskin->change_name(
							$this->input->post('id'), 
							$this->input->post('gameskinname')
						);
						
						$data['changed'] = $old_name;
					}
				}
				elseif($this->input->post('delete'))
				{
					$this->session->set_userdata('delete_gameskin_id', $this->input->post('id'));
					$data['delete'] = $old_name;
					$data['delete_id'] = $this->input->post('id');
				}
				elseif($this->input->post('really_delete'))
				{
					if($this->input->post('id') != $this->session->userdata('delete_gameskin_id'))
					{
						$this->form_validation->add_message('Delete ID doesn\'t match confirm ID.');
					}
					else
					{
						$this->session->unset_userdata('delete_gameskin_id');
						$this->gameskin->remove($this->input->post('id'));
						@unlink($this->config->item('upload_path','gameskin').'/'.$old_name.'.png');
						@unlink($this->config->item('preview_path','gameskin').'/'.$old_name.'.png');
						$data['delete'] = $old_name;
					}
					
				}
			}
		}

		$this->load->vars($data);
		$this->gameskins($order, $direction, $from);
	}
	
	/**
	 * Show my gameskins
	 */
	function gameskins($order='new', $direction='desc', $from=0)
	{
		$data = $this->_input_request('gameskinname', $this->skin, $this->config->item('upload_path_gameskins'));
		
		list($limit, $sort) = $this->_sort($order, $direction, $from, 'gameskin', $this->gameskin->count_my_gameskins(), 10);
		
		$data['uploads'] = $this->gameskin->get_my_gameskins($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'gameskins';
		
		$this->template->set_subtitle('My gameskins');
		$this->template->view('my_images', $data);
	}

	// --------------------------------------------------------------------

	/**
	 * Gameskin form editing
	 */	
	public function _post_mapres($order='new', $direction='desc', $from=0)
	{
		$data = array();
		
		if($this->form_validation->run('is_id') === TRUE)
		{
			//Check id belongs to user and get name before renaming
			if(!$old_name = $this->tileset->get_my_name($this->input->post('id')))
			{
				$this->form_validation->add_message('ID dosen\'t belong to you.');
			}
			else
			{
				//Reset validation
				$this->form_validation->reset_validation();
				
				if($this->input->post('change'))
				{
					if($this->form_validation->run('my_mapres') === TRUE)
					{
						//Rename gameskinfile
						if(!@rename($this->config->item('upload_path','mapres').'/'.$old_name.'.png',
									$this->config->item('upload_path','mapres').'/'.$this->input->post('mapresname').'.png'))
						{
							$this->form_validation->add_message('An error occurred while trying to rename the file.');
						}
						//Rename preview file
						elseif(!@rename($this->config->item('preview_path','mapres').'/'.$old_name.'.png',
										$this->config->item('preview_path','mapres').'/'.$this->input->post('mapresname').'.png'))
						{
							
							//Coudn't rename preview file? -> create new one
							$configResize['source_image'] = $this->config->item('preview_path','mapres').'/'.$old_name.'.png';
							$configResize['new_image'] = $this->config->item('preview_path', 'mapres');
							$configResize['width'] = 110;
							$configResize['height'] = 64;
							
							$this->image_lib->initialize($configResize);
							
							if(!$this->image_lib->resize())
							{
								$this->form_validation->add_message('Coundnt rename preview file.');
								$this->form_validation->add_message($this->image_lib->error_msg);
							}
							else
							{
								if(file_exists($this->config->item('preview_path','mapres').'/'.$old_name.'.png'))
								{
									@unlink($this->config->item('preview_path','mapres').'/'.$old_name.'.png');
								}
							}
						}
						
						//Rename gameskin in DB
						$this->tileset->change_name(
							$this->input->post('id'), 
							$this->input->post('mapresname')
						);
						
						$data['changed'] = $old_name;
					}
				}
				elseif($this->input->post('delete'))
				{
					$this->session->set_userdata('delete_mapres_id', $this->input->post('id'));
					$data['delete'] = $old_name;
					$data['delete_id'] = $this->input->post('id');
				}
				elseif($this->input->post('really_delete'))
				{
					if($this->input->post('id') != $this->session->userdata('delete_mapres_id'))
					{
						$this->form_validation->add_message('Delete ID doesn\'t match confirm ID.');
					}
					else
					{
						$this->session->unset_userdata('delete_mapres_id');
						$this->tileset->remove($this->input->post('id'));
						@unlink($this->config->item('upload_path','mapres').'/'.$old_name.'.png');
						@unlink($this->config->item('preview_path','mapres').'/'.$old_name.'.png');
						$data['delete'] = $old_name;
					}
					
				}
			}
		}

		$this->load->vars($data);
		$this->mapres($order, $direction, $from);
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
		$this->template->view('my_images', $data);
	}

	// --------------------------------------------------------------------

	/**
	 * Map form editing
	 */	
	public function _post_maps($order='new', $direction='desc', $from=0)
	{
		$data = array();
		
		if($this->form_validation->run('is_id') === TRUE)
		{
			//Check id belongs to user and get name before renaming
			if(!$old_name = $this->map->get_my_name($this->input->post('id')))
			{
				$this->form_validation->add_message('ID dosen\'t belong to you.');
			}
			else
			{
				//Reset validation
				$this->form_validation->reset_validation();
				
				if($this->input->post('change'))
				{
					if($this->form_validation->run('my_maps') === TRUE)
					{
						//Rename demofile
						if(!@rename($this->config->item('upload_path','map').'/'.$old_name.'.png',
									$this->config->item('upload_path','map').'/'.$this->input->post('mapname').'.png'))
						{
							$this->form_validation->add_message('An error occurred while trying to rename the file.');
						}
						//Rename preview file
						elseif(!@rename($this->config->item('preview_path','map').'/'.$old_name.'.png',
										$this->config->item('preview_path','map').'/'.$this->input->post('mapname').'.png'))
						{
							
							//Coudn't rename preview file? -> create new one
							if(FALSE && !$this->map_preview->create($data['file_name']))
							{
								$this->form_validation->add_message('Coundnt rename preview file.');
								$this->form_validation->add_message($this->map_preview->error_msg);
							}
							else
							{
								//FIXME: uncomment when map builder works
								// if(file_exists($this->config->item('preview_path','demo').'/'.$old_name.'.png'))
								// {
									// @unlink($this->config->item('preview_path','demo').'/'.$old_name.'.png');
								// }
							}
						}
						
						//Rename gameskin in DB
						$this->map->change_name(
							$this->input->post('id'), 
							$this->input->post('mapname')
						);
						
						$data['changed'] = $old_name;
					}
				}
				elseif($this->input->post('delete'))
				{
					$this->session->set_userdata('delete_map_id', $this->input->post('id'));
					$data['delete'] = $old_name;
					$data['delete_id'] = $this->input->post('id');
				}
				elseif($this->input->post('really_delete'))
				{
					if($this->input->post('id') != $this->session->userdata('delete_map_id'))
					{
						$this->form_validation->add_message('Delete ID doesn\'t match confirm ID.');
					}
					else
					{
						$this->session->unset_userdata('delete_map_id');
						$this->map->remove($this->input->post('id'));
						@unlink($this->config->item('upload_path','map').'/'.$old_name.'.png');
						@unlink($this->config->item('preview_path','map').'/'.$old_name.'.png');
						$data['delete'] = $old_name;
					}
					
				}
			}
		}

		$this->load->vars($data);
		$this->maps($order, $direction, $from);
	}

	function maps($order='new', $direction='desc', $from=0){
		list($limit, $sort) = $this->_sort($order, $direction, $from, 'map', $this->map->count_my_maps());
		
		$data = array();
		$data['uploads'] = $this->map->get_my_maps($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'maps';
		
		$this->template->set_subtitle('My maps');
		$this->template->view('my_images', $data);
	}

	// --------------------------------------------------------------------

	/**
	 * Map form editing
	 */	
	public function _post_mods($order='new', $direction='desc', $from=0)
	{
		$data = array();
		
		if($this->form_validation->run('is_id') === TRUE)
		{
			//Check id belongs to user and get name before renaming
			if(!$old_mod = $this->mod->get_my_mod($this->input->post('id')))
			{
				$this->form_validation->add_message('ID dosen\'t belong to you.');
			}
			else
			{
				//Reset validation
				$this->form_validation->reset_validation();
				
				if($this->input->post('change'))
				{
					//Changed name?
					if($old_mod->name !== $this->input->post('modname') && $this->form_validation->run('mod_name') === TRUE)
					{
						//Rename modfile
						if(!@rename($this->config->item('upload_path','mod').'/'.$old_mod->name.'.png',
									$this->config->item('upload_path','mod').'/'.$this->input->post('modname').'.png'))
						{
							$this->form_validation->add_message('An error occurred while trying to rename the file.');
						}
						
						//Rename mod in DB
						$this->mod->change_name(
							$this->input->post('id'), 
							$this->input->post('modname')
						);
						
						$data['changed'] = $old_mod->name;
					}
					
					//Changed checkboxes?
					if($old_mod->server != ($this->input->post('server') == "server"))
					{
						$this->mod->change_server(
							$this->input->post('id'), 
							!$old_mod->server
						);
						
						$data['changed'] = $old_mod->name;
					}
					if($old_mod->client != ($this->input->post('client') == "client"))
					{
						$this->mod->change_client(
							$this->input->post('id'), 
							!$old_mod->client
						);
						
						$data['changed'] = $old_mod->name;
					}
					
					//Changed name?
					$errors = $this->form_validation->error_array();
					$this->form_validation->reset_validation();
					if($old_mod->link !== $this->input->post('link') && $this->form_validation->run('mod_link') === TRUE)
					{
						$this->mod->change_link(
							$this->input->post('id'), 
							$this->input->post('link')
						);
						
						$data['changed'] = $old_mod->name;
					}
					$this->form_validation->add_message($errors);
					
					//New screenshot?
					if(isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name'] != "")
					{
						$this->upload->initialize($this->config->item('mod'));
						if($this->upload->do_upload('file'))
						{							
							//Upload data
							$data = $this->upload->data();
							
							//Create thumbnail
							$configResize['source_image'] = $data['full_path'];
							$configResize['new_image'] = $this->config->item('upload_path', 'mod').'/'.$this->input->post('modname').'.png';
							$configResize['width'] = $this->config->item('min_width', 'mod');
							$configResize['height'] = $this->config->item('min_height', 'mod');
							
							$this->image_lib->initialize($configResize);
							if(!$this->image_lib->resize())
							{
								//Add errors
								$this->form_validation->add_message($this->image_lib->error_msg);
								
								//Trackback upload
								@unlink($data['full_path']);
							}
							else
							{
								//Remove full image
								@unlink($data['full_path']);
						
								$data['changed'] = $old_mod->name;
							}
						}
						else
						{
							$this->form_validation->add_message($this->upload->error_msg);
						}
					}
				}
				elseif($this->input->post('delete'))
				{
					$this->session->set_userdata('delete_mod_id', $this->input->post('id'));
					$data['delete'] = $old_mod->name;
					$data['delete_id'] = $this->input->post('id');
				}
				elseif($this->input->post('really_delete'))
				{
					if($this->input->post('id') != $this->session->userdata('delete_mod_id'))
					{
						$this->form_validation->add_message('Delete ID doesn\'t match confirm ID.');
					}
					else
					{
						$this->session->unset_userdata('delete_mod_id');
						$this->mod->remove($this->input->post('id'));
						@unlink($this->config->item('upload_path','mod').'/'.$old_mod->name.'.png');
						$data['delete'] = $old_mod->name;
					}
					
				}
			}
		}

		$this->load->vars($data);
		$this->mods($order, $direction, $from);
	}

	function mods($order='new', $direction='desc', $from=0)
	{
		list($limit, $sort) = $this->_sort($order, $direction, $from, 'mod', $this->mod->count_my_mods());
		
		$data = array();
		$data['uploads'] = $this->mod->get_my_mods($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'mods';
		
		$this->template->set_subtitle('My mods');
		$this->template->view('my_mods', $data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Sorting and pageination
	 * 
	 * Check enum values for sorting
	 * 
	 * @access private
	 * @param string Order ENUM( new, rate, dw, name, author)
	 * @param string Direction desc or asc
	 * @param integer Limit offset
	 * @param string Type ENUM( skin, mapres, map, demo, mod, gameskin)
	 * @return array (limit, order_by)
	 */
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

	// --------------------------------------------------------------------
	
	//FIXME Old stuff:

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