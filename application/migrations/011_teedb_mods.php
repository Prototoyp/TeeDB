<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * TeeDB Mods Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_TeeDB_Mods extends MY_Migration {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->model(array('user/user', 'teedb/mod'));
	}
	
	/**
	 * Build table up
	 */	
	function up() 
	{	
		if ( ! $this->db->table_exists($this->mod->get_table()))
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
				// 'server' => array('type' => 'INT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
				// 'client' => array('type' => 'INT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
				// 'link' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
				// 'downloads' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
				// 'update' => array('type' => 'DATETIME', 'null' => FALSE),
				// 'create' => array('type' => 'DATETIME', 'null' => FALSE)
			// ));
// 
			// $this->dbforge->create_table(self::TABLE, TRUE);
			
            $this->db->query("
				CREATE TABLE IF NOT EXISTS ".$this->db->dbprefix($this->mod->get_table())." (
				  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `user_id` int(10) unsigned NOT NULL,
				  `server` int(1) unsigned NOT NULL DEFAULT '0',
				  `client` int(1) unsigned NOT NULL DEFAULT '0',
				  `link` varchar(255) NOT NULL,
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
		$this->dbforge->drop_table($this->mod->get_table());
	}
}

/* End of file 011_teedb_mods.php */
/* Location: ./application/migrations/011_teedb_mods.php */