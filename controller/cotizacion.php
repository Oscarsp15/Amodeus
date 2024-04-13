<?php
    class cotizacion extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->lista_producto = $this->lista_producto();
            $this->view->codigo_cotizacion = $this->codigo_cotizacion();
            $this->view->parametros = mainModel::parametros();
            $this->view->id_nav_active = "cotizacion-active";
            $this->view->id_collapase_active = "cotizacion";
            $this->view->brand = "Cotizaciones";
            $this->view->render('cotizacion/index');
        }
        // lista de productos
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
        // Generar Codigos para las cotizaciones
        function codigo_cotizacion(){
            $cn = mainModel::conectar();
            $contar_cotizaciones = $cn->query("SELECT * FROM cotizacion");
            $n_cotizaciones = $contar_cotizaciones->rowCount();
            return $codigo = mainModel::generar_codigo_aleatorio("C000",2,$n_cotizaciones);
        }
        // Guardar la cotizacion
        function nuevacotizacion(){
            if(isset($_POST['productos'])){
                $cn = mainModel::conectar();
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
                //capturando el codigo de cotizacion
                $venta =  $_POST["venta"];
                $subtotal =  $_POST["subtotal"];
                $descuento =  $_POST["descuento"];
                $total = $_POST['total'];
                date_default_timezone_set(ZONE);
                $fechahora = date('Y-m-d H:i:s');
                $fecha = date('Y-m-d');
                $tipo = $_POST['tipo'];
                $guardar_cotizacion = $cn->query("INSERT INTO `cotizacion`(`ID_COTIZACION`, `ID_CLIENTE`, `ID_USUARIO`, `FECHAHORA`,`FECHA`,  `ENTREGA`, `SUBTOTAL`, `DESCUENTO`, `PRECIO_VENTA`) VALUES ('$venta','$id_cliente','$usuario','$fechahora','$fecha','$tipo','$subtotal','$descuento','$total')");
                if($guardar_cotizacion->rowCount()>0){
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
                        $precio = $producto[5];
                        $guardar_productos = $cn->query("INSERT INTO `detalle_cotizacion`(`ID_COTIZACION`, `ID_PRODUCTO`, `ID_UNIDAD`, `DETALLE`, `CANTIDAD`) VALUES ('$venta','$id','$unidadmedida','$detalle','$cantidad')");
                    }
                    echo 1;
                }

            }
        }
        // Reporte de una cotizacion
        function imprimircotizacion($param = null){
            $id = $param[0];
            $this->view->id = $id;
            $this->view->conexion = mainModel::conectar();
            $this->view->parametros = mainModel::parametros();
            $this->view->render('cotizacion/imprimir');
        }
        // Vista Lista de cotizaciones
        function cotizaciones(){
            $this->view->brand = "Lista de Cotizaciones";
            $this->view->lista_cotizacion = $this->lista_cotizacion();
            $this->view->id_nav_active = "cotizaciones-active";
            $this->view->id_collapase_active = "cotizacion";
            $this->view->render('cotizacion/lista');
        }
        // Lista de Cotizaciones
        function lista_cotizacion(){
            $tabla = "";
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT c.FECHAHORA,c.ID_COTIZACION,cl.NOMBRE,c.ENTREGA,c.PRECIO_VENTA FROM cotizacion as c INNER JOIN cliente as cl ON c.ID_CLIENTE = cl.ID_CLIENTE ORDER BY `c`.`FECHA` DESC");
            foreach($datos as $rows){
                $entrega = $rows["ENTREGA"];
                if($entrega == 1){
                    $entrega = "Por Pedido";
                }else{
                    $entrega = "Entrega Inmediata";
                }   
                $tabla .="
                    <tr>
                        <td>".$rows['FECHAHORA']."</td>
                        <td>".$rows['ID_COTIZACION']."</td>
                        <td>".$rows['NOMBRE']."</td>
                        <td>".$entrega."</td>
                        <td>".$rows['PRECIO_VENTA']."</td>
                        <td>
                            <a href='".SERVERURL."cotizacion/imprimircotizacion/".$rows['ID_COTIZACION']."' class='btn btn-warning btn-sm'  data-toggle='tooltip' data-placement='top' title='Ver Cotizacion' data-container='body'>
                                <i class='fa fa-file'></i>
                            </a>
                        </td>
                    </tr>
                ";
            }
            return $tabla;
        }
        function buscar(){
            if(isset($_POST["inicio"]) && isset($_POST["fin"])){
                $inicio = date($_POST["inicio"]);
                $fin = date($_POST["fin"]);
                $cn = mainModel::conectar();
                $tabla = "";
                $parametro = mainModel::parametros();
                $moneda = $parametro["Moneda"];
                $datos = $cn->query("SELECT E.ID_ENTRADA , E.TIPO_INGRESO, P.RAZON_SOCIAL, E.DOCUMENTO, E.NUMERO,E.F_INGRESO FROM entrada_producto as E INNER JOIN proveedor AS P on E.ID_PROVEEDOR = P.ID_PROVEEDOR AND date(E.F_INGRESO) >= '$inicio' AND date(E.F_INGRESO) <= '$fin' "); 
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