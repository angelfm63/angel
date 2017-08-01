<?php
ob_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SeriesEliminar</title>
</head>
<body>
<?php
ob_start();
	  include 'conexionPHP.php';
				
		// conexión por PDO  (conexionesPHP.php)
 			PDO($servername, $username, $password, $dbname);

	if (isset($_GET['cod']))
  		{
		$cod=$_GET['cod'];
			
				
		//Preparar la consulta
		$consulta = "DELETE FROM comentarios WHERE IdComentario=$cod";
		$conn->exec($consulta);
					
		}
	else
	    {
  		echo "no encontrada Serie a eliminar";
		}
	
	
		
	$conn = null;
	
	header("location:paginacion.php");   
	
    
?>
</body>
</html>
<?php
ob_end_flush();
?>