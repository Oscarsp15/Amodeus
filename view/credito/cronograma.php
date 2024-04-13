<?php
    require 'view/vendor/fpdf/fpdf.php';
    $idventa = $this->idventa;
    $cn = $this->conexion;
    $parametros = $this->parametros;
    $logo = $parametros['Logo'];
    $moneda = $parametros['Moneda'];
    $fecha = "";
    $vendedor = "";
    $cliente = "";
    $nombre = "";
    $direccion = "";
    $subtotal = "";
    $interes = "";
    $descuento = "";
    $inicial = "";
    $total = "";
    $buscardatosventa = $cn->query("SELECT * FROM venta_credito WHERE ID_VENTA = '$idventa'");
    foreach( $buscardatosventa as $row){
        $fecha = $row["FECHA"];
        $vendedor = $row["ID_USUARIO"];
        $subtotal = $row["TOTAL"];
        $interes = $row["TASA"];
        $descuento = $row["DESCUENTO"];
        $inicial = $row["INICIAL"];
        $total = $row["INTERES"];
        $nombrevendedor = $cn->query("SELECT p.NOMBRE FROM usuario as u INNER JOIN persona as p on p.ID_PERSONA = u.ID_PERSONA WHERE u.ID_USUARIO = '$vendedor'");
        $vendedor = ucfirst($nombrevendedor->fetchColumn(0));
        $cliente = $row["ID_CLIENTE"];
        $datoscliente = $cn->query("SELECT * FROM cliente WHERE ID_CLIENTE = '$cliente'");
        foreach($datoscliente as $client){
            $cliente = $client["ID_CLIENTE"];
            $nombre = ucfirst($client["NOMBRE"]);
            $direccion = ucfirst($client["DIRECCION"]);
        }
    } 
    // GENERAR PDF
    $pdf = new FPDF();
    $pdf->AliasNbPages();
    //image('./ubicacion',posicionx,posiciony,tamaño);
    //Agregar una Pagina
    $pdf->AddPage();
    // ------------------ AGREGAR CABECERA
    $pdf->Image("archives/assets/$logo",10,5,40);
    //SetFont('TipodeFuente','Tipo de Letra Borita - Itallic',tamaño);
    $pdf->SetFont('Arial','B',15);
    $pdf->SetX(10);
    $pdf->SetFillColor(20,57,68);
    $pdf->Cell(190,10, 'CRONOGRAMA DE PAGOS',0,1,'C');
    $pdf->Cell(190,5, '',0,1,'C');
    $pdf->Cell(50,5,'',0,0,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(40,5,'Fecha de Contrato:',0,0,'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(50,5,$fecha,0,0,'L');
    $pdf->SetFillColor(38,50,56);
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell(50,5, 'Codigo de Venta',1,1,'C',1);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(50,5,'',0,0,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(40,5,'Vendedor:',0,0,'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(50,5,$vendedor,0,0,'L');
    $pdf->Cell(50,5,$idventa,1,1,'C');
    $pdf->Cell(50,5,'',0,0,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(40,5,'NIT:',0,0,'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(100,5, $cliente,0,1,'L');
    $pdf->Cell(50,5,'',0,0,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(40,5,'Cliente:',0,0,'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(100,5, $nombre,0,1,'L');
    $pdf->Cell(50,5,'',0,0,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(40,5,'Direccion:',0,0,'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(100,5, $direccion,0,1,'L');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(190,10, 'Importante: Todos los pagos deben realizarse unicamente en el local donde realizo su compra.',0,1,'L');
    $pdf->SetFillColor(38,50,56);
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell(47,7, 'Concepto',1,0,'C',1);
    $pdf->Cell(47,7, 'Monto',1,0,'C',1);
    $pdf->Cell(48,7, 'Fecha de Vencimiento',1,0,'C',1);
    $pdf->Cell(48,7, 'Observaciones',1,1,'C',1);
    $pdf->SetTextColor(0,0,0);
    $cuotas = $cn->query("SELECT * FROM cuotas_credito WHERE ID_VENTA = '$idventa'");
    foreach($cuotas as $row){
        $pdf->SetFont('Arial','',10);
        $cuota = $row["NUM_CUOTA"];
        $dia = $row["DIA"];
        if($dia<10){
            $dia = "0".$dia;
        }
        $mes = $row["MES"];
        if($mes<10){
            $mes = "0".$mes;
        }
        $year = $row["ANO"];
        $monto = number_format($row["MONTOCUOTA"],2);
        $fecha = $year."-".$mes."-".$dia;
        $estado = $row["ESTADO"];
        if($estado == 1){
            $estado = "Pendiente";
        }else{
            $estado = "Cancelado";
        }
        $pdf->Cell(47,7, "Cuota $cuota",1,0,'C');
        $pdf->Cell(47,7, $moneda."$monto",1,0,'C');
        $pdf->Cell(48,7, "$fecha",1,0,'C');
        $pdf->Cell(48,7, $estado,1,1,'C');
    }
    $pdf->Cell(190,3, '',0,1,'L');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(190,10, 'LISTA DE PRODUCTOS ADQUIRIDOS',0,1,'C');
    $pdf->SetFillColor(38,50,56);
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell(15,7, 'Cant.',1,0,'C',1);
    $pdf->Cell(105,7, 'Descripcion',1,0,'L',1);
    $pdf->Cell(35,7, 'Precio',1,0,'C',1);
    $pdf->Cell(35,7, 'Importe',1,1,'C',1);
    $pdf->SetTextColor(0,0,0);
    $listarproductos = $cn->query("SELECT d.DETALLE,d.CANTIDAD,p.PRECIO FROM detalle_venta_credito as d INNER JOIN precio_producto as p ON d.ID_UNIDAD = p.ID_PRECIO WHERE d.ID_VENTA = '$idventa'");
    $pdf->SetFont('Arial','',10);
    $articulos = $listarproductos->rowCount();
    foreach($listarproductos as $row){
        $cantidad = $row["CANTIDAD"];
        $precio = $row["PRECIO"];
        $nombre = $row["DETALLE"];
        $importe = number_format($cantidad * $precio,2);
        $pdf->Cell(15,5,$cantidad,1,0,'C');
        $pdf->Cell(105,5,substr($nombre,0,38),1,0,'L');
        $pdf->Cell(35,5, $moneda."$precio",1,0,'C');
        $pdf->Cell(35,5, $moneda."$importe",1,1,'C');
    }
    $pdf->Cell(190,3, '',0,1,'L');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(190,10, 'INFORME DE CREDITO',0,1,'C');
    $pdf->SetFillColor(38,50,56);
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell(35,7, 'Sub Total',1,0,'C',1);
    $pdf->Cell(35,7, 'Interes %',1,0,'C',1);
    $pdf->Cell(35,7, 'Descuento',1,0,'C',1);
    $pdf->Cell(35,7, 'Inicial',1,0,'C',1);
    $pdf->Cell(50,7, 'Credito Total',1,1,'C',1);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(35,7, $moneda.number_format($subtotal,2),1,0,'C');
    $pdf->Cell(35,7, number_format($interes,2)."%",1,0,'C');
    $pdf->Cell(35,7, $moneda.number_format($descuento,2),1,0,'C');
    $pdf->Cell(35,7, $moneda.number_format($inicial,2),1,0,'C');
    $pdf->Cell(50,7, $moneda.number_format($total,2),1,1,'C');
    $pdf->Output();
    ?>