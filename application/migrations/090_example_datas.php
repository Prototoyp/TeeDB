<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Example datas Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_Example_Datas extends CI_Migration {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->library('user/auth');
		$this->load->model(array('user/user'));
	}
	
	/**
	 * Build sample data
	 */	
	function up() 
	{	
		if ( ! $this->db->table_exists($this->user->get_table()))
		{
			// Create sample user:
			// username: foobar
			// password: foobar
			$user_id = $this->user->add_user(
				'foobar', 
				$this->auth->get_hash('foobar'),
				'foobar@test.de'
			);
			//Activate user
			$this->db
			->set('status', 1)
			->where('id', $user_id)
			->update($this->user->get_table());
		}
	}

	/**
	 * Build clear sample data
	 */
	function down() 
	{
		$this->db->empty_table($this->user->get_table()); 
	}
}

/* End of file 090_example_datas.php */
/* Location: ./application/migrations/090_example_datas.php */