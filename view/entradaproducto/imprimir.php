<?php
    require 'view/vendor/fpdf/fpdf.php';
    $dato = $this->datos_entrada_entrada;
    $pdf = new FPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $parametros = $this->parametros;
    $logo = $parametros["Logo"];
    $moneda = $parametros["Moneda"];
    // ------------------ AGREGAR CABECERA
    $pdf->Image("archives/assets/$logo",10,5,40);
    //SetFont('TipodeFuente','Tipo de Letra Borita - Itallic',tamaño);
    $pdf->SetFont('Arial','B',15);
    $pdf->SetX(40);
    $pdf->SetFillColor(20,57,68);
    $pdf->Cell(110,10, $parametros["Empresa"],0,0,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(250,250,250);
    $pdf->Cell(40,10,'FECHA',1,1,'C',1);
    $pdf->SetX(40);
    $pdf->SetFont('Arial','',11);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(110,10,"COMPRA DE PRODUCTOS",0,0,'C');
    $pdf->SetX(150);
    $pdf->Cell(40,10,$dato["Fecha"],1,1,'C');
    $pdf->Sety(40);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(180,5,"JHONY CREATIVO",0,1,'R');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(180,5,utf8_decode("Trujillo - La Libertad - Perú"),0,1,'R');
    $pdf->SetX(10);
    // ----------------- AGREGAR CUERPO
    // -------------- ASUNTO
    // C1
    $pdf->SetX(20);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(30,5,'Codigo de entrada:',0,0,'L');
    // C2
    $pdf->SetFont('Arial','B',9);
    $pdf->MultiCell(120,5,$dato["Id"],0,'J');
    // C1
    $pdf->SetX(20);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(30,5,'Tipo de entrada:',0,0,'L');
    // C2
    $pdf->SetFont('Arial','B',9);
    $pdf->MultiCell(120,5,$dato["Tipo_entrada"],0,'J');
    // C1
    $pdf->SetX(20);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(30,5,'Documento:',0,0,'L');
    // C2
    $pdf->SetFont('Arial','B',9);
    $pdf->MultiCell(120,5,$dato["Tipo_documento"],0,'J');
    // C1
    $pdf->SetX(20);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(30,5,utf8_decode("N° de documento:"),0,0,'L');
    // C2
    $pdf->SetFont('Arial','B',9);
    $pdf->MultiCell(120,5,$dato["Numero"],0,'J');
    //C1
    $pdf->SetX(20);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(30,5,("Proveedor:"),0,0,'L');
    // C2
    $pdf->SetFont('Arial','B',9);
    $pdf->MultiCell(120,5,$dato["Proveedor"],0,'J');
    //C1
    $pdf->SetX(20);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(30,5,("Observacion:"),0,0,'L');
    // C2
    $pdf->SetFont('Arial','B',9);
    $pdf->MultiCell(120,5,$dato["Observacion"],0,'J');
    
    // -------------- PROYECTO
    $pdf->Ln(10);
    // C1
    $pdf->SetX(20);
    $pdf->SetFillColor(38,50,56);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(170,6,'DETALLE DE LA COMPRA DE PRODUCTOS',1,1,'C',1);
    $pdf->SetX(20);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(15,6,utf8_decode("Nº"),1,0,'C',1);
    $pdf->Cell(70,6,utf8_decode("PRODUCTO"),1,0,'C',1);
    $pdf->Cell(15,6,utf8_decode("U.M"),1,0,'C',1);
    $pdf->Cell(25,6,utf8_decode("CANTIDAD"),1,0,'C',1);
    $pdf->Cell(25,6,utf8_decode("PRECIO UNIT"),1,0,'C',1);
    $pdf->Cell(20,6,utf8_decode("TOTAL"),1,1,'C',1);
    $pdf->SetTextColor(0,0,0); 
    $cn = $this->conexion;
    $id = $dato["Id"];
    $productos = $cn->query("SELECT d.ID_PRODUCTO,p.NOMBRE,d.PRECIO,d.CANTIDAD,d.ID_UNIDAD,u.PREFIJO FROM detalle_salida_entrada_producto AS d INNER JOIN producto as p on d.ID_PRODUCTO = p.ID_PRODUCTO INNER JOIN precio_producto as pp ON pp.ID_PRECIO = d.ID_UNIDAD INNER JOIN unidad_medida as u on u.ID_UNIDAD = pp.ID_UNIDAD WHERE d.ID_SALIDA_ENTRADA = '$id'"); 
    $n = 1;
    $total_neto=0;
    foreach ($productos as $row) {
        $producto = $row["NOMBRE"];
        $cantidad = $row["CANTIDAD"];
        $precio = $row["PRECIO"];
        $unidad = $row["PREFIJO"];
        $total = number_format($cantidad*$precio,2);
        $total_neto += $total;
        if($n%2==0){
            $pdf->SetFillColor(135,139,144);
        }else{
            $pdf->SetFillColor(255,255,255);
        }
        $pdf->SetX(20);
        $pdf->Cell(15,6,$n,1,0,'C',1);
        $pdf->Cell(70,6,substr($producto,0,40),1,0,'L',1);
        $pdf->Cell(15,6,$unidad,1,0,'C',1);
        $pdf->Cell(25,6,$cantidad,1,0,'C',1);
        $pdf->Cell(25,6,$precio,1,0,'C',1);
        $pdf->Cell(20,6,$total,1,1,'C',1);
        $n++;
        
    }
    $pdf->SetFont('Arial','B',8);
    $pdf->SetFillColor(38,50,56);
    $pdf->SetTextColor(250,250,250);
    $pdf->SetX(20);
    $pdf->Cell(150,6,"TOTAL ".$moneda,1,0,'R',1);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(20,6,number_format($total_neto,2),1,0,'C',1);
    
    $pdf->Output();
?>