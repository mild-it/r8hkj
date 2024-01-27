<?php
Class Database{
	private $server = "mysql:host=;dbname=";
	private $username = "";
	private $password = "";
	private $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
	protected $conn;
 	
	public function open() {
 		try {
 			$this->conn = new PDO($this->server, $this->username, $this->password, $this->options);
 			return $this->conn;
 		}
 		catch (PDOException $e) {
 			echo "There are some problems connecting.: " . $e->getMessage();
 		}
    }
 
	public function close() {
   		$this->conn = null;
 	}
}
$pdo = new Database();
?>