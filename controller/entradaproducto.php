<?php
    class entradaproducto extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->brand = "Compras de Productos";
            $this->view->id_nav_active = "entrada_producto-active";
            $this->view->id_collapase_active = "entrada_salida";
            $this->view->producto = $this->contartabla('producto');
            $this->view->numeros_entradas = $this::numeros_entradas();
            $this->view->lista_entradas = $this::lista_entradas();
            $this->view->render('entradaproducto/index');
            
        }
        function lista_entradas(){
            $tabla = "";
            $cn = mainModel::conectar();
            $parametro = mainModel::parametros();
            $moneda = $parametro["Moneda"];
            date_default_timezone_set(ZONE);
            $dia = date("Y-m-d");
            $datos = $cn->query("SELECT E.ID_ENTRADA , E.TIPO_INGRESO, P.RAZON_SOCIAL, E.DOCUMENTO, E.NUMERO,E.F_INGRESO FROM entrada_producto as E INNER JOIN proveedor AS P on E.ID_PROVEEDOR = P.ID_PROVEEDOR WHERE date(E.F_INGRESO) = '$dia'"); 
            foreach($datos as $rows){
                $id = $rows['ID_ENTRADA'];
                $tipo_entrada = $rows["TIPO_INGRESO"];
                switch($tipo_entrada){
                    case 1:
                        $tipo_entrada = "Ingreso por compra";
                        break;
                    case 2:
                        $tipo_entrada = "Ingreso por donacion";
                        break;
                    case 3:
                        $tipo_entrada = "Ingreso por devolucion";
                        break;
                    case 4:
                        $tipo_entrada = "Ingreso por traspaso almacén";
                        break;
                    case 5:
                        $tipo_entrada = "Ingreso por ajuste de inventarios";
                        break;
                    case 6:
                        $tipo_entrada = "Otras entradas";
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
                $neto = $cn->query("SELECT D.CANTIDAD,D.PRECIO FROM detalle_salida_entrada_producto as D INNER JOIN producto as P ON P.ID_PRODUCTO = D.ID_PRODUCTO WHERE D.ID_SALIDA_ENTRADA = '$id'");
                $precio_neto = 0;
                foreach($neto as $row){
                    $cantidad = $row["CANTIDAD"];
                    $precio = $row["PRECIO"];
                    $total = $cantidad * $precio;
                    $precio_neto =  number_format($precio_neto + $total,2);
                }
                $fecha = date('Y-m-d',strtotime($rows['F_INGRESO']));
                $tabla .="
                    <tr>
                        <td>".$id."</td>
                        <td>".$tipo_entrada."</td>
                        <td>".$rows['RAZON_SOCIAL']."</td>
                        <td>".$documento."</td>
                        <td>".$rows['NUMERO']."</td>
                        <td>".$moneda.$precio_neto."</td>
                        <td>".$fecha."</td>
                        <td>
                            <div class='btn-group' role='group'>
                                <a href='".SERVERURL."entradaproducto/verentrada/$id' class='btn btn-info-amosis btn-sm' data-toggle='tooltip' data-placement='top' title='Ver Entrada' data-container='body'>
                                    <i class='fas fa-eye'> </i>
                                </a>
                                <a href='".SERVERURL."entradaproducto/imprimirentrada/$id' target='_blank' class='btn btn-danger-amosis btn-sm' data-toggle='tooltip' data-placement='top' title='Imprimir Entrada' data-container='body'>
                                    <i class='fas fa-print'> </i>
                                </a>
                            </div>                   
                        </td>
                    </tr>
                ";
            }
            return $tabla;
        }
        function nuevoentrada(){
            $this->view->brand = "Nueva compra de productos";
            $this->view->id_nav_active = "entrada_producto-active";
            $this->view->id_collapase_active = "entrada_salida";
            $this->view->codigo_entrada = $this::codigo_entrada();
            $this->view->lista_proveedor = $this::lista_proveedor();
            $this->view->lista_producto = $this::lista_producto();
            $this->view->parametro = mainModel::parametros();
            $this->view->render('entradaproducto/nuevo');
        }
        function actualizarentrada(){
            if(isset($_POST["tipo_ingreso"]) && isset($_POST["proveedor"]) && isset($_POST["documento"])){
                $cn = mainModel::conectar();
                $codigo = $_POST["id_agregar"];
                $tipo_ingreso = $_POST["tipo_ingreso"];
                $proveedor = $_POST["proveedor"];
                $documento = $_POST["documento"];
                $n_documento = $_POST["numero_documento"];
                $observacion = $_POST["observacion"];
                $data = [
                    "cod_entrada" => $codigo,
                    "tipo_ingreso" => $tipo_ingreso,  
                    "proveedor" => $proveedor,
                    "documento" => $documento,
                    "numero" => utf8_decode($n_documento),
                    "observacion" => utf8_decode($observacion)
                ];
                $guardar = $this->model->actualizar($data);
                if($guardar->rowCount()>0){
                    echo " 
                        <script>
                            showNotification('bottom','center','La entrada de productos se actualizo correctamente','success');
                        </script>";
                }else{
                    echo " 
                        <script>
                            showNotification('bottom','center','No se pudo actualizar la entrada, intenta recargar la pagina','danger');
                        </script>";
                }

            }else{
                echo "Peticion Invalida";
            }
        }
        function numeros_entradas(){
            $cn = mainModel::conectar();
            date_default_timezone_set(ZONE);
            $dia = date("Y-m-d");
            $numero = $cn->query("SELECT * FROM entrada_producto as E WHERE date(E.F_INGRESO) = '$dia'");
            $numero = $numero->rowCount();
            return $numero;
        }
        function contartabla($tabla){
            $cn = mainModel::conectar();
            $datos = $cn->query("SELECT * FROM $tabla");
            $num = $datos->rowCount();
            return $num;
        }

        function codigo_entrada(){
            $n = $this->numeros_entradas();
            $codigo = mainModel::generar_codigo_aleatorio('ENTR',2,$n);
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
            $datos = $cn->query("SELECT * FROM producto");
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
        function nuevaentrada(){
            if(isset($_POST["cod_entrada"]) && isset($_POST["proveedor"])){
                $cn = mainModel::conectar();
                $cod_entrada = $_POST["cod_entrada"];
                $tipo_ingreso = $_POST["tipo_ingreso"];
                $proveedor = $_POST["proveedor"];
                $documento = $_POST["documento"];
                $numero = $_POST["numero"];
                $observacion = $_POST["observacion"];
                $data = [
                    "cod_entrada" => $cod_entrada,
                    "tipo_ingreso" => $tipo_ingreso,  
                    "proveedor" => $proveedor,
                    "documento" => $documento,
                    "numero" => utf8_decode($numero),
                    "observacion" => utf8_decode($observacion)
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
                        $query = $cn->query("SELECT p.UNIDADES,p.ID_PRECIO,p.PRECIO_COSTO FROM precio_producto as p INNER JOIN unidad_medida as u ON u.ID_UNIDAD = p.ID_UNIDAD WHERE p.ID_PRODUCTO = '$id' AND u.PREFIJO = '$unidad'");
                        foreach($query as $row){
                            $unidades = $row["UNIDADES"];
                            $id_unidad = $row["ID_PRECIO"];
                            $precio = $row["PRECIO_COSTO"];
                        }
                        $query = $cn->query("SELECT STOCK FROM productos_almacen WHERE ID_PRODUCTO = '$id'");
                        $stock = $query->fetchColumn(0);
                        $cantidad = $cantidad_e * $unidades;
                        $stock_existencial = $stock + $cantidad;
                        $query = $cn->query("INSERT INTO detalle_salida_entrada_producto (TIPO_DETALLE, ID_SALIDA_ENTRADA, ID_PRODUCTO,ID_UNIDAD, PRECIO, CANTIDAD, STOCK_EXISTENTE) VALUES ('1','$cod_entrada','$id','$id_unidad','$precio','$cantidad_e','$stock_existencial')");
                        if($query->rowCount()>0){
                            $query = $cn->query("SELECT * FROM productos_almacen WHERE  ID_PRODUCTO = '$id'");
                            if($query->rowCount()>0){
                                $query = $cn->query("UPDATE productos_almacen SET STOCK = '$stock_existencial' WHERE  ID_PRODUCTO = '$id'");
                            }else{
                                $query = $cn->query("INSERT INTO productos_almacen(ID_PRODUCTO,STOCK) VALUES ('$id','$stock_existencial')");
                            }
                        }
                   }
                   echo " 
                   <script>
                       showNotification('bottom','center','La entrada de productos se agrego correctamente','success');
                   </script>";
                }else{
                    echo " 
                    <script>
                        showNotification('bottom','center','No se pudo agregar la entrada, intenta recargar la pagina','danger');
                    </script>";
                }

            }else{
                echo "Peticion Invalida";
            }
            
        }
        function verentrada($id = null){
            $this->view->brand = "Compra de Productos";
            $this->view->id_nav_active = "entrada_producto-active";
            $this->view->id_collapase_active = "entrada_salida";
            $this->view->id_entrada = $id[0];
            $this->view->provedor_lista_entrada =  $this::provedor_entrada($id[0]);
            $this->view->tipo_lista_entrada =  $this::tipo_lista_entrada($id[0]);
            $this->view->documento_lista_entrada =  $this::documento_lista_entrada($id[0]);
            $this->view->lista_productos_entrada =  $this::lista_productos_entrada($id[0]);
            $this->view->datos_entrada_entrada = $this::datos_entrada($id[0]);
            $this->view->render('entradaproducto/editar');
        }
        function datos_entrada($id){
            $cn = mainModel::conectar();
            $array = [];
            $data = $cn->query("SELECT * FROM entrada_producto WHERE ID_ENTRADA = '$id'");
            if ($data->RowCount() >= 1) {
                foreach ($data as $rows) {
                    $array = [
                        "Numero" => $rows["NUMERO"],
                        "Observacion" => $rows["OBSERVACION"]
                    ];
                }
            }
            return $array;
        }
        function tipo_lista_entrada($id){
            $cn = mainModel::conectar();
            $tipo = $cn->query("SELECT TIPO_INGRESO FROM entrada_producto WHERE ID_ENTRADA = '$id'");
            $tipo = $tipo->fetchColumn(0);
            $option = "";
            switch($tipo){
                case 1:
                    $option = "
                        <option value='1' selected>INGRESO POR COMPRA</option>
                        <option value='2'>INGRESO POR DONACION</option>
                        <option value='3'>INGRESO POR DEVOLUCION</option>
                        <option value='4'>INGRESO POR TRASPASO ALMACÉN</option>
                        <option value='5'>INGRESO POR AJUSTE DE INVENTARIOS</option>
                        <option value='6'>OTRAS ENTRADAS</option>
                    ";
                    break;
                case 2:
                    $option = "
                        <option value='1'>INGRESO POR COMPRA</option>
                        <option value='2' selected>INGRESO POR DONACION</option>
                        <option value='3'>INGRESO POR DEVOLUCION</option>
                        <option value='4'>INGRESO POR TRASPASO ALMACÉN</option>
                        <option value='5'>INGRESO POR AJUSTE DE INVENTARIOS</option>
                        <option value='6'>OTRAS ENTRADAS</option>
                    ";
                    break;
                case 3:
                    $option = "
                        <option value='1'>INGRESO POR COMPRA</option>
                        <option value='2'>INGRESO POR DONACION</option>
                        <option value='3' selected>INGRESO POR DEVOLUCION</option>
                        <option value='4'>INGRESO POR TRASPASO ALMACÉN</option>
                        <option value='5'>INGRESO POR AJUSTE DE INVENTARIOS</option>
                        <option value='6'>OTRAS ENTRADAS</option>
                        ";
                    break;
                case 4:
                    $option = "
                        <option value='1'>INGRESO POR COMPRA</option>
                        <option value='2'>INGRESO POR DONACION</option>
                        <option value='3'>INGRESO POR DEVOLUCION</option>
                        <option value='4' selected>INGRESO POR TRASPASO ALMACÉN</option>
                        <option value='5'>INGRESO POR AJUSTE DE INVENTARIOS</option>
                        <option value='6'>OTRAS ENTRADAS</option>
                    ";
                    break;
                case 5:
                    $option = "
                        <option value='1'>INGRESO POR COMPRA</option>
                        <option value='2'>INGRESO POR DONACION</option>
                        <option value='3'>INGRESO POR DEVOLUCION</option>
                        <option value='4'>INGRESO POR TRASPASO ALMACÉN</option>
                        <option value='5' selected>INGRESO POR AJUSTE DE INVENTARIOS</option>
                        <option value='6'>OTRAS ENTRADAS</option>
                    ";
                    break;    
                case 6:
                    $option = "
                        <option value='1'>INGRESO POR COMPRA</option>
                        <option value='2'>INGRESO POR DONACION</option>
                        <option value='3'>INGRESO POR DEVOLUCION</option>
                        <option value='4'>INGRESO POR TRASPASO ALMACÉN</option>
                        <option value='5'>INGRESO POR AJUSTE DE INVENTARIOS</option>
                        <option value='6' selected>OTRAS ENTRADAS</option>
                    ";
                    break;
            }
            return $option;
        }
        function provedor_entrada($id){
            $cn = mainModel::conectar();
            $proveedor = $cn->query("SELECT ID_PROVEEDOR FROM entrada_producto WHERE ID_ENTRADA = '$id'");
            $proveedor = $proveedor->fetchColumn(0);
            $option = "";
            $proveedores = $cn->query("SELECT * FROM proveedor");
            foreach($proveedores as $row){
                $id_pro = $row["ID_PROVEEDOR"];
                $rs = $row["RAZON_SOCIAL"];
                if($id_pro == $proveedor){
                    $option .= "
                        <option value='$id_pro' selected>$rs</option>
                    ";
                }else{
                    $option .= "
                        <option value='$id_pro'>$rs</option>
                    ";
                }
            }
            return $option;
        }
        function documento_lista_entrada($id){
            $cn = mainModel::conectar();
            $tipo = $cn->query("SELECT DOCUMENTO FROM entrada_producto WHERE ID_ENTRADA = '$id'");
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
        function lista_productos_entrada($id){
            $cn = mainModel::conectar();
            $productos = $cn->query("SELECT d.ID_PRODUCTO,p.NOMBRE,d.PRECIO,d.CANTIDAD,d.ID_UNIDAD,u.PREFIJO FROM detalle_salida_entrada_producto AS d INNER JOIN producto as p on d.ID_PRODUCTO = p.ID_PRODUCTO INNER JOIN precio_producto as pp ON pp.ID_PRECIO = d.ID_UNIDAD INNER JOIN unidad_medida as u on u.ID_UNIDAD = pp.ID_UNIDAD WHERE d.ID_SALIDA_ENTRADA = '$id'");
            $tabla = "";
            $total_neto = 0;
            $parametro = mainModel::parametros();
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
                    <td colspan='2'><h6 class='font-weight-bolder'>Total Neto ".$parametro['Moneda']."<span>$total_neto</span> </h6></td>
                </tr>
            ";
            return $tabla;
        }
        function imprimirentrada($id = null){
            $this->view->datos_entrada_entrada = $this::datos_entrada_imprimir($id[0]);
            $this->view->parametros = mainModel::parametros(); 
            $this->view->conexion = mainModel::conectar();
            $this->view->render('entradaproducto/imprimir');
        }
        function datos_entrada_imprimir($id){
            $cn = mainModel::conectar();
            $array = [];
            $data = $cn->query("SELECT e.ID_ENTRADA,e.TIPO_INGRESO,e.DOCUMENTO,e.NUMERO,e.OBSERVACION,e.F_INGRESO,p.RAZON_SOCIAL FROM entrada_producto as e INNER JOIN proveedor as p on e.ID_PROVEEDOR = p.ID_PROVEEDOR  WHERE e.ID_ENTRADA = '$id'");
            if ($data->RowCount() >= 1) {
                foreach ($data as $rows) {
                    $ID = $rows["ID_ENTRADA"];
                    $tipo_ingreso = $rows["TIPO_INGRESO"];
                    switch($tipo_ingreso){
                        case 1:
                            $tipo_ingreso = "INGRESO POR COMPRA";
                            break;
                        case 2:
                            $tipo_ingreso = "INGRESO POR DONACION";
                            break;
                        case 3:
                            $tipo_ingreso = "INGRESO POR DEVOLUCION";
                            break;
                        case 4:
                            $tipo_ingreso = "INGRESO DE TRASPASO DE ALMACEN";
                            break;
                        case 5:
                            $tipo_ingreso = "INGRESO DE AJUSTES DE INVENTARIOS";
                            break;
                        case 6:
                            $tipo_ingreso = "OTRAS ENTRADAS";
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
                    $numero = $rows["NUMERO"];
                    $fecha = date('Y-m-d',strtotime($rows['F_INGRESO']));
                    $array = [
                        "Id" => $ID,
                        "Tipo_entrada" => $tipo_ingreso,
                        "Tipo_documento" => $tipo_documento,
                        "Numero" => $numero,
                        "Fecha" => $fecha,
                        "Proveedor" => $rows["RAZON_SOCIAL"],
                        "Observacion" => $rows["OBSERVACION"]
                    ];
                }
            }
            return $array;
        }
        function fecha(){
            $this->view->brand = "Buscar compras por fecha";
            $this->view->id_nav_active = "compras-active";
            $this->view->id_collapase_active = "entrada_salida";
            $this->view->codigo_entrada = $this::codigo_entrada();
            $this->view->lista_proveedor = $this::lista_proveedor();
            $this->view->lista_producto = $this::lista_producto();
            $this->view->parametro = mainModel::parametros();
            $this->view->render('entradaproducto/fecha');
        }
        function buscarfecha(){
            if(isset($_POST["inicio"]) && isset($_POST["fin"])){
                $inicio = date($_POST["inicio"]);
                $fin = date($_POST["fin"]);
                $cn = mainModel::conectar();
                $parametro = mainModel::parametros();
                $moneda = $parametro["Moneda"];
                $tabla = "";
                $query = "SELECT E.ID_ENTRADA , E.TIPO_INGRESO, P.RAZON_SOCIAL, E.DOCUMENTO, E.NUMERO,E.F_INGRESO FROM entrada_producto as E INNER JOIN proveedor AS P on E.ID_PROVEEDOR = P.ID_PROVEEDOR WHERE date(E.F_INGRESO) >= '$inicio' and date(E.F_INGRESO) <= '$fin' ";
                $datos = $cn->query($query);
                foreach($datos as $rows){
                    $id = $rows['ID_ENTRADA'];
                    $tipo_entrada = $rows["TIPO_INGRESO"];
                    switch($tipo_entrada){
                        case 1:
                            $tipo_entrada = "Ingreso por compra";
                            break;
                        case 2:
                            $tipo_entrada = "Ingreso por donacion";
                            break;
                        case 3:
                            $tipo_entrada = "Ingreso por devolucion";
                            break;
                        case 4:
                            $tipo_entrada = "Ingreso por traspaso almacén";
                            break;
                        case 5:
                            $tipo_entrada = "Ingreso por ajuste de inventarios";
                            break;
                        case 6:
                            $tipo_entrada = "Otras entradas";
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
                    $neto = $cn->query("SELECT D.CANTIDAD,D.PRECIO FROM detalle_salida_entrada_producto as D INNER JOIN producto as P ON P.ID_PRODUCTO = D.ID_PRODUCTO WHERE D.ID_SALIDA_ENTRADA = '$id'");
                    $precio_neto = 0;
                    foreach($neto as $row){
                        $cantidad = $row["CANTIDAD"];
                        $precio = $row["PRECIO"];
                        $total = $cantidad * $precio;
                        $precio_neto =  number_format($precio_neto + $total,2);
                    }
                    $fecha = date('Y-m-d',strtotime($rows['F_INGRESO']));
                    $tabla .="
                        <tr>
                            <td>".$id."</td>
                            <td>".$tipo_entrada."</td>
                            <td>".$rows['RAZON_SOCIAL']."</td>
                            <td>".$documento."</td>
                            <td>".$rows['NUMERO']."</td>
                            <td>".$moneda.$precio_neto."</td>
                            <td>".$fecha."</td>
                            <td>
                                <div class='btn-group' role='group'>
                                    <a href='".SERVERURL."entradaproducto/verentrada/$id' class='btn btn-info-amosis btn-sm' data-toggle='tooltip' data-placement='top' title='Ver Entrada' data-container='body'>
                                        <i class='fas fa-eye'> </i>
                                    </a>
                                    <a href='".SERVERURL."entradaproducto/imprimirentrada/$id' target='_blank' class='btn btn-danger-amosis btn-sm' data-toggle='tooltip' data-placement='top' title='Imprimir Entrada' data-container='body'>
                                        <i class='fas fa-print'> </i>
                                    </a>
                                </div>                   
                            </td>
                        </tr>
                    ";
                }
                echo $tabla;
            }
        }
        function mes(){
            $this->view->brand = "Buscar compras por mes";
            $this->view->id_nav_active = "comprasm-active";
            $this->view->id_collapase_active = "entrada_salida";
            $this->view->codigo_entrada = $this::codigo_entrada();
            $this->view->lista_proveedor = $this::lista_proveedor();
            $this->view->lista_producto = $this::lista_producto();
            $this->view->parametro = mainModel::parametros();
            $this->view->render('entradaproducto/mes');
        }
        function buscarmes(){
            if(isset($_POST["inicio"])){
                $fecha = date($_POST["inicio"]);
                $fecha = explode('-',$fecha);
                $year = $fecha[0];
                $mes = $fecha[1];
                $cn = mainModel::conectar();
                $parametro = mainModel::parametros();
                $moneda = $parametro["Moneda"];
                $tabla = "";
                $query = "SELECT E.ID_ENTRADA , E.TIPO_INGRESO, P.RAZON_SOCIAL, E.DOCUMENTO, E.NUMERO,E.F_INGRESO FROM entrada_producto as E INNER JOIN proveedor AS P on E.ID_PROVEEDOR = P.ID_PROVEEDOR AND MONTH(E.F_INGRESO) = '$mes' AND YEAR(E.F_INGRESO) = '$year' ";
                $datos = $cn->query($query);
                foreach($datos as $rows){
                    $id = $rows['ID_ENTRADA'];
                    $tipo_entrada = $rows["TIPO_INGRESO"];
                    switch($tipo_entrada){
                        case 1:
                            $tipo_entrada = "Ingreso por compra";
                            break;
                        case 2:
                            $tipo_entrada = "Ingreso por donacion";
                            break;
                        case 3:
                            $tipo_entrada = "Ingreso por devolucion";
                            break;
                        case 4:
                            $tipo_entrada = "Ingreso por traspaso almacén";
                            break;
                        case 5:
                            $tipo_entrada = "Ingreso por ajuste de inventarios";
                            break;
                        case 6:
                            $tipo_entrada = "Otras entradas";
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
                    $neto = $cn->query("SELECT D.CANTIDAD,D.PRECIO FROM detalle_salida_entrada_producto as D INNER JOIN producto as P ON P.ID_PRODUCTO = D.ID_PRODUCTO WHERE D.ID_SALIDA_ENTRADA = '$id'");
                    $precio_neto = 0;
                    foreach($neto as $row){
                        $cantidad = $row["CANTIDAD"];
                        $precio = $row["PRECIO"];
                        $total = $cantidad * $precio;
                        $precio_neto =  number_format($precio_neto + $total,2);
                    }
                    $fecha = date('Y-m-d',strtotime($rows['F_INGRESO']));
                    $tabla .="
                        <tr>
                            <td>".$id."</td>
                            <td>".$tipo_entrada."</td>
                            <td>".$rows['RAZON_SOCIAL']."</td>
                            <td>".$documento."</td>
                            <td>".$rows['NUMERO']."</td>
                            <td>".$moneda.$precio_neto."</td>
                            <td>".$fecha."</td>
                            <td>
                                <div class='btn-group' role='group'>
                                    <a href='".SERVERURL."entradaproducto/verentrada/$id' class='btn btn-info-amosis btn-sm' data-toggle='tooltip' data-placement='top' title='Ver Entrada' data-container='body'>
                                        <i class='fas fa-eye'> </i>
                                    </a>
                                    <a href='".SERVERURL."entradaproducto/imprimirentrada/$id' target='_blank' class='btn btn-danger-amosis btn-sm' data-toggle='tooltip' data-placement='top' title='Imprimir Entrada' data-container='body'>
                                        <i class='fas fa-print'> </i>
                                    </a>
                                </div>                   
                            </td>
                        </tr>
                    ";
                }
                echo $tabla;
            }
        }
    }