<?php
	
	$conn;
	$servername = "localhost";
	$username = "id2227626_angel";
	$password = "angel";
	$dbname = "id2227626_comentariosbd";	
			
	function PDO ($servername, $username, $pasword, $db)
		{     
			try {
			   	   global $conn;
					
    			   $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $pasword);
    			// set the PDO error mode to exception
                   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				   echo "Conexión Establecida<br>"; 
					}
			catch(PDOException $e)
					{
					echo "Error en la conexión: " . $e->getMessage();
					}
							
		}

	
	function MyLiOOP ($servername, $username, $pasword, $db)
		{     
			// Create connection
			global $conn;
			$conn = new mysqli($servername, $username, $password, $db);

			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 
			echo "Connected successfully";
					}
		
	function MyLiPro ($servername, $username, $pasword, $db)
		{     
			// Create connection
			global $conn;
			$conn = mysqli_connect($servername, $username, $password, $db);
			
			// Check connection
			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}
			echo "Connected successfully";
						
		}
?>