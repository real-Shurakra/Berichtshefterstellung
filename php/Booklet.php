<?php
$subject = $_GET['subject'];
$id_creator = $_GET['id_creator'];

include 'DatabaseConnector.php';

class Booklet
{
	function databaseConnector()
	{ // Instanz von 'DatabaseConnector' erzeugen

		 $databaseConnector = new DatabaseConnector();
		 return $databaseConnector;
	}


	function subjectTaken($subject, $id_creator)
	{ // Prüfen ob bereits ein Berichtsheft mit dem Titel existiert

		$connection = $this->databaseConnector()->connect();
		$sql = "SELECT subject FROM t_booklets WHERE subject ='" . $subject . "' AND id_creator = " . $id_creator;

		$result = $connection->query($sql);
		if ($result->num_rows > 0)
		{
			$connection->close();
			return true;
		}
		else
		{
			$connection->close();
			return false;
		}
	}


	function create($subject, $id_creator)
	{ // Neues Berichtsheft anlegen

		if ($this->subjectTaken($subject, $id_creator)) return "Ein Berichtsheft mit dem Namen existiert bereits in der Datenbank!";

		$today = date("Y/m/d");
		$connection = $this->databaseConnector()->connect();
		$sql = "INSERT INTO t_booklets (id, creationdate, subject, id_creator) VALUES (default" . ",'" . $today . "','" . $subject . "'," . $id_creator . ")";

		$result = $connection->query($sql);
		if ($result === TRUE)
		{	
			$connection->close();
			return "Berichtsheft erfolgreich angelegt!";
		}
		else
		{
			$connection->close();
			return "Error: " . $sql . "<br>" . $connection->error;
		}
	}

} // Ende Klasse Booklet

$booklet = new Booklet();
echo $booklet->create($subject, $id_creator);

?>