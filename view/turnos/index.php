<?php require 'view/templeate/head.php';
    $cn = $this->conexion;
    $parametros = $this->parametros;
    $moneda = $parametros["Moneda"];
    $turno = $_SESSION['idturno'];
    $datos = $cn->query("SELECT * FROM turno WHERE ID_TURNO = '$turno'");
    $fechai = "";
    $fechaf = "";
    $horai = "";
    $horaf = "";
    $saldo_inicial = "";
    $total_final = "";
    if($datos->rowCount()>0){
        foreach($datos as $row){
            $saldo_inicial = $row["SALDO"];
            $fechai = $row["FECHA_I"];
            $horai = $row["FHORA"];
            $fechaf = $row["FECHA_F"];
            $horaf = $row["FHORA2"];
        }
    }
    date_default_timezone_set(ZONE);
    $total_ventas = 0;
    $ventas = $cn->query("SELECT TOTAL FROM `venta_contado` WHERE ID_TURNO = '$turno'");
    if($ventas->rowCount()>0){
        foreach($ventas as $row){
            $total_ventas += $row["TOTAL"];
        }
    }
?>
<?php
    if(!$_SESSION["ventas"]){
        echo "
        <script>
            location.href = '".SERVERURL."acerca/';
        </script>
        ";
    }
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <div class="card card-stats">
                    <div class="card-header card-header-success-amosis card-header-icon">
                        <div class="card-icon" data-header-animation="true">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <p class="card-category">Fecha Inicio</p>
                        <h3 class="card-title">
                        <?php
                            if(!empty($fechai)){
                                $fechai = strtotime($fechai);
                                echo date("d/m/Y",$fechai);
                            }else{
                                echo "--/--/----";
                            }
                         ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                        <?php
                            if(!empty($horai)){
                                $horai = strtotime($horai);
                                $horai = date("H:i:s",$horai);
                                echo "A las $horai";
                            }else{
                                echo "No hay Hora Disponible";
                            }
                         ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="card card-stats">
                    <div class="card-header card-header-product-amosis card-header-icon">
                        <div class="card-icon" data-header-animation="true">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <p class="card-category">Fecha Fin</p>
                        <h3 class="card-title">
                        <?php
                            if(!empty($fechaf)){
                                $fechaf = strtotime($fechaf);
                                echo date("d/m/Y",$fechaf);
                            }else{
                                echo "--/--/----";
                            }
                         ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                        <?php
                            if(!empty($horaf)){
                                $horaf = strtotime($horaf);
                                $horaf = date("H:i:s",$horaf);
                                echo "A las $horaf";
                            }else{
                                echo "No hay Hora Disponible";
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="card card-stats">
                    <div class="card-header card-header-info-amosis card-header-icon">
                        <div class="card-icon" data-header-animation="true">
                            <i class="fa fa-store-alt"></i>
                        </div>
                        <p class="card-category">Ventas</p>
                        <h3 class="card-title"><?php
                            if(empty($total_ventas) || empty($saldo_inicial)){
                                echo "$moneda 0.00";
                            }else{
                                $total_ventas = number_format($total_ventas,2);
                                echo "$moneda $total_ventas";
                            }
                        ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            Ventas durante el turno
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="card card-stats">
                    <div class="card-header card-header-marcas-amosis card-header-icon">
                        <div class="card-icon" data-header-animation="true">
                            <i class="fa fa-user"></i>
                        </div>
                        <p class="card-category">Turno</p>
                        <h3 class="card-title"><?=$_SESSION['idturno']?></h3>
                    </div>
                    <div class="card-footer">
                        <?php
                            if($_SESSION["turno"]==0){
                        ?>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#abrir">Abrir Turno</button>
                        <?php
                            }else{
                        ?>
                            <button type="button" id="cerrar_turno" class="btn btn-primary btn-sm">Cerrar Turno</button>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-lg-7 col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">Detalle del turno</h4>
                                <p class="card-category">Dinero Recibido</p>
                            </div>
                            <div class="card-body">
                            <table class="table table-hover">
                                <tbody>
                                    <tr class="w-100">
                                        <td class="w-50">Saldo inicial</td>
                                        <td class="w-50">
                                        <?php
                                            if(!empty($saldo_inicial)){
                                                $saldo_inicial = number_format($saldo_inicial,2);
                                                echo "$saldo_inicial";
                                            }else{
                                                echo "0.00";
                                            }
                                        ?>
                                        </td>
                                    </tr>
                                    <tr class="w-100">
                                        <td class="w-50">Efectivo</td>
                                        <td class="w-50">
                                        <?php
                                            if(!empty($total_ventas)){
                                                $total_ventas = number_format($total_ventas,2);
                                                echo "$total_ventas";
                                            }else{
                                                echo "0.00";
                                            }
                                        ?>
                                        </td>
                                    </tr>
                                    <tr class="w-100">
                                        <td class="w-50" style="font-weight: bold;">Total Final</td>
                                        <td class="w-50" style="font-weight: bold;">
                                        <?php
                                            if(!empty($total_ventas) || !empty($saldo_inicial)){
                                                if($total_ventas == ""){
                                                    $total_ventas = 0;
                                                }
                                                $total_final = $total_ventas + $saldo_inicial;
                                                echo $total_final;
                                            }else{
                                                echo "0.00";
                                            }
                                        ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12">
                        <div class="card">
                            <div class="card-header card-header-warning">
                            <h4 class="card-title">Turnos de Hoy</h4>
                            <p class="card-category">Lista de turnos</p>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-hover">
                                    <thead class="text-warning">
                                    <tr>
                                        <th>N°</th>
                                        <th>Persona</th>
                                        <th>Estado</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?=$this->lista_turno?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modals -->
<div class="modal fade" id="abrir" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ABRIR TURNO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="">Saldo inicial</label>
                            <input type="number" id="saldo_inicial" placeholder="Ejm. 10.00" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="abrir_turno" class="btn btn-success">Abrir</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<?php require 'view/templeate/footer.php';?>
<script>
    $("#abrir_turno").click(function(){
        let saldo_inicial = $("#saldo_inicial").val();
        if(saldo_inicial.length == 0 || saldo_inicial <= 0){
            showNotification('bottom','center','Los valores deben ser correctamente llenados','danger');
        }else{
            let data = {
               "usuario" : "<?=$_SESSION['usuario']?>",
                "turno" : "<?=$_SESSION['idturno']?>",
                "saldo" : saldo_inicial
            }
            $.post('<?=SERVERURL;?>turnos/abrir',data,function(response){
                if(response == 1){
                    $.post('<?=SERVERURL;?>turnos/abrirturno',{},function(estado){
                        if(estado == 1){
                            showNotification('bottom','center','El turno se inicio con éxito','success');
                            setTimeout(function(){
                                location.reload();
                            },1000);
                        }else{
                            showNotification('bottom','center','Hubo un error precione F5','danger');
                        }
                    });
                }else if(response == 0){
                    showNotification('bottom','center','El turno ya existe','danger');
                }else if(response == 2){
                    showNotification('bottom','center','No se pudo iniciar con el turno','danger');
                }
            });
        }
    });
    $("#cerrar_turno").click(function(){
        let data = {
            "turno" : "<?=$_SESSION['idturno']?>"
        }
        $.post('<?=SERVERURL;?>turnos/cerrarturno',data,function(estado){
            if(estado == 1){
                showNotification('bottom','center','El turno se cerro con éxito','success');
                setTimeout(function(){
                    location.reload();
                },1000);
            }else{
                showNotification('bottom','center','Hubo un error precione F5','danger');
            }
        });
    });
</script>