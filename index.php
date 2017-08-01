<?php
ob_start();
// Start the session
session_start();
// if ($_SESSION['x'] == 0) 
// {$_SESSION['x']=1;}
$Intentos = 0;
$Bloqueo = 0;
include 'conexionPHP.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <title>FORO</title> 
<style> 
	.error {color: #FF0000;}

	#container {
		        margin:auto;
			    padding:0;
			  /*  width:500px; */
				background-color:#CCC;
               }
	.boton {margin-left:275px;
			margin-bottom:10px;
			margin-top:10px;
			border-radius:5px solid #3F0;
			height:40px;
			width:200px;
			background-color:#CCC;
			font-family:Verdana, Geneva, sans-serif;}
</style>
</head>
<body>
<?php
// define variables and set to empty values
$usuarioErr = ""; 


//if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
  if (isset($_POST['Registro']))
  {
	  header('location:usuarios.php');
  } 
  
  
  if (isset($_POST["boton"]))
  { 
  	  	
	$email=$_POST['email'];
	$paso=$_POST['paso'];
	
	//		header('Location:validacion.php?cod='.$email.'&pas='.$paso);
	//      
			
	    	echo $email;
			
		// conexión por PDO  (conexionesPHP.php)
 			PDO($servername, $username, $password, $dbname);
						
					
			$stmt = $conn->prepare("SELECT * FROM usuarios where email='$email'"); 
  			  $stmt->execute();
		//	  $stmt->setFetchMode(PDO::FETCH_ASSOC); 
			  $row =$stmt->fetch();
			  
			  $Bloqueo = $row['Bloqueo'];
			  
			  
			
			if ($row && $Bloqueo == '0')
				{   echo "Encuentra Uusario";
					$id = $row['IdUsuario'];
					$nombre = $row['Nombre'];
				//	$_SESSION['x'] = $row['Intentos'];
					$Intentos = $row['Intentos'];
					$Bloqueo = $row['Bloqueo'];
			
					$pagina = "SELECT * FROM usuarios WHERE email='$email' and pasword='$paso'";
						
        			$pagina = $conn->prepare($pagina);
					$pagina->execute();
					$row = $pagina->fetch();
					
					
			
				if ($row)
				{   echo "Encuentra Uusario y Pasword";
					$id = $row['IdUsuario'];
					$nombre = $row['Nombre'];
			//		$_SESSION['x'] = $row['Intentos'];
					$Intentos = $row['Intentos'];
					$Bloqueo = $row['Bloqueo'];
					
					
					$_SESSION['idu'] = $id;
					$_SESSION['nomusu'] = $nombre;
					
					$Texto = $nombre." se ha conectado correctamente";
				 				
					$sql = "INSERT INTO log (Texto)	VALUES ('$Texto')";
				    	
   					$conn->exec($sql);  
				
		 	//	header('Location:Comentarios.php?cod='.$id.'&nom='.$nombre);
		
					if ($Bloqueo == 0)   { 
						header('Location:comentarios.php'); 
				}
				}
				 else
				{ 
				  echo "Encuentra Uusario y No Pasword";
		//		  if ($_SESSION['x'] <= 3)
				  if ($Intentos <= 3)
				  	{
				//   $_SESSION['x']++;
					$Intentos++;
				//  $sqlintentos = "UPDATE usuarios SET Intentos=".$_SESSION['x']." WHERE email='$email'";
				$sqlintentos = "UPDATE usuarios SET Intentos=".$Intentos." WHERE email='$email'";
						$sqlintentos = $conn->prepare($sqlintentos);
				$sqlintentos->execute();
				
				$Texto = $nombre." ha realizado 1 intento fallido de conexion";
				echo $Texto;
				
				$sql = "INSERT INTO log (Texto)
					VALUES ('$Texto')";
				echo $sql;
    	
   				 $conn->exec($sql);  
					}	
				  else
				  {
					  $sqlintentos = "UPDATE usuarios SET Bloqueo='1', Intentos=0 WHERE email='$email'";
						$sqlintentos = $conn->prepare($sqlintentos);
				$sqlintentos->execute();
				
					$Texto = $nombre." ha sido bloqueado por exceder el numero de intentos de conexion";
				
					$sql = "INSERT INTO log (Texto)
					VALUES ('$Texto')"; 
    	
   					 $conn->exec($sql);  
				
				  }
		
        	
						
				 
						 
					//	 header('location: Index.php'); 
					
				}	
	//	
				}
		$conn = null;
   	 }
?>
<form  method="post" >

	<div id="container">
    
    <div class="jumbotron">
    <h2 align="center"> FORO DE COMENTARIOS </h2> 
</div>
		        
        <div class="form-group col-xs-6">
		  	<label for="usr">* Email:</label>
  			<input type="text" class="form-control" id="usr" name="email">
            <span class="error"> <?php echo $usuarioErr;?></span>
		</div>
        
    	<div class="form-group col-xs-6">
		  	<label for="pwd">* Contraseña:</label>
  			<input type="text" class="form-control" id="pwd" name="paso">
      	</div>    
		
        <br>
        
        <input type="submit" class="boton" name="boton" value="Aceptar"/>
        
		<input type="submit" class="boton" name="Registro" value="Registrarse"/>
        
        
        <p><span class="error">* <i> Campos Obligatorios </i> </span></p>
        
        <div id="error"><?php if (($Intentos > 3) || ($Bloqueo == 1))
						
						{ echo "<span class='error'>Usuario Bloqueado - Contacte con el administrador </span>"; }
						
						?>
        </div>
        
                
	</div>
</form>

</body>
</html>
<?php
ob_end_flush();
?>