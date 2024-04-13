<?php
    class salidaproducto extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->id_nav_active = "salida_producto-active";
            $this->view->id_collapase_active = "ventas";
            $this->view->brand = "Salidas de Productos";
            $this->view->numeros_salidas = $this::numeros_salidas();
            $this->view->lista_salidas = $this::lista_salidas();
            $this->view->render('salidaproducto/index');
        }
        function versalida($id = null){
            $id = $id[0];
            $this->view->id_nav_active = "salida_producto-active";
            $this->view->id_collapase_active = "ventas";
            $this->view->brand = "Salidas de Productos";
            $this->view->id_salida = $id;
            $this->view->tipo_lista_salida =  $this::tipo_lista_salida($id);
            $this->view->parametros = mainModel::parametros(); 
            $this->view->documento_lista_salida =  $this::documento_lista_salida($id);
            $this->view->documento_destinatario_lista_salida =  $this::documento_destinatario_lista_salida($id);
            $this->view->lista_productos_salida =  $this::lista_productos_salida($id);
            $this->view->datos_salida = $this::datos_salida($id);
            $this->view->render('salidaproducto/editar');
        }
        function imprimirsalida($id = null){
            $id = $id[0];
            $this->view->datos_salida = $this::datos_salida_imprimir($id);
            $this->view->parametros = mainModel::parametros(); 
            $this->view->conexion = mainModel::conectar();
            $this->view->render('salidaproducto/imprimir');

        }
        function datos_salida_imprimir($id){
            $cn = mainModel::conectar();
            $array = [];
            $data = $cn->query("SELECT * FROM salida_producto WHERE ID_SALIDA = '$id'");
            if ($data->RowCount() >= 1) {
                foreach ($data as $rows) {
                    $ID = $rows["ID_SALIDA"];
                    $tipo_salida = $rows["TIPO_SALIDA"];
                    switch($tipo_salida){
                        case 1:
                            $tipo_salida = "PEDIDO DE VENTA";
                            break;
                        case 2:
                            $tipo_salida = "PEDIDO DE TRANSFERENCIA";
                            break;
                        case 3:
                            $tipo_salida = "PEDIDO DE DEVOLUCION DE COMPRA";
                            break;
                        case 4:
                            $tipo_salida = "PEDIDO DE SERVICIO";
                            break;
                        case 5:
                            $tipo_salida = "PEDIDO DE EMSAMBLADO";
                            break;
                        case 6:
                            $tipo_salida = "ORDEN DE PRODUCCION";
                            break;
                        case 7:
                            $tipo_salida = "OTRAS SALIDAS";
                            break;
                    }
                    $tipo_documento = $rows["DOCUMENTO"];
                    switch($tipo_documento){
                        case 1:
                            $tipo_documento = "FACTURA";
                            break;
                        case 2:
                            $tipo_documento = "BOLETA";
                            break;
                        case 3:
                            $tipo_documento = "NOTA DE ENTRADA";
                            break;
                        case 4:
                            $tipo_documento = "NOTA DE SALIDA";
                            break;
                        case 5:
                            $tipo_documento = "NOTA DE CREDTO";
                            break;
                        case 6:
                            $tipo_documento = "NOTA DE DEBITO";
                            break;
                        case 7:
                            $tipo_documento = "REMISION";
                            break;
                        case 8:
                            $tipo_documento = "OTROS DOCUMENTOS";
                            break;
                    }
                    $tipo_documento_des = $rows["DOC_DESTINATARIO"];
                    switch($tipo_documento_des){
                        case 1:
                            $tipo_documento_des = "RUC";
                            break;
                        case 2:
                            $tipo_documento_des = "DNI";
                            break;
                        case 3:
                            $tipo_documento_des = "CARNET EXTRANJERA";
                            break;
                        case 4:
                            $tipo_documento_des = "PASAPORTE";
                            break;
                        case 5:
                            $tipo_documento_des = "PART. NACIMIENTO";
                            break;
                        case 6:
                            $tipo_documento_des = "OTROS DOCUMENTOS";
                            break;
                    }
                    $numero = $rows["NUMERO"];
                    $numero_des = $rows["NUM_DOC_DESTINATARIO"];
                    $destinatario = $rows["DESTINATARIO"];
                    $fecha = date('Y-m-d',strtotime($rows['F_SALIDA']));
                    $array = [
                        "Id" => $ID,
                        "Tipo_salida" => $tipo_salida,
                        "Tipo_documento" => $tipo_documento,
                        "Tipo_documento_des" => $tipo_documento_des,
                        "Destinatario" => $destinatario,
                        "Numero_des" => $numero_des,
                        "Numero" => $numero,
                        "Fecha" => $fecha,
                        "Observacion" => $rows["OBSERVACION"]
                    ];
                }
            }
            return $array;
        }
        function actualizarsalida(){
            if(isset($_POST["tipo_ingreso"]) && isset($_POST["documento"])){
                $codigo = $_POST["id_agregar"];
                $tipo_salida = $_POST["tipo_ingreso"];
                $documento = $_POST["documento"];
                $documento_des = $_POST["tipo_documento_destinatario"];
                $destinatario = $_POST["nombre_destinatario"];
                $n_documento = $_POST["numero_documento"];
                $n_documento_des = $_POST["numero_documento_destinatario"];
                $observacion = $_POST["observacion"];
                $data = [
                    "cod_salida" => $codigo,
                    "tipo_salida" => $tipo_salida,  
                    "nombre_destinatario" => $destinatario,
                    "documento" => $documento,
                    "tipo_documento_destinatario" => $documento_des,
                    "numero" => utf8_decode($n_documento),
                    "numero_documento_destinatario" => utf8_decode($n_documento_des),
                    "observacion" => utf8_decode($observacion)
                ];
                $guardar = $this->model->actualizar($data);
                if($guardar->rowCount()>0){
                    echo " 
                        <script>
                            showNotification('bottom','center','La salida de productos se actualizo correctamente','success');
                        </script>";
                }else{
                    echo " 
                        <script>
                            showNotification('bottom','center','No se pudo actualizar la salida, intenta recargar la pagina','danger');
                        </script>";
                }

            }else{
                echo "Peticion Invalida";
            }
        }
        function lista_productos_salida($id){
            $cn = mainModel::conectar();
            $productos = $cn->query("SELECT d.ID_PRODUCTO,p.NOMBRE,d.PRECIO,d.CANTIDAD,u.PREFIJO FROM detalle_salida_entrada_producto AS d INNER JOIN producto as p on d.ID_PRODUCTO = p.ID_PRODUCTO INNER JOIN precio_producto as pp ON d.ID_UNIDAD = pp.ID_PRECIO INNER JOIN unidad_medida as u ON pp.ID_UNIDAD = u.ID_UNIDAD WHERE d.ID_SALIDA_ENTRADA = '$id'");
            $tabla = "";
            $total_neto = 0;
            $parametro = mainModel::parametros();
            $moneda = $parametro["Moneda"];
            foreach($productos as $row){
                $id = $row["ID_PRODUCTO"];
                $nombre = $row["NOMBRE"];
                $precio = $row["PRECIO"];
                $cantidad = $row["CANTIDAD"];
                $unidad = $row["PREFIJO"];
                $importe = number_format($precio * $cantidad,2);
                $total_neto = number_format($total_neto + $importe,2); 
                $tabla .= "
                    <tr>
                        <td>$id</td>
                        <td>$nombre</td>
                        <td>$unidad</td>
                        <td>$precio</td>
                        <td>$cantidad</td>
                        <td>$importe</td>
                    </tr>
                ";
            }
            $tabla .= "
                <tr>
                    <td colspan='4'></td>
                    <td colspan='2'><h6 class='font-weight-bolder'>Total Neto ".$moneda."<span>$total_neto</span> </h6></td>
                </tr>
            ";
            return $tabla;
        }
        function datos_salida($id){
            $cn = mainModel::conectar();
            $array = [];
            $data = $cn->query("SELECT * FROM salida_producto WHERE ID_SALIDA = '$id'");
            if ($data->RowCount() >= 1) {
                foreach ($data as $rows) {
                    $array = [
                        "Numero" => $rows["NUMERO"],
                        "Destinatario" => $rows["DESTINATARIO"],
                        "num_doc_Destinatario" => $rows["NUM_DOC_DESTINATARIO"],
                        "Observacion" => $rows["OBSERVACION"]
                    ];
                }
            }
            return $array;
        }
        function tipo_lista_salida($id){
            $cn = mainModel::conectar();
            $tipo = $cn->query("SELECT TIPO_SALIDA FROM salida_producto WHERE ID_SALIDA = '$id'");
            $tipo = $tipo->fetchColumn(0);
            $option = "";
            switch($tipo){
                case 1:
                    $option = "
                        <option value='1' selected>PEDIDO DE VENTA</option>
                        <option value='2'>PEDIDO DE TRANSFERENCIA</option>
                        <option value='3'>PEDIDO DE DEVOLUCION DE COMPRA</option>
                        <option value='4'>PEDIDO DE SERVICIO</option>
                        <option value='5'>PEDIDO DE EMSAMBLADO</option>
                        <option value='6'>ORDEN DE PRODUCCION</option>
                        <option value='7'>OTRAS SALIDAS</option>
                    ";
                    break;
                case 2:
                    $option = "
                        <option value='1'>PEDIDO DE VENTA</option>
                        <option value='2' selected>PEDIDO DE TRANSFERENCIA</option>
                        <option value='3'>PEDIDO DE DEVOLUCION DE COMPRA</option>
                        <option value='4'>PEDIDO DE SERVICIO</option>
                        <option value='5'>PEDIDO DE EMSAMBLADO</option>
                        <option value='6'>ORDEN DE PRODUCCION</option>
                        <option value='7'>OTRAS SALIDAS</option>
                    ";
                    break;
                case 3:
                    $option = "
                        <option value='1'>PEDIDO DE VENTA</option>
                        <option value='2'>PEDIDO DE TRANSFERENCIA</option>
                        <option value='3' selected>PEDIDO DE DEVOLUCION DE COMPRA</option>
                        <option value='4'>PEDIDO DE SERVICIO</option>
                        <option value='5'>PEDIDO DE EMSAMBLADO</option>
                        <option value='6'>ORDEN DE PRODUCCION</option>
                        <option value='7'>OTRAS SALIDAS</option>        
                        ";
                    break;
                case 4:
                    $option = "
                        <option value='1'>PEDIDO DE VENTA</option>
                        <option value='2'>PEDIDO DE TRANSFERENCIA</option>
                        <option value='3'>PEDIDO DE DEVOLUCION DE COMPRA</option>
                        <option value='4' selected>PEDIDO DE SERVICIO</option>
                        <option value='5'>PEDIDO DE EMSAMBLADO</option>
                        <option value='6'>ORDEN DE PRODUCCION</option>
                        <option value='7'>OTRAS SALIDAS</option>
                    ";
                    break;
                case 5:
                    $option = "
                        <option value='1'>PEDIDO DE VENTA</option>
                        <option value='2'>PEDIDO DE TRANSFERENCIA</option>
                        <option value='3'>PEDIDO DE DEVOLUCION DE COMPRA</option>
                        <option value='4'>PEDIDO DE SERVICIO</option>
                        <option value='5' selected>PEDIDO DE EMSAMBLADO</option>
                        <option value='6'>ORDEN DE PRODUCCION</option>
                        <option value='7'>OTRAS SALIDAS</option>
                    ";
                    break;    
                case 6:
                    $option = "
                        <option value='1'>PEDIDO DE VENTA</option>
                        <option value='2'>PEDIDO DE TRANSFERENCIA</option>
                        <option value='3'>PEDIDO DE DEVOLUCION DE COMPRA</option>
                        <option value='4'>PEDIDO DE SERVICIO</option>
                        <option value='5'>PEDIDO DE EMSAMBLADO</option>
                        <option value='6' selected>ORDEN DE PRODUCCION</option>
                        <option value='7'>OTRAS SALIDAS</option>
                    ";
                    break;
                case 7:
                    $option = "
                        <option value='1'>PEDIDO DE VENTA</option>
                        <option value='2'>PEDIDO DE TRANSFERENCIA</option>
                        <option value='3'>PEDIDO DE DEVOLUCION DE COMPRA</option>
                        <option value='4'>PEDIDO DE SERVICIO</option>
                        <option value='5'>PEDIDO DE EMSAMBLADO</option>
                        <option value='6'>ORDEN DE PRODUCCION</option>
                        <option value='7' selected>OTRAS SALIDAS</option>
                    ";
                    break;
            }
            return $option;
        }
        function documento_lista_salida($id){
            $cn = mainModel::conectar();
            $tipo = $cn->query("SELECT DOCUMENTO FROM salida_producto WHERE ID_SALIDA = '$id'");
            $tipo = $tipo->fetchColumn(0);
            $option = "";
            switch($tipo){
                case 1:
                    $option = "
                        <option value='1' selected>FACTURA</option>
                        <option value='2'>BOLETA</option>
                        <option value='3'>NOTA DE ENTRADA</option>
                        <option value='4'>NOTA DE SALIDA</option>
                        <option value='5'>NOTA DE CREDITO</option>
                        <option value='6'>NOTA DE DEBITO</option>
                        <option value='7'>REMISION</option>
                        <option value='8'>OTROS DOCUMENTOS</option>
                    ";
                    break;
                case 2:
                    $option = "
                        <option value='1'>FACTURA</option>
                        <option value='2' selected>BOLETA</option>
                        <option value='3'>NOTA DE ENTRADA</option>
                        <option value='4'>NOTA DE SALIDA</option>
                        <option value='5'>NOTA DE CREDITO</option>
                        <option value='6'>NOTA DE DEBITO</option>
                        <option value='7'>REMISION</option>
                        <option value='8'>OTROS DOCUMENTOS</option>
                    ";
                    break;
                case 3:
                    $option = "
                        <option value='1'>FACTURA</option>
                        <option value='2'>BOLETA</option>
                        <option value='3' selected>NOTA DE ENTRADA</option>
                        <option value='4'>NOTA DE SALIDA</option>
                        <option value='5'>NOTA DE CREDITO</option>
                        <option value='6'>NOTA DE DEBITO</option>
                        <option value='7'>REMISION</option>
                        <option value='8'>OTROS DOCUMENTOS</option>
                        ";
                    break;
                case 4:
                    $option = "
                        <option value='1'>FACTURA</option>
                        <option value='2'>BOLETA</option>
                        <option value='3'>NOTA DE ENTRADA</option>
                        <option value='4' selected>NOTA DE SALIDA</option>
                        <option value='5'>NOTA DE CREDITO</option>
                        <option value='6'>NOTA DE DEBITO</option>
                        <option value='7'>REMISION</option>
                        <option value='8'>OTROS DOCUMENTOS</option>
                    ";
                    break;
                case 5:
                    $option = "
                        <option value='1'>FACTURA</option>
                        <option value='2'>BOLETA</option>
                        <option value='3'>NOTA DE ENTRADA</option>
                        <option value='4'>NOTA DE SALIDA</option>
                        <option value='5' selected>NOTA DE CREDITO</option>
                        <option value='6'>NOTA DE DEBITO</option>
                        <option value='7'>REMISION</option>
                        <option value='8'>OTROS DOCUMENTOS</option>
                    ";
                    break;    
                case 6:
                    $option = "
                        <option value='1'>FACTURA</option>
                        <option value='2'>BOLETA</option>
                        <option value='3'>NOTA DE ENTRADA</option>
                        <option value='4'>NOTA DE SALIDA</option>
                        <option value='5'>NOTA DE CREDITO</option>
                        <option value='6' selected>NOTA DE DEBITO</option>
                        <option value='7'>REMISION</option>
                        <option value='8'>OTROS DOCUMENTOS</option>
                    ";
                    break;
                case 7:
                    $option = "
                        <option value='1'>FACTURA</option>
                        <option value='2'>BOLETA</option>
                        <option value='3'>NOTA DE ENTRADA</option>
                        <option value='4'>NOTA DE SALIDA</option>
                        <option value='5'>NOTA DE CREDITO</option>
                        <option value='6'>NOTA DE DEBITO</option>
                        <option value='7' selected>REMISION</option>
                        <option value='8'>OTROS DOCUMENTOS</option>
                    ";
                    break;
                case 8:
                    $option = "
                        <option value='1'>FACTURA</option>
                        <option value='2'>BOLETA</option>
                        <option value='3'>NOTA DE ENTRADA</option>
                        <option value='4'>NOTA DE SALIDA</option>
                        <option value='5'>NOTA DE CREDITO</option>
                        <option value='6'>NOTA DE DEBITO</option>
                        <option value='7'>REMISION</option>
                        <option value='8' selected>OTROS DOCUMENTOS</option>
                    ";
                    break;
            }
            return $option;
        }
        function documento_destinatario_lista_salida($id){
            $cn = mainModel::conectar();
            $tipo = $cn->query("SELECT DOCUMENTO FROM salida_producto WHERE ID_SALIDA = '$id'");
            $tipo = $tipo->fetchColumn(0);
            $option = "";
            switch($tipo){
                case 1:
                    $option = "
                        <option value='1' selected>RUC</option>
                        <option value='2'>DNI</option>
                        <option value='3'>CARNET DE EXTRANJERIA</option>
                        <option value='4'>PASAPORTE</option>
                        <option value='5'>PART. DE NACIMIENTO</option>
                        <option value='6'>OTROS DOCUMENTOS</option>
                    ";
                    break;
                case 2:
                    $option = "
                        <option value='1'>RUC</option>
                        <option value='2' selected>DNI</option>
                        <option value='3'>CARNET DE EXTRANJERIA</option>
                        <option value='4'>PASAPORTE</option>
                        <option value='5'>PART. DE NACIMIENTO</option>
                        <option value='6'>OTROS DOCUMENTOS</option>
                    ";
                    break;
                case 3:
                    $option = "
                        <option value='1'>RUC</option>
                        <option value='2'>DNI</option>
                        <option value='3' selected>CARNET DE EXTRANJERIA</option>
                        <option value='4'>PASAPORTE</option>
                        <option value='5'>PART. DE NACIMIENTO</option>
                        <option value='6'>OTROS DOCUMENTOS</option>
                        ";
                    break;
                case 4:
                    $option = "
                        <option value='1'>RUC</option>
                        <option value='2'>DNI</option>
                        <option value='3'>CARNET DE EXTRANJERIA</option>
                        <option value='4' selected>PASAPORTE</option>
                        <option value='5'>PART. DE NACIMIENTO</option>
                        <option value='6'>OTROS DOCUMENTOS</option>
                    ";
                    break;
                case 5:
                    $option = "
                        <option value='1'>RUC</option>
                        <option value='2'>DNI</option>
                        <option value='3'>CARNET DE EXTRANJERIA</option>
                        <option value='4'>PASAPORTE</option>
                        <option value='5' selected>PART. DE NACIMIENTO</option>
                        <option value='6'>OTROS DOCUMENTOS</option>
                    ";
                    break;    
                case 6:
                    $option = "
                        <option value='1'>RUC</option>
                        <option value='2'>DNI</option>
                        <option value='3'>CARNET DE EXTRANJERIA</option>
                        <option value='4'>PASAPORTE</option>
                        <option value='5'>PART. DE NACIMIENTO</option>
                        <option value='6' selected>OTROS DOCUMENTOS</option>
                    ";
                    break;
            }
            return $option;
        }
        function lista_salidas(){
            $tabla = "";
            $cn = mainModel::conectar();
            $parametros = mainModel::parametros(); 
            $datos = $cn->query("SELECT S.ID_SALIDA , S.TIPO_SALIDA, S.DESTINATARIO, S.DOCUMENTO, S.NUMERO,S.F_SALIDA FROM salida_producto AS S");
            foreach($datos as $rows){
                $id = $rows['ID_SALIDA'];
                $tipo_salida = $rows["TIPO_SALIDA"];
                switch($tipo_salida){
                    case 1:
                        $tipo_salida = "Pedido de venta";
                        break;
                    case 2:
                        $tipo_salida = "Pedido de Transferencia";
                        break;
                    case 3:
                        $tipo_salida = "Pedido de devolucion de compra";
                        break;
                    case 4:
                        $tipo_salida = "Pedido de servicio";
                        break;
                    case 5:
                        $tipo_salida = "Pedido de ensamblado";
                        break;
                    case 6:
                        $tipo_salida = "Orden de Produccion";
                        break;
                    case 7:
                        $tipo_salida = "Otras Salidas";
                        break;
                }
                $documento = $rows["DOCUMENTO"];
                switch($documento){
                    case 1:
                        $documento = "Factura";
                        break;
                    case 2:
                        $documento = "Boleta";
                        break;
                    case 3:
                        $documento = "Nota de Entrada";
                        break;
                    case 4:
                        $documento = "Nota de Salida";
                        break;
                    case 5:
                        $documento = "Nota de Credito";
                        break;
                    case 6:
                        $documento = "Nota de Debito";
                        break;
                    case 7:
                        $documento = "Remision";
                        break;
                    case 8:
                        $documento = "Otro documento";
                        break;
                }
                $neto = $cn->query("SELECT D.CANTIDAD,D.PRECIO FROM detalle_salida_entrada_producto as D INNER JOIN producto as P ON P.ID_PRODUCTO = D.ID_PRODUCTO WHERE ID_SALIDA_ENTRADA = '$id'");
                $precio_neto = 0;
                foreach($neto as $row){
                    $cantidad = $row["CANTIDAD"];
                    $precio = $row["PRECIO"];
                    $total = $cantidad * $precio;
                    $precio_neto =  $precio_neto + $total;
                }
                $fecha = date('Y-m-d',strtotime($rows['F_SALIDA']));
                $tabla .="
                    <tr>
                        <td>".$id."</td>
                        <td>".$tipo_salida."</td>
                        <td>".$rows['DESTINATARIO']."</td>
                        <td>".$documento."</td>
                        <td>".$rows['NUMERO']."</td>
                        <td> ".$parametros['Moneda'].number_format($precio_neto,2)."</td>
                        <td>".$fecha."</td>
                        <td>
                            <div class='btn-group' role='group'>
                                <a href='".SERVERURL."salidaproducto/versalida/$id' class='btn btn-info-amosis btn-sm' data-toggle='tooltip' data-placement='top' title='Ver Salida' data-container='body'>
                                    <i class='fas fa-eye'> </i>
                                </a>
                                <a href='".SERVERURL."salidaproducto/imprimirsalida/$id' target='_blank' class='btn btn-danger-amosis btn-sm' data-toggle='tooltip' data-placement='top' title='Imprimir Salida' data-container='body'>
                                    <i class='fas fa-print'> </i>
                                </a>
                            </div>                   
                        </td>
                    </tr>
                ";
            }
            return $tabla;
        }
        function nuevosalida(){
            $this->view->brand = "Nueva salida de producto";
            $this->view->id_nav_active = "salida_producto-active";
            $this->view->id_collapase_active = "ventas";
            $this->view->codigo_entrada = $this::codigo_entrada();
            $this->view->parametros = mainModel::parametros(); 
            $this->view->lista_proveedor = $this::lista_proveedor();
            $this->view->lista_producto = $this::lista_producto();
            $this->view->render('salidaproducto/nuevo');
        }
        function numeros_salidas(){
            $cn = mainModel::conectar();
            $numero = $cn->query("SELECT * FROM salida_producto");
            $numero = $numero->rowCount();
            return $numero;
        }
        function codigo_entrada(){
            $n = $this->numeros_salidas();
            $codigo = mainModel::generar_codigo_aleatorio('SALI',2,$n);
            return $codigo; 
        }
        function lista_proveedor(){
            $option = "";
            $cn = mainModel::conectar();
            $datos = $cn->query("SELECT * FROM proveedor");
            foreach($datos as $row){
                $option .= "
                    <option value=".$row['ID_PROVEEDOR'].">".$row["RAZON_SOCIAL"]."</option>
                ";
            }
            return $option;
        }
        function lista_producto(){
            $option = "";
            $cn = mainModel::conectar();
            $datos = $cn->query("SELECT p.ID_PRODUCTO,p.NOMBRE FROM productos_almacen as pa INNER JOIN producto as p ON p.ID_PRODUCTO = pa.ID_PRODUCTO");
            foreach($datos as $row){
                $option .= "
                    <option value=".$row['ID_PRODUCTO'].">".$row["NOMBRE"]."</option>
                ";
            }
            return $option;
        }
        function datosproducto(){
            $id = $_POST["value"];
            $cn = mainModel::conectar();
            $datos = $cn->query("SELECT * FROM producto WHERE ID_PRODUCTO = '$id'");
            $precio = $datos->fetchColumn(3);
            echo $precio;
            
        }
        function nuevasalida(){
            if(isset($_POST["cod_salida"]) && isset($_POST["tipo_salida"])){
                $cn = mainModel::conectar();
                $cod_salida = $_POST["cod_salida"];
                $tipo_salida = $_POST["tipo_salida"];
                $tipo_documento_destinatario = $_POST["tipo_documento_destinatario"];
                $documento = $_POST["documento"];
                $numero = $_POST["numero"];
                $observacion = $_POST["observacion"];
                $nombre_destinatario = $_POST["nombre_destinatario"];
                $numero_documento_destinatario = $_POST["numero_documento_destinatario"];
                $data = [
                    "cod_salida" => $cod_salida,
                    "tipo_salida" => $tipo_salida,  
                    "tipo_documento_destinatario" => $tipo_documento_destinatario,  
                    "documento" => $documento,
                    "numero" => $numero,
                    "nombre_destinatario" => $nombre_destinatario,
                    "numero_documento_destinatario" => $numero_documento_destinatario,
                    "observacion" => $observacion
                ];
                $guardar = $this->model->insertar($data);
                if($guardar->rowCount()>0){
                    $tabla = $_POST["tabla"];
                    foreach($tabla as $value){
                        $id = $value["id"];
                        $cantidad_e = $value["cantidad"];
                        $unidad = $value["unidad"];
                        $precio = $value["precio"];
                        $id_unidad = 0;
                        $unidades = 0;
                        $query = $cn->query("SELECT p.UNIDADES,p.ID_PRECIO,p.PRECIO FROM precio_producto as p INNER JOIN unidad_medida as u ON u.ID_UNIDAD = p.ID_UNIDAD WHERE p.ID_PRODUCTO = '$id' AND u.PREFIJO = '$unidad'");
                        foreach($query as $row){
                            $unidades = $row["UNIDADES"];
                            $id_unidad = $row["ID_PRECIO"];
                            $precio = $row["PRECIO"];
                        }
                        $query = $cn->query("SELECT STOCK FROM productos_almacen WHERE ID_PRODUCTO = '$id'");
                        $stock = $query->fetchColumn(0);
                        $cantidad = $cantidad_e * $unidades;
                        $stock_existencial = $stock - $cantidad;
                        $query = $cn->query("INSERT INTO detalle_salida_entrada_producto (TIPO_DETALLE, ID_SALIDA_ENTRADA, ID_PRODUCTO,ID_UNIDAD, PRECIO, CANTIDAD, STOCK_EXISTENTE) VALUES ('2','$cod_salida','$id','$id_unidad','$precio','$cantidad_e','$stock_existencial')");
                        if($query->rowCount()>0){
                            $query = $cn->query("UPDATE productos_almacen SET STOCK = '$stock_existencial' WHERE  ID_PRODUCTO = '$id'");
                        }
                    }
                    echo " 
                    <script>
                        showNotification('bottom','center','La salida de productos se agrego correctamente','success');
                    </script>";
                }else{
                    echo " 
                    <script>
                        showNotification('bottom','center','No se pudo agregar la salida, intenta recargar la pagina','danger');
                    </script>";
                }

            }else{
                echo "Peticion Invalida";
            }
            
        }
        function producto_cantidad(){
            if(isset($_POST["idpro"])){
                $idpro = $_POST["idpro"];
                $idunidad = $_POST["idunidad"];
                $cn = mainModel::conectar();
                $datos = $cn->query("SELECT STOCK FROM productos_almacen WHERE  ID_PRODUCTO= '$idpro'");
                $cantidad = $datos->fetchColumn(0);
                $datos2 = $cn->query("SELECT UNIDADES FROM precio_producto WHERE  ID_PRODUCTO= '$idpro' AND ID_PRECIO = '$idunidad'");
                $convertido = $datos2->fetchColumn(0);
                echo $cantidad.'|'.$convertido;
            }else{
                echo "Petición Invalida";
            }
        }
    }