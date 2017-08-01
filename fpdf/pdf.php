<?php
ob_start();
    require('fpdf.php');

    class PDF extends FPDF {
        // Cabecera de página
        function Header() {
            // Logo
            //$this->Image('tv.jpg',10,8,33);
            // Arial bold 15
            $this->SetFont('Arial','B',15);
            // Movernos a la derecha
            $this->Cell(80);
            // Título
            $this->Cell(0,10,'Universal Sports Inc.',0,0,'L');
            // Salto de línea
            $this->Ln(20);
        }

        // Pie de página
        function Footer() {
            // Posición: a 1,5 cm del final
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',8);
            // Número de página
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }	

    $border=0;

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,40,utf8_decode('Factura Nº 30145'),$border,1,'L');
    $pdf->Cell(105,10,utf8_decode('Producto'),$border,0,'L');
    $pdf->Cell(30,10,'Unidades',$border,0,'L');
    $pdf->Cell(40,10,'Precio',$border,1,'L');
	
		// conexion base de datos
	
	include 'conexionPHP.php';
				
		// conexión por PDO  (conexionesPHP.php)
 			PDO($servername, $username, $password, $dbname);
			
			$pagina = "SELECT comentarios.IdComentario, comentarios.IdUsuario, usuarios.Nombre , comentarios.comentario, comentarios.Fecha, usuarios.color FROM comentarios INNER JOIN usuarios on comentarios.IdUsuario = usuarios.IdUsuario ORDER BY ". $order;
									
	    $pagina = $conn->prepare($pagina);
		$pagina->execute();
		
		while($row = $pagina->fetch(PDO::FETCH_ASSOC))
  {    
        $nombre = $row["Nombre"];
		$comentario = $row["comentario"];
		$fecha = $row["Fecha"];
	    
        $pdf->Cell(105,10,$nombre,$border,0,'L');
        $pdf->Cell(30,10,$comentario,$border,0,'L');
        $pdf->Cell(40,10,$fecha,$border,1,'L');	
    }

    $pdf->Output();
	ob_end_flush();
?>