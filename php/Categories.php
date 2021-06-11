<?php

include 'DatabaseConnector.php';

class Categories
{
	function databaseConnector()
	{ // Instanz von 'DatabaseConnector' erzeugen
		 $databaseConnector = new DatabaseConnector();
		 return $databaseConnector;
	}


    function getAll()
    { // Alle Kategorien auslesen
		$connection = $this->databaseConnector()->connect();
		
		$sql = "SELECT * FROM t_categories";
		$result = $connection->query($sql);

		$sth = mysqli_query($connection, $sql);
		$rows = array();
		while($r = mysqli_fetch_assoc($sth))
		{
			$rows[] = $r;
		}
		return json_encode($rows);
    }

} // Ende Klasse Categories

$categories = new Categories();
echo $categories->getAll();

?>