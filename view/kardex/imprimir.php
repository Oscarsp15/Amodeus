<?php
    require 'view/vendor/fpdf/fpdf.php';
    // GENERAR PDF
    $pdf = new FPDF();
    $cn = $this->conexion;
    $parametros = $this->parametros;
    $MONEDA = $parametros["Moneda"];

    $nombre = strtoupper($this->nombre_producto);
    $dato = $this->datos_productos;
    $y = $this->year;
    $m = $this->mes;
    $tipo = $this->tipo;
    $p = $this->producto;
    $pdf->AliasNbPages();
    //image('./ubicacion',posicionx,posiciony,tamaño);
    //Agregar una Pagina
    $pdf->AddPage('L','A4');
    // ------------------ AGREGAR CABECERA
    $pdf->Image('archives/assets/AMOSIS-LOGO-pdf.png',10,5,40);
    //SetFont('TipodeFuente','Tipo de Letra Borita - Itallic',tamaño);
    $pdf->SetFont('Arial','B',15);
    $pdf->SetFillColor(20,57,68);
    $pdf->Cell(277,10, 'AMOSIS - SISTEMA DE ALMACEN',0,1,'C');
    $pdf->SetFont('Arial','',11);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(277,10,utf8_decode("MOVIMIENTOS DEL PRODUCTO $nombre"),0,1,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(277,5,"JHONY CREATIVO",0,1,'R');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(277,5,utf8_decode("Trujillo - La Libertad - Perú"),0,1,'R');
    $pdf->Ln(10);
    $pdf->SetFont('Arial','',10);
    $pdf->setX(20);
    $pdf->Cell(30,5,utf8_decode("Producto :"),0,0,'L');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(40,5,utf8_decode($dato['Id']),0,0,'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(30,5,utf8_decode("Nombre :"),0,0,'L');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(80,5,utf8_decode("$nombre"),0,0,'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(40,5,utf8_decode("Stock en Almacén:"),0,0,'L');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(30,5,utf8_decode($dato['Stock']),0,0,'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Ln(5);
    $pdf->setX(20);
    $pdf->Cell(30,5,utf8_decode("Marca :"),0,0,'L');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(40,5,utf8_decode($dato['Marca']),0,0,'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(30,5,utf8_decode("Categoría :"),0,0,'L');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(100,5,utf8_decode($dato['Categoria']),0,1,'L');
    $pdf->Ln(5);
    
    // -------------- PROYECTO
    // C1
    $pdf->SetFillColor(38,50,56);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(277,6,'DETALLE DE LOS MOVIMIENTOS DE ENTRADA Y SALIDA DEL PRODUCTO',1,1,'C',1);
    $pdf->SetFont('Arial','B',8);
    // HEADER 1
    $pdf->Cell(67,6,utf8_decode(""),1,0,'C',1);
    $pdf->Cell(70,6,utf8_decode("ENTRADAS"),1,0,'C',1);
    $pdf->Cell(70,6,utf8_decode("SALIDAS"),1,0,'C',1);
    $pdf->Cell(70,6,utf8_decode("EXISTENCIAS"),1,1,'C',1);
    // HEADER 2
    $pdf->Cell(67,6,utf8_decode("FECHA"),1,0,'C',1);
    $pdf->Cell(25,6,utf8_decode("CANTIDAD"),1,0,'C',1);
    $pdf->Cell(25,6,utf8_decode("PRECIO UNIT"),1,0,'C',1);
    $pdf->Cell(20,6,utf8_decode("TOTAL"),1,0,'C',1);
    $pdf->Cell(25,6,utf8_decode("CANTIDAD"),1,0,'C',1);
    $pdf->Cell(25,6,utf8_decode("PRECIO UNIT"),1,0,'C',1);
    $pdf->Cell(20,6,utf8_decode("TOTAL"),1,0,'C',1);
    $pdf->Cell(25,6,utf8_decode("CANTIDAD"),1,0,'C',1);
    $pdf->Cell(25,6,utf8_decode("PRECIO UNIT"),1,0,'C',1);
    $pdf->Cell(20,6,utf8_decode("TOTAL"),1,1,'C',1);
    $pdf->SetTextColor(0,0,0); 
    // BODY
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0,0,0);
    function fechatext($fecha){
        $fecha = substr($fecha,0,10);
        $ndia = date('d',strtotime($fecha));
        $dia = date('l',strtotime($fecha));
        $mes = date('F',strtotime($fecha));
        $year = date('Y',strtotime($fecha));
        $dia_ES = array("Lunes","Martes","Miercoles","Jueves","Viernes","Sábado","Domingo");
        $dia_EN = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
        $nombredia = str_replace($dia_EN,$dia_ES,$dia);
        $mes_ES = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $mes_EN = array("January","Febrery","March","April","May","June","July","August","September","October","November","December");
        $nombremes = str_replace($mes_EN,$mes_ES,$mes);
        return $nombredia." ".$ndia." de ".$nombremes." del ".$year;
    }
    switch($tipo){
        case 1:
            $query = "SELECT d.CANTIDAD,um.PREFIJO,d.STOCK_EXISTENTE,d.PRECIO,p.PRECIO_COSTO,p.NOMBRE,d.TIPO_DETALLE,d.FECHA FROM detalle_salida_entrada_producto as d INNER JOIN producto as p ON d.ID_PRODUCTO = p.ID_PRODUCTO INNER JOIN precio_producto as pp on d.ID_UNIDAD = pp.ID_PRECIO INNER JOIN unidad_medida as um ON pp.ID_UNIDAD = um.ID_UNIDAD WHERE d.ID_PRODUCTO = '$p' ORDER BY d.FECHA ASC";
            $kardex_entrada = $cn->query($query);
            foreach($kardex_entrada as $rows){
                $fecha = date('Y-m-d',strtotime($rows['FECHA']));
                $cantidad = $rows["CANTIDAD"];
                $prefijo = $rows["PREFIJO"];
                $precio = $rows["PRECIO"];
                $stock_existente = $rows["STOCK_EXISTENTE"];
                $nombre = $rows["NOMBRE"];
                $precio_costo = $rows["PRECIO_COSTO"];
                $total = number_format($cantidad * $precio,2);
                $total_existente = number_format($stock_existente * $precio_costo,2);
                if($rows["TIPO_DETALLE"] == 1){       
                    // FILAS
                    $pdf->SetFillColor(140,253,144);
                    $pdf->Cell(67,6,utf8_decode(fechatext($fecha)),1,0,'C',1);
                    $pdf->SetFillColor(255,255,255);
                    $pdf->Cell(25,6,utf8_decode("$cantidad $prefijo"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode($MONEDA."$precio"),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode($MONEDA."$total"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode("$stock_existente UND"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode($MONEDA."$precio_costo"),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode($MONEDA."$total_existente"),1,1,'C',1);
                }else{
                    $pdf->SetFillColor(255,109,136);
                    $pdf->Cell(67,6,utf8_decode(fechatext($fecha)),1,0,'C',1);
                    $pdf->SetFillColor(255,255,255);
                    $pdf->Cell(25,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode("$cantidad $prefijo"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode($MONEDA."$precio"),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode($MONEDA."$total"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode("$stock_existente UND"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode($MONEDA."$precio_costo"),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode($MONEDA."$total_existente"),1,1,'C',1);
                }
            }
            break;
        case 2: 
            $query = "SELECT d.CANTIDAD,um.PREFIJO,d.STOCK_EXISTENTE,d.PRECIO,p.PRECIO_COSTO,p.NOMBRE,d.TIPO_DETALLE,d.FECHA FROM detalle_salida_entrada_producto as d INNER JOIN producto as p ON d.ID_PRODUCTO = p.ID_PRODUCTO INNER JOIN precio_producto as pp on d.ID_UNIDAD = pp.ID_PRECIO INNER JOIN unidad_medida as um ON pp.ID_UNIDAD = um.ID_UNIDAD  WHERE d.ID_PRODUCTO = '$p' AND YEAR(d.FECHA) = $y AND MONTH(d.FECHA) = $m  ORDER BY d.FECHA ASC";
            $kardex_entrada = $cn->query($query);
            foreach($kardex_entrada as $rows){
                $fecha = date('Y-m-d',strtotime($rows['FECHA']));
                $cantidad = $rows["CANTIDAD"];
                $prefijo = $rows["PREFIJO"];
                $precio = $rows["PRECIO"];
                $stock_existente = $rows["STOCK_EXISTENTE"];
                $nombre = $rows["NOMBRE"];
                $precio_costo = $rows["PRECIO_COSTO"];
                $total = number_format($cantidad * $precio,2);
                $total_existente = number_format($stock_existente * $precio_costo,2);
                if($rows["TIPO_DETALLE"] == 1){       
                    // FILAS
                    $pdf->SetFillColor(140,253,144);
                    $pdf->Cell(67,6,utf8_decode(fechatext($fecha)),1,0,'C',1);
                    $pdf->SetFillColor(255,255,255);
                    $pdf->Cell(25,6,utf8_decode("$cantidad $prefijo"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode($MONEDA."$precio"),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode($MONEDA."$total"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode("$stock_existente UND"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode($MONEDA."$precio_costo"),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode($MONEDA."$total_existente"),1,1,'C',1);
                }else{
                    $pdf->SetFillColor(255,109,136);
                    $pdf->Cell(67,6,utf8_decode(fechatext($fecha)),1,0,'C',1);
                    $pdf->SetFillColor(255,255,255);
                    $pdf->Cell(25,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode("$cantidad $prefijo"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode($MONEDA."$precio"),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode($MONEDA."$total"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode("$stock_existente UND"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode($MONEDA."$precio_costo"),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode($MONEDA."$total_existente"),1,1,'C',1);
                }
            }
            break;
        case 3:
            $query = "SELECT d.CANTIDAD,um.PREFIJO,d.STOCK_EXISTENTE,d.PRECIO,p.PRECIO_COSTO,p.NOMBRE,d.TIPO_DETALLE,d.FECHA FROM detalle_salida_entrada_producto as d INNER JOIN producto as p ON d.ID_PRODUCTO = p.ID_PRODUCTO INNER JOIN precio_producto as pp on d.ID_UNIDAD = pp.ID_PRECIO INNER JOIN unidad_medida as um ON pp.ID_UNIDAD = um.ID_UNIDAD  WHERE d.ID_PRODUCTO = '$p' AND YEAR(d.FECHA) = $y  ORDER BY d.FECHA ASC";
            $kardex_entrada = $cn->query($query);
            foreach($kardex_entrada as $rows){
                $fecha = date('Y-m-d',strtotime($rows['FECHA']));
                $cantidad = $rows["CANTIDAD"];
                $prefijo = $rows["PREFIJO"];
                $precio = $rows["PRECIO"];
                $stock_existente = $rows["STOCK_EXISTENTE"];
                $nombre = $rows["NOMBRE"];
                $precio_costo = $rows["PRECIO_COSTO"];
                $total = number_format($cantidad * $precio,2);
                $total_existente = number_format($stock_existente * $precio_costo,2);
                if($rows["TIPO_DETALLE"] == 1){       
                    // FILAS
                    $pdf->SetFillColor(140,253,144);
                    $pdf->Cell(67,6,utf8_decode(fechatext($fecha)),1,0,'C',1);
                    $pdf->SetFillColor(255,255,255);
                    $pdf->Cell(25,6,utf8_decode("$cantidad $prefijo"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode($MONEDA."$precio"),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode($MONEDA."$total"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode("$stock_existente UND"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode($MONEDA."$precio_costo"),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode($MONEDA."$total_existente"),1,1,'C',1);
                }else{
                    $pdf->SetFillColor(255,109,136);
                    $pdf->Cell(67,6,utf8_decode(fechatext($fecha)),1,0,'C',1);
                    $pdf->SetFillColor(255,255,255);
                    $pdf->Cell(25,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode("$cantidad $prefijo"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode($MONEDA."$precio"),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode($MONEDA."$total"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode("$stock_existente UND"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode($MONEDA."$precio_costo"),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode($MONEDA."$total_existente"),1,1,'C',1);
                }
            }
            break;
        case 4:
            $query = "SELECT d.CANTIDAD,um.PREFIJO,d.STOCK_EXISTENTE,d.PRECIO,p.PRECIO_COSTO,p.NOMBRE,d.TIPO_DETALLE,d.FECHA FROM detalle_salida_entrada_producto as d INNER JOIN producto as p ON d.ID_PRODUCTO = p.ID_PRODUCTO INNER JOIN precio_producto as pp on d.ID_UNIDAD = pp.ID_PRECIO INNER JOIN unidad_medida as um ON pp.ID_UNIDAD = um.ID_UNIDAD  WHERE d.ID_PRODUCTO = '$p' AND MONTH(d.FECHA) = $m  ORDER BY d.FECHA ASC";
            $kardex_entrada = $cn->query($query);
            foreach($kardex_entrada as $rows){
                $fecha = date('Y-m-d',strtotime($rows['FECHA']));
                $cantidad = $rows["CANTIDAD"];
                $prefijo = $rows["PREFIJO"];
                $precio = $rows["PRECIO"];
                $stock_existente = $rows["STOCK_EXISTENTE"];
                $nombre = $rows["NOMBRE"];
                $precio_costo = $rows["PRECIO_COSTO"];
                $total = number_format($cantidad * $precio,2);
                $total_existente = number_format($stock_existente * $precio_costo,2);
                if($rows["TIPO_DETALLE"] == 1){       
                    // FILAS
                    $pdf->SetFillColor(140,253,144);
                    $pdf->Cell(67,6,utf8_decode(fechatext($fecha)),1,0,'C',1);
                    $pdf->SetFillColor(255,255,255);
                    $pdf->Cell(25,6,utf8_decode("$cantidad $prefijo"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode($MONEDA."$precio"),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode($MONEDA."$total"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode("$stock_existente UND"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode($MONEDA."$precio_costo"),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode($MONEDA."$total_existente"),1,1,'C',1);
                }else{
                    $pdf->SetFillColor(255,109,136);
                    $pdf->Cell(67,6,utf8_decode(fechatext($fecha)),1,0,'C',1);
                    $pdf->SetFillColor(255,255,255);
                    $pdf->Cell(25,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode(""),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode("$cantidad $prefijo"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode($MONEDA."$precio"),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode($MONEDA."$total"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode("$stock_existente UND"),1,0,'C',1);
                    $pdf->Cell(25,6,utf8_decode($MONEDA."$precio_costo"),1,0,'C',1);
                    $pdf->Cell(20,6,utf8_decode($MONEDA."$total_existente"),1,1,'C',1);
                }
            }
            break;
    }
    $pdf->Output();
?>