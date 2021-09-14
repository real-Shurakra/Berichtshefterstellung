<?php
session_start();
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
		$sql = "SELECT id, firstname, lastname FROM t_apprentices WHERE email ='" . $email . "' AND password = '" . $password . "'";
		$result = $connection->query($sql);
		if ($result == false){
			$answer = array(
				'rc' => false,
				'rv' => '<strong>SQL Error<strong><br>Bitte melden Sie sich nei einen Administrator!'
			);
		}
		elseif ($result->num_rows != 1 ){
			$answer = array(
				'rc' => false,
				'rv' => '<strong>Benutzername oder Passwort fehlerhaft.<strong><br>Sollten Sie ihr passwort vergessen haben, wenden Sie sich bitte an einen Administrator'
			);
		}
		else{
			while($row = $result->fetch_assoc())
			{
				$_SESSION['id_user'] = $row['id'];
				$answer = array(
					'rc' => true,
					'rv' => NULL
				);
				break;
			}
		}
		$connection->close();
		return $answer;
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