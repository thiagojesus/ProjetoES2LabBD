<?php
/*
* Mysql database class - only one connection alowed
*/
class Database {
	private $_connection;
	private static $_instance = null; //The single instance
	private $_host = "localhost";
	private $_username = "thiagojesus";
	private $_password = "madera";
	private $_database = "projeto";

	/*
	Get an instance of the Database
	@return Instance
	*/
	public static function getInstance() {
        if ($instance === null) {
            $instance = new Database();
        }
        return $instance;
	}

	// Constructor
	private function __construct() {
		$this->_connection = pg_connect("host=$this->_host dbname=$this->_database user=$this->_username password=$this->_password")
				or die("Could not connect to server\n");
	
	}

	// Magic method clone is empty to prevent duplication of connection
	private function __clone() { }

	// Get mysqli connection
	public function getConnection() {
		return $this->_connection;
	}
}
?>