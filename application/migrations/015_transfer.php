<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Old TeeDB database-data and upload transfer Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_Transfer extends CI_Migration {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->library('user/auth');
		$this->load->model(array('user/user','teedb/skin'));
	}
	
	/**
	 * Build table up
	 */	
	function up() 
	{	
		$config['hostname'] = "localhost";
		$config['username'] = "";
		$config['password'] = "";
		$config['database'] = "twdoodads";
		$config['dbdriver'] = "mysql";
		$config['dbprefix'] = "tw_";
		$config['pconnect'] = FALSE;
		$config['db_debug'] = TRUE;
		$config['cache_on'] = FALSE;
		$config['cachedir'] = "";
		$config['char_set'] = "utf8";
		$config['dbcollat'] = "utf8_general_ci";
		
		if ($old_db = $this->load->database($config, TRUE))
		{
			//Build user password translate table
			$this->dbforge->add_field(array(
				'old_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'user_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'password' => array('type' => 'VARCHAR', 'constraint' => 32, 'null' => FALSE)
			));
			
			//Transfer the data
			
			//Userdata
			$old_users = $old_db->select('*')->get('user');
			
			//Ignore/ remove not yet confirmed users
			
			//Check usernames (alphanumeric)
			
			//Check valid email
			
			//Translate username, email, reg_date
			
			//Translate password
		}
	}

	/**
	 * Build table down
	 */
	function down() 
	{
		$this->db->empty_table($this->user->get_table()); 
		//$this->db->empty_table($this->skin->get_table()); 
	}
}

/* End of file 012_teedb_rates.php */
/* Location: ./application/migrations/012_teedb_rates.php */