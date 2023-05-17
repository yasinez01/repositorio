<?php
include 'fpdf.php';
include "administrador/basededatos.php";

define("ERROR_CARGA_DATOS", array([-1]));

class PDF extends FPDF
{

    function Header()
    {
        //Imagen de cabecera
        $this->Image('img/icono.png', 10, 10, 20 , 20, 'PNG', 'https://www.emtmadrid.es/Home');

        //Titulo
        $this->SetFont('Arial','B', 20);
        $this->SetX(35);
        $this->Cell(50, 10, 'Listado de Usuarios', 0, 1, 'L');

        //Subtitulo
        $this->SetFont('Arial','B', 16);
        $this->SetTextColor(0, 13, 201);
        $this->SetX(35);
        $this->Cell(50, 10, 'EMT Madrid', 0, 1, 'L');
    }

    function Footer()
    {
        //Pie de pagina
        $this->SetY(-10);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 10, 'Listado de Usuarios | EMT Madrid | '.utf8_decode('Página').' '.$this->PageNo(), 0, 0, 'R');
    }

    function mostrarmensaje($titulo, $texto) {
		$pagina = file_get_contents("administrador/mensaje.html");
		$pagina = str_replace("##titulo##", $titulo, $pagina);
		$pagina = str_replace("##texto##", $texto, $pagina);
		echo $pagina;		
	}

    function obtenerlistadousuarios($con) {
		$consulta = "Select * from db_grupo28.final_usuario";
		if ($resultado = $con->query($consulta)) {
			return $resultado;
		} else {
			return -1;
		}
	}

    function cargadatosusuarios($resultado) { //vmostrarlistadousuarios(mlistadousuario($con));
		//$pagina = file_get_contents("administrador/listadousuarios.html");
		if (!is_object($resultado)) {
			$this->mostrarmensaje("Listado de personas", "Se ha producido un error en el sistema. Vuelva a intentarlo. Y si el problema persiste póngase en contacto con el administrador.");	
            return array([-1]);	
		} else {
            $data = array();
			while ($datos = $resultado->fetch_assoc()) {
                
				if($datos['administrador'] == 0){
					$admin = "No es administrador";
				}else{
					$admin = "Es administrador";
				}

                $line = $datos['id'].';'.$datos['usuario'].';'.$datos['password'].';'.$admin;
                $data[] = explode(';',trim($line));
			}
            return $data;
		}
	}

    // Tabla coloreada
    function FancyTable($header, $data)
    {
        //La cabecera y el footer se realizan directamente con la llamada al objeto PDF.
        $this->Ln();

        // Colores, ancho de línea y fuente en negrita
        $this->SetFont('','B',14);
        $this->SetFillColor(0, 49, 134);    //Color del encabezado.
        $this->SetTextColor(255);           //Color blanco de texto en el encabezado.
        $this->SetDrawColor(0, 200, 255);   //Color de los bordes. 128,0,0
        $this->SetLineWidth(.3);
        //$this->SetFont('','B');

        // Cabecera
        $w = array(20, 60, 60, 50); //Dimensiones de las columnas.
        for($i=0; $i<count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->Ln();

        // Restauración de colores y fuentes
        $this->SetFillColor(224,235,255); //Color de algunas celdas de la tabla. 224,235,255
        $this->SetTextColor(0);
        $this->SetFont('');

        // Datos
        $fill = false;
        foreach($data as $row)
        {
            $this->Cell($w[0],6,number_format($row[0]),'LR',0,'C',$fill);
            $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
            $this->Cell($w[2],6,$row[2],'LR',0,'L',$fill);
            $this->Cell($w[3],6,$row[3],'LR',0,'L',$fill);
            //$this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
            //$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
            //$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        $this->Cell(array_sum($w),0,'','T');
    }
}

$pdf = new PDF();

// Títulos de las columnas
$header = array('ID', 'Usuario', 'Password', 'Administrador');

// Carga de datos
$data = $pdf->cargadatosusuarios($pdf->obtenerlistadousuarios($con));

if($data != ERROR_CARGA_DATOS) {
    $pdf->SetFont('Arial','',14);
    $pdf->AddPage();
    $pdf->FancyTable($header, $data);
    $pdf->Output();
}
?>