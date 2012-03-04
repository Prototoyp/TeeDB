<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Profiler
{
    private $CI;
    
    public function enable()
    {
        $this->CI =& get_instance();
        
        $this->CI->output->enable_profiler(TRUE);
    }
}

/* End of file profiler.php */
/* Location: ./system/application/hools/profiler.php */