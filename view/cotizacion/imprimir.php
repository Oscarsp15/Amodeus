<?php
    require 'view/vendor/fpdf/fpdf.php';
    $cotizacion = $this->id;
    $cn = $this->conexion;
    // Instaciar Variables
    $fecha_creacion = "";
    $cotizado_por = "";
    $identificacion_c = "";
    $cliente_c = "";
    $tipo_entrega = "";
    $subtotal = "";
    $descuento = "";
    $total = "";
    $parametros = $this->parametros;
    $empresa = $parametros["Empresa"];
    $Direccion = $parametros["Direccion"];
    $Tipo = $parametros["Tipo"];
    $Logo = $parametros["Logo"];
    $Num = $parametros["Num"];
    $MONEDA = $parametros["Moneda"];

    $datos = $cn->query("SELECT c.FECHA,c.ENTREGA,c.SUBTOTAL,c.DESCUENTO,c.PRECIO_VENTA,cl.NOMBRE,c.ID_CLIENTE,p.NOMBRE as 'persona', p.APELLIDO FROM cotizacion as  c inner join cliente as cl on c.ID_CLIENTE = cl.ID_CLIENTE inner join usuario as u on u.ID_USUARIO = c.ID_USUARIO inner join persona as p on p.ID_PERSONA = u.ID_PERSONA where c.ID_COTIZACION = '$cotizacion' ");
    foreach($datos as $row){
        $fecha_creacion = $row["FECHA"];
        $identificacion_c = $row["ID_CLIENTE"];
        $cliente_c = $row["NOMBRE"];
        $cotizado_por = $row["persona"].' '.$row["APELLIDO"] ;
        $tipo_entrega = $row["ENTREGA"];
        if($tipo_entrega == 1){
            $tipo_entrega = "Por Pedido";
        }else{
            $tipo_entrega = "Entrega Inmediata";
            
        }
        $subtotal = $row["SUBTOTAL"];
        $descuento = $row["DESCUENTO"];
        $total = $row["PRECIO_VENTA"];
    }
    // CREACION DE PDF
    $pdf = new FPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    // ------------------ AGREGAR CABECERA
    $pdf->Image("archives/assets/$Logo",10,5,40);
    //SetFont('TipodeFuente','Tipo de Letra Borita - Itallic',tamaño);
    $pdf->SetFont('Arial','B',15);
    $pdf->SetX(40);
    $pdf->SetFillColor(20,57,68);
    $pdf->Cell(110,7, "$empresa",0,0,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(250,250,250);
    $pdf->Cell(40,7,'COTIZACION',0,1,'C',1);
    $pdf->SetX(40);
    $pdf->SetFont('Arial','',11);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(110,7,"$Direccion",0,0,'C');
    $pdf->Cell(40,7,$cotizacion,1,1,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->SetX(40);
    $pdf->Cell(110,7,utf8_decode("$Tipo : $Num"),0,1,'C');
    $pdf->Cell(110,7,"",0,1,'C');
    $pdf->SetX(50);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(40,7,utf8_decode("Fecha de creación:"),0,0,'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(40,7,utf8_decode("$fecha_creacion"),0,1,'L');
    $pdf->SetX(50);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(40,7,utf8_decode("Cotizado por:"),0,0,'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(40,7,utf8_decode("$cotizado_por"),0,1,'L');
    $pdf->SetX(50);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(40,7,utf8_decode("Identificación Cliente:"),0,0,'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(40,7,utf8_decode("$identificacion_c"),0,1,'L');
    $pdf->SetX(50);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(40,7,utf8_decode("Cliente:"),0,0,'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(100,7,utf8_decode("$cliente_c"),0,1,'L');
    $pdf->SetX(50);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(40,7,utf8_decode("Tipo de Entrega:"),0,0,'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(100,7,utf8_decode("$tipo_entrega "),0,1,'L');
    $pdf->SetX(50);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(180,2,'',0,1,'C');
    $pdf->SetFillColor(38,50,56);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFont('Arial','B',8);
    $pdf->SetX(20);
    $pdf->Cell(170,6,'DETALLE DE LOS PRODUCTOS',1,1,'C',1);
    $pdf->SetX(20);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(12,6,utf8_decode("CANT."),1,0,'C',1);
    $pdf->Cell(108,6,utf8_decode("PRODUCTO"),1,0,'C',1);
    $pdf->Cell(25,6,utf8_decode("PRECIO X UNIT"),1,0,'C',1);
    $pdf->Cell(25,6,utf8_decode("VALOR"),1,1,'C',1);
    $pdf->SetTextColor(0,0,0); 
    $cotizacion_detalle = $cn->query("SELECT dc.CANTIDAD,dc.DETALLE,pp.PRECIO FROM detalle_cotizacion as dc INNER JOIN precio_producto as pp on dc.ID_UNIDAD = pp.ID_PRECIO WHERE dc.ID_COTIZACION = '$cotizacion'"); 
    $n = 1;
    foreach ($cotizacion_detalle as $row) {
        $cantidad = $row["CANTIDAD"];
        $producto = $row["DETALLE"];
        $precio = $row["PRECIO"];
        if($n%2==0){
            $pdf->SetFillColor(135,139,144);
        }else{
            $pdf->SetFillColor(255,255,255);
        }
        $valor = number_format($precio*$cantidad,2);
        $pdf->SetX(20);
        $pdf->Cell(12,6,$cantidad,1,0,'C',1);
        $pdf->Cell(108,6,substr($producto,0,42),1,0,'L',1);
        $pdf->Cell(25,6,$MONEDA.$precio,1,0,'C',1);
        $pdf->Cell(25,6,$MONEDA.$valor,1,1,'C',1);
        $n++;
        
    }
    $pdf->SetFont('Arial','B',8);
    $pdf->SetFillColor(38,50,56);
    $pdf->SetTextColor(250,250,250);
    $pdf->SetX(20);
    $pdf->Cell(145,6,"SUB TOTAL",1,0,'R',1);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(25,6,$MONEDA.number_format($subtotal,2),1,1,'C',1);
    $pdf->SetX(20);
    $pdf->SetFillColor(38,50,56);
    $pdf->SetTextColor(250,250,250);
    $pdf->Cell(145,6,"DESCUENTO",1,0,'R',1);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(25,6,MONEDA.number_format($descuento,2),1,1,'C',1);
    $pdf->SetX(20);
    $pdf->SetFillColor(38,50,56);
    $pdf->SetTextColor(250,250,250);
    $pdf->Cell(145,6,"TOTAL",1,0,'R',1);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(25,6,MONEDA.number_format($total,2),1,1,'C',1);
    
    $pdf->Output();
?>