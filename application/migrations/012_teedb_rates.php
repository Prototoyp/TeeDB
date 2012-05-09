<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * TeeDB Rates Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_TeeDB_Rates extends MY_Migration {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->model(array('user/user', 'teedb/rate'));
	}
	
	/**
	 * Build table up
	 */	
	function up() 
	{	
		if ( ! $this->db->table_exists($this->rate->get_table()))
		{
			// Setup Keys
			// $this->dbforge->add_key('id', TRUE);
			// $this->dbforge->add_key('user_id');
// 			
			// $this->dbforge->add_field(array(
				// 'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				// 'type_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				// 'type' => array('type' => 'ENUM', 'constraint' => "'skin','mapres','map','gameskin','mod','demo'", 'null' => FALSE),
				// 'user_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				// 'value' => array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
				// 'update' => array('type' => 'DATETIME', 'null' => FALSE),
				// 'create' => array('type' => 'DATETIME', 'null' => FALSE)
			// ));
// 
			// $this->dbforge->create_table(self::TABLE, TRUE);
			
            $this->db->query("
				CREATE TABLE IF NOT EXISTS ".$this->db->dbprefix($this->rate->get_table())." (
				  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `type_id` int(10) unsigned NOT NULL,
				  `type` enum('skin','mapres','map','gameskin','mod','demo') NOT NULL,
				  `user_id` int(10) unsigned NOT NULL,
				  `value` tinyint(1) unsigned NOT NULL DEFAULT '0',
				  `update` datetime NOT NULL,
				  `create` datetime NOT NULL,
				  PRIMARY KEY (`id`),
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
		$this->dbforge->drop_table($this->rate->get_table());
	}
}

/* End of file 012_teedb_rates.php */
/* Location: ./application/migrations/012_teedb_rates.php */