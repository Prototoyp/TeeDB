<?php //Old teedb upload validation

function skins_submit()
	{
		if($this->input->post('name') === FALSE 
			or isset($_FILES['file']['name']) and !empty($_FILES['file']['name'])){
			$this->file('skin');
			return;
		}
			
		if($this->_skin_validate() === FALSE) {
			$data['upload_data'] = array('raw_name' => $this->input->post('raw_name'),
				'file_size' => $this->input->post('file_size'));
			$this->load->view('skin/upload', $data);
			return;
		}
		if($this->input->post('name') != $this->input->post('raw_name')){
			if(is_file('upload/skins/'.$this->input->post('name').'.png')){
				unlink('upload/skins/'.$this->input->post('name').'.png');
				unlink('upload/skins/previews/'.$this->input->post('name').'.png');
			}
			if(is_file('upload/skins/'.$this->input->post('raw_name').'.png')){
				rename('upload/skins/'.$this->input->post('raw_name').'.png', 
					'upload/skins/'.$this->input->post('name').'.png');
				rename('upload/skins/previews/'.$this->input->post('raw_name').'.png', 
					'upload/skins/previews/'.$this->input->post('name').'.png');
			}
		}
		$this->load->model('skin');
		$this->skin->setSkin();		
		$data['submit']=true;	
		$this->load->view('skin/upload', $data);
	}
	
	function _mapres()
	{
		if($this->input->post('name') === FALSE 
			or isset($_FILES['file']['name']) and !empty($_FILES['file']['name'])){
			$this->file('mapres');
			return;
		}
			
		if($this->_mapres_validate() === FALSE) {
			$data['upload_data'] = array('raw_name' => $this->input->post('raw_name'),
				'file_size' => $this->input->post('file_size'));
			$this->load->view('mapres/upload', $data);
			return;
		}
		if($this->input->post('name') != $this->input->post('raw_name')){
			if(is_file('upload/mapress/'.$this->input->post('name').'.png')){
				unlink('upload/mapress/'.$this->input->post('name').'.png');
				unlink('upload/mapress/previews/'.$this->input->post('name').'.png');
			}
			if(is_file('upload/mapress/'.$this->input->post('raw_name').'.png')){
				rename('upload/mapress/'.$this->input->post('raw_name').'.png', 
					'upload/mapress/'.$this->input->post('name').'.png');
				rename('upload/mapress/previews/'.$this->input->post('raw_name').'.png', 
					'upload/mapress/previews/'.$this->input->post('name').'.png');
			}
		}
		$this->load->model('Mapres');
		$this->Mapres->setMapres();		
		$data['submit']=true;	
		$this->load->view('mapres/upload', $data);
	}
	
	function _skin_validate()
	{
		$this->form_validation->set_rules('name', 'Skinname',
			'required|alpha_numeric|min_length[3]|max_length[15]|unique[Skin.name]');
		$this->form_validation->set_rules('raw_name', 'Filename',
			'required|alpha_dash');
		$this->form_validation->set_rules('file_size', 'Filesize',
			'required|numeric');

		return $this->form_validation->run();
	}
	
	function _mapres_validate()
	{
		$this->form_validation->set_rules('name', 'Mapresname',
			'required|alpha_numeric|min_length[3]|max_length[15]|unique[Skin.name]');
		$this->form_validation->set_rules('raw_name', 'Filename',
			'required|alpha_dash');
		$this->form_validation->set_rules('file_size', 'Filesize',
			'required|numeric');

		return $this->form_validation->run();
	}
	
	function skinpreview()
	{		
		if($this->_skinpreview_validate() === FALSE) {
			$data['upload_data'] = array('raw_name' => $this->input->post('raw_name'),
				'file_size' => $this->input->post('file_size'));
			if($this->input->post('name'))
				$data['upload_data']['name'] = $this->input->post('name');
			$this->load->view('skin/upload', $data);
			return;
		}
		$data['upload_data'] = array('raw_name' => $this->input->post('raw_name'),
			'file_size' => $this->input->post('file_size'));
		if($this->input->post('name'))
			$data['upload_data']['name'] = $this->input->post('name');
		$data['refresh'] = TRUE;
		
		$this->load->library('teepreview');
		$this->teepreview->create_tee(base_url().'/upload/skins/'.$this->input->post('raw_name').'.png');	
		$this->load->view('skin/upload', $data);	
	}
	
	function _skinpreview_validate()
	{
		$this->form_validation->set_rules('raw_name', 'Filename',
			'required|alpha_dash');

		return $this->form_validation->run();
	}