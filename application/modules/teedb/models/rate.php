<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Rate Model Class
 *
 * @package		Application
 * @subpackage	Models
 * @category	Model
 * @author		Andreas Gehle
 */
class Rate extends CI_Model {
	
	const TABLE = 'teedb_rates';
	
	const TYPE_DEMO		= 'demo';
	const TYPE_GAMESKIN	= 'gameskin';
	const TYPE_MAPRES 	= 'mapres';
	const TYPE_MAP		= 'map';
	const TYPE_MOD 		= 'mod';
	const TYPE_SKIN 	= 'skin';
	
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->database();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Tablename
	 * 
	 * @access public
	 * @return integer
	 */	
	public function get_table()
	{
		return self::TABLE;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Set a new rate
	 * 
	 * @param string Type ENUM( skin, mapres, ...)
	 * @param integer ID of the entry to rate
	 * @param integer Value to rate. Can be 0 for 'flop' or 1 for 'top'
	 */
	public function set_rate($type, $id, $value)
	{
		if( ! $user_id = $this->auth->get_id())
		{
			return FALSE;
		}
		
		$data = array();
		
		$query = $this->db
		->select('value')
		->where('type_id', $id)
		->where('type', $type)
		->where('user_id', $user_id)
		->limit(1)
		->get(self::TABLE);
		
		if($query->num_rows())
		{
			$data['has_rated'] = $query->row()->value;
			
			$this->db
			->set('value', $value)
			->set('update', 'NOW()', FALSE)
			->where('type_id', $id)
			->where('type', $type)
			->where('user_id', $user_id)
			->update(self::TABLE);
		}
		else
		{
			$data['has_rated'] = -1;
			
			$this->db
			->set('value', $value)
			->set('type', $type)
			->set('type_id', $id)
			->set('user_id', $user_id)
			->set('update', 'NOW()', FALSE)
			->set('create', 'NOW()', FALSE)
			->insert(self::TABLE);
		}
		
		$query = $this->db
		->select('SUM(value) as sum, COUNT(*) AS count')
		->where('type_id', $id)
		->where('type', $type)
		->limit(1)
		->get(self::TABLE);
		
		if($query->num_rows())
		{
			$rate = $query->row();
			
			if($rate->count == 0)
			{
				$data['like'] = 50;
				$data['dislike'] = 50;
			}
			else
			{
				$proc = round($rate->sum/$rate->count)*90;
				$data['like'] = ($proc >= 10)? $proc : 10;
				$data['dislike'] = 100 - $data['like'];
			}
			return $data;
		}

		return FALSE;
	}
}