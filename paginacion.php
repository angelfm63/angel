<?php
ob_start();
/* capturar variable por método GET */

// Start the session
session_start();

	if (isset($_GET['pos']))
		{
  		$ini=$_GET['pos'];
		$control = $_GET['control'];
		}
	else
	{ $ini=1;
	  $control = " ";
	}
$serie = " ";
	
//$idu = $_GET['cod'];
//$usuario = $_GET['nom'];

$idu = $_SESSION['idu'];
$usuario = $_SESSION['nomusu'];
// conexion */
	include 'conexionPHP.php';
?>

<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <title>Comentarios</title>
 <style>
   h3 {text-align:center;}
   #tablephp {width:800px; font-size:12px; padding:50px;}
   table th{background-color:#AED7FF;}
   #Usuario {text-align:center;
   			 font-size:24px;}
   
 </style>
</head>
 <body>
 
 <!-- <form method="post"> -->
  
  <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Foro de Comentarios</a>
    </div>
    <ul class="nav navbar-nav">
 <!--     <li class="active"><a href="Comentarios.php?cod=<?php // echo $idu."&nom=".$usuario; ?>">Comentarios</a></li> -->
       <li class="active"><a href="comentarios.php">Comentarios</a></li>
       <li><a href="#">PDF</a></li>
    </ul>
    <form class="navbar-form navbar-left" method="post">
      <div class="input-group">
  <!--      <input type="text" class="form-control" name="texto" value="<?php echo $serie;?>">
        <div class="input-group-btn">
          <button class="btn btn-default" type="submit" name="buscar" >
            <i class="glyphicon glyphicon-search"></i>
          </button> 
        </div> -->
      </div>
    </form>
    	<ul class="nav navbar-nav navbar-right">
      <li><a href="#"><span class="glyphicon glyphicon-user"><?php echo " ".$usuario ?></span></a></li>
      
    </ul>
  </div>
