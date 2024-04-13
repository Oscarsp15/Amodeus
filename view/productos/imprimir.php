<?php
    require 'view/vendor/fpdf/fpdf.php';
    $pdf = new FPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    // PARAMETROS 
    $parametros = $this->parametros;
    $logo = $parametros["Logo"];
    $MONEDA = $parametros["Moneda"];
    // ------------------ AGREGAR CABECERA
    $pdf->Image("archives/assets/$logo",10,5,40);
    //SetFont('TipodeFuente','Tipo de Letra Borita - Itallic',tamaño);
    $pdf->SetFont('Arial','B',15);
    $pdf->SetX(40);
    $pdf->SetFillColor(20,57,68);
    $pdf->Cell(110,10, $parametros['Empresa'],0,0,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(250,250,250);
    $pdf->Cell(40,10,'FECHA',1,1,'C',1);
    $pdf->SetX(40);
    $pdf->SetFont('Arial','',11);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(110,10,"REPORTE DE INVENTARIO",0,0,'C');
    $pdf->SetX(150);
    $pdf->Cell(40,10,date('Y-m-d'),1,1,'C');
    $pdf->Sety(40);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(180,5,"",0,1,'R');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(180,5,utf8_decode(""),0,1,'R');
    $pdf->SetX(20);
    $pdf->SetFillColor(38,50,56);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(170,6,'DETALLE DE PRODUCTOS',1,1,'C',1);
    $pdf->SetX(20);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(10,6,utf8_decode("Nº"),1,0,'C',1);
    $pdf->Cell(65,6,utf8_decode("PRODUCTO"),1,0,'C',1);
    $pdf->Cell(30,6,utf8_decode("COD. BARRA"),1,0,'C',1);
    $pdf->Cell(15,6,utf8_decode("STOCK"),1,0,'C',1);
    $pdf->Cell(25,6,utf8_decode("PRECIO X UNIT"),1,0,'C',1);
    $pdf->Cell(25,6,utf8_decode("VALOR"),1,1,'C',1);
    $pdf->SetTextColor(0,0,0); 
    $cn = $this->conexion;
    $productos = $cn->query("SELECT p.NOMBRE,p.CODIGO_BARRA,pp.STOCK,p.PRECIO_COSTO FROM productos_almacen as pp INNER JOIN producto as p on pp.ID_PRODUCTO = p.ID_PRODUCTO"); 
    $n = 1;
    $total=0;
    foreach ($productos as $row) {
        $producto = $row["NOMBRE"];
        $cantidad = $row["STOCK"];
        $codigo_barra = $row["CODIGO_BARRA"];
        $precio = $row["PRECIO_COSTO"];
        $total += $cantidad*$precio;
        if($n%2==0){
            $pdf->SetFillColor(135,139,144);
        }else{
            $pdf->SetFillColor(255,255,255);
        }
        $valor = number_format($precio*$cantidad,2);
        $pdf->SetX(20);
        $pdf->Cell(10,6,$n,1,0,'C',1);
        $pdf->Cell(65,6,substr($producto,0,42),1,0,'L',1);
        $pdf->Cell(30,6,$codigo_barra,1,0,'L',1);
        $pdf->Cell(15,6,$cantidad,1,0,'C',1);
        $pdf->Cell(25,6,$MONEDA.$precio,1,0,'C',1);
        $pdf->Cell(25,6,$MONEDA.$valor,1,1,'C',1);
        $n++;
        
    }
    $pdf->SetFont('Arial','B',8);
    $pdf->SetFillColor(38,50,56);
    $pdf->SetTextColor(250,250,250);
    $pdf->SetX(20);
    $pdf->Cell(145,6,"TOTAL",1,0,'R',1);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(25,6,$MONEDA.number_format($total,2),1,0,'C',1);
    
    $pdf->Output();
?>