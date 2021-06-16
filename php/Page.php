<?php

include 'DatabaseConnector.php';

class Page
{
	function databaseConnector()
	{ // Instanz von 'DatabaseConnector' erzeugen
		 $databaseConnector = new DatabaseConnector();
		 return $databaseConnector;
	}


    function login( $email, $password )
    { // User-Credentials zum einloggen überprüfen
		$connection = $this->databaseConnector()->connect();
		
		$sql = "SELECT id, firstname, lastname, password FROM t_apprentices WHERE email ='" . $email . "'";
		$result = $connection->query($sql);

		if ($result->num_rows > 0)
		{
			// Durch Zeilen iterieren
			$response = array();
			while($row = $result->fetch_assoc())
			{
				if( $row["password"] == $password )
				{
					//$_SESSION['id_user'] = $row['id'];
					$response["id"] = $row['id'];
					$response["firstname"] = $row['firstname'];
					$response["lastname"] = $row['lastname'];
					$connection->close();
					return $response;
				}
			}
		}
		else
		{
			$connection->close();
			return false;
		}
    }
	
	
	function logout()
	{
		return "Die Logout-Funktion muss noch implementiert werden.";
		// TODO Funktion zum Ausloggen schreiben
	}

} // Ende Klasse Page


// Methoden-Aufrufauswahl

$method = $_POST['method'];
$page = new Page();
if ($method == "login")
{
	$password = $_POST['password'];
	$email = $_POST['email'];
	echo json_encode($page->login($email, $password));
}
else if ($method == "logout")
{
	echo json_encode($page->logout());
}
else
{
	echo json_encode("Error: Die Klasse verfügt über keine Methode namens '" . $method . "'");
}

?>