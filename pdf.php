<?php
ob_start();
session_start();

    include('fpdf.php');
	
	include 'conexionPHP.php';
	
    class PDF extends FPDF {
        // Cabecera de página
        function Header() {
           
            // Arial bold 15
            $this->SetFont('Arial','B',15);
            // Movernos a la derecha
            $this->Cell(80);
            // Título
            $this->Cell(0,10,'Listado de comentarios',0,0,'L');
            // Salto de línea
            $this->Ln(10);
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
    //$pdf->Cell(0,40,utf8_decode('Listado'),$border,1,'L');
    $pdf->Cell(105,10,'Usuario',$border,0,'L');
    $pdf->Cell(30,10,'idusuario',$border,0,'L');
    $pdf->Cell(40,10,'Comentario',$border,1,'L');

	$consulta = "SELECT comentarios.IdComentario, comentarios.IdUsuario, usuarios.Nombre , comentarios.comentario, comentarios.Fecha, usuarios.color FROM comentarios INNER JOIN usuarios on comentarios.IdUsuario = usuarios.IdUsuario";
	
  $query = $conn->prepare($consulta);
  $query->execute();		
  $result = $query->fetchAll();	
  foreach($result as $row)
    	{
		$pdf->Cell(105,10,$row['Nombre'],$border,0,'L');
        $pdf->Cell(30,10,$row['IdUsuario'],$border,0,'L');
        $pdf->Cell(40,10,$row['comentario'],$border,1,'L');			
		}
$conn = null; 
$pdf->Output();
ob_end_flush();
?>