<?php
    class contado extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->brand = "Ventas al contado del dia de hoy";
            $this->view->id_nav_active = "contado-active";
            $this->view->id_collapase_active = "ventas";
            $this->view->parametros = mainModel::parametros();
            $this->view->lista_ventas = $this::lista_ventas();
            $this->view->ventas_canceladas = $this::ventas_canceladas();
            $this->view->ganancia_ventas = $this::ganancia_ventas();
            $this->view->ventas = $this::ventas();
            $this->view->total_ventas = $this::total_ventas();
            $this->view->render('contado/index');
        }
        function reporte(){
            $this->view->id_nav_active = "reporte-active";
            $this->view->brand = "Reporte de ventas del mes";
            $this->view->id_collapase_active = "ventas";
            $this->view->parametros = mainModel::parametros();
            $this->view->lista_ventas = $this::lista_ventas_2();
            $this->view->ventas_canceladas = $this::ventas_canceladas2();
            $this->view->ganancia_ventas = $this::ganancia_ventas2();
            $this->view->ventas = $this::ventas2();
            $this->view->total_ventas = $this::total_ventas2();
            $this->view->render('contado/mes');
        }
        function anual(){
            $this->view->id_nav_active = "anual-active";
            $this->view->id_collapase_active = "ventas";
            $this->view->brand = "Reporte Anual";
            $this->view->parametros = mainModel::parametros();
            $this->view->lista_ventas = $this::lista_ventas_3();
            $this->view->ventas_canceladas = $this::ventas_canceladas3();
            $this->view->ganancia_ventas = $this::ganancia_ventas3();
            $this->view->ventas = $this::ventas3();
            $this->view->total_ventas = $this::total_ventas3();
            $this->view->render('contado/anual');
        }

        function lista_ventas_3(){
            date_default_timezone_set("America/lima");
            $year = date('Y');
            $mes = date('m');
            $table = "";
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM venta_contado");
            foreach($datos as $rows){
                $id = $rows['ID_VENTA'];
                $estado = $rows['ESTADO'];
                if($estado == 1){
                    $estado = "<h2 class='badge badge-success'>Venta activa</h2>";
                }else{
                    $estado = "<h2 class='badge badge-danger'>Venta cancelada</h2>";
                }
                $cliente = $rows['ID_CLIENTE'];
                if($cliente == ""){
                    $cliente = "Publico General";
                }
                $table .="
                    <tr>
                        <td>".$rows['FECHAHORA']."</td>
                        <td>".$rows['ID_USUARIO']."</td>
                        <td>".$cliente."</td>
                        <td>".$rows['SUBTOTAL']."</td>
                        <td>".$rows['DESCUENTO']."</td>
                        <td>".$rows['TOTAL']."</td>
                        <td>".$rows['PAGOCON']."</td>
                        <td>".$rows['CAMBIO']."</td>
                        <td>".$estado."</td>
                        <td clas='text-center'> 
                            <div class='btn-group'>
                                <a href='".SERVERURL."caja/verticket/$id' target='_blank' class='btn-editar btn btn-warning btn-sm'  data-toggle='tooltip' data-placement='top' title='Ver Ticket' data-container='body'>
                                    <i class='fa fa-file-alt'></i>
                                </a>
                                <a href='".SERVERURL."contado/imprimirticket/$id' target='_blank' class='btn-editar btn btn-danger btn-sm'  data-toggle='tooltip' data-placement='top' title='Imprimir Ticket' data-container='body'>
                                    <i class='fa fa-print'></i>
                                </a>     
                            </div>              
                        </td>
                    </tr>
                ";
            }
            return $table;
        }
        function lista_ventas_2(){
            date_default_timezone_set("America/lima");
            $year = date('Y');
            $mes = date('m');
            $table = "";
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM venta_contado WHERE MES = '$mes' AND ANO = '$year'");
            foreach($datos as $rows){
                $id = $rows['ID_VENTA'];
                $estado = $rows['ESTADO'];
                if($estado == 1){
                    $estado = "<h2 class='badge badge-success'>Venta activa</h2>";
                }else{
                    $estado = "<h2 class='badge badge-danger'>Venta cancelada</h2>";
                }
                $cliente = $rows['ID_CLIENTE'];
                if($cliente == ""){
                    $cliente = "Publico General";
                }
                $table .="
                    <tr>
                        <td>".$rows['FECHAHORA']."</td>
                        <td>".$rows['ID_USUARIO']."</td>
                        <td>".$cliente."</td>
                        <td>".$rows['SUBTOTAL']."</td>
                        <td>".$rows['DESCUENTO']."</td>
                        <td>".$rows['TOTAL']."</td>
                        <td>".$rows['PAGOCON']."</td>
                        <td>".$rows['CAMBIO']."</td>
                        <td>".$estado."</td>
                        <td clas='text-center'> 
                            <div class='btn-group'>
                                <a href='".SERVERURL."caja/verticket/$id' target='_blank' class='btn-editar btn btn-warning btn-sm'  data-toggle='tooltip' data-placement='top' title='Ver Ticket' data-container='body'>
                                    <i class='fa fa-file-alt'></i>
                                </a>
                                <a href='".SERVERURL."contado/imprimirticket/$id' target='_blank' class='btn-editar btn btn-danger btn-sm'  data-toggle='tooltip' data-placement='top' title='Imprimir Ticket' data-container='body'>
                                    <i class='fa fa-print'></i>
                                </a>     
                            </div>              
                        </td>
                    </tr>
                ";
            }
            return $table;
        }
        function lista_ventas(){
            date_default_timezone_set("America/lima");
            $year = date('Y');
            $mes = date('m');
            $dia = date('d');
            $table = "";
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM venta_contado WHERE DIA = '$dia' AND MES = '$mes' AND ANO = '$year'");
            foreach($datos as $rows){
                $id = $rows['ID_VENTA'];
                $estado = $rows['ESTADO'];
                if($estado == 1){
                    $estado = "<h2 class='badge badge-success'>Venta activa</h2>";
                }else{
                    $estado = "<h2 class='badge badge-danger'>Venta cancelada</h2>";
                }
                $cliente = $rows['ID_CLIENTE'];
                if($cliente == ""){
                    $cliente = "Publico General";
                }
                $table .="
                    <tr>
                        <td>".$rows['FECHAHORA']."</td>
                        <td>".$rows['ID_USUARIO']."</td>
                        <td>".$cliente."</td>
                        <td>".$rows['SUBTOTAL']."</td>
                        <td>".$rows['DESCUENTO']."</td>
                        <td>".$rows['TOTAL']."</td>
                        <td>".$rows['PAGOCON']."</td>
                        <td>".$rows['CAMBIO']."</td>
                        <td>".$estado."</td>
                        <td clas='text-center'> 
                            <div class='btn-group'>
                                <a href='".SERVERURL."caja/verticket/$id' target='_blank' class='btn-editar btn btn-warning btn-sm'  data-toggle='tooltip' data-placement='top' title='Ver Ticket' data-container='body'>
                                    <i class='fa fa-file-alt'></i>
                                </a>
                                <a href='".SERVERURL."contado/imprimirticket/$id' target='_blank' class='btn-editar btn btn-danger btn-sm'  data-toggle='tooltip' data-placement='top' title='Imprimir Ticket' data-container='body'>
                                    <i class='fa fa-print'></i>
                                </a>     
                            </div>              
                        </td>
                    </tr>
                ";
            }
            return $table;
        }

        function ventas_canceladas(){
            date_default_timezone_set("America/lima");
            $year = date('Y');
            $mes = date('m');
            $dia = date('d');
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM venta_contado WHERE ESTADO = 0 AND DIA = '$dia' AND MES = '$mes' AND ANO = '$year'");
            return $datos->rowCount();
        }
        function ventas(){
            $conexion = mainModel::conectar();
            date_default_timezone_set("America/lima");
            $year = date('Y');
            $mes = date('m');
            $dia = date('d');
            $datos = $conexion->query("SELECT * FROM venta_contado WHERE ESTADO = 1 AND DIA = '$dia' AND MES = '$mes' AND ANO = '$year'");
            return $datos->rowCount();
        }
        function ganancia_ventas(){
            date_default_timezone_set("America/lima");
            $year = date('Y');
            $mes = date('m');
            $dia = date('d');
            $conexion = mainModel::conectar();
            $venta = $conexion->query("SELECT * FROM venta_contado WHERE ESTADO = 1 AND DIA = '$dia' AND MES = '$mes' AND ANO = '$year'");
            $total = 0;
            $total_inventario = 0;
            $total_venta = 0;
            $total_descuento = 0;
            foreach($venta as $rows){
                $id_venta = $rows["ID_VENTA"];
                $total_descuento += $rows["DESCUENTO"];
                $detalle = $conexion->query("SELECT d.CANTIDAD,p.PRECIO,p.PRECIO_COSTO FROM detalle_venta_contado as d INNER JOIN precio_producto as p ON d.ID_UNIDAD = p.ID_PRECIO WHERE d.ID_VENTA = '$id_venta'");
                foreach($detalle as $row){
                    $cantidad = $row["CANTIDAD"];
                    $precio = $row["PRECIO"];
                    $precio_costo = $row["PRECIO_COSTO"];
                    $total_inventario += $cantidad * $precio_costo;
                    $total_venta += $cantidad * $precio;
                }
            }
            $total = $total_venta - $total_inventario;
            $total = $total-$total_descuento;
            return number_format($total,2);
        }
        function total_ventas(){
            date_default_timezone_set("America/lima");
            $year = date('Y');
            $mes = date('m');
            $dia = date('d');
            $conexion = mainModel::conectar();
            $venta = $conexion->query("SELECT * FROM venta_contado WHERE ESTADO = 1 AND DIA = '$dia' AND MES = '$mes' AND ANO = '$year'");
            $total = 0;
            foreach($venta as $rows){
                $total += $rows["TOTAL"];
            }
            return number_format($total,2);
        }
        
        function ventas_canceladas2(){
            date_default_timezone_set("America/lima");
            $year = date('Y');
            $mes = date('m');
            $dia = date('d');
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM venta_contado WHERE ESTADO = 0 AND MES = '$mes' AND ANO = '$year'");
            return $datos->rowCount();
        }
        function ventas2(){
            $conexion = mainModel::conectar();
            date_default_timezone_set("America/lima");
            $year = date('Y');
            $mes = date('m');
            $dia = date('d');
            $datos = $conexion->query("SELECT * FROM venta_contado WHERE ESTADO = 1 AND MES = '$mes' AND ANO = '$year'");
            return $datos->rowCount();
        }
        function ganancia_ventas2(){
            date_default_timezone_set("America/lima");
            $year = date('Y');
            $mes = date('m');
            $dia = date('d');
            $conexion = mainModel::conectar();
            $venta = $conexion->query("SELECT * FROM venta_contado WHERE ESTADO = 1 AND MES = '$mes' AND ANO = '$year'");
            $total = 0;
            $total_inventario = 0;
            $total_venta = 0;
            $total_descuento = 0;
            foreach($venta as $rows){
                $id_venta = $rows["ID_VENTA"];
                $total_descuento += $rows["DESCUENTO"];
                $detalle = $conexion->query("SELECT d.CANTIDAD,p.PRECIO,p.PRECIO_COSTO FROM detalle_venta_contado as d INNER JOIN precio_producto as p ON d.ID_UNIDAD = p.ID_PRECIO WHERE d.ID_VENTA = '$id_venta'");
                foreach($detalle as $row){
                    $cantidad = $row["CANTIDAD"];
                    $precio = $row["PRECIO"];
                    $precio_costo = $row["PRECIO_COSTO"];
                    $total_inventario += $cantidad * $precio_costo;
                    $total_venta += $cantidad * $precio;
                }
            }
            $total = $total_venta - $total_inventario;
            $total = $total-$total_descuento;
            return number_format($total,2);
        }
        function total_ventas2(){
            date_default_timezone_set("America/lima");
            $year = date('Y');
            $mes = date('m');
            $dia = date('d');
            $conexion = mainModel::conectar();
            $venta = $conexion->query("SELECT * FROM venta_contado WHERE ESTADO = 1 AND MES = '$mes' AND ANO = '$year'");
            $total = 0;
            foreach($venta as $rows){
                $total += $rows["TOTAL"];
            }
            return number_format($total,2);
        }
        
        function ventas_canceladas3(){
            date_default_timezone_set("America/lima");
            $year = date('Y');
            $mes = date('m');
            $dia = date('d');
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM venta_contado WHERE ESTADO = 0");
            return $datos->rowCount();
        }
        function ventas3(){
            $conexion = mainModel::conectar();
            date_default_timezone_set("America/lima");
            $year = date('Y');
            $mes = date('m');
            $dia = date('d');
            $datos = $conexion->query("SELECT * FROM venta_contado WHERE ESTADO = 1");
            return $datos->rowCount();
        }
        function ganancia_ventas3(){
            date_default_timezone_set("America/lima");
            $year = date('Y');
            $mes = date('m');
            $dia = date('d');
            $conexion = mainModel::conectar();
            $venta = $conexion->query("SELECT * FROM venta_contado WHERE ESTADO = 1");
            $total = 0;
            $total_inventario = 0;
            $total_venta = 0;
            $total_descuento = 0;
            foreach($venta as $rows){
                $id_venta = $rows["ID_VENTA"];
                $total_descuento += $rows["DESCUENTO"];
                $detalle = $conexion->query("SELECT d.CANTIDAD,p.PRECIO,p.PRECIO_COSTO FROM detalle_venta_contado as d INNER JOIN precio_producto as p ON d.ID_UNIDAD = p.ID_PRECIO WHERE d.ID_VENTA = '$id_venta'");
                foreach($detalle as $row){
                    $cantidad = $row["CANTIDAD"];
                    $precio = $row["PRECIO"];
                    $precio_costo = $row["PRECIO_COSTO"];
                    $total_inventario += $cantidad * $precio_costo;
                    $total_venta += $cantidad * $precio;
                }
            }
            $total = $total_venta - $total_inventario;
            $total = $total-$total_descuento;
            return number_format($total,2);
        }
        function total_ventas3(){
            date_default_timezone_set("America/lima");
            $year = date('Y');
            $mes = date('m');
            $dia = date('d');
            $conexion = mainModel::conectar();
            $venta = $conexion->query("SELECT * FROM venta_contado WHERE ESTADO = 1");
            $total = 0;
            foreach($venta as $rows){
                $total += $rows["TOTAL"];
            }
            return number_format($total,2);
        }
        function imprimirticket($param = null){
            $this->view->conexion = mainModel::conectar();
            $this->view->parametros = mainModel::parametros();
            $this->view->idticket = $param[0];
            $this->view->detalleticket = $this->detalleticket();
            $this->view->render('contado/ticket');
            
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
    }