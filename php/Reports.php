<?php
$reportDate = $_GET['reportDate'];
$id_author = $_GET['id_author'];
$id_booklet = $_GET['id_booklet'];
$id_category = $_GET['id_category'];
$description = $_GET['description'];

include 'DatabaseConnector.php';

class Reports
{
	function databaseConnector()
	{ // Instanz von 'DatabaseConnector' erzeugen

		 $databaseConnector = new DatabaseConnector();
		 return $databaseConnector;
	}


	function getAllBookletReports($id_booklet)
	{ // Alle Berichte eines Berichtsheftes auslesen

		$connection = $this->databaseConnector()->connect();
		$sql = "SELECT * FROM t_reports WHERE id_booklet =" . $id_booklet;

		$result = $connection->query($sql);

		$sth = mysqli_query($connection, $sql);
		$rows = array();
		while($r = mysqli_fetch_assoc($sth))
		{
			$rows[] = $r;
		}
		return json_encode($rows);
	}


	function create($reportDate, $id_author, $id_booklet, $id_category, $description)
	{ // Ausbildungsbericht anlegen

		$creationDate = date("Y/m/d");
		$connection = $this->databaseConnector()->connect();
		$sql = "INSERT INTO t_reports (id, reportdate, creationdate, id_author, id_booklet, id_category, description) VALUES (default, '" . $reportDate . "','" . $creationDate . "','" . $id_author . "','" . $id_booklet . "','" . $id_category . "','" . $description . "')";

		$result = $connection->query($sql);
		if ($result === TRUE)
		{	
			$connection->close();
			return "Bericht erfolgreich angelegt!";
		}
		else
		{
			$connection->close();
			return "Error: " . $sql . "<br>" . $connection->error;
		}
	}

} // Ende Klasse Reports

$reports = new Reports();
//echo $reports->create($reportDate, $id_author, $id_booklet, $id_category, $description);
echo $reports->getAllBookletReports($id_booklet);

?>