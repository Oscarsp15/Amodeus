<?php 
    require 'view/templeate/head.php';
    $idventa = $this->ventaid;
    $cn = $this->conexion;
    $parametros = $this->parametros;
    $moneda = $parametros['Moneda'];
    $fecha = "";
    $vendedor = "";
    $idvendedor = "";
    $cliente = "";
    $nombre = "";
    $direccion = "";
    $subtotal = "";
    $interes = "";
    $descuento = "";
    $inicial = "";
    $total = "";
    $buscardatosventa = $cn->query("SELECT * FROM venta_credito WHERE ID_VENTA = '$idventa'");
    foreach( $buscardatosventa as $row){
        $fecha = $row["FECHA"];
        $idvendedor = $row["ID_USUARIO"];
        $vendedor = $row["ID_USUARIO"];
        $subtotal = $row["TOTAL"];
        $interes = $row["TASA"];
        $descuento = $row["DESCUENTO"];
        $inicial = $row["INICIAL"];
        $total = $row["INTERES"];
        $nombrevendedor = $cn->query("SELECT p.NOMBRE FROM usuario as u INNER JOIN persona as p on p.ID_PERSONA = u.ID_PERSONA WHERE u.ID_USUARIO = '$vendedor'");
        $vendedor = ucfirst($nombrevendedor->fetchColumn(0));
        $cliente = $row["ID_CLIENTE"];
        $datoscliente = $cn->query("SELECT * FROM cliente WHERE ID_CLIENTE = '$cliente'");
        foreach($datoscliente as $client){
            $cliente = $client["ID_CLIENTE"];
            $nombre = ucfirst($client["NOMBRE"]);
            $direccion = ucfirst($client["DIRECCION"]);
        }
    } 
    $ccreditocancelado = $cn->query("SELECT * FROM cuotas_credito WHERE ID_VENTA = '$idventa' AND ESTADO = 0");
    $creditoc = 0.00;
    foreach($ccreditocancelado as $row){
        $creditoc += $row["MONTOCUOTA"];
    }
    $ccreditodisponible = $cn->query("SELECT * FROM cuotas_credito WHERE ID_VENTA = '$idventa' AND ESTADO = 1");
    $creditod = 0.00;
    foreach($ccreditodisponible as $row){
        $creditod += $row["MONTOCUOTA"];
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
            <div class="col-md-3 col-sm-3">
                <div class="card card-stats">
                    <div class="card-header card-header-info-amosis card-header-icon">
                        <div class="card-icon" data-header-animation="true">
                            <i class="fa fa-user"></i>
                        </div>
                        <p class="card-category">Cliente</p>
                        <h3 class="card-title"><?=substr($nombre,0,15);?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            NIT: <?=$cliente;?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="card card-stats">
                    <div class="card-header card-header-success-amosis card-header-icon">
                    <div class="card-icon" data-header-animation="true">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <p class="card-category">Credito Cancelado</p>
                        <h3 class="card-title"><?=$moneda;?><?=number_format($creditoc,2);?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            Credito cancelado hasta el momento
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="card card-stats">
                    <div class="card-header card-header-entrada-amosis card-header-icon">
                    <div class="card-icon" data-header-animation="true">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <p class="card-category">Credito Pendiente</p>
                        <h3 class="card-title"><?=$moneda;?><?=number_format($creditod,2);?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            Credito pendiente hasta el momento
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="card card-stats">
                    <div class="card-header card-header-marcas-amosis card-header-icon">
                    <div class="card-icon" data-header-animation="true">
                        <i class="fa fa-street-view"></i>
                    </div>
                    <p class="card-category">Vendedor</p>
                    <h3 class="card-title"><?=substr($vendedor,0,15);?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            USUARIO : <?=$idvendedor;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-tabs card-header-amosis">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <span class="nav-tabs-title">Opciones:</span>
                                <ul class="nav nav-tabs" data-tabs="tabs">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#informe" data-toggle="tab">
                                            <i class="fa fa-file-pdf"></i> Informe
                                            <div class="ripple-container"></div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#messages" data-toggle="tab">
                                        <i class="fa fa-bars"></i> Cuotas
                                        <div class="ripple-container"></div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#settings" data-toggle="tab">
                                        <i class="fa fa-file-alt"></i> Inicial
                                        <div class="ripple-container"></div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane" id="informe">
                                <div class="text-center">
                                    <h3>Imprimir estado de credito</h3>
                                    <a class="btn btn-primary" target="_blank" href="<?=SERVERURL;?>credito/cronogramapago/<?=$this->ventaid;?>"> Imprimir</a>
                                </div>
                            </div>
                            <div class="tab-pane active" id="messages">
                                <table class="table table-hover table-striped">
                                    <thead class="text-primary-amosis">
                                        <tr>
                                            <th>N°</th>
                                            <th>Fecha de Pago</th>
                                            <th>Cuota</th>
                                            <th>Estado</th>
                                            <th>Opcion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?=$this->cuotas;?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="settings">
                                <div class="text-center">
                                    <h3>Imprimir ticket de la inicial</h3>
                                    <a class="btn btn-primary" target="_blank" href="<?=SERVERURL;?>credito/ticketinicial/<?=$this->ventaid;?>"> Ver Ticket de la inicial</a>
                                    <a class="btn btn-info" target="_blank" href="<?=SERVERURL;?>credito/imprimir_ticket_inicial/<?=$this->ventaid;?>"> Imprimir Ticket de la inicial</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'view/templeate/footer.php';?>