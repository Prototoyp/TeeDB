<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migrate extends MY_Controller {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		//IMPORTATNT: Enable Migratetion in config file only if needed
		//Set to false up after working.
		$this->load->library(array('migration', 'form_validation'));
		$this->load->helper('form');
		
		$this->load->config('migration');
		$this->template->set_theme('default');
	}
	
	function index()
	{
		$data['enabled'] = $this->config->item('migration_enabled');
		$data['config'] = $this->config->item('migration_version');
		$data['current'] = $this->migration->get_version();
		
		$data['versions'] = array();
		$files = $this->migration->get_migrations();
		$data['latest'] = count($files);
		for($version = 1, $count = $data['latest']; $version <= $count; $version++)
		{
			$data['versions'][$version] = basename($files[$version-1], '.php');
		}
		
		$this->template->set_subtitle('Migration');
		$this->template->view('migrate', $data);
	}

	// --------------------------------------------------------------------

	/**
	 * Migrate current
	 * 
	 * This will migrate to the configed migration version
	 */
	public function current()
	{
		if ( ! $this->migration->current())
		{
			$errors = $this->migration->error_string();
			
			if($errors === '')
			{
				$this->form_validation->add_message('Coundn\'t migrate to recommended version. Error unknown.');
			}
			else
			{
				$this->form_validation->add_message($this->migration->error_string());
			}
		}
		else
		{
			$this->template->add_success_msg('Migrate to recommended version successful.');
		}

		$this->index();
	}

	// --------------------------------------------------------------------

	/**
	 * Migrate latest
	 * 
	 * This will migrate to the latest migration version
	 */
	public function latest()
	{
		if ( ! $this->migration->latest())
		{
			$errors = $this->migration->error_string();
			
			if($errors === '')
			{
				$this->form_validation->add_message('Coundn\'t migrate to latest version. Error unknown.');
			}
			else
			{
				$this->form_validation->add_message($this->migration->error_string());
			}
		}
		else
		{
			$this->template->add_success_msg('Migrate to latest version successful.');
		}

		$this->index();
	}

	// --------------------------------------------------------------------

	/**
	 * Migrate to version
	 * 
	 * This will migrate up/down to the given migration version
	 * 
	 * @param int
	 * @return void
	 */
	public function version($id = NULL)
	{
		$this->form_validation->set_rules('version', 'version', 'trim|required|is_natural_no_zero');
		
		if ($this->form_validation->run() == TRUE)
		{
			$id = $this->input->post('version');
		}
		else
		{
			if($this->input->post('version_migrate'))
			{
				//id has been sent by form and we have errors
				$this->index();
				return;
			}
			else
			{
				if(is_null($id))
				{
					$this->form_validation->add_message('The version id must be set in the URL or use the form.');
					$this->index();
					return;
				}
			}
		}

		//migrate to version
		if ( ! $this->migration->version($id))
		{
			$errors = $this->migration->error_string();
			
			if($errors === '')
			{
				$this->form_validation->add_message('Coundn\'t migrate to version '.$id.'. Error unknown.');
			}
			else
			{
				$this->form_validation->add_message($this->migration->error_string());
			}
		}
		else
		{
			$this->template->add_success_msg('Migrate to version '.$id.' successful.');
		}

		$this->index();
	}
}

/* End of file migrate.php */
/* Location: ./application/controllers/migrate.php */