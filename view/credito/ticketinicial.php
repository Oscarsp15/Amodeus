<?php
    require 'view/vendor/fpdf/fpdf.php';
    $cn = $this->conexion;
    // Detalle del ticket
    $venta = $this->venta;
    $detalleticket = $this->detalleticket;
    $parametros = $this->parametros;
    $logo = $parametros['Logo'];
    $moneda = $parametros['Moneda'];
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
    //Detalle del credito
    $detallecompra = $cn->query("SELECT * FROM ticket_inicial_credito WHERE ID_VENTA = '$venta'");
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
        $inicial = $row["INICIAL"];
        $efectivo = $row["PAGOCON"];
        $cambio = $row["CAMBIO"];
    }
    $credito_total = $cn->query("SELECT INTERES FROM venta_credito WHERE ID_VENTA = '$venta'");
    $credito = $credito_total->fetchColumn(0);
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
    $pdf->SetFillColor(20,57,68);
    $pdf->Cell(70,3,$tituloticket,0,1,'C');
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
    $pdf->Cell(50,4, 'TICKET DE INICIAL DE CREDITO:',0,0,'R');
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(10,4, "$venta",0,1,'L');
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
    $pdf->Cell(75,2, '',0,1,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->SetX(5);
    $pdf->Cell(70,3, 'PRODUCTOS DEL CREDITO',0,1,'C');
    $pdf->SetX(5);
    $pdf->Cell(60,1, '------------------------------------------------------------------------------------',0,1,'L');
    $pdf->SetX(5);
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(10,3, 'Cant.',0,0,'L');
    $pdf->Cell(35,3, 'Descripcion',0,0,'L');
    $pdf->Cell(12,3, 'Precio',0,0,'L');
    $pdf->Cell(12,3, 'Importe',0,1,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->SetX(5);
    $pdf->Cell(60,1, '------------------------------------------------------------------------------------',0,1,'L');
    $listarproductos = $cn->query("SELECT d.DETALLE,d.CANTIDAD,p.PRECIO FROM detalle_venta_credito as d INNER JOIN precio_producto as p ON d.ID_UNIDAD = p.ID_PRECIO WHERE d.ID_VENTA = '$venta'");
    $pdf->SetFont('Arial','',7);
    foreach($listarproductos as $row){
        $pdf->SetX(5);
        $cantidad = $row["CANTIDAD"];
        $precio = $row["PRECIO"];
        $nombre = $row["DETALLE"];
        $importe = number_format($cantidad * $precio,2);
        $pdf->Cell(10,3,$cantidad,0,0,'L');
        $pdf->Cell(35,3,substr($nombre,0,28),0,0,'L');
        $pdf->Cell(12,3, $moneda."$precio",0,0,'L');
        $pdf->Cell(12,3, $moneda."$importe",0,1,'L');
    }
    $contarcuotas = $cn->query("SELECT * FROM cuotas_credito WHERE ID_VENTA = '$venta'");
    $cuotas = $contarcuotas->rowCount();
    $pdf->SetFont('Arial','B',7);
    $pdf->SetX(5);
    $pdf->Cell(60,1, '------------------------------------------------------------------------------------',0,1,'L');
    $pdf->Cell(70,3, '',0,1,'L');
    $pdf->SetX(5);
    $pdf->Cell(25,4, '',0,0,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(22,4, 'Monto de Credito',0,0,'R');
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(22,4, $moneda."$credito",0,1,'L');
    $pdf->SetX(5);
    $pdf->Cell(25,4, '',0,0,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(22,4, 'Inicial',0,0,'R');
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(22,4, $moneda."$inicial",0,1,'L');
    $pdf->SetX(5);
    $pdf->Cell(25,4, '',0,0,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(22,4, 'Efectivo',0,0,'R');
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(22,4, $moneda."$efectivo",0,1,'L');
    $pdf->SetX(5);
    $pdf->Cell(25,4, '',0,0,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(22,4, 'Cambio',0,0,'R');
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(22,4, $moneda."$cambio",0,1,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->SetX(5);
    $pdf->Cell(60,3, '------------------------------------------------------------------------------------',0,1,'L');
    $pdf->SetX(5);
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(25,4, 'Cuotas Pendientes',0,0,'L');
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(11,4, "$cuotas",0,1,'L');
    $pdf->SetFont('Arial','B',7);
    $pdf->SetX(5);
    $pdf->Cell(60,1, '------------------------------------------------------------------------------------',0,1,'L');
    $pdf->SetX(5);
    $pdf->Cell(70,4, $pieticket,0,1,'C');
    $pdf->Output();
?>