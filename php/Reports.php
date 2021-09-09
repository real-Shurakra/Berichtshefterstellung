<?php

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

		//$result = $connection->query($sql);

		$sth = mysqli_query($connection, $sql);
		$rows = array();
		while($r = mysqli_fetch_assoc($sth))
		{
			$rows[] = $r;
		}
		$connection->close();
		return $rows;
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
			$arrayAnswer = array(
				'rc'=>true,
				'rv'=>NULL);
		}
		else
		{
			$connection->close();
			$arrayAnswer = array(
				'rc'=>false,
				'rv'=>$connection->error);
		}
		return $arrayAnswer;
	}

} // Ende Klasse Reports


// Methoden-Aufrufauswahl

$method = $_POST['method'];
$reports = new Reports();
if ($method == "create")
{
	$reportDate 	= $_POST['reportDate'];
	$id_author 		= $_POST['id_author'];
	$id_booklet 	= $_POST['id_booklet'];
	$id_category 	= $_POST['id_category'];
	$description 	= $_POST['description'];
	echo json_encode($reports->create($reportDate, $id_author, $id_booklet, $id_category, $description));
}
else if ($method == "getAllBookletReports")
{
	$id_booklet 	= $_POST['id_booklet'];
	echo json_encode($reports->getAllBookletReports($id_booklet));
}
else
{
	echo json_encode("Error: Die Klasse verfügt über keine Methode namens '" . $method . "'");
}
?>