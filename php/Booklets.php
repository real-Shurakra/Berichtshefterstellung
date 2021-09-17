<?php
session_start();

include 'DatabaseConnector.php';
//include 'Reports.php';

class Booklets
{
	function databaseConnector()
	{ // Instanz von 'DatabaseConnector' erzeugen

		 $databaseConnector = new DatabaseConnector();
		 return $databaseConnector;
	}
	
	function Reports()
	{ // Instanz von 'Reports' erzeugen

		 //$reports = new Reports();
		 //return $reports;
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

	function create($subject)
	{ // Neues Berichtsheft anlegen
		$id_creator = $_SESSION['id_user'];
		if ($this->subjectTaken($subject, $id_creator)) return "Ein Berichtsheft mit dem Namen existiert bereits in der Datenbank!";

		$today = date("Y/m/d");
		$connection = $this->databaseConnector()->connect();
		$sql = "INSERT INTO t_booklets (id, creationdate, subject, id_creator) VALUES (default" . ",'" . $today . "','" . $subject . "'," . $id_creator . ")";
		$result = $connection->query($sql);
		if ($result === TRUE)
		{	
			$sql = "SELECT MAX(id) AS id_booklet FROM t_booklets WHERE id_creator =" . $id_creator;
			$result = $connection->query($sql);
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					$id_booklet = $row['id_booklet'];
				}
			}
			else return "Es wurden noch keine Berichtshefte angelegt!";
		}
		else
		{
			$connection->close();
			return array(
				"rc" => false,
				"rv" => "<strong>SQL Error!</strong><br>" . $connection->error);
		}

		// Author als Member eintragen
		$sql = "INSERT INTO t_memberof (id_booklet, id_apprentice) VALUES (" . $id_booklet . "," . $id_creator . ")";
		
		$result = $connection->query($sql);
		if ($result === TRUE)
		{
			return array(
				"rc" => true,
				"rv" => "Berichtsheft wurde angelegt.");
		}
		else
		{
			$connection->close();
			return array(
				"rc" => false,
				"rv" => "<strong>SQL Error!</strong>" . $connection->error);
		}
	}
	
	function getAllBooklets()
	{ // Alle angelegten Berichtshefte eines Users auslesen
		if (isset($_SESSION['id_user']) != true){
			return array (
				'rc' => false,
				'rv' => '<strong>Nicht angemeldet.</strong><br>Bitte melden Sie sich zunächst an.'
			);
		} 
		$id_creator = $_SESSION['id_user'];
		$all = array();
		// Verbindung zum SQL-Server aufbauen
		$connection = $this->DatabaseConnector()->connect();


		// Alle Berichtshefte auslesen die erstellt wurden (Metadaten)
		$sql = "SELECT * 
				FROM t_booklets
				WHERE id_creator =" . $id_creator;

		$result = $connection->query($sql);

		if($result->num_rows > 0)
		{
			$booklets = array();
			while($row = $result->fetch_assoc())
			{
				array_push($booklets, $row);
			}
			$all['booklets'] = $booklets;
		}
		else return array(
			"rc" => false,
			"rv" => "Es wurden noch keine Berichtshefte angelegt!");
		
		
		// Alle Member der Berichtshefte auslesen
		$members = array();
		for ($i = 0; $i < sizeOf($booklets); $i++)
		{
			$sql = "SELECT *
					FROM t_memberof
					WHERE id_booklet =" . $booklets[$i]['id'];
					
			$result = $connection->query($sql);
			
			if($result->num_rows > 0)
			{
				while($row = $result->fetch_assoc())
				{
					array_push($members, $row);
				}
			}
			$all['members'] = $members;
		}

		
		// Alle Reports der Member auslesen
		$reports = array();
		for ($i = 0; $i < sizeOf($members); $i++)
		{
			$sql = "SELECT *
					FROM t_reports
					WHERE id_author = " . $members[$i]['id_apprentice'];

			$result = $connection->query($sql);

			if($result->num_rows > 0)
			{	
				while($row = $result->fetch_assoc())
				{
					array_push($reports, $row);
				}
			}
			$all['reports'] = $reports;
		}
		
		
		// Alle Kategorien auslesen
		$sql = "SELECT * 
				FROM t_categories";

		$result = $connection->query($sql);

		if($result->num_rows > 0)
		{
			$categories = array();
			while($row = $result->fetch_assoc())
			{
				array_push($categories, $row);
			}
			$all['categories'] = $categories;
		}
		
		
		// Alle IDs der User auslesen
		$sql = "SELECT firstname, lastname, id 
				FROM t_apprentices";

		$result = $connection->query($sql);

		if($result->num_rows > 0)
		{
			$apprentices = array();
			while($row = $result->fetch_assoc())
			{
				array_push($apprentices, $row);
			}
			$all['apprentices'] = $apprentices;
		}
		
		//return $all;


			// Daten fürs Frontend mergen
			//$mergedBooklets = array();

		for ($i = 0; $i < sizeOf($booklets); $i++)
		{
			$subject = $booklets[$i]['subject'];
			$booklets[$i]['reports'] = array();
			//$mergedBooklets[$subject] = array();
			
			for ($j = 0; $j < sizeOf($reports); $j++)
			{				
				for ($k = 0; $k < sizeOf($apprentices); $k++)
				{
					if ($reports[$j]['id_author'] == $apprentices[$k]['id']) $reports[$j]['author'] = $apprentices[$k]['firstname'] . " " . $apprentices[$k]['lastname'];
				}

				for ($k = 0; $k < sizeOf($categories); $k++)
				{
					if ($reports[$j]['id_category'] == $categories[$k]['id']) $reports[$j]['category'] = $categories[$k]['description'];
				}
				
				if ($booklets[$i]['id'] == $reports[$j]['id_booklet'])
				{
					if(!in_array($reports[$j],$booklets[$i]['reports'],true)) array_push($booklets[$i]['reports'], $reports[$j]);
				}
			}
		}

		return array(
			"rc" => true,
			"rv" => $booklets);
		
	}

	function getCoAuthors ($strBookletId) {
		$connection = $this->databaseConnector()->connect();
		$sql = "SELECT userid, email, firstname, lastname, occupation FROM getcoauthors WHERE bookletid = " . $strBookletId . ";";

		$result = $connection->query($sql);
		$rows = array();
		while($r = mysqli_fetch_assoc($result))
		{
			if ($r['userid'] == $_SESSION['id_user']){continue;}
			$rows[] = $r;
		}
		if ($rows == []){
			return true;
		}
		$connection->close();
		return $rows;
	}

	function getAllMail () {
		$connection = $this->databaseConnector()->connect();
		$sql = "SELECT id AS userid, email FROM t_apprentices;";
		$result = $connection->query($sql);
		if (!$result) {
			return false;
		}
		$rows = array();
		while($r = mysqli_fetch_assoc($result))
		{
			if ($r['userid'] == $_SESSION['id_user']){continue;}
			$rows[] = $r['email'];
		}
		return $rows;
	}

	function addCoAuthor ($strAuthorMail, $strBookletId){
		$connection = $this->databaseConnector()->connect();
		$sql = "INSERT INTO t_memberof(id_booklet, id_apprentice) VALUES(".$strBookletId." , (SELECT id FROM t_apprentices WHERE email = '".$strAuthorMail."'));";
		$result = $connection->query($sql);
		if (!$result){
			$answer = array(
				'rc' => false,
				'rv' => "<strong>SQL Error!</strong><br>" . $connection->error
			);
		}
		else {
			$answer = array(
				'rc' => true,
				'rv' => NULL
			);
		}
		return $answer;
	}
	
	function delCoAuthors ($arrayCoAuthors, $strBookletId){
		$arrayCoAuthors = explode(',', $arrayCoAuthors);
		$connection = $this->databaseConnector()->connect();
		foreach ($arrayCoAuthors as $arrayCoAuthorsId){
			$sql = "DELETE FROM t_memberof WHERE id_booklet = ".$strBookletId." AND id_apprentice = ".$arrayCoAuthorsId.";";
			$result = $connection->query($sql);
			if (!$result){
				$answer = array(
					'rc' => false,
					'rv' => "<strong>SQL Error!</strong><br>" . $connection->error
				);
				break;
			}
			else {
				$answer = array(
					'rc' => true,
					'rv' => NULL
				);
			}
		}
		return $answer;
	}

	function getRandomReport() {
		$connection = $this->databaseConnector()->connect();
		$sql = "SELECT description FROM t_reports WHERE id_author = ".$_SESSION['id_user'].";";
		$result = $connection->query($sql);
		if (!$result) {
			return false;
		}
		$rows = array();
		while($r = mysqli_fetch_assoc($result))
		{
			$rows[] = $r;
		}
		return $rows[rand(0, count($rows)-1)];
	}

} // Ende Klasse Booklets

// Methoden-Aufrufauswahl

$method = $_REQUEST['method'];
$booklets = new Booklets();

if		($method == "create")			{echo json_encode($booklets->create($_POST['subject']));}
else if	($method == "getAllBooklets")	{echo json_encode($booklets->getAllBooklets());}
else if	($method == "getCoAuthors")		{echo json_encode($booklets->getCoAuthors($_REQUEST['strBookletId']));}
else if	($method == "addCoAuthor")		{echo json_encode($booklets->addCoAuthor($_REQUEST['strAuthorMail'], $_REQUEST['strBookletId']));}
else if	($method == "delCoAuthors")		{echo json_encode($booklets->delCoAuthors($_REQUEST['arrayCoAuthors'], $_REQUEST['strBookletId']));}
else if	($method == "getAllMail")		{echo json_encode($booklets->getAllMail());}
else if	($method == "getRandomReport")		{echo json_encode($booklets->getRandomReport());}

else	{echo json_encode("Error: Die Klasse verfügt über keine Methode namens '" . $method . "'");}
?>