<?php
	class Conexao{
		
		public static $instance;

    	private function __construct() {}

		public static function getConexao()
		{
			if (!isset(self::$instance))
			{
				$servername = 'localhost';
				$mydatabase = 'db_validez'; 
				$username = 'root';
				$password = '';
				
				try
				{
					$conn = new PDO("mysql:host=$servername;dbname=$mydatabase", $username, $password);
					// set the PDO error mode to exception
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					self::$instance = $conn;
				}
				catch(PDOException $e)
				{
					return "Connection failed: " . $e->getMessage();
				}
			}

			return self::$instance;
		}
	}
?>