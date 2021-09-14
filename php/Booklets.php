<?php

//var_dump(__DIR__ . '/DatabaseConnector.php');

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


	function create($subject, $id_creator)
	{ // Neues Berichtsheft anlegen

		if ($this->subjectTaken($subject, $id_creator)) return "Ein Berichtsheft mit dem Namen existiert bereits in der Datenbank!";

		$today = date("Y/m/d");
		$connection = $this->databaseConnector()->connect();
		$sql = "INSERT INTO t_booklets (id, creationdate, subject, id_creator) VALUES (default" . ",'" . $today . "','" . $subject . "'," . $id_creator . ")";
		$result = $connection->query($sql);
		if ($result === TRUE)
		{
			$sql = "SELECT MAX(id) AS id_booklet FROM t_booklets WHERE id_creator =" . $id_creator;
			$id_booklet;
			$result = $connection->query($sql);
			if($result->num_rows > 0)
			{
				$rows = array();
				while($row = $result->fetch_assoc())
				{
					$id_booklet = $row['id_booklet'];
				}
			}
			else return "Es wurden noch keine Berichtshefte angelegt!";
		}
		else
		{
			$connection->close();
			return "Error: " . $sql . "<br>" . $connection->error;
		}

		// Author als Member eintragen
		$sql = "INSERT INTO t_memberof (id_booklet, id_apprentice) VALUES (" . $id_booklet . "," . $id_creator . ")";

		$result = $connection->query($sql);
		if ($result === TRUE)
		{
			return "Berichtsheft wurde angelegt!";
		}
		else
		{
			$connection->close();
			return "Error: " . $sql . "<br>" . $connection->error;
		}
	}

	function getAllBooklets($id_creator)
	{ // Alle angelegten Berichtshefte eines Users auslesen

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
		else return "Es wurden noch keine Berichtshefte angelegt!";


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

				if ($booklets[$i]['id'] == $reports[$j]['id_booklet']) array_push($booklets[$i]['reports'], $reports[$j]);
			}
		}
		return $booklets;

	}

} // Ende Klasse Booklets


// Methoden-Aufrufauswahl

$method = $_POST['method'];
$booklets = new Booklets();

if($method == "create")
{
	$subject 	= $_POST['subject'];
	$id_creator = $_POST['id_creator'];
	echo json_encode($booklets->create($subject, $id_creator));
}
else if($method == "getAllBooklets")
{
	$id_creator = $_POST['id_creator'];
	echo json_encode($booklets->getAllBooklets($id_creator));
}
else
{
	echo json_encode("Error: Die Klasse verfügt über keine Methode namens '" . $method . "'");
}
?>
