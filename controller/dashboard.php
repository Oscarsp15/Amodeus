<?php
    class dashboard extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->id_nav_active = "dashboard-active";
            $this->view->id_collapase_active = "null";
            $this->view->producto = $this->contartabla('producto');
            $this->view->categoria = $this->contartabla('categoria');
            $this->view->marca = $this->contartabla('marca');
            $this->view->proveedor = $this->contartabla('proveedor');
            $this->view->unidad_medida = $this->contartabla('unidad_medida');
            $this->view->entrada_producto = $this->contartabla('entrada_producto');
            $this->view->salida_producto = $this->contartabla('salida_producto');
            $this->view->productos_almacen = $this->contartabla('productos_almacen');
            $this->view->brand = "Dashboard";
            $this->view->render('dashboard/index');
        }
        function contartabla($tabla){
            $cn = mainModel::conectar();
            $datos = $cn->query("SELECT * FROM $tabla");
            $num = $datos->rowCount();
            return $num;
        }
        function porcentaje_diario(){
            date_default_timezone_set(ZONE);
            $dia_hoy = date("Y-m-d");
            $dia_ayer = date("Y-m-d",strtotime($dia_hoy."-1 days"));
            $cn = mainModel::conectar();
            $dia_hoy = $cn->query("SELECT * FROM venta_contado WHERE date(FECHA) = '$dia_hoy'");
            $dia_ayer = $cn->query("SELECT * FROM venta_contado WHERE date(FECHA) = '$dia_ayer'");
            $hoy = $dia_hoy->rowCount();
            $ayer = $dia_ayer->rowCount();
            $d = 0;
            if($hoy == 0 && $ayer == 0){
                $percent = "0%";
            }else{
                if($ayer == 0){
                    $percent = "0%";
                }else{
                    $d = number_format(($hoy - $ayer)/$ayer,2);
                    $percent = ($d*100)."%";
                }
            }
            if($d>=0){
                echo "<span  class='text-success'><i class='fa fa-long-arrow-up'></i> $percent </span> en las ventas de hoy. ";
            }else{
                echo "<span  class='text-danger'><i class='fa fa-long-arrow-up'></i> $percent </span> en las ventas de hoy.";
            }

            
        }
        function porcentaje_mensual(){
            date_default_timezone_set(ZONE);
            $mes_hoy = date("m");
            $mes_ayer = date("m",strtotime($mes_hoy."-1 month"));
            $year = date("Y");
            $cn = mainModel::conectar();
            $mes_hoy = $cn->query("SELECT * FROM venta_contado WHERE MONTH(FECHA) = '$mes_hoy' AND YEAR(FECHA) = '$year'");
            $mes_ayer = $cn->query("SELECT * FROM venta_contado WHERE MONTH(FECHA) = '$mes_ayer' AND YEAR(FECHA) = '$year'");
            $hoy = $mes_hoy->rowCount();
            $ayer = $mes_ayer->rowCount();
            $d = 0;
            if($hoy == 0 && $ayer == 0){
                $percent = "0%";
            }else{
                if($ayer == 0){
                    $percent = "0%";
                }else{
                    $d = number_format(($hoy - $ayer)/$ayer,2);
                    $percent = ($d*100)."%";
                }
            }
            if($d>=0){
                echo "<span  class='text-success'><i class='fa fa-long-arrow-up'></i> $percent </span> en las ventas del mes. ";
            }else{
                echo "<span  class='text-danger'><i class='fa fa-long-arrow-up'></i> $percent </span> en las ventas del mes.";
            }

            
        }
        function dia(){
            date_default_timezone_set(ZONE);
            $fecha = date('Y-m-d');
            $fecha = strtotime($fecha);
            $date2 = strtotime('sunday this week -1 week',$fecha);
            $inicio = date("Y-m-d",$date2);
            $dias = array();
            for ($i=1; $i <= 7; $i++) { 
                $dias[$i] = date("Y-m-d",strtotime("$inicio +$i day"));
            }

            $ventas = array();
            foreach($dias as $clave => $valor){
                $cn = mainModel::conectar();
                $datos = $cn->query("SELECT * FROM venta_contado WHERE date(FECHA) = '$valor'");
                $ventas[$clave] = $datos->rowCount();
            }
            $valores = "";
            foreach($ventas as $clave => $valor){
                $valores .= "{$valor}|";
            }
            echo $valores;
        }
        function mes(){
            date_default_timezone_set(ZONE);
            $fecha = date('Y-m-d');
            $fecha = strtotime($fecha);
            $date2 = strtotime('january this year',$fecha);
            $inicio = date("Y-m-d",$date2);
            $meses = array();
            for ($i=0; $i <= 11; $i++) { 
                $meses[$i] = date("Y-m-d",strtotime("$inicio +$i month"));
            }
            $ventas = array();
            foreach($meses as $clave => $valor){
                $cn = mainModel::conectar();
                $date = strtotime($valor);
                $mes = date("m",$date);
                $year = date("Y",$date);
                $datos = $cn->query("SELECT * FROM venta_contado WHERE MONTH(FECHA) = '$mes' AND YEAR(FECHA) = '$year'");
                $ventas[$clave] = $datos->rowCount();
            }
            $valores = "";
            foreach($ventas as $clave => $valor){
                $valores .= "{$valor}|";
            }
            echo $valores;
        }
    }