<?php
ob_start();
// Start the session
session_start();

	if (isset($_GET['pos']))
  		$ini=$_GET['pos'];
	else
	{ $ini=1;}
	
//$idu = $_GET['cod'];
//$usuario = $_GET['nom'];

$idu = $_SESSION['idu'];
$usuario = $_SESSION['nomusu'];
// conexion */

include 'conexionPHP.php';
$serie = " ";		
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
 
 <form method="post">
   
  <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Foro de Comentarios</a>
    </div>
    <ul class="nav navbar-nav">
 
       <li class="active"><a href="comentarios.php">Comentarios</a></li>
    </ul>
    
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
		
	 	$url = basename($_SERVER ["PHP_SELF"]);
		$limit_end = 10;
		$init = ($ini-1) * $limit_end;
		/* querys */
	
	//  FORMA ENCONTRADA POR MI 	
	//	$count = current($conn->query("SELECT COUNT(*)FROM usuarios")->fetch());
	
	//  FORMA PROFESOR 
				
		echo $usuario;
		
		if (($usuario == "admin"))
				
			{	$Scount = $conn->prepare("SELECT count(*) as NumReg FROM log"); 
				$Scount->execute();
				$Scount->setFetchMode(PDO::FETCH_ASSOC); 
	   			$count = $Scount->fetchAll()[0]['NumReg'];	
			
				$pagina = "SELECT IdLog, Texto, Fecha FROM log";
				$pagina .= " LIMIT $init, $limit_end";
			    
				$pagina = $conn->prepare($pagina);
				$pagina->execute();
				$total = ceil($count/$limit_end);
				 }
									
	    

		/* Obtener todas las filas restantes del conjunto de resultados */
		
		
		
		echo "<table border='1' class='table table-bordered table-hover'>
		  <thead><tr>
		  <th>Texto</th>
		  <th>Fecha</th>
		  </tr>
		  </thead>
		  <tbody>";
  
  while($row = $pagina->fetch(PDO::FETCH_ASSOC))
  {    
        $Texto = $row["Texto"];
		$Fecha = $row["Fecha"];
		echo '<tr><td>'.$row["Texto"].'</td>';
		echo '<td>'.$row["Fecha"].'</td>';
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
      echo "<li><a href='$url?pos=$k'>".$k."</a></li>";
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
   
  </form> 
   
  </div>
  </center>
  
  
  
 </body>
 
 
</html>
<?php
ob_end_flush();
?>