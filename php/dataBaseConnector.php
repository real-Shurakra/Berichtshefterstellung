<?php

class databaseConnector
{
	protected $servername = "localhost";
	protected $username = "root";
	protected $password = "";
	protected $dbname = "apprenticeship_reports";
	
    function connect()
    {
		// Verbindung aufbauen
		$connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
		
		// Verbindung prüfen
		if ($connection->connect_error)
		{
			die("Connection failed: " . $connection->connect_error);
			echo $connection;
		}
		else return $connection;
		
    }

}

//$test = new dataBaseConnector();

?>