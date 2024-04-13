<?php
    class turnos extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->id_nav_active = "turnos-active";
            $this->view->id_collapase_active = "ventas";
            $this->view->brand = "Turnos";
            $this->view->conexion = mainModel::conectar();
            $this->view->parametros = mainModel::parametros();
            $this->view->lista_turno = $this->lista_turno();
            $this->view->render('turnos/index');
        }
        function abrir(){
            if(isset($_POST["saldo"])){
                $saldo =  number_format($_POST["saldo"],2);
                $usuario = $_POST["usuario"];
                $turno = $_POST["turno"];
                date_default_timezone_set("America/lima");
                $fechahora = date('Y-m-d H:i:s');
                $fecha = date('Y-m-d');
                $cn = mainModel::conectar();
                $buscar = $cn->query("SELECT * FROM turno WHERE ID_TURNO = '$turno'");
                if($buscar->rowCount()>0){
                    echo 0;
                }else{
                    $insertar = $cn->query("INSERT INTO `turno`(`ID_TURNO`, `SALDO`, `FECHA_I`, `FHORA`, `ESTADO`, `ID_USUARIO`) VALUES ('$turno','$saldo','$fecha','$fechahora',1,'$usuario')");
                    if($insertar->rowCount()>0){
                        echo 1;
                    }else{
                        echo 2;
                    }
                }
            }
        }
        function abrirturno(){
            session_name('AMOSIS');
            session_start();
            $_SESSION["turno"] = 1;
            echo  $_SESSION["turno"];
        }
        function cerrarturno(){
            if(isset($_POST["turno"])){
                $turno = $_POST["turno"];
                date_default_timezone_set(ZONE);
                $fechahora = date('Y-m-d H:i:s');
                $fecha = date('Y-m-d');
                $cn = mainModel::conectar();
                $insertar = $cn->query("UPDATE `turno` SET `FECHA_F`= '$fecha',`FHORA2`= '$fechahora',`ESTADO`= 0  WHERE `ID_TURNO`= '$turno' ");
                if($insertar->rowCount()>0){
                    session_name('AMOSIS');
                    session_start();
                    $_SESSION["turno"] = 0;
                    $turno = $_SESSION["turno"];
                    if($turno == 0){
                        echo 1;
                    }else{
                        echo 2;
                    }
                }else{
                    echo 0;
                }
            }
        }
        function lista_turno(){
            $tabla = "";
            $conexion = mainModel::conectar();
            date_default_timezone_set(ZONE);
            $fecha = date('Y-m-d');
            $n = 1;
            $datos = $conexion->query("SELECT p.NOMBRE,t.ESTADO FROM turno AS t INNER JOIN usuario AS u ON t.ID_USUARIO = u.ID_USUARIO INNER JOIN persona as p ON p.ID_PERSONA = u.ID_PERSONA WHERE date(t.FECHA_I) = '$fecha' ORDER BY t.FHORA DESC");
            foreach($datos as $rows){
                $nombre = $rows["NOMBRE"];
                $estado = $rows["ESTADO"];
                if($estado == 0){
                    $estado = "<h2 class='badge badge-secondary'>Turno Cerrado</h2>";
                }else{
                    $estado = "<h2 class='badge badge-success'>Turno Abierto</h2>";
                }
                $tabla .="
                    <tr>
                        <td>$n</td>
                        <td>$nombre</td>
                        <td>$estado</td>
                    </tr>
                ";
                $n += 1;
            }
            return $tabla;
        }
        function historico(){
            $this->view->id_nav_active = "historico-active";
            $this->view->id_collapase_active = "turnos";
            $this->view->brand = "Historico de turnos";
            $this->view->lista_turno = self::turnos();
            $this->view->render('turnos/historico');
        }
        function buscar(){
            if(isset($_POST["inicio"]) && isset($_POST["fin"])){
                $inicio = date($_POST["inicio"]);
                $fin = date($_POST["fin"]);
                $conexion = mainModel::conectar();
                $tabla = "";
                $parametro = mainModel::parametros();
                $moneda = $parametro["Moneda"];
                $datos = $conexion->query("SELECT t.ID_TURNO, t.FHORA,t.SALDO,t.ESTADO,t.FECHA_F,p.NOMBRE FROM turno AS t INNER JOIN usuario AS u ON t.ID_USUARIO = u.ID_USUARIO INNER JOIN persona AS p ON p.ID_PERSONA = u.ID_PERSONA WHERE date(t.FECHA_I) >= '$inicio' AND date(t.FECHA_I) <= '$fin'  ORDER BY t.FHORA DESC");
                foreach($datos as $rows){
                    $cierre = $rows['FECHA_F'];
                    if(empty($cierre)){
                        $cierre = "--/--/----";
                    }
                    $estado = $rows['ESTADO'];
                    $button = "";
                    $id = $rows['ID_TURNO'];
                    if($estado == 1){
                        $estado = "<h2 class='badge badge-success'>Turno Abierto</h2>";
                        $button = "
                            <button class='btn btn-primary btn-cerrar btn-sm' value='$id' data-toggle='modal' data-target='#cerrar'>
                                <i class='fa fa-sign-out-alt'></i>
                            </button>
                        ";
                    }else{
                        $estado = "<h2 class='badge badge-secondary'>Turno Cerrado</h2>";
                    }
                    $tabla .="
                        <tr>
                            <td>".$rows['FHORA']."</td>
                            <td>".$moneda.$rows['SALDO']."</td>
                            <td>".$rows['NOMBRE']."</td>
                            <td>".$cierre."</td>
                            <td>".$estado."</td>
                            <td>".$button."</td>
                        </tr>
                    ";
                }
                echo $tabla;
            }
        }
        function turnos(){
            $tabla = "";
            $conexion = mainModel::conectar();
            $parametro = mainModel::parametros();
            $moneda = $parametro["Moneda"];
            $datos = $conexion->query("SELECT t.ID_TURNO, t.FHORA,t.SALDO,t.ESTADO,t.FECHA_F,p.NOMBRE FROM turno AS t INNER JOIN usuario AS u ON t.ID_USUARIO = u.ID_USUARIO INNER JOIN persona AS p ON p.ID_PERSONA = u.ID_PERSONA ORDER BY t.FHORA DESC");
            foreach($datos as $rows){
                $id = $rows['ID_TURNO'];
                $cierre = $rows['FECHA_F'];
                if(empty($cierre)){
                    $cierre = "--/--/----";
                }
                $estado = $rows['ESTADO'];
                $button = "";
                if($estado == 1){
                    $estado = "<h2 class='badge badge-success'>Turno Abierto</h2>";
                    $button = "
                        <button class='btn btn-primary btn-cerrar btn-sm' value='$id' data-toggle='modal' data-target='#cerrar'>
                            <i class='fa fa-sign-out-alt'></i>
                        </button>
                    ";
                }else{
                    $estado = "<h2 class='badge badge-secondary'>Turno Cerrado</h2>";
                }
                $tabla .="
                    <tr>
                        <td>".$rows['FHORA']."</td>
                        <td>".$moneda.$rows['SALDO']."</td>
                        <td>".$rows['NOMBRE']."</td>
                        <td>".$cierre."</td>
                        <td>".$estado."</td>
                        <td>".$button."</td>
                    </tr>
                ";
            }
            return $tabla;
        }
    }