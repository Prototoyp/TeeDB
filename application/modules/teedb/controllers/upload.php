<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends Request_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('inflector');
		$this->load->config('teedb/upload');
		$this->load->library(array('form_validation', 'upload'));
	}

	// --------------------------------------------------------------------
	
	/**
	 * On default use skin upload form
	 */
	public function index()
	{
		$this->skins();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Skin ajax/form upload
	 */
	public function _ajax_skins()
	{
		$this->set_multi_ajax(TRUE);
		$this->output->set_output($this->_upload_skins());
	}
	
	public function _post_skins()
	{
		$data = array();
		$data['type'] = 'skins';
		$data['uploads'] = $this->_upload_skins();
		
		$this->template->set_subtitle('Upload skins');
		$this->template->view('upload', $data);
	}
	
	public function skins()
	{
		$this->_upload_form('skins');
	}

	// --------------------------------------------------------------------
		
	/**
	 * Mapres ajax/form upload
	 */
	public function _ajax_mapres()
	{
		$this->set_multi_ajax(TRUE);
		$this->output->set_output($this->_upload_mapres());
	}
	
	public function _post_mapres()
	{
		$data = array();
		$data['type'] = 'mapres';
		$data['uploads'] = $this->_upload_mapres();
		
		$this->template->set_subtitle('Upload mapres');
		$this->template->view('upload', $data);
	}
	
	public function mapres()
	{
		$this->_upload_form('mapres');
	}

	// --------------------------------------------------------------------
		
	/**
	 * Maps ajax/form upload
	 */
	public function _ajax_maps()
	{
		$this->set_multi_ajax(TRUE);
		$this->output->set_output($this->_upload_maps());
	}
	
	public function _post_maps()
	{
		$data = array();
		$data['type'] = 'maps';
		$data['uploads'] = $this->_upload_maps();
		
		$this->template->set_subtitle('Upload maps');
		$this->template->view('upload', $data);
	}
	
	public function maps()
	{
		$this->_upload_form('maps');
	}

	// --------------------------------------------------------------------
		
	/**
	 * Demos ajax/form upload
	 */
	public function _ajax_demos()
	{
		$this->set_multi_ajax(TRUE);
		$this->output->set_output($this->_upload_demos());
	}
	
	public function _post_demos()
	{
		$data = array();
		$data['type'] = 'demos';
		$data['uploads'] = $this->_upload_demos();
		
		$this->template->set_subtitle('Upload demos');
		$this->template->view('upload', $data);
	}
	
	public function demos()
	{
		$this->_upload_form('demos');
	}

	// --------------------------------------------------------------------
		
	/**
	 * Gameskins ajax/form upload
	 */
	public function _ajax_gameskins()
	{
		$this->set_multi_ajax(TRUE);
		$this->output->set_output($this->_upload_gameskins());
	}
	
	public function _post_gameskins()
	{
		$data = array();
		$data['type'] = 'gameskins';
		$data['uploads'] = $this->_upload_gameskins();
		
		$this->template->set_subtitle('Upload gameskins');
		$this->template->view('upload', $data);
	}
	
	public function gameskins()
	{
		$this->_upload_form('gameskins');
	}

	// --------------------------------------------------------------------
		
	/**
	 * Mods ajax/form upload
	 */
	public function _ajax_mods()
	{
		$this->set_multi_ajax(TRUE);
		$this->output->set_output($this->_upload_mods());
	}
	
	public function _post_mods()
	{
		$data = array();
		$data['type'] = 'mods';
		$data['uploads'] = $this->_upload_mods();
		
		$this->template->set_subtitle('Upload mods');
		$this->template->view('upload', $data);
	}
	
	public function mods()
	{
		$this->_upload_form('mods');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Upload form
	 */
	private function _upload_form($type = 'skins')
	{
		$this->template->set_subtitle('Upload '.$type);
		$this->template->view('upload', array('type' => $type));
	}

	// --------------------------------------------------------------------
	
	/**
	 * Upload handler
	 */
	
	/**
	 * Upload skins and create previews
	 */
	private function _upload_skins()
	{
		$this->load->model('teedb/skin');
		$this->load->library('teedb/Skin_preview');
		
		$upload_data = $this->_upload('skin');
		
		foreach ($upload_data as $key => $data)
		{
			//Create skin previews
			if(!$this->skin_preview->create($data['file_name']))
			{
				//Add errors
				foreach($this->skin_preview->error_msg as $error)
				{
					$this->form_validation->add_message($error.' ('.$data['file_name'].')');
				}
				//Trackback upload
				@unlink($data['full_path']);
				//Delete from data array
				unset($upload_data[$key]);
			}
			else
			{
				//Extend upload data
				$upload_data[$key]['preview'] = base_url(($this->config->item('preview_path', 'skin')).'/'.$data['file_name']);
				$this->skin->setSkin($data['raw_name']);
			}
		}
		return $upload_data;
	}
	
	
	/**
	 * Upload mapres and create thumbnails
	 */
	private function _upload_mapres()
	{
		$this->load->model('teedb/tileset');
		$this->load->library('image_lib');
		
		$upload_data = $this->_upload('mapres');
		
		foreach ($upload_data as $key => $data)
		{
			//Create thumbnail
			$configResize['source_image'] = $data['full_path'];
			$configResize['new_image'] = $this->config->item('preview_path', 'mapres');
			$configResize['width'] = 110;
			$configResize['height'] = 64;
			
			$this->image_lib->initialize($configResize);
			if(!$this->image_lib->resize())
			{
				//Add errors
				foreach($this->image_lib->error_msg as $error)
				{
					$this->form_validation->add_message($error.' ('.$data['file_name'].')');
				}
				//Trackback upload
				@unlink($data['full_path']);
				//Delete from data array
				unset($upload_data[$key]);
			}
			else
			{
				//Resize again to fit width too
				$this->image_lib->clear();
				$this->image_lib->initialize($configResize);
				if(!$this->image_lib->resize())
				{
					//Add errors
					foreach($this->image_lib->error_msg as $error)
					{
						$this->form_validation->add_message($error.' ('.$data['file_name'].')');
					}
					//Trackback upload
					@unlink($data['full_path']);
					//Delete from data array
					unset($upload_data[$key]);
				}
				else
				{
					//Extend upload data
					$upload_data[$key]['preview'] = base_url(($this->config->item('preview_path', 'mapres')).'/'.$data['file_name']);
					$this->tileset->setMapres($data['raw_name']);
				}
			}
			$this->image_lib->clear();
		}
		return $upload_data;
	}
	
	/**
	 * Upload gameskins and create thumbnails
	 */
	private function _upload_gameskins()
	{
		$this->load->model('teedb/gameskin');
		$this->load->library('image_lib');
		
		$upload_data = $this->_upload('gameskin');
		
		foreach ($upload_data as $key => $data)
		{
			//Create thumbnail
			$configResize['source_image'] = $data['full_path'];
			$configResize['new_image'] = $this->config->item('preview_path', 'gameskin');
			$configResize['width'] = 110;
			$configResize['height'] = 64;
			
			$this->image_lib->initialize($configResize);
			if(!$this->image_lib->resize())
			{
				//Add errors
				foreach($this->image_lib->error_msg as $error)
				{
					$this->form_validation->add_message($error.' ('.$data['file_name'].')');
				}
				//Trackback upload
				@unlink($data['full_path']);
				//Delete from data array
				unset($upload_data[$key]);
			}
			else
			{
				//Extend upload data
				$upload_data[$key]['preview'] = base_url(($this->config->item('preview_path', 'gameskin')).'/'.$data['file_name']);
				$this->gameskin->setGameskin($data['raw_name']);
			}
			$this->image_lib->clear();
		}
		return $upload_data;
	}
	
	/**
	 * Upload maps, create preview and map2image
	 * 
	 * FIXME: map_preview create preview instead of static 'not avaible'-image
	 */
	private function _upload_maps()
	{
		$this->load->model('teedb/map');
		//$this->load->library('teedb/Map_preview');
		
		$upload_data = $this->_upload('map');
		
		foreach ($upload_data as $key => $data)
		{
			//Create preview
			if(FALSE && !$this->map_preview->create($data['file_name']))
			{
				//Add errors
				foreach($this->map_preview->error_msg as $error)
				{
					$this->form_validation->add_message($error.' ('.$data['file_name'].')');
				}
				//Trackback upload
				@unlink($data['full_path']);
				//Delete from data array
				unset($upload_data[$key]);
			}
			else
			{
				//Extend upload data
				//$upload_data[$key]['preview'] = base_url(($this->config->item('preview_path', 'map')).'/'.$data['file_name']);
				$upload_data[$key]['preview'] = base_url('assets/images/nopic_map.png');
				$this->map->setMap($data['raw_name']);
			}
		}
		return $upload_data;
	}
	
	/**
	 * Upload demos and create preview of used map
	 * 
	 * FIXME: demo_preview create preview instead of static 'not avaible'-image
	 */
	private function _upload_demos()
	{
		$this->load->model('teedb/demo');
		//$this->load->library('teedb/Demo_preview');
		
		$upload_data = $this->_upload('demo');
		
		foreach ($upload_data as $key => $data)
		{
			//Create preview
			if(FALSE && !$this->demo_preview->create($data['file_name']))
			{
				//Add errors
				foreach($this->demo_preview->error_msg as $error)
				{
					$this->form_validation->add_message($error.' ('.$data['file_name'].')');
				}
				//Trackback upload
				@unlink($data['full_path']);
				//Delete from data array
				unset($upload_data[$key]);
			}
			else
			{
				//Extend upload data
				//$upload_data[$key]['preview'] = base_url(($this->config->item('preview_path', 'demo')).'/'.$data['file_name']);
				$upload_data[$key]['preview'] = base_url('assets/images/nopic_demo.png');
				$this->demo->setDemo($data['raw_name']);
			}
		}
		return $upload_data;
	}
	
	/**
	 * Upload mod preview image and validate form data
	 */
	private function _upload_mods()
	{
		$this->load->model('teedb/mod');
		$this->load->library('image_lib');
		
		if(!$this->auth->logged_in())
		{
			$this->form_validation->add_message('You have to login.');
			return array();
		}
		
		if ($this->form_validation->run('mod') === FALSE)
		{
			return array();
		}
		
		//Upload preview image files
		$this->upload->initialize($this->config->item('mod'));
		if(!$this->upload->do_upload('file'))
		{
			return array();
		}
		
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
			//Delete data array
			unset($data);
		}
		else
		{
			//Extend upload data
			@unlink($data['full_path']);
			
			$data = array();
			$data[0]['preview'] = base_url($configResize['new_image']);
			$data[0]['raw_name'] = $this->input->post('modname');
			$data[0]['file_name'] = $this->input->post('modname');
					
			$this->mod->setMod(
				$this->input->post('modname'),
				$this->input->post('link'),
				(bool) $this->input->post('server'),
				(bool) $this->input->post('client')
			);
		}
		
		return $data;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Upload multiple files
	 * 
	 * @param array Config-array
	 * @return array Upload-data successful
	 */
	private function _upload($config)
	{
		if(!$this->auth->logged_in())
		{
			$this->form_validation->add_message('You have to login.');
			return array();
		}
		
		//Upload files
		$this->upload->initialize($this->config->item($config));
		return $this->upload->do_multi_upload('file');
	}
	
	//-------------------------------------------------------
}