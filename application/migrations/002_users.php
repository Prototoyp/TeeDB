<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_Users extends CI_Migration {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->model('user/user');
	}
	
	/**
	 * Build table up
	 */	
	function up() 
	{	
		if ( ! $this->db->table_exists($this->user->get_table()))
		{
			// Setup Keys
			// $this->dbforge->add_key('id', TRUE);
			// $this->dbforge->add_field("UNIQUE KEY `name` (`name`)");
			// $this->dbforge->add_field("UNIQUE KEY `email` (`email`)");
// 			
			// $this->dbforge->add_field(array(
				// 'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				// 'name' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
				// 'password' => array('type' => 'VARCHAR', 'constraint' => '40', 'null' => FALSE),
				// 'email' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
				// 'status' => array('type' => 'INT', 'constraint' => 4, 'null' => FALSE, 'default' => 0),
				// 'update' => array('type' => 'DATETIME', 'null' => FALSE),
				// 'create' => array('type' => 'DATETIME', 'null' => FALSE)
			// ));
// 
			// $this->dbforge->create_table(self::TABLE, TRUE);
			
			
            $this->db->query("
				CREATE TABLE IF NOT EXISTS ".$this->db->dbprefix($this->user->get_table())." (
				  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `password` varchar(40) NOT NULL,
				  `email` varchar(255) NOT NULL,
				  `status` int(4) NOT NULL DEFAULT '0',
				  `update` datetime NOT NULL,
				  `create` datetime NOT NULL,
				  PRIMARY KEY (`id`),
				  UNIQUE KEY `name` (`name`),
				  UNIQUE KEY `email` (`email`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
         	");
		}
	}

	/**
	 * Build table down
	 */
	function down() 
	{
		$this->dbforge->drop_table($this->user->get_table());
	}
}

/* End of file 002_users.php */
/* Location: ./application/migrations/002_users.php */