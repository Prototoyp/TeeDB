<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Example datas Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_Example_Users extends CI_Migration {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->model('user/user');
	}
	
	/**
	 * Build sample data
	 */	
	function up() 
	{
		if(ENVIRONMENT == 'development' && $this->db->table_exists(User::TABLE))
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
			->set('status', User::STATUS_ACTIVE)
			->where('id', $user_id)
			->update(User::TABLE);
			
			// username: admin
			// password: admin
			$user_id = $this->user->add_user(
				'admin', 
				$this->auth->get_hash('admin'),
				'admin@test.de'
			);
			
			//Activate user
			$this->db
			->set('status', User::STATUS_ADMIN)
			->where('id', $user_id)
			->update(User::TABLE);
		}
	}

	/**
	 * Build clear sample data
	 */
	function down() 
	{
		if(ENVIRONMENT == 'development')
		{	
			//Cascading should do the rest for us
			$this->db->empty_table(User::TABLE);
		}
	}
}

/* End of file 090_example_datas.php */
/* Location: ./application/migrations/090_example_datas.php */