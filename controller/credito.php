<?php
    class credito extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->brand = "Ventas al credito";
            $this->view->id_nav_active = "credito-active";
            $this->view->id_collapase_active = "ventas";
            $this->view->lista_ventas = $this::lista_ventas();
            $this->view->ganancia_pendiente = $this::ganancia_pendiente();
            $this->view->ganancia_credito = $this::ganancia_credito();
            $this->view->parametros = mainModel::parametros();
            $this->view->ventas = $this::ventas();
            $this->view->render('credito/index');
        }
        function pagosdehoy(){
            $this->view->brand = "Pagos pendientes para hoy";
            $this->view->id_nav_active = "pagosxhoy-active";
            $this->view->id_collapase_active = "ventas";
            $this->view->lista_cotashoy = $this::lista_cotashoy();
            $this->view->render('credito/pagohoy');
        }
        function lista_ventas(){
            $table = "";
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM venta_credito");
            $parametros = mainModel::parametros();
            $moneda = $parametros["Moneda"];
            foreach($datos as $rows){
                $id = $rows['ID_VENTA'];
                $cuotas = $conexion->query("SELECT * FROM cuotas_credito WHERE ID_VENTA = '$id' AND ESTADO = 1");
                $estado = $cuotas->rowCount();
                if($estado >0){
                    $estado = "<h2 class='badge badge-info'>Progreso</h2>";
                }else{
                    $estado = "<h2 class='badge badge-success'>Terminado</h2>";
                }
                $table .="
                    <tr>
                        <td>".$rows['FECHA']."</td>
                        <td>".$rows['ID_USUARIO']."</td>
                        <td>".$rows['ID_CLIENTE']."</td>
                        <td>".$moneda.number_format($rows['INTERES'],2)."</td>
                        <td>".$rows['DIA_PAGO']." de cada mes</td>
                        <td>".$moneda.$rows['MESESCUOTA']."</td>
                        <td>".$moneda.number_format($rows['INICIAL'],2)."</td>
                        <td>".$estado."</td>
                        <td>                    
                            <a href='".SERVERURL."credito/estadocredito/$id' class='btn-editar btn btn-danger btn-sm'  data-toggle='tooltip' data-placement='top' title='Ver Credito' data-container='body'>
                                <i class='fa fa-book'></i>
                            </a>
                        </td>
                    </tr>
                ";
            }
            return $table;
        }
        function lista_cotashoy(){
            $table = "";
            $conexion = mainModel::conectar();
            date_default_timezone_set(ZONE);
            $fecha = date('Y-m-d');
            $year = date('Y');
            $mes = (int)date('m');
            $dia = (int)date('d');
            $parametros = mainModel::parametros();
            $moneda = $parametros["Moneda"];
            $datos = $conexion->query("SELECT * FROM cuotas_credito WHERE ESTADO = 1 AND ANO ='$year' AND MES = '$mes' AND DIA = '$dia'");
            foreach($datos as $rows){
                $id = $rows['ID_VENTA'];
                $idcliente = $rows['ID_CLIENTE'];
                $nCuota = $rows['NUM_CUOTA'];
                $monto = $rows['MONTOCUOTA'];
                $table .="
                    <tr>
                        <td>$fecha</td>
                        <td>$idcliente</td>
                        <td>$nCuota</td>
                        <td>".$moneda."$monto</td>
                        <td>                    
                            <a href='".SERVERURL."credito/estadocredito/$id' class='btn-editar btn btn-danger btn-sm'  data-toggle='tooltip' data-placement='top' title='Ver Credito' data-container='body'>
                                <i class='fa fa-book'></i>
                            </a>
                        </td>
                    </tr>
                ";
            }
            return $table;
        }
        function ganancia_pendiente(){
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM cuotas_credito WHERE ESTADO = 1");
            $total = 0;
            foreach($datos as $rows){
                $total += $rows["MONTOCUOTA"];
            }
            return number_format($total,2);
        }
        function ganancia_credito(){
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM cuotas_credito WHERE ESTADO = 0");
            $total = 0;
            foreach($datos as $rows){
                $total += $rows["MONTOCUOTA"];
            }
            $datos2 = $conexion->query("SELECT * FROM ticket_inicial_credito");
            foreach($datos2 as $rows){
                $total += $rows["INICIAL"];
            }

            return number_format($total,2);
        }
        function ventas(){
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM venta_credito");
            return $datos->rowCount();
        }
        function estadocredito($param = null){
            $id = $param[0];
            $this->view->brand = "Estado de credito";
            $this->view->id_nav_active = "credito-active";
            $this->view->id_collapase_active = "ventas";
            $this->view->conexion = mainModel::conectar();
            $this->view->parametros = mainModel::parametros();
            $this->view->ventaid = $id;
            $this->view->cuotas = $this::cuotas_credito($id);
            $this->view->render('credito/estado');
        }
        function cuotas_credito($venta){
            $table = "";
            $conexion = mainModel::conectar();
            $parametros = mainModel::parametros();
            $moneda = $parametros["Moneda"];
            $datos = $conexion->query("SELECT * FROM cuotas_credito WHERE ID_VENTA = '$venta'");
            foreach($datos as $rows){
                $id = $rows['ID_CUOTA'];
                $estado = $rows["ESTADO"];
                $estadocuota = $rows["ESTADO"];
                $dia = $rows["DIA"];
                $mes = $rows["MES"];
                if($mes<10){
                    $mes = "0".$mes;
                }
                $year = $rows["ANO"];
                $monto = number_format($rows["MONTOCUOTA"],2);
                $fecha = $year."-".$mes."-".$dia;
                $option = "";
                if($estado >0){
                    $estado = "<h2 class='badge badge-info'>Pendiente</h2>";
                }else{
                    $estado = "<h2 class='badge badge-success'>Cancelado</h2>";
                }
                if($estadocuota > 0){
                    $option = "
                    <div class='btn-group'>
                        <a href='".SERVERURL."credito/pagarcuota/$id' class='btn-editar btn btn-danger btn-sm'  data-toggle='tooltip' data-placement='top' title='Pagar Cuota' data-container='body'>
                        <i class='fa fa-file-alt'></i>
                        </a>
                    </div>
                    ";
                }else{
                    $option = "
                    <div class='btn-group'>    
                        <a href='".SERVERURL."credito/vercuotaticket/$id' target='_blank' class='btn-editar btn btn-success btn-sm'  data-toggle='tooltip' data-placement='top' title='Ver Ticket' data-container='body'>
                            <i class='fa fa-file-alt'></i>
                        </a>
                        <a href='".SERVERURL."credito/imprimir_ticket_cuota/$id' target='_blank' class='btn-editar btn btn-warning btn-sm'  data-toggle='tooltip' data-placement='top' title='Imprimir Ticket' data-container='body'>
                            <i class='fa fa-print'></i>
                        </a>
                    </div>";
                }
                $table .="
                    <tr>
                        <td>".$rows['NUM_CUOTA']."</td>
                        <td>".$fecha."</td>
                        <td>".$moneda.$monto."</td>
                        <td>".$estado."</td>
                        <td>".$option."</td>
                    </tr>
                ";
            }
            return $table;
        }
        function cronogramapago($param = null){
            $idventa = $param[0];
            $this->view->idventa = $idventa;
            $this->view->conexion = mainModel::conectar();
            $this->view->parametros = mainModel::parametros();
            $this->view->render('credito/cronograma');
        }
        function ticketinicial($param = null){
            $idventa = $param[0];
            $this->view->detalleticket = $this->detalleticket();
            $this->view->venta = $idventa;
            $this->view->conexion = mainModel::conectar();
            $this->view->parametros = mainModel::parametros();
            $this->view->render('credito/ticketinicial');
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
        function pagarcuota($param = null){
            $id = $param[0];
            $this->view->brand = "Pagar Cuota";
            $this->view->id_nav_active = "credito-active";
            $this->view->id_collapase_active = "ventas";
            $this->view->conexion = mainModel::conectar();
            $this->view->parametros = mainModel::parametros();
            $this->view->cuotaid = $id;
            $this->view->render('credito/cuota');
        }
        function pagocuota(){
            if(isset($_POST["usuario"]) && isset($_POST["pagocon"])){
                $cn = mainModel::conectar();
                $usuario = $_POST["usuario"];
                $pagocon = $_POST["pagocon"];
                $cambio = $_POST["cambio"];
                $cuota = $_POST["cuota"];
                date_default_timezone_set(ZONE);
                $fechahora = date('Y-m-d H:i:s');
                $guardar = $cn->query("INSERT INTO ticket_cuotas_credito(ID_CUOTA, FECHAHORA, PAGOCON, CAMBIO, ID_USUARIO) VALUES ('$cuota','$fechahora','$pagocon','$cambio','$usuario')");
                if($guardar->rowCount()>0){
                    $actualizar = $cn->query("UPDATE cuotas_credito SET ESTADO = 0  WHERE ID_CUOTA = '$cuota'");
                    if($actualizar->rowCount()>0){
                        echo 1;
                    }
                }else{
                    echo 0;
                }
            }
        }
        function vercuotaticket($param = null){
            $idcuota = $param[0];
            $this->view->detalleticket = $this->detalleticket();
            $this->view->cuota = $idcuota;
            $this->view->conexion = mainModel::conectar();
            $this->view->parametros = mainModel::parametros();
            $this->view->render('credito/ticketcuota');
        }
        function imprimir_ticket_inicial($param = null){
            $this->view->conexion = mainModel::conectar();
            $this->view->parametros = mainModel::parametros();
            $this->view->idticket = $param[0];
            $this->view->detalleticket = $this->detalleticket();
            $this->view->render('credito/ticketinicialprint');
        }
        function imprimir_ticket_cuota($param = null){
            $idcuota = $param[0];
            $this->view->conexion = mainModel::conectar();
            $this->view->parametros = mainModel::parametros();
            $this->view->cuota = $idcuota;
            $this->view->detalleticket = $this->detalleticket();
            $this->view->render('credito/ticketcuotaprint');
        }
    }