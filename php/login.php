<?php
$password = $_GET['password'];
$email = $_GET['email'];

include 'databaseConnector.php';

class login
{
	// Instanz von 'databaseConnector' zu erzeugen
	function databaseConnector()
	{
		 $databaseConnector = new databaseConnector();
		 return $databaseConnector;
	}

	// User-Credentials zu überprüfen
    function checkCredentials( $email, $password )
    {
		$connection = $this->databaseConnector()->connect();
		
		$sql = "SELECT password FROM t_apprentices WHERE email ='" . $email . "'";
		$result = $connection->query($sql);

		if ($result)
		{
			// Durch Zeilen iterieren
			while($row = $result->fetch_assoc())
			{
				if( $row["password"] == $password ) return true;
				else return false;
			}
		}
		else
		{
			echo "0 results";
		}
		$connection->close();
    }
}

$login = new login();
// echo $login->checkCredentials("hans@peter.de", "1234");
echo $login->checkCredentials($email, $password);

?>