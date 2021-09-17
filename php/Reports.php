<?php
session_start();

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

	function create($reportDate, $id_booklet, $id_category, $description)
	{ // Ausbildungsbericht anlegen
		$id_author = $_SESSION['id_user'];
		$creationDate = date("Y/m/d");
		$connection = $this->databaseConnector()->connect();
		$sql = "INSERT INTO t_reports (id, reportdate, creationdate, id_author, id_booklet, id_category, description) VALUES (default, '" . $reportDate . "','" . $creationDate . "','" . $id_author . "','" . $id_booklet . "','" . $id_category . "','" . $description . "')";

		$result = $connection->query($sql);
		if ($result === TRUE)
		{	
			$arrayAnswer = array(
				'rc'=>true,
				'rv'=>NULL);
			$connection->close();
		}
		else
		{
			$arrayAnswer = array(
				'rc'=>false,
				'rv'=>$connection->error);
			$connection->close();
		}
		return $arrayAnswer;
	}

	function getAllCategories()
	{ // Ausbildungsbericht anlegen
		$connection = $this->databaseConnector()->connect();
		$sql = "SELECT `id`, `description` FROM `t_categories` WHERE 1";

		$result = $connection->query($sql);
		$rows = array();
		while($r = mysqli_fetch_assoc($result))
		{
			$rows[] = $r;
		}
		$connection->close();
		return $rows;
	}

	function alterreport($reportid, $newDescrioption) {
		$sql = "UPDATE t_reports SET description='".$newDescrioption."', edited=".$_SESSION['id_user']." WHERE id = ".$reportid.";";
		$connection = $this->databaseConnector()->connect();
		$result = $connection->query($sql);
		if ($result === TRUE)
		{	
			$arrayAnswer = array(
				'rc'=>true,
				'rv'=>NULL);
			$connection->close();
		}
		else
		{
			$arrayAnswer = array(
				'rc'=>false,
				'rv'=>$connection->error);
			$connection->close();
		}
		return $arrayAnswer;
	}

	function deletereport ($reportid) {
		$connection = $this->databaseConnector()->connect();
		$sql = 'DELETE FROM `t_reports` WHERE `id` = ' . $reportid . ';';
		$result = $connection->query($sql);
		if ($result === TRUE)
		{	
			$arrayAnswer = array(
				'rc'=>true,
				'rv'=>NULL);
			$connection->close();
		}
		else
		{
			$arrayAnswer = array(
				'rc'=>false,
				'rv'=>$connection->error);
			$connection->close();
		}
		return $arrayAnswer;
	}

} // Ende Klasse Reports


// Methoden-Aufrufauswahl

$method = $_REQUEST['method'];
$reports = new Reports();
if ($method == "create")
{
	$reportDate 	= $_POST['reportDate'];
	$id_booklet 	= $_POST['id_booklet'];
	$id_category 	= $_POST['id_category'];
	$description 	= $_POST['description'];
	echo json_encode($reports->create($reportDate, $id_booklet, $id_category, $description));
}
else if ($method == "getAllBookletReports")
{
	$id_booklet 	= $_POST['id_booklet'];
	echo json_encode($reports->getAllBookletReports($id_booklet));
}
else if ($method == "getAllCategories")
{
	echo json_encode($reports->getAllCategories());
}
else if ($method == "deletereport")
{	
	echo json_encode($reports->deletereport($_POST['reportid']));
}
else if ($method == "alterreport")
{
	echo json_encode($reports->alterreport($_POST['reportid'], $_POST['newDescrioption']));
}
else
{
	echo json_encode("Error: Die Klasse verfügt über keine Methode namens '" . $method . "'");
}
?>