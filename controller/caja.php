<?php
    class Caja extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->codigo_venta = $this->codigo_venta();
            $this->view->lista_producto = $this->lista_producto();
            $this->view->parametros = mainModel::parametros();
            $this->view->brand = "Punto de Venta";
            $this->view->id_nav_active = "caja-active";
            $this->view->id_collapase_active = "ventas";
            $this->view->render('caja/index');
        }
        function codigo_venta(){
            $cn = mainModel::conectar();
            $contarventa = $cn->query("SELECT * FROM venta_contado");
            $n_ventas = $contarventa->rowCount();
            return $codigo = mainModel::generar_codigo_aleatorio("000",2,$n_ventas);
        }
        function unidad_option_precio($id){
            $cn = mainModel::conectar();
            $option = "";
            $datos = $cn->query("SELECT pp.ID_PRECIO, u.PREFIJO FROM precio_producto as pp INNER JOIN unidad_medida as u ON pp.ID_UNIDAD = u.ID_UNIDAD WHERE pp.ID_PRODUCTO = '$id'");
            foreach($datos as $row){
                $id = $row["ID_PRECIO"];
                $prefijo = $row["PREFIJO"];
                $option .= "
                    <option value='$id'>$prefijo</option>
                ";
            }
            return $option;
        }
        function barra_producto(){
            if(isset($_POST["codigo"])){
                $cn = mainModel::conectar();
                $codigo = $_POST["codigo"];
                $buscar_producto = $cn->query("SELECT pa.ID_PRODUCTO,p.NOMBRE,p.CODIGO_BARRA,pa.STOCK FROM productos_almacen as pa INNER JOIN producto as p ON pa.ID_PRODUCTO = p.ID_PRODUCTO WHERE p.CODIGO_BARRA = '$codigo'");
                if($buscar_producto->rowCount()>0){
                    foreach ($buscar_producto as $key){
                        if ($key['STOCK'] <= 0){
                            echo 2;
                        }else{
                            $option = $this->unidad_option_precio($key['ID_PRODUCTO']);
                            echo $key['NOMBRE'].'|'.$key['STOCK'].'|'.$key['ID_PRODUCTO'].'|'.$option;
                        }
                    }
                }else{
                    echo 1;
                }
                $cn = null;
            }
        }
        function buscarcliente(){
            if(isset($_POST["id"])){
                $cn = mainModel::conectar();
                $id = $_POST["id"];
                $buscar_cliente = $cn->query("SELECT * FROM cliente WHERE ID_CLIENTE = '$id'");
                if($buscar_cliente->rowCount()>0){
                    foreach ($buscar_cliente as $key){
                        echo $key['ID_CLIENTE'].'|'.$key['NOMBRE'].'|'.$key['DIRECCION'];
                    }
                }else{
                    echo 1;
                }
                $cn = null;
            }
        }
        function verticket($param = null){
            $this->view->conexion = mainModel::conectar();
            $this->view->parametros = mainModel::parametros();
            $this->view->ticket = $param[0];
            $this->view->detalleticket = $this->detalleticket();
            $this->view->render('caja/ticketcontado');
            
        }
        function pago_contado(){
            if(isset($_POST["productos"])){
                $cn = mainModel::conectar();
                //capturando datos del cliente
                $id_cliente =  $_POST["doc"];
                $nombre_cliente =  $_POST["nombre_c"];
                $direccion_cliente =  $_POST["direccion"];
                $usuario =  $_POST["usuario"];
                //evaluar si existe cliente
                if($id_cliente != "" && $nombre_cliente != "" ){
                    $evaluar_cliente = $cn->query("SELECT * FROM cliente WHERE ID_CLIENTE = '$id_cliente'");
                    if($evaluar_cliente->rowCount()==0){
                        $insetar = $cn->query("INSERT INTO cliente(ID_CLIENTE, NOMBRE, DIRECCION) VALUES ('$id_cliente','$nombre_cliente','$direccion_cliente')");
                    }
                }
                //capturando el codigo de venta
                $venta =  $_POST["venta"];
                $subtotal =  $_POST["subtotal"];
                $descuento =  $_POST["descuento"];
                $total = $_POST['total'];
                $pagocon = $_POST['pagocon'];
                $cambio = $_POST['cambio'];
                $turno = $_POST['turno'];
                date_default_timezone_set(ZONE);
                $fechahora = date('Y-m-d H:i:s');
                $fecha = date('Y-m-d');
                $year = date('Y');
                $mes = date('m');
                $dia = date('d');
                $estado = 1;
                //SALIDA_PRODUCTO
                $cod_salida = $venta;
                $tipo_salida = 1;
                $tipo_documento_destinatario = 6;
                $documento = 2;
                $numero = $venta;
                $observacion = "Venta de tipo contado con Ticket: $venta, SubTotal de venta: $subtotal, Descuento: $descuento, Total: $total";
                $numero_documento_destinatario = $id_cliente;
                $nombre_destinatario = $nombre_cliente;
                $guardar_nota = $cn->query("INSERT INTO salida_producto(ID_SALIDA, TIPO_SALIDA, DESTINATARIO, DOC_DESTINATARIO, NUM_DOC_DESTINATARIO, DOCUMENTO, NUMERO, OBSERVACION) VALUES ('$cod_salida','$tipo_salida','$nombre_destinatario','$tipo_documento_destinatario','$numero_documento_destinatario','$documento','$numero','$observacion')");
                if($guardar_nota->rowCount()>0){
                    //todos los productos de caja
                    $productos = $_POST["productos"];
                    //separo los producto en arreglo
                    $arrayproductos = explode(',',$productos);
                    //cuento la cantidad de productos
                    $n_productos = count($arrayproductos)-1;
                    //recorro el arreglo
                    for($i=0;$i<$n_productos;$i++){
                        //capturo el string del array que esta en el indice
                        $productostring = $arrayproductos[$i];
                        //separo el string por el | y lo convierto
                        $producto = explode("|",$productostring);
                        //coloco cada variable en su lugar
                        $id = $producto[0];
                        $detalle = $producto[1];
                        $cantidad = $producto[2];
                        $unidadmedida = $producto[3];
                        $equivalente = $producto[4];
                        $precio = $producto[5];
                        $cantidaunidadsolicitada = $cantidad*$equivalente;
                        $buscar_stock = $cn->query("SELECT * FROM productos_almacen WHERE ID_PRODUCTO = '$id'");
                        foreach($buscar_stock as $pro){
                            $stock = $pro["STOCK"];
                        }
                        $stock = $stock-$cantidaunidadsolicitada;
                        $guardar_productos = $cn->query("INSERT INTO detalle_salida_entrada_producto (TIPO_DETALLE, ID_SALIDA_ENTRADA, ID_PRODUCTO,ID_UNIDAD, PRECIO, CANTIDAD, STOCK_EXISTENTE) VALUES ('2','$cod_salida','$id','$unidadmedida','$precio','$cantidad','$stock')");
                    }
                }
                $guardar_venta = $cn->query("INSERT INTO venta_contado(ID_VENTA, FECHAHORA, FECHA, ANO, MES, DIA, SUBTOTAL, DESCUENTO, TOTAL, PAGOCON, CAMBIO, ESTADO, ID_CLIENTE, ID_USUARIO , ID_TURNO) VALUES ('$venta','$fechahora','$fecha','$year','$mes','$dia',$subtotal,$descuento,$total,$pagocon,$cambio,$estado,'$id_cliente','$usuario', '$turno' )");
                if($guardar_venta->rowCount()>0){
                    //todos los productos de caja
                    $productos = $_POST["productos"];
                    //separo los producto en arreglo
                    $arrayproductos = explode(',',$productos);
                    //cuento la cantidad de productos
                    $n_productos = count($arrayproductos)-1;
                    //recorro el arreglo
                    for($i=0;$i<$n_productos;$i++){
                        //capturo el string del array que esta en el indice
                        $productostring = $arrayproductos[$i];
                        //separo el string por el | y lo convierto
                        $producto = explode("|",$productostring);
                        //coloco cada variable en su lugar
                        $id = $producto[0];
                        $detalle = $producto[1];
                        $cantidad = $producto[2];
                        $unidadmedida = $producto[3];
                        $equivalente = $producto[4];
                        $precio = $producto[5];
                        $cantidaunidadsolicitada = $cantidad*$equivalente;
                        $buscar_stock = $cn->query("SELECT * FROM productos_almacen WHERE ID_PRODUCTO = '$id'");
                        foreach($buscar_stock as $pro){
                            $stock = $pro["STOCK"];
                        }
                        $stock = $stock-$cantidaunidadsolicitada;
                        $guardar_productos = $cn->query("INSERT INTO detalle_venta_contado(ID_VENTA, ID_PRODUCTO, ID_UNIDAD, DETALLE, CANTIDAD) VALUES ('$venta','$id','$unidadmedida','$detalle','$cantidad')");
                        $actualizar_stock = $cn->query("UPDATE productos_almacen SET STOCK = $stock WHERE ID_PRODUCTO = '$id'");  
                    }
                    echo 1;
                }

            }
        }
        function detalleticket(){
            $cn = mainModel::conectar();
            $array = [];
            $data = $cn->query("SELECT * FROM ticket WHERE ID = 1"); 
            if ($data->RowCount() >= 1) {
                foreach ($data as $rows) {
                    $array = [
                        "Titulo" => $rows["TITULO"],
                        "Direccion" => $rows["DIRECCION"],
                        "Pie" => $rows["PIE"],
                        "Telefono" => $rows["TELEFONO"]
                    ];
                }
            }
            return $array;
        }
        function pago_credito(){
            if(isset($_POST["productos"])){
                $cn = mainModel::conectar();
                $total = $_POST["total"];
                $subtotal = $_POST["subtotal"];
                $pagocon = $_POST["pagocon"];
                $cambio = $_POST["cambio"];
                $venta = $_POST["venta"];
                $fechadepago = $_POST["fecha"];
                $meses = $_POST["meses"];
                $inicial = $_POST["inicial"];
                $descuento = $_POST["descuentocredito"];
                $interes = $_POST["interes"];
                $cuotamensual = $_POST["cuotamensual"];
                $totalinteres = ($meses*$cuotamensual)+$inicial;
                //capturando datos del cliente
                $id_cliente =  $_POST["doc"];
                $nombre_cliente =  $_POST["nombre_c"];
                $direccion_cliente =  $_POST["direccion"];
                $usuario =  $_POST["usuario"];
                //evaluar si existe cliente
                if($id_cliente != "" && $nombre_cliente != "" ){
                    $evaluar_cliente = $cn->query("SELECT * FROM cliente WHERE ID_CLIENTE = '$id_cliente'");
                    if($evaluar_cliente->rowCount()==0){
                        $insetar = $cn->query("INSERT INTO cliente(ID_CLIENTE, NOMBRE, DIRECCION) VALUES ('$id_cliente','$nombre_cliente','$direccion_cliente')");
                    }
                }
                //Generar Compra a Credito
                date_default_timezone_set(ZONE);
                $fecha = date('Y-m-d');
                $year = date('Y');
                $mes = date('m');
                $dia = date('d');
                //SALIDA_PRODUCTO
                $cod_salida = $venta;
                $tipo_salida = 1;
                $tipo_documento_destinatario = 6;
                $documento = 2;
                $numero = $venta;
                $observacion = "Venta de tipo credito con Ticket: $venta, SubTotal de venta: $subtotal, Descuento: $descuento, Total: $total, Meses: $meses , Interes: $interes";
                $numero_documento_destinatario = $id_cliente;
                $nombre_destinatario = $nombre_cliente;
                $guardar_nota = $cn->query("INSERT INTO salida_producto(ID_SALIDA, TIPO_SALIDA, DESTINATARIO, DOC_DESTINATARIO, NUM_DOC_DESTINATARIO, DOCUMENTO, NUMERO, OBSERVACION) VALUES ('$cod_salida','$tipo_salida','$nombre_destinatario','$tipo_documento_destinatario','$numero_documento_destinatario','$documento','$numero','$observacion')");
                if($guardar_nota->rowCount()>0){
                    //todos los productos de caja
                    $productos = $_POST["productos"];
                    //separo los producto en arreglo
                    $arrayproductos = explode(',',$productos);
                    //cuento la cantidad de productos
                    $n_productos = count($arrayproductos)-1;
                    //recorro el arreglo
                    for($i=0;$i<$n_productos;$i++){
                        //capturo el string del array que esta en el indice
                        $productostring = $arrayproductos[$i];
                        //separo el string por el | y lo convierto
                        $producto = explode("|",$productostring);
                        //coloco cada variable en su lugar
                        $id = $producto[0];
                        $detalle = $producto[1];
                        $cantidad = $producto[2];
                        $unidadmedida = $producto[3];
                        $equivalente = $producto[4];
                        $precio = $producto[5];
                        $cantidaunidadsolicitada = $cantidad*$equivalente;
                        $buscar_stock = $cn->query("SELECT * FROM productos_almacen WHERE ID_PRODUCTO = '$id'");
                        foreach($buscar_stock as $pro){
                            $stock = $pro["STOCK"];
                        }
                        $stock = $stock-$cantidaunidadsolicitada;
                        $guardar_productos = $cn->query("INSERT INTO detalle_salida_entrada_producto (TIPO_DETALLE, ID_SALIDA_ENTRADA, ID_PRODUCTO,ID_UNIDAD, PRECIO, CANTIDAD, STOCK_EXISTENTE) VALUES ('2','$cod_salida','$id','$unidadmedida','$precio','$cantidad','$stock')");
                    }
                }
                $guardar_venta = $cn->query("INSERT INTO venta_credito(ID_VENTA, FECHA, ANO, MES, DIA, SUBTOTAL, DESCUENTO, TASA, INTERES, TOTAL, ID_CLIENTE, ID_USUARIO, ESTADO, MESES, MESESCUOTA, INICIAL, DIA_PAGO) VALUES ('$venta','$fecha','$year','$mes','$dia','$subtotal','$descuento','$interes','$totalinteres','$total','$id_cliente','$usuario',1,'$meses','$cuotamensual','$inicial','$fechadepago')");
                if($guardar_venta->rowCount()>0){
                    //todos los productos de caja
                    $productos = $_POST["productos"];
                    //separo los producto en arreglo
                    $arrayproductos = explode(',',$productos);
                    //cuento la cantidad de productos
                    $n_productos = count($arrayproductos)-1;
                    //recorro el arreglo
                    for($i=0;$i<$n_productos;$i++){
                        //capturo el string del array que esta en el indice
                        $productostring = $arrayproductos[$i];
                        //separo el string por el | y lo convierto
                        $producto = explode("|",$productostring);
                        //coloco cada variable en su lugar
                        $id = $producto[0];
                        $detalle = $producto[1];
                        $cantidad = $producto[2];
                        $unidadmedida = $producto[3];
                        $equivalente = $producto[4];
                        $precio = $producto[5];
                        $cantidaunidadsolicitada = $cantidad*$equivalente;
                        $buscar_stock = $cn->query("SELECT * FROM productos_almacen WHERE ID_PRODUCTO = '$id'");
                        foreach($buscar_stock as $pro){
                            $stock = $pro["STOCK"];
                        }
                        $stock = $stock-$cantidaunidadsolicitada;
                        $guardar_productos = $cn->query("INSERT INTO detalle_venta_credito(ID_VENTA, ID_PRODUCTO, ID_UNIDAD, DETALLE, CANTIDAD) VALUES ('$venta','$id','$unidadmedida','$detalle','$cantidad')");
                        $actualizar_stock = $cn->query("UPDATE productos_almacen SET STOCK = $stock WHERE ID_PRODUCTO = '$id'");  
                    }
                    //agregarcuotas
                    $year = date('Y');
                    $mes = date('m');
                    for($i=1;$i<=$meses;$i++){
                        $mes++;
                        if($mes>12){
                            $mes = 1;
                            $year++;
                        }
                        $guardar_cuotas = $cn->query("INSERT INTO cuotas_credito(NUM_CUOTA, ID_VENTA, ID_CLIENTE, MES, ANO, DIA, MONTOCUOTA, ESTADO) VALUES ('$i','$venta','$id_cliente','$mes','$year','$fechadepago','$cuotamensual',1)");
                    }
                    $fechahora = date('Y-m-d H:i:s');
                    $ticket_inicial = $cn->query("INSERT INTO ticket_inicial_credito(ID_VENTA, FECHAHORA, INICIAL, PAGOCON, CAMBIO, ID_CLIENTE, ID_USUARIO) VALUES ('$venta','$fechahora','$inicial','$pagocon','$cambio','$id_cliente','$usuario')");
                    if($ticket_inicial->rowCount()>0){
                        echo 1;
                    }
                }
            }
        }
        function cancelarticket(){
            if(isset($_POST["num"])){
                $cn = mainModel::conectar();
                $codigo = $_POST["num"];
                $buscar = $cn->query("UPDATE venta_contado SET ESTADO = 0 WHERE ID_VENTA = '$codigo'");
                if($buscar->rowCount()>0){
                    echo 1;
                }else{
                    echo 0;
                }
            }
        }
        function lista_producto(){
            $table = "";
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT pa.ID_PRODUCTO,p.NOMBRE,p.CODIGO_BARRA,pa.STOCK,m.NOMBRE AS marca ,um.PREFIJO  FROM productos_almacen as pa INNER JOIN producto as p ON pa.ID_PRODUCTO = p.ID_PRODUCTO INNER JOIN marca as m ON m.ID_MARCA = p.ID_MARCA INNER JOIN unidad_medida as um on p.ID_UNIDAD = um.ID_UNIDAD");
            foreach($datos as $rows){
                $id = $rows['ID_PRODUCTO'];
                $codigo = $rows['CODIGO_BARRA'];
                $table .="
                    <tr>
                        <td>".$rows['ID_PRODUCTO']."</td>
                        <td>".$rows['NOMBRE']."</td>
                        <td>".$rows['CODIGO_BARRA']."</td>
                        <td>".$rows['marca']."</td>
                        <td>".$rows['STOCK'].' '.$rows["PREFIJO"]."</td>
                        <td><button class='btn btn-success btn-sm btn-seleccionar' value='$codigo' type='button'><i class='fa fa-check'></i></button></td>
                    </tr>
                ";
            }
            return $table;
        }
    }