<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * My Migration Class
 *
 * @package		Application
 * @subpackage	Libraries
 * @category	Validation
 * @author		Andreas Gehle
 */
 
class MY_Migration extends CI_Migration {
		
	/**
	 * Constructor
	 */
	function __construct($config = array())
	{
		//init config vars
		$this->_load_config_file();
		
		foreach ($config as $key => $val)
		{
			$this->{'_' . $key} = $val;
		}

		log_message('debug', 'Migrations class initialized');

		// Are they trying to use migrations while it is disabled?
		if ($this->_migration_enabled !== TRUE)
		{
			show_error('Migrations has been loaded but is disabled or set up incorrectly.');
		}

		// If not set, set it
		$this->_migration_path == '' AND $this->_migration_path = APPPATH.'migrations/';

		// Add trailing slash if not set
		$this->_migration_path = rtrim($this->_migration_path, '/').'/';

		// Load migration language
		$this->lang->load('migration');

		// They'll probably be using dbforge
		$this->load->dbforge();

		// Make sure the migration table name was set.
		if (empty($this->_migration_table))
		{
			show_error('Migrations configuration file (migration.php) must have "migration_table" set.');
		}

		// If the migrations table is missing, make it
		if ( ! $this->db->table_exists($this->_migration_table))
		{
			$this->dbforge->add_field(array(
				'version' => array('type' => 'INT', 'constraint' => 3),
			));

			$this->dbforge->create_table($this->_migration_table, TRUE);

			$this->db->insert($this->_migration_table, array('version' => 0));
		}

		// Do we auto migrate to the latest migration?
		if ($this->_migration_auto_latest === TRUE AND ! $this->latest())
		{
			show_error($this->error_string());
		}
	}

	// --------------------------------------------------------------------	
	
	/**
	 * Load template config
	 * 
	 * Load template specific config items from config/template.php
	 */
	private function _load_config_file()
	{
		if ( ! @include(APPPATH.'config/migration'.EXT))
		{
			return FALSE;
		}

		foreach($config as $key => $val)
		{
			$this->{'_' . $key} = $val;
		}

		return TRUE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get migration files
	 * 
	 * Set function to public
	 *
	 * @access	public
	 * @return	mixed	true if already latest, false if failed, int if upgraded
	 */
	public function get_migrations()
	{
		return $this->find_migrations();
	}
	
	// --------------------------------------------------------------------

	/**
	 * Get active migration version
	 * 
	 * Set function to public
	 *
	 * @access	public
	 * @return	integer	Current Migration
	 */
	public function get_version()
	{
		return $this->_get_version();
	}
}
	