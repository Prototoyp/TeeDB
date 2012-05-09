<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User Confirm Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_User_Confirms extends MY_Migration {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->model(array('user/user', 'user/confirm'));
	}
	
	/**
	 * Build table up
	 */	
	function up() 
	{	
		if ( ! $this->db->table_exists($this->confirm->get_table()))
		{
			// Setup Keys
			// $this->dbforge->add_key('id', TRUE);
			// $this->dbforge->add_field("KEY `user_id` (`user_id`)");
			// $this->dbforge->add_field("UNIQUE KEY `link` (`link`)");
// 			
			// $this->dbforge->add_field(array(
				// 'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				// 'user_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				// 'link' => array('type' => 'VARCHAR', 'constraint' => '32', 'null' => FALSE),
				// 'password' => array('type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE, 'default' => NULL),
				// 'update' => array('type' => 'DATETIME', 'null' => FALSE),
				// 'create' => array('type' => 'DATETIME', 'null' => FALSE)
			// ));
// 
			// $this->dbforge->create_table(self::TABLE, TRUE);
			
            $this->db->query("
				CREATE TABLE IF NOT EXISTS ".$this->db->dbprefix($this->confirm->get_table())." (
				  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `user_id` int(10) unsigned NOT NULL,
				  `link` varchar(32) NOT NULL,
				  `password` varchar(40) DEFAULT NULL,
				  `update` datetime NOT NULL,
				  `create` datetime NOT NULL,
				  PRIMARY KEY (`id`),
				  UNIQUE KEY `link` (`link`),
				  UNIQUE KEY `user_id` (`user_id`),
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
		$this->dbforge->drop_table($this->confirm->get_table());
	}
}

/* End of file 003_user_confirms.php */
/* Location: ./application/migrations/003_user_confirms.php */