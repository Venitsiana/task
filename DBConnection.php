<?php
class DBConnection
{
	private static $instance;
	private $connection;
	
	private function __construct()
	{
		$connectionString = 'mysql:host=localhost;dbname=edgesoft_task4';
        $this->connection = new \PDO($connectionString , "task4@edge-soft.com", "qwelkj494");
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       // echo "<p>DB Connection estabished ...</p>";
	}
	
	private function __clone(){}
	
	public static function getInstance()
	{
		if(empty(self::$instance))
		{
			self::$instance = new DBConnection();
		}
		
		return self::$instance;
	}
	
	public function getConnection()
	{
		return $this->connection;
	}
	
	public static function getDBConnection()
	{
		return self::getInstance()->getConnection();
	}
	
}
