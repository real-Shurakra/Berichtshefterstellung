<?php

include 'DatabaseConnector.php';

class Apprentices
{
	function databaseConnector()
	{ // Instanz von 'DatabaseConnector' erzeugen
		 $databaseConnector = new DatabaseConnector();
		 return $databaseConnector;
	}


    function getAll()
    { // Alle Kategorien auslesen
		$connection = $this->databaseConnector()->connect();
		
		$sql = "SELECT id, email, firstname, lastname, occupation FROM t_apprentices";
		$result = $connection->query($sql);

		$sth = mysqli_query($connection, $sql);
		$rows = array();
		while($r = mysqli_fetch_assoc($sth))
		{
			$rows[] = $r;
		}
		return json_encode($rows);
    }

} // Ende Klasse Apprentices

$apprentices = new Apprentices();
echo $apprentices->getAll();

?>