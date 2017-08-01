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
  <title>Comentarios por Usuarios</title>
</head>
<body>

 
<?php

// $id = $_GET['cod'];
// $nombre = $_GET['nom'];

$id = $_SESSION['idu'];
$nombre = $_SESSION['nomusu'];
				

if (isset($_POST['enviar']))
	{	   
					
		// conexión por PDO  (conexionesPHP.php)
 			PDO($servername, $username, $password, $dbname);
			
		 $comentarios = $_POST['comment'];
					
		try {
			echo $id;
   		 $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
   		 // set the PDO error mode to exception
   		 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	 $sql = "INSERT INTO comentarios (IdUsuario, Comentario)
					VALUES ($id, '$comentarios')";
    // use exec() because no results are returned
   		 $conn->exec($sql);
   					 
		 echo "Añadido nuevo registro<br>";
		 
		 $Texto = $nombre." ha introducido un comentario";
				
					$altalog = "INSERT INTO log (Texto)
					VALUES ('$Texto')"; 
    	
   					 $conn->exec($altalog);  
		 
		  }
		catch(PDOException $e)
   		 {
   		 echo $sql . "<br>" . $e->getMessage();

		 }
		 $conn=null;
	}
	
	if (isset($_POST['Visualizar']))
	{
		header('location:paginacion.php');
	//	header('Location:Comentarios.php?cod='.$id.'&nom='.$nombre)
	}

?>

<form method="post">

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Comentarios</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="Logout.php">Home</a></li>
      <?php if ($nombre == "admin") 
	  		{
	  		echo "<li><a href='paginacionlogs.php'>Logs</a></li>";
			}
	   ?>
    </ul>
    
    	<ul class="nav navbar-nav navbar-right">
      <li><a href="#"><span class="glyphicon glyphicon-user"><?php echo " ".$nombre ?></span></a></li>
      
    </ul>
  </div>
</nav>

<div class="container">

<h3 align="center"> COMENTARIOS </h3>

<div class="form-group input-lg">
  <label for="usr">Usuario:</label>
  <input type="text"  class="form-control" id="usr" name="nombre"  readonly value="<?php echo $nombre ?>">
</div>
<br/>
<div class="form-group">
      <label for="comment">Comentarios:</label>
      <textarea class="form-control" rows="5" id="comment" name="comment"></textarea>
</div>

<br/><br/>

<button type="submit" class="btn btn-success btn-lg btn-block" name="enviar">Añadir</button>
<br>
<button type="submit" class="btn btn-primary btn-lg btn-block" name="Visualizar">Visualizar</button>


</div>

</form>



</body>
</html>
<?php
ob_end_flush();
?>