<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Comments Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_Comments extends CI_Migration {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->model(array('user/user', 'blog/blog', 'blog/comment'));
	}
	
	/**
	 * Build table up
	 */	
	function up() 
	{	
		if ( ! $this->db->table_exists($this->comment->get_table()))
		{
			// Setup Keys
			// $this->dbforge->add_key('id', TRUE);
			// $this->dbforge->add_key('user_id');
// 			
			// $this->dbforge->add_field(array(
				// 'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				// 'user_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				// 'comment' => array('type' => 'TEXT', 'null' => FALSE),
				// 'news_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				// 'update' => array('type' => 'DATETIME', 'null' => FALSE),
				// 'create' => array('type' => 'DATETIME', 'null' => FALSE)
			// ));
// 
			// $this->dbforge->create_table(self::TABLE, TRUE);
			
            $this->db->query("
				CREATE TABLE IF NOT EXISTS ".$this->db->dbprefix($this->comment->get_table())." (
				  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `user_id` int(10) unsigned NOT NULL,
				  `comment` text NOT NULL,
				  `news_id` int(10) unsigned NOT NULL,
				  `update` datetime NOT NULL,
				  `create` datetime NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `user_id` (`user_id`),
				  KEY `news_id` (`news_id`),
				  FOREIGN KEY (`user_id`) REFERENCES ".$this->db->dbprefix($this->user->get_table())." (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
				  FOREIGN KEY (`news_id`) REFERENCES ".$this->db->dbprefix($this->blog->get_table())." (`id`) ON DELETE CASCADE ON UPDATE CASCADE
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
         	");
		}
	}

	/**
	 * Build table down
	 */
	function down() 
	{
		$this->dbforge->drop_table($this->comment->get_table());
	}
}

/* End of file 005_comments.php */
/* Location: ./application/migrations/005_comments.php */