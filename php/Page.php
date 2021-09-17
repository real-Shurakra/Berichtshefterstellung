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

	function passEncript($password) {
		// Change pepper and salt befor going live for security reasons
		$pepper = "B3r!c#s";
		$salt = "H3fT";
		return hash("sha512", $pepper . strval($password) . $salt);
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
			while($row = $result->fetch_assoc()) {
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
	
	
	function register($mail, $firstname, $lastname, $occupation, $password) {
		$connection = $this->databaseConnector()->connect();
		$sql = "SELECT email FROM t_apprentices WHERE email = '".$mail."'";
		$result = $connection->query($sql);
		if ($result->num_rows != 0 ){
			$answer = array(
				'rc' => false,
				'rv' => '<strong>E-Mail vergeben<strong><br>Die E-Mail Adresse, mit der Sie sich registrieren möchten, ist bereits vergeben.'
			);
		}
		else{
			$sql = "INSERT INTO t_apprentices(email, firstname, lastname, occupation, password) 
			VALUES ('".$mail."', '".$firstname."', '".$lastname."', '".$occupation."', '".$password."')";
			$result = $connection->query($sql);
			if (!$result) {
				$answer = array(
					'rc' => false,
					'rv' => '<strong>SQL Error in "register()"<strong><br>Bitte melden Sie sich bei einem Administrator.',
					'error' => $connection->error
				);
			}
			else{
				$answer = array(
					'rc' => true,
					'rv' => '<strong>Registriert.<strong><br>Klicken Sie nun auf "Zum Login" um sich anzumelden.',
					'error' => NULL
				);
			}
		}
		return $answer;
	}
} // Ende Klasse Page


// Methoden-Aufrufauswahl

$method = $_REQUEST['method'];
$page = new Page();
if ($method == "login") {
	$password = $page->passEncript($_POST['password']);
	$email = $_POST['email'];
	echo json_encode($page->login($email, $password));
}
else if ($method == "register") {
	echo json_encode($page->register($_POST['mail'],
									 $_POST['firstname'],
									 $_POST['lastname'],
									 $_POST['occupation'],
									 $page->passEncript($_POST['password1'])));
}
else {
	echo json_encode("Error: Die Klasse verfügt über keine Methode namens '" . $method . "'");
}

?>