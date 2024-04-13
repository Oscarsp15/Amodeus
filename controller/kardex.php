<?php
    class kardex extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->id_nav_active = "kardex-active";
            $this->view->id_collapase_active = "inventario";
            $this->view->brand = "Kardex";
            $this->view->lista_de_productos = $this->lista_de_productos();
            $this->view->render('kardex/index');
        }
        function lista_de_productos(){
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
        function kardex(){
            $year = $_POST["year"];
            $mes = $_POST["mes"];
            $producto = $_POST["producto"];
            if($year == "0" && $mes == "0" && $producto != "0"){
                echo $this->tabla_kardex($year,$mes,$producto,1);
            }else if($year!= "0" && $mes != "0" && $producto != "0"){
                echo $this->tabla_kardex($year,$mes,$producto,2);
            }else if($year!= "0" && $mes == "0"  && $producto != "0"){
                echo $this->tabla_kardex($year,$mes,$producto,3);
            }else if($year== "0" && $mes != "0"  && $producto != "0"){
                echo $this->tabla_kardex($year,$mes,$producto,4);
            }
        }
        function tabla_kardex($y,$m,$p,$t){
            $cn = mainModel::conectar();
            $parametros = mainModel::parametros();
            $MONEDA = $parametros["Moneda"];

            $table_head = "
                <div class='card'>
                    <div class='card-header card-header-gold'>
                        <h4 class='card-title'>Kardex del Producto</h4>
                        <p class='card-category'>Informacion del producto</p>
                    </div>
                    <div class='card-body table-responsive'>
                        <table class='table table-hover table-bordered'>
                            <thead class='text-warning'>
                                <tr>
                                    <th colspan='2'></th>
                                    <th colspan='3' class='text-center'>ENTRADAS</th>
                                    <th colspan='3' class='text-center'>SALIDAS</th>
                                    <th colspan='3' class='text-center'>EXISTENCIAS</th>
                                </tr>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unit</th>
                                    <th>Total</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unit</th>
                                    <th>Total</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unit</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
            ";
            $table_body = "";
            $nombre = "";
            switch($t){
                case 1:
                    $query = "SELECT d.CANTIDAD,um.PREFIJO,d.STOCK_EXISTENTE,d.PRECIO,p.PRECIO_COSTO,p.NOMBRE,d.TIPO_DETALLE,d.FECHA FROM detalle_salida_entrada_producto as d INNER JOIN producto as p ON d.ID_PRODUCTO = p.ID_PRODUCTO INNER JOIN precio_producto as pp on d.ID_UNIDAD = pp.ID_PRECIO INNER JOIN unidad_medida as um ON pp.ID_UNIDAD = um.ID_UNIDAD WHERE d.ID_PRODUCTO = '$p' ORDER BY d.FECHA ASC";
                    $kardex_entrada = $cn->query($query);
                    foreach($kardex_entrada as $rows){
                        // $fecha = date('Y-m-d',strtotime($rows['FECHA']));
                        $fecha = $rows['FECHA'];
                        $cantidad = $rows["CANTIDAD"];
                        $prefijo = $rows["PREFIJO"];
                        $precio = $rows["PRECIO"];
                        $stock_existente = $rows["STOCK_EXISTENTE"];
                        $nombre = $rows["NOMBRE"];
                        $precio_costo = $rows["PRECIO_COSTO"];
                        $total = number_format($cantidad * $precio,2);
                        $total_existente = number_format($stock_existente * $precio_costo,2);
                        if($rows["TIPO_DETALLE"] == 1){       
                            $table_body .= "
                                <tr>
                                    <td>$fecha</td>
                                    <td>$nombre</td>
                                    <td>$cantidad $prefijo </td>
                                    <td>".$MONEDA."$precio</td>
                                    <td>".$MONEDA."$total</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>$stock_existente UND</td>
                                    <td>".$MONEDA."$precio_costo</td>
                                    <td>".$MONEDA."$total_existente</td>
                                </tr>
                            ";
                        }else{
                            $table_body .= "
                                <tr>
                                    <td>$fecha</td>
                                    <td>$nombre</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>$cantidad $prefijo </td>
                                    <td>".$MONEDA."$precio</td>
                                    <td>".$MONEDA."$total</td>
                                    <td>$stock_existente UND</td>
                                    <td>".$MONEDA."$precio_costo</td>
                                    <td>".$MONEDA."$total_existente</td>
                                </tr>
                            ";
                        }
                    }
                    break;
                case 2: 
                    $query = "SELECT d.CANTIDAD,um.PREFIJO,d.STOCK_EXISTENTE,d.PRECIO,p.PRECIO_COSTO,p.NOMBRE,d.TIPO_DETALLE,d.FECHA FROM detalle_salida_entrada_producto as d INNER JOIN producto as p ON d.ID_PRODUCTO = p.ID_PRODUCTO INNER JOIN precio_producto as pp on d.ID_UNIDAD = pp.ID_PRECIO INNER JOIN unidad_medida as um ON pp.ID_UNIDAD = um.ID_UNIDAD WHERE d.ID_PRODUCTO = '$p' AND YEAR(d.FECHA) = $y AND MONTH(d.FECHA) = $m ORDER BY d.FECHA";
                    $kardex_entrada = $cn->query($query);
                    foreach($kardex_entrada as $rows){
                        // $fecha = date('Y-m-d',strtotime($rows['FECHA']));
                        $fecha = $rows['FECHA'];
                        $cantidad = $rows["CANTIDAD"];
                        $prefijo = $rows["PREFIJO"];
                        $precio = $rows["PRECIO"];
                        $stock_existente = $rows["STOCK_EXISTENTE"];
                        $nombre = $rows["NOMBRE"];
                        $precio_costo = $rows["PRECIO_COSTO"];
                        $total = number_format($cantidad * $precio,2);
                        $total_existente = number_format($stock_existente * $precio_costo,2);
                        if($rows["TIPO_DETALLE"] == 1){       
                            $table_body .= "
                                <tr>
                                    <td>$fecha</td>
                                    <td>$nombre</td>
                                    <td>$cantidad $prefijo </td>
                                    <td>".$MONEDA."$precio</td>
                                    <td>".$MONEDA."$total</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>$stock_existente UND</td>
                                    <td>".$MONEDA."$precio_costo</td>
                                    <td>".$MONEDA."$total_existente</td>
                                </tr>
                            ";
                        }else{
                            $table_body .= "
                                <tr>
                                    <td>$fecha</td>
                                    <td>$nombre</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>$cantidad $prefijo </td>
                                    <td>".$MONEDA."$precio</td>
                                    <td>".$MONEDA."$total</td>
                                    <td>$stock_existente UND</td>
                                    <td>".$MONEDA."$precio_costo</td>
                                    <td>".$MONEDA."$total_existente</td>
                                </tr>
                            ";
                        }
                    }
                    break;
                case 3:
                    $query = "SELECT d.CANTIDAD,um.PREFIJO,d.STOCK_EXISTENTE,d.PRECIO,p.PRECIO_COSTO,p.NOMBRE,d.TIPO_DETALLE,d.FECHA FROM detalle_salida_entrada_producto as d INNER JOIN producto as p ON d.ID_PRODUCTO = p.ID_PRODUCTO INNER JOIN precio_producto as pp on d.ID_UNIDAD = pp.ID_PRECIO INNER JOIN unidad_medida as um ON pp.ID_UNIDAD = um.ID_UNIDAD WHERE d.ID_PRODUCTO = '$p'  AND YEAR(d.FECHA) = $y ORDER BY d.FECHA";
                    $kardex_entrada = $cn->query($query);
                    foreach($kardex_entrada as $rows){
                        // $fecha = date('Y-m-d',strtotime($rows['FECHA']));
                        $fecha = $rows['FECHA'];
                        $cantidad = $rows["CANTIDAD"];
                        $prefijo = $rows["PREFIJO"];
                        $precio = $rows["PRECIO"];
                        $stock_existente = $rows["STOCK_EXISTENTE"];
                        $nombre = $rows["NOMBRE"];
                        $precio_costo = $rows["PRECIO_COSTO"];
                        $total = number_format($cantidad * $precio,2);
                        $total_existente = number_format($stock_existente * $precio_costo,2);
                        if($rows["TIPO_DETALLE"] == 1){       
                            $table_body .= "
                                <tr>
                                    <td>$fecha</td>
                                    <td>$nombre</td>
                                    <td>$cantidad $prefijo </td>
                                    <td>".$MONEDA."$precio</td>
                                    <td>".$MONEDA."$total</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>$stock_existente UND</td>
                                    <td>".$MONEDA."$precio_costo</td>
                                    <td>".$MONEDA."$total_existente</td>
                                </tr>
                            ";
                        }else{
                            $table_body .= "
                                <tr>
                                    <td>$fecha</td>
                                    <td>$nombre</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>$cantidad $prefijo </td>
                                    <td>".$MONEDA."$precio</td>
                                    <td>".$MONEDA."$total</td>
                                    <td>$stock_existente UND</td>
                                    <td>".$MONEDA."$precio_costo</td>
                                    <td>".$MONEDA."$total_existente</td>
                                </tr>
                            ";
                        }
                    }
                    break;
                case 4:
                    $query = "SELECT d.CANTIDAD,um.PREFIJO,d.STOCK_EXISTENTE,d.PRECIO,p.PRECIO_COSTO,p.NOMBRE,d.TIPO_DETALLE,d.FECHA FROM detalle_salida_entrada_producto as d INNER JOIN producto as p ON d.ID_PRODUCTO = p.ID_PRODUCTO INNER JOIN precio_producto as pp on d.ID_UNIDAD = pp.ID_PRECIO INNER JOIN unidad_medida as um ON pp.ID_UNIDAD = um.ID_UNIDAD  WHERE d.ID_PRODUCTO = '$p' AND MONTH(d.FECHA) = $m ORDER BY d.FECHA";
                    $kardex_entrada = $cn->query($query);
                    foreach($kardex_entrada as $rows){
                        // $fecha = date('Y-m-d',strtotime($rows['FECHA']));
                        $fecha = $rows['FECHA'];
                        $cantidad = $rows["CANTIDAD"];
                        $prefijo = $rows["PREFIJO"];
                        $precio = $rows["PRECIO"];
                        $stock_existente = $rows["STOCK_EXISTENTE"];
                        $nombre = $rows["NOMBRE"];
                        $precio_costo = $rows["PRECIO_COSTO"];
                        $total = number_format($cantidad * $precio,2);
                        $total_existente = number_format($stock_existente * $precio_costo,2);
                        if($rows["TIPO_DETALLE"] == 1){       
                            $table_body .= "
                                <tr>
                                    <td>$fecha</td>
                                    <td>$nombre</td>
                                    <td>$cantidad $prefijo </td>
                                    <td>".$MONEDA."$precio</td>
                                    <td>".$MONEDA."$total</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>$stock_existente UND</td>
                                    <td>".$MONEDA."$precio_costo</td>
                                    <td>".$MONEDA."$total_existente</td>
                                </tr>
                            ";
                        }else{
                            $table_body .= "
                                <tr>
                                    <td>$fecha</td>
                                    <td>$nombre</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>$cantidad $prefijo </td>
                                    <td>".$MONEDA."$precio</td>
                                    <td>".$MONEDA."$total</td>
                                    <td>$stock_existente UND</td>
                                    <td>".$MONEDA."$precio_costo</td>
                                    <td>".$MONEDA."$total_existente</td>
                                </tr>
                            ";
                        }
                    }
                    break;
            }
            if(empty($nombre)){
                $nombre="Producto sin Movimientos";
            }
            if(empty($table_body)){
                $table_body ="
                    <tr>
                        <td colspan='11' class='text-center'>
                            No hay registros
                        </td>
                    </tr>
                ";
            }
            $tabla_footer = "
               
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <a href='".SERVERURL."kardex/imprimirkardex/$y/$m/$t/$p/$nombre' class='btn btn-rose'>Imprimir</a>
            ";
            $table = $table_head.$table_body.$tabla_footer;
            return $table;
        }
        function imprimirkardex($param = null){
            $this->view->conexion = mainModel::conectar();
            $this->view->parametros = mainModel::parametros();
            $this->view->year = $param[0];
            $this->view->mes = $param[1];
            $this->view->tipo = $param[2];
            $this->view->producto = $param[3];
            $this->view->nombre_producto = $param[4];
            $this->view->datos_productos = $this->dato_producto($param[3]);
            $this->view->render('kardex/imprimir');
        }
        function dato_producto($id){
            $cn = mainModel::conectar();
            $array = [];
            $data = $cn->query("SELECT P.ID_PRODUCTO , M.NOMBRE as MARCA , C.NOMBRE as CATEGORIA, pp.STOCK  FROM producto as P INNER JOIN marca as M on P.ID_MARCA = M.ID_MARCA INNER JOIN categoria as C on P.ID_CATEGORIA = C.ID_CATEGORIA INNER JOIN productos_almacen as pp ON pp.ID_PRODUCTO = pp.ID_PRODUCTO WHERE P.ID_PRODUCTO = '$id'"); 
            if ($data->RowCount() >= 1) {
                foreach ($data as $rows) {
                    $array = [
                        "Id" => $rows["ID_PRODUCTO"],
                        "Marca" => $rows["MARCA"],
                        "Categoria" => $rows["CATEGORIA"],
                        "Stock" => $rows["STOCK"]
                    ];
                }
            }
            return $array;
        }
    }