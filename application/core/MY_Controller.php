<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
	
	function __construct()
	{
		parent::__construct();
		
		if(ENVIRONMENT == 'development')
		{
			$this->output->enable_profiler(TRUE);
		}
        
		//For user module
        if($this->load->is_loaded('auth'))
		{
			//Set rediction after login
			if( ! $this->auth->logged_in())
			{
				$this->auth->set_redirect_from();
			}
			
			//Display admin nav
			elseif($this->auth->is_admin())
			{
				$this->template->show_admin_bar();
			}
		}
		
        // If the user is using a mobile, use a mobile theme
        // $this->load->library('user_agent');
        // if( $this->agent->is_mobile() )
        // {
            // $this->template->set_theme('mobile');
        // }
        
        //Running on command-line
        // if($this->input->is_cli_request())
		// {
			// //...
		// }
	}
	
}