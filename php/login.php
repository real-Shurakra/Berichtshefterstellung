<?php
$password = $_GET['password'];
$email = $_GET['email'];

include 'DatabaseConnector.php';

class Login
{
	function databaseConnector()
	{ // Instanz von 'DatabaseConnector' erzeugen
		 $databaseConnector = new DatabaseConnector();
		 return $databaseConnector;
	}

    function checkCredentials( $email, $password )
    { // User-Credentials überprüfen
		$connection = $this->databaseConnector()->connect();
		
		$sql = "SELECT id, password FROM t_apprentices WHERE email ='" . $email . "'";
		$result = $connection->query($sql);

		if ($result->num_rows > 0)
		{
			// Durch Zeilen iterieren
			while($row = $result->fetch_assoc())
			{
				if( $row["password"] == $password )
				{
					$_SESSION['id_user'] = $row['id']; 
					return true;
				}
				else return false;
			}
		}
		else
		{
			echo "0 results";
		}
		$connection->close();
    }

} // Ende Klasse Login

$login = new login();
echo $login->checkCredentials($email, $password);

?>