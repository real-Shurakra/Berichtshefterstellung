<?php

class DatabaseConnector
{
	protected $servername = "localhost";
	protected $username = "root";
	protected $password = "";
	protected $dbname = "apprenticeship_reports";
	
    function connect()
    { // Verbindung zu Datenbank aufbauen
		$connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
		
		// Verbindung prüfen
		if ($connection->connect_error)
		{
			die("Connection failed: " . $connection->connect_error);
		}
		else return $connection;
    }

} // Ende Klasse DatabaseConnector

?>