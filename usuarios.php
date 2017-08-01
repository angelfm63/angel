<?php
ob_start();
// Start the session
session_start();

// establecer conexion e insertar registro en Tabla de Comentarios
			include 'conexionPHP.php';

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <title>Usuarios</title>
</head>



<body>

<?php

	if (isset($_POST['enviar']))
		{
				
		 $nombre = $_POST['nombre'];
		 $pwd = $_POST['pwd'];
		 $email = $_POST['email'];
		 $fecha = $_POST['fecha'];
		 $perfil = $_POST['perfil'];
		 
		 $fecha=str_replace("/","-",$_POST['fecha']);
		 $fecha=date('Ymd', strtotime($fecha));
		 
		 $color = $_POST['color'];
		 
		 
				
		try {
   		 $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
   		 // set the PDO error mode to exception
   		 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	 $sql = "INSERT INTO usuarios (Nombre, pasword, email, Fecha, Perfil, color)
					VALUES ('$nombre', '$pwd', '$email', $fecha, '$perfil', '$color')";
    // use exec() because no results are returned
   		 $conn->exec($sql);
   		 
		 $last_id = $conn->lastInsertId();
		 
		 echo "Añadido nuevo registro<br>";
		 
		 $Texto = $nombre." ha sido dado de alta";
				
					$altalog = "INSERT INTO log (Texto)
					VALUES ('$Texto')"; 
    	
   					 $conn->exec($altalog);  
		 
			    echo $last_id;
			 	echo $nombre;
				
				$_SESSION['idu'] = $last_id;
					$_SESSION['nomusu'] = $nombre;
		 	
				header('Location:comentarios.php');
		 		 
  		  }
		catch(PDOException $e)
   		 { 
   		 echo $sql . "<br>" . $e->getMessage();
   		 }

		$conn = null;
		
		}
		
		
?>

<form method="post" enctype="multipart/form-data">



<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
    <a class="navbar-brand" href="#">Usuarios</a> 
   	
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="index.php">Home</a></li>
      
    </ul>
    
    	<ul class="nav navbar-nav navbar-right">
      <li><a href="#"><span class="glyphicon glyphicon-user"><?php echo " ".$nombre ?></span></a></li>
      
    </ul>
  </div>
</nav>


<div class="container">

<h3 align="center"> AÑADIR USUARIOS </h3>

<div class="form-group input-lg">
  <label for="usr">Nombre Usuario:</label>
  <input type="text" class="form-control" id="usr" name="nombre">
</div>

<div class="form-group input-lg">
  <label for="pwd">Pasword:</label>
  <input type="text" class="form-control" id="pwd" name="pwd">
</div>

<div class="form-group input-lg">
  <label for="email">Email:</label>
  <input type="text" class="form-control" id="email" name="email">
</div>

<div class="form-group input-lg">
  <label for="fecha">Fecha:</label>
  <input type="text" class="form-control" id="fecha" name="fecha">
</div>

<div class="form-group input-lg">
  <label for="perfil">Perfil:</label>
  <input type="text" class="form-control" id="perfil" name="perfil">
</div>

<div class="form-group input-lg">
  <label for="color">Color:</label>
  <input type="color" class="form-control" id="color" name="color">
</div>

<br/><br/>

<button type="submit" class="btn btn-success btn-lg btn-block" name="enviar">Añadir</button>



</div>

</form>

</body>
</html>
<?php
ob_end_flush();
?>