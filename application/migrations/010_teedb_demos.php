<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * TeeDB Demos Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_TeeDB_Demos extends CI_Migration {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->model(array('user/user', 'teedb/demo'));
	}
	
	/**
	 * Build table up
	 */	
	function up() 
	{	
		if ( ! $this->db->table_exists($this->demo->get_table()))
		{
			// Setup Keys
			// $this->dbforge->add_key('id', TRUE);
			// $this->dbforge->add_key('user_id');
			// $this->dbforge->add_field("UNIQUE KEY `name` (`name`)");
// 			
			// $this->dbforge->add_field(array(
				// 'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				// 'name' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
				// 'user_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				// 'discription' => array('type' => 'TEXT', 'null' => FALSE),
				// 'downloads' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
				// 'update' => array('type' => 'DATETIME', 'null' => FALSE),
				// 'create' => array('type' => 'DATETIME', 'null' => FALSE)
			// ));
// 
			// $this->dbforge->create_table(self::TABLE, TRUE);
			
            $this->db->query("
				CREATE TABLE IF NOT EXISTS ".$this->db->dbprefix($this->demo->get_table())." (
				 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `user_id` int(10) unsigned NOT NULL,
				  `discription` text NOT NULL,
				  `downloads` int(10) unsigned NOT NULL DEFAULT '0',
				  `update` datetime NOT NULL,
				  `create` datetime NOT NULL,
				  PRIMARY KEY (`id`),
				  UNIQUE KEY `name` (`name`),
				  KEY `user_id` (`user_id`),
				  FOREIGN KEY (`user_id`) REFERENCES ".$this->db->dbprefix($this->user->get_table())." (`id`) ON DELETE CASCADE ON UPDATE CASCADE
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
         	");
		}
	}

	/**
	 * Build table down
	 */
	function down() 
	{
		$this->dbforge->drop_table($this->demo->get_table());
	}
}

/* End of file 010_teedb_demos.php */
/* Location: ./application/migrations/010_teedb_demos.php */