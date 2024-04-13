<?php
    require 'view/vendor/ticket/autoload.php';
    use Mike42\Escpos\Printer;
    use Mike42\Escpos\EscposImage;
    use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

    /*Conectamos con la impresora*/
    $nombre_impresora = trim(file('print/print.ini')[0]);
    $connector = new WindowsPrintConnector($nombre_impresora);
    $printer = new Printer($connector);

    // /* Datos de la empresa */
    $parametros = $this->parametros;
    $detalleticket = $this->detalleticket;
    $empresa = $parametros["Empresa"];
    $Direccion = $parametros["Direccion"];
    $Tipo = $parametros["Tipo"];
    $Logo = $parametros["Logo"];
    $Num = $parametros["Num"];
    $Moneda = $parametros["Moneda"];
    $Telefono = $detalleticket["Telefono"];
    $pie = $detalleticket["Pie"];

     // /* Dato del Ticket*/
    $id_venta = $this->idticket;

    /**Hacemos busqueda del cliente */
    $conexion = $this->conexion;
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
    $detallecompra = $conexion->query("SELECT * FROM venta_contado WHERE ID_VENTA = '$id_venta'");
    foreach($detallecompra as $row){
        $fechahora = $row["FECHAHORA"];
        $usuario = $row["ID_USUARIO"];
        $nombreusuario = $conexion->query("SELECT p.NOMBRE,p.APELLIDO FROM usuario as u INNER JOIN persona as p ON p.ID_PERSONA = u.ID_PERSONA WHERE u.ID_USUARIO = '$usuario'");
        foreach($nombreusuario as $row2){
            $usuario = ucfirst($row2["NOMBRE"])." ".ucfirst($row2["APELLIDO"]);
        }
        $cliente = $row["ID_CLIENTE"];
        $nombrecliente = $conexion->query("SELECT * FROM cliente WHERE ID_CLIENTE = '$cliente'");
        if($nombrecliente->rowCount()>0){
            foreach($nombrecliente as $rows){
                $nit = $rows["ID_CLIENTE"];
                $cliente = ucfirst($rows["NOMBRE"]);
                $direccion = $rows["DIRECCION"];
            }
        }else{
            $nit = "----";
            $cliente = "Publico General";
            $direccion = "----";
        }
        $subtotal = $row["SUBTOTAL"];
        $descuento = $row["DESCUENTO"];
        $total = $row["TOTAL"];
        $efectivo = $row["PAGOCON"];
        $cambio = $row["CAMBIO"];
        $estado = $row["ESTADO"];
    }

    // /*Cargamos el logo*/
    $ruta_imagen_logo = "archives/assets/$Logo";
    $logo = EscposImage::load($ruta_imagen_logo, false);

    /*Le decimos que centre lo que vaya a imprimir*/
    $printer->setJustification(Printer::JUSTIFY_CENTER);

    /*Imprimimos imagen y avanzamos el papel*/
    $printer->bitImage($logo);
    $printer->feed();
    

    $printer->setTextSize(2,2);
    $printer->text("$empresa \n");
    $printer->setTextSize(2,1);
    $printer->selectPrintMode(Printer::MODE_EMPHASIZED | Printer::MODE_FONT_B);
    $printer->text("$Tipo $Num \n");
    $printer->text("$Direccion \n");
    $printer->text("TELEFONO $Telefono \n");

    /*Hacemos que el texto sea en negritas e imprimimos el nùmero de venta*/
    $printer->setEmphasis(true);
    $printer->text("VENTA #" . $id_venta);
    $printer->setEmphasis(false);
    /**Imprimir Datos de la venta */
    $printer->feed();
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text("Fecha y Hora:" . $fechahora."\n");
    $printer->feed();
    $printer->text("Vendedor:" . $usuario."\n");
    $printer->feed();
    $printer->text("Cliente:" . $cliente."\n");
    $printer->text("N Documento:" . $nit."\n");
    $printer->text("Direccion:" . $direccion."\n");
    $printer->feed();
    // LLENAR PRODUCTOS
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $query_productos = $conexion->query("SELECT d.DETALLE,d.CANTIDAD,p.PRECIO FROM detalle_venta_contado as d INNER JOIN precio_producto as p ON d.ID_UNIDAD = p.ID_PRECIO WHERE d.ID_VENTA = '$id_venta'");
    foreach ($query_productos as $producto) {
        $cantidad = $producto["CANTIDAD"];
        $precio = $producto["PRECIO"];
        $nombre = $producto["DETALLE"];
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("$cantidad x $nombre - $Moneda $precio\n");
        $importe = $precio * $cantidad;
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text("$Moneda $importe\n");
    }
    $printer->text("--------\n");
    $printer->text("SUB TOTAL $Moneda " . $subtotal . "\n");
    $printer->text("DESCUENTO $Moneda " . $descuento . "\n");
    $printer->text("TOTAL $Moneda " . $total . "\n");
    $printer->text("EFECTIVO $Moneda " . $efectivo . "\n");
    $printer->text("CAMBIO $Moneda " . $cambio . "\n");
    $printer->feed();

    $printer->selectPrintMode(Printer::MODE_FONT_A);
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->text(strtoupper($pie));
    $printer->feed();
    $printer->cut();
    $printer->pulse();
    $printer->close();
    echo "<script languaje='javascript' >window.close();</script>";