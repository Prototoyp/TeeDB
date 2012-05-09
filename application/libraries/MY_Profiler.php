<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Profiler extends CI_Profiler{

	// --------------------------------------------------------------------

	public function __construct($config = array())
	{
		parent::__construct($config);
		array_unshift($this->_available_sections, 'view_data');		
		
		if ( ! isset($config['view_data']))
		{
			$this->_compile_{'view_data'} = TRUE;
		}
		
		$this->set_sections($config);
	}

	// --------------------------------------------------------------------

	/**
	 * Compile view vars
	 * 
	 * FIXME: 'View data array' TO $this->CI->lang->line('profiler_post_data')
	 * FIXME: 'No view data set' TO $this->CI->lang->line('profiler_no_post')
	 *
	 * @return	string
	 */
	protected function _compile_view_data()
	{
		$data = $this->CI->load->get_vars();
		
		$output = "\n\n"
			. '<fieldset id="ci_profiler_vars" style="border:1px solid #10A;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">'
			. "\n"
			. '<legend style="color:#10A;">&nbsp;&nbsp;'.'View vars'.'&nbsp;&nbsp;</legend>'
			. "\n";

		if (count($data) == 0)
		{
			$output .= "<div style='color:#10A;font-weight:normal;padding:4px 0 4px 0'>".'No view data set.'."</div>";
		}
		else
		{
			$output .= "\n\n<table style='width:100%'>\n";

			foreach ($data as $key => $val)
			{
				// if ( ! is_numeric($key))
				// {
					// $key = "'".$key."'";
				// }
				
				if(is_object($val))
				{
					$val = $this->_obj_to_array($val);
				}
				
				$output .= "<tr><td style='width:50%;padding:5px;color:#000;background-color:#ddd;'>&#36;".$key."&nbsp;&nbsp; </td><td style='width:50%;padding:5px;color:#10A;font-weight:normal;background-color:#ddd;'>";
				if (is_array($val))
				{
					$output .= "<pre>" . htmlspecialchars(stripslashes(print_r($val, TRUE))) . "</pre>";
				}
				else
				{
					$output .= htmlspecialchars(stripslashes($val));
				}
				$output .= "</td></tr>\n";
			}

			$output .= "</table>\n";
		}

		return $output.'</fieldset>';
	}

 	/**
    * Convert an object to an array
    *
    * @param object $object The object to convert
    * @return array
    */
    private function _obj_to_array( $object )
    {
        if( !is_object( $object ) && !is_array( $object ) )
        {
            return $object;
        }
        if( is_object( $object ) )
        {
            $object = get_object_vars( $object );
        }
        return array_map( array($this,'_obj_to_array'), $object );
    }
}

// END CI_Profiler class

/* End of file Profiler.php */
/* Location: ./system/libraries/Profiler.php */