</nav>

  <div class="container">
  
  <center>
   <div id="tablephp">
     <?php 
	 	// conexión por PDO  (conexionesPHP.php)
 			PDO($servername, $username, $password, $dbname);
				
		/* variables */
		$order="IdComentario";
	 	$url = basename($_SERVER ["PHP_SELF"]);
		$limit_end = 10;
		$init = ($ini-1) * $limit_end;
		/* querys */
	
	//  FORMA ENCONTRADA POR MI 	
	//	$count = current($conn->query("SELECT COUNT(*)FROM usuarios")->fetch());
	
	//  FORMA PROFESOR 
				
		
				
				echo "TODOS<br>";	
		
				$Scount = $conn->prepare("SELECT count(*) as NumReg FROM comentarios INNER JOIN usuarios on comentarios.IdUsuario = usuarios.IdUsuario"); 
				$Scount->execute();
				$Scount->setFetchMode(PDO::FETCH_ASSOC); 
	   			$count = $Scount->fetchAll()[0]['NumReg'];	
			
				$pagina = "SELECT comentarios.IdComentario, comentarios.IdUsuario, usuarios.Nombre , comentarios.comentario, comentarios.Fecha, usuarios.color FROM comentarios INNER JOIN usuarios on comentarios.IdUsuario = usuarios.IdUsuario ORDER BY ". $order;
				$pagina .= " LIMIT $init, $limit_end"; 
		
		if (isset($_POST['buscar']))
		{
			 if ($_POST['texto'] != " ")
			 {   $serie = $_POST['texto'];
				 echo "SERIE <br>";
				 $Scount = $conn->prepare("SELECT count(*) as NumReg FROM comentarios INNER JOIN usuarios on comentarios.IdUsuario = usuarios.IdUsuario WHERE comentario LIKE '%".$serie."%' OR Nombre LIKE '%".$serie."%'"); 
				$Scount->execute();
				$Scount->setFetchMode(PDO::FETCH_ASSOC); 
	   			$count = $Scount->fetchAll()[0]['NumReg'];
				
															
				$pagina = "SELECT comentarios.IdComentario, comentarios.IdUsuario, usuarios.Nombre , comentarios.comentario, comentarios.Fecha, color FROM comentarios INNER JOIN usuarios on comentarios.IdUsuario = usuarios.IdUsuario WHERE comentario LIKE '%".$serie."%' OR Nombre LIKE '%".$serie."%' ORDER BY ". $order;
				$pagina .= " LIMIT $init, $limit_end";
												
				$control = $serie;
			 }
			 else
			    $control = "";
										
		}
		else
		{    if ($control != " ")
		     {
				  echo "CONTROL <br>";
			$Scount = $conn->prepare("SELECT count(*) as NumReg FROM comentarios INNER JOIN usuarios on comentarios.IdUsuario = usuarios.IdUsuario WHERE comentario LIKE '%".$control."%' OR Nombre LIKE '%".$control."%'"); 
				$Scount->execute();
				$Scount->setFetchMode(PDO::FETCH_ASSOC); 
	   			$count = $Scount->fetchAll()[0]['NumReg'];
				
															
				$pagina = "SELECT comentarios.IdComentario, comentarios.IdUsuario, usuarios.Nombre , comentarios.comentario, comentarios.Fecha, color FROM comentarios INNER JOIN usuarios on comentarios.IdUsuario = usuarios.IdUsuario WHERE comentario LIKE '%".$control."%' OR Nombre LIKE '%".$control."%' ORDER BY ". $order;
				$pagina .= " LIMIT $init, $limit_end";
				
				
			 }
		
		}
				
		
	    $pagina = $conn->prepare($pagina);
		$pagina->execute();

		/* Obtener todas las filas restantes del conjunto de resultados */
		
		$total = ceil($count/$limit_end);
		
		echo "<table border='1' class='table table-bordered table-hover'>
		  <thead><tr>
		  <th>Clave</th>
		  <th>Nombre Usuario</th>
		  <th>Comentario</th>
		  <th>fecha</th>
		  </tr>
		  </thead>
		  <tbody>";
  
  while($row = $pagina->fetch(PDO::FETCH_ASSOC))
  {    
        $codigo = $row["IdComentario"];
		$nombre = $row["Nombre"];
		$color = $row["color"];
		echo '<tr bgcolor='.$color.'><td>'.$row["IdComentario"].'</td>';
		echo '<td>'.$row["Nombre"].'</td>';
		echo '<td>'.$row["comentario"].'</td>';
		echo '<td>'.$row["Fecha"].'</td>';
						
		// <a href="javascript:confirmarBorrado('user385',385)">Eliminar</a>
		
		echo "<td><a href=" . chr(34) . "javascript:borrar(".$codigo.",'" .
                     $usuario. "')" . chr(34) . ">Eliminar</a></td>";
		
		
	//	echo "<td><a href='actualizar.php?cod=$codigo'>Actualizar</a></td>";
		echo "</tr>";
    		
  }
  
  echo "</tbody>";
  echo "<table>";
  
  
  
  $conn = null;
    
  
  /* numeración de registros [importante]*/
  echo "<div class='pagination'>";
  echo "<ul class='pagination pagination-lg'>";
  /****************************************/
    
  if(($ini - 1) == 0)
  {
    echo "<li><a href='#'>&laquo;</a></li>";
  }
  else
  { // lLAMA A LA PAGINA PASANDOLE LA PAGINACION QUE TIENE QUE MOSTRAR
    echo "<li><a href='$url?pos=".($ini-1)."'><b>&laquo;</b></a></li>";
	
  }
  /****************************************/
  for($k=1; $k <= $total; $k++)
  {
    if($ini == $k)
    {
      echo "<li><a href='#'><b>".$k."</b></a></li>";
    }
    else
    {
      echo "<li><a href='$url?pos=$k&control=$control'>".$k."</a></li>";
	  
    }
  }
  /****************************************/
  if($ini == $total)
  {
    echo "<li><a href='#'>&raquo;</a></li>";
  }
  else
  {
    echo "<li><a href='$url?pos=".($ini+1)."'><b>&raquo;</b></a></li>";
	
  }
  /*******************END*******************/
  echo "</ul>";
  echo "</div>";


	  ?>
   </div>
   
 <!--  </form> -->
   
  </div>
  </center>
  
  
  
 </body>
 
 <script>
  	
		function borrar(codigo, nombre)
		{		
			alert(nombre);		
			ventana=confirm("Seguro que quieres Eliminarlo"); 
			if (ventana==true && nombre == "admin") 
				{ 
					location.href="eliminar.php?cod="+codigo;
				}
			else 
				{
				return false;
		    	}
		}
  </script>
</html>
<?php
ob_end_flush();
?>