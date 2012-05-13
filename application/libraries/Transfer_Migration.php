<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Transfer_Migration extends MY_Migration {
	
	protected $old_db = NULL;
	
	/**
	 * Constructor
	 * 
	 * Initialize $old_db | Transfer DB object
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('file');
		
		if (!$this->old_db = $this->load->database('transfer', TRUE))
		{
			show_error('Cant connect to transfer DB.');
		}
		
		//Set error delimiters to nullstring
		if($this->load->library('form_validation'))
		{
			$this->form_validation->set_error_delimiters('','');
		}
		if($this->load->library('upload'))
		{
			$this->upload->set_error_delimiters('','');
		}
	}
	
	/**
	 * Show info about the amout of data transfered or deleted
	 * inc. google pie chart
	 * 
	 * @param	string	Title of the info/chart
	 * @param	integer	Amount of the full data (100%)
	 * @param	array 	Parts. Use {  {'part-title' => amount}, ...}
	 */
	protected function _output_info($title, $count, $parts = array())
	{
		$output = '';
		$chart_values = '';
		$chart_labels = '';
		
		$output .= '<strong>'.$title.': </strong><br>';
		$output .= 'Count: '.$count.'<br>';
		foreach ($parts as $part => $value) {
			$output .= $part.': '.$value.' ('.round(($value*100)/$count).'%)<br>';
			$chart_values .= round(($value*100)/$count).',';
			$chart_labels .= $part.'|';
		}
		$output .= '<br>------------------<br>';
		
		$chart_values = substr($chart_values, 0, -1);
		$chart_labels = substr($chart_labels, 0, -1);
		$output .= '<img src="http://chart.apis.google.com/chart?cht=p&chs=500x250&chd=t:'.$chart_values.'&chtt=Usertransfer&chl='.$chart_labels.'" />';
		
		return $output;
	}
	
}