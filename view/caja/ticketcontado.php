<?php
    require 'view/vendor/fpdf/fpdf.php';
    $ticket = $this->ticket;
    $cn = $this->conexion;
    $parametros = $this->parametros;
    $logo = $parametros["Logo"];
    $MONEDA = $parametros["Moneda"];
    // Detalle del ticket
    $detalleticket = $this->detalleticket;
    $tituloticket = $detalleticket["Titulo"];
    $direccionticket = $detalleticket["Direccion"];
    $telefonoticket = $detalleticket["Telefono"];
    $pieticket = $detalleticket["Pie"];
    $fechahora = "";
    $usuario = "";
    $cliente = "";
    $direccion = "";
    $nit = "";
    $total = "";
    $efectivo = "";
    $cambio = "";
    $estado = "";
    $subtotal = "";
    $descuento = "";
    //Detalle de la compra
    $detallecompra = $cn->query("SELECT * FROM venta_contado WHERE ID_VENTA = '$ticket'");
    foreach($detallecompra as $row){
        $fechahora = $row["FECHAHORA"];
        $usuario = $row["ID_USUARIO"];
        $nombreusuario = $cn->query("SELECT p.NOMBRE,p.APELLIDO FROM usuario as u INNER JOIN persona as p ON p.ID_PERSONA = u.ID_PERSONA WHERE u.ID_USUARIO = '$usuario'");
        foreach($nombreusuario as $row2){
            $usuario = ucfirst($row2["NOMBRE"])." ".ucfirst($row2["APELLIDO"]);
        }
        $cliente = $row["ID_CLIENTE"];
        $nombrecliente = $cn->query("SELECT * FROM cliente WHERE ID_CLIENTE = '$cliente'");
        if($nombrecliente->rowCount()>0){
            foreach($nombrecliente as $rows){
                $nit = $rows["ID_CLIENTE"];
                $cliente = ucfirst($rows["NOMBRE"]);
                $direccion = $rows["DIRECCION"];
            }
        }else{
            $nit = "Publico en General";
            $cliente = "----";
            $direccion = "---";
        }
        $subtotal = $row["SUBTOTAL"];
        $descuento = $row["DESCUENTO"];
        $total = $row["TOTAL"];
        $efectivo = $row["PAGOCON"];
        $cambio = $row["CAMBIO"];
        $estado = $row["ESTADO"];
    }
    // GENERAR PDF
    $pdf = new FPDF();
    $pdf->AliasNbPages();
    //image('./ubicacion',posicionx,posiciony,tamaño);
    //Agregar una Pagina
    $pdf->AddPage('p',[80,170]);
    // ------------------ AGREGAR CABECERA
    $pdf->Image("archives/assets/$logo",30,2,20);
    $pdf->SetFont('Arial','B',7);
    $pdf->SetY(22);
    $pdf->SetX(5);
    $pdf->Cell(70,3,$tituloticket,0,1,'C');
    if($estado == 0){
        $pdf->SetX(5);
        $pdf->SetFillColor(20,57,68);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(70,5,"VENTA CANCELADA",0,1,'C',1);
        $pdf->SetTextColor(0,0,0);
    }
    $pdf->SetFont('Arial','B',7);
    $pdf->SetX(5);
    $pdf->Cell(70,2, '------------------------------------------------------------------------------------',0,1,'L');
    $pdf->SetX(5);
    $pdf->Cell(20,3, 'Fecha y Hora:',0,0,'L');
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(40,3, "$fechahora",0,1,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->SetX(5);
    $pdf->Cell(70,2, '------------------------------------------------------------------------------------',0,1,'L');
    $pdf->SetX(5);
    $pdf->Cell(20,3, 'Direccion:',0,0,'L');
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(45,3,$direccionticket,0,1,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->SetX(5);
    $pdf->Cell(20,3, 'Telefono:',0,0,'L');
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(45,3, $telefonoticket,0,1,'L');
    $pdf->SetX(5);
    $pdf->SetFont('Arial','B',7);
    $pdf->SetX(5);
    $pdf->Cell(60,2, '------------------------------------------------------------------------------------',0,1,'L');
    $pdf->SetFont('Arial','',7);
    $pdf->SetX(5);
    $pdf->Cell(35,4, 'TICKET :',0,0,'R');
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(35,4, "$ticket",0,1,'L');
    $pdf->SetX(5);
    $pdf->Cell(60,1, '------------------------------------------------------------------------------------',0,1,'L');
    $pdf->SetX(5);
    $pdf->Cell(20,3, 'Vendedor:',0,0,'L');
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(45,3,$usuario,0,1,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->SetX(5);
    $pdf->Cell(20,3, 'NIT:',0,0,'L');
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(45,3, $nit,0,1,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->SetX(5);
    $pdf->Cell(20,3, 'Cliente:',0,0,'L');
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(45,3,$cliente,0,1,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->SetX(5);
    $pdf->Cell(20,3, 'Direccion:',0,0,'L');
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(45,3, $direccion,0,1,'L');
    $pdf->Cell(75,5, '',0,1,'L');
    $pdf->SetX(5);
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(10,3, 'Cant.',0,0,'L');
    $pdf->Cell(35,3, 'Descripcion',0,0,'L');
    $pdf->Cell(12,3, 'Precio',0,0,'L');
    $pdf->Cell(12,3, 'Importe',0,1,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->SetX(5);
    $pdf->Cell(60,1, '------------------------------------------------------------------------------------',0,1,'L');
    $listarproductos = $cn->query("SELECT d.DETALLE,d.CANTIDAD,p.PRECIO FROM detalle_venta_contado as d INNER JOIN precio_producto as p ON d.ID_UNIDAD = p.ID_PRECIO WHERE d.ID_VENTA = '$ticket'");
    $pdf->SetFont('Arial','',7);
    $articulos = 0;
    foreach($listarproductos as $row){
        $pdf->SetX(5);
        $cantidad = $row["CANTIDAD"];
        $precio = $row["PRECIO"];
        $nombre = $row["DETALLE"];
        $importe = number_format($cantidad * $precio,2);
        $pdf->Cell(10,3,$cantidad,0,0,'L');
        $pdf->Cell(35,3,substr($nombre,0,21),0,0,'L');
        $pdf->Cell(12,3, $MONEDA."$precio",0,0,'L');
        $pdf->Cell(12,3, $MONEDA."$importe",0,1,'L');
        $articulos += $cantidad; 
    }
    $pdf->SetFont('Arial','B',7);
    $pdf->SetX(5);
    $pdf->Cell(60,1, '------------------------------------------------------------------------------------',0,1,'L');
    $pdf->Cell(70,3, '',0,1,'L');
    $pdf->SetX(5);
    $pdf->Cell(40,4, '',0,0,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(14,4, 'Sub Total',0,0,'L');
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(16,4, $MONEDA."$subtotal",0,1,'L');
    $pdf->SetX(5);
    $pdf->Cell(40,4, '',0,0,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(14,4, 'Descuento',0,0,'L');
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(16,4, $MONEDA."$descuento",0,1,'L');
    $pdf->SetX(5);
    $pdf->Cell(40,4, '',0,0,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(14,4, 'Total',0,0,'L');
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(16,4, $MONEDA."$total",0,1,'L');
    $pdf->SetX(5);
    $pdf->Cell(40,4, '',0,0,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(14,4, 'Efectivo',0,0,'L');
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(16,4, $MONEDA."$efectivo",0,1,'L');
    $pdf->SetX(5);
    $pdf->Cell(40,4, '',0,0,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(14,4, 'Cambio',0,0,'L');
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(16,4, $MONEDA."$cambio",0,1,'L');
    $pdf->Cell(70,3, '',0,1,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->SetX(5);
    $pdf->Cell(60,1, '------------------------------------------------------------------------------------',0,1,'L');
    $pdf->SetX(5);
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(25,4, 'Articulos Vendidos',0,0,'L');
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(11,4, "$articulos",0,1,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->SetX(5);
    $pdf->Cell(60,1, '------------------------------------------------------------------------------------',0,1,'L');
    $pdf->SetX(5);
    $pdf->Cell(70,4, $pieticket,0,1,'C');
    $pdf->Output();
    ?>