<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Map Model Class
 *
 * @package		Application
 * @subpackage	Models
 * @category	Model
 * @author		Andreas Gehle
 */
class Gameskin extends CI_Model {
	
	const TABLE = 'teedb_gameskins';
		
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->database();
		$this->load->model(array('user', 'teedb/rate'));
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
	 * Count mapres
	 * 
	 * @access public
	 * @return integer
	 */	
	public function count_gameskins()
	{
		return $this->db->count_all(self::TABLE);
	}	

	// --------------------------------------------------------------------
	
	/**
	 * Get a all gameskins
	 * 
	 * @access public
	 * @param integer limit
	 * @param integer offset
	 * @param string order
	 * @param string direction
	 * @return string Gameskin name
	 */	
	public function get_gameskins($limit, $offset='0', $order='update', $direction='DESC')
	{
		$query = $this->db
		->select('gameskin.id, gameskin.name, gameskin.downloads, user.name AS username, gameskin.create')
		->select('SUM(rate.value) AS rate_sum, COUNT(rate.user_id) AS rate_count')
		->from(self::TABLE.' as gameskin')
		->join(User::TABLE.' as user', 'gameskin.user_id = user.id')
		->join(Rate::TABLE.' as rate', 'gameskin.id = rate.type_id AND rate.type = "gameskin"', 'left')
		->order_by($order, $direction)
		->group_by('gameskin.id')
		->limit($limit, $offset)
		->get();
		
		return $query->result();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Count user demos
	 * 
	 * @access public
	 * @return integer
	 */	
	public function count_my_gameskins()
	{
		$this->db
			->from(self::TABLE.' as gameskin')
			->join(User::TABLE.' as user', 'gameskin.user_id = user.id')
			->where('user.id', $this->auth->get_id());		
		
		return $this->db->count_all_results();
	}	

	// --------------------------------------------------------------------
	
	/**
	 * Get a all gameskins
	 * 
	 * @access public
	 * @param integer limit
	 * @param integer offset
	 * @param string order
	 * @param string direction
	 * @return string Gameskin name
	 */	
	public function get_my_gameskins($limit, $offset='0', $order='update', $direction='DESC')
	{
		$query = $this->db
		->select('gameskin.id, gameskin.name, gameskin.downloads, user.name AS username, gameskin.create')
		->select('SUM(rate.value) AS rate_sum, COUNT(rate.user_id) AS rate_count')
		->from(self::TABLE.' as gameskin')
		->join(User::TABLE.' as user', 'gameskin.user_id = user.id')
		->join(Rate::TABLE.' as rate', 'gameskin.id = rate.type_id AND rate.type = "gameskin"', 'left')
		->where('user.id', $this->auth->get_id())
		->order_by($order, $direction)
		->group_by('gameskin.id')
		->limit($limit, $offset)
		->get();
		
		return $query->result();
	}

	// --------------------------------------------------------------------
	
	public function setGameskin($name = null){
		if(!$name and !$name = $this->input->post('name') or
			!$this->auth and !$this->auth->logged_in()){
			return false;
		}
		
		$this->db->set('name', $name);
		$this->db->set('user_id', $this->auth->get_id());
		$this->db->set('update', 'NOW()', FALSE);
		$this->db->set('create', 'NOW()', FALSE);
		$this->db->insert(self::TABLE);
		
		return $this->db->insert_id();
	}
	
	public function get_name($id)
	{
		$query = $this->db
		->select('name')
		->where('id', $id)
		->get(self::TABLE);
		
		return $query->row()->name;
	}
	
	public function get_my_name($id)
	{
		$query = $this->db
		->select('name')
		->where('id', $id)
		->where('user_id', $this->auth->get_id())
		->get(self::TABLE);
		
		return $query->row()->name;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Change skinname
	 * 
	 * @access public
	 * @param string skin id
	 * @param string skin name
	 * @return integer user id
	 */
	public function change_name($id, $name)
	{		
		return $this->db
		->set('name', $name)
		->set('update', 'NOW()', FALSE)
		->where('id', $id)
		->update(self::TABLE);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Remove skin
	 * 
	 * @access public
	 * @param integer user id
	 * @return db-obj user
	 */
	public function remove($id)
	{
		return $this->db
		->where('id', $id)
		->limit(1)
		->delete(self::TABLE);
	}

	// --------------------------------------------------------------------
}

/* End of file: gameskin.php */
/* Location: application/modules/teedb/models/gameskin.php */