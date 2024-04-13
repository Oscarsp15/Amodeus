<?php require 'view/templeate/head.php';
    $parametros = $this->parametros;
    $logo = $parametros['Logo'];
    $moneda = $parametros['Moneda'];
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
            <div class="col-md-4 col-sm-4">
                <div class="card card-stats">
                    <div class="card-header card-header-info-amosis card-header-icon">
                        <div class="card-icon" data-header-animation="true">
                            <i class="fa fa-ticket-alt"></i>
                        </div>
                        <p class="card-category">Ventas</p>
                        <h3 class="card-title"><?=$this->ventas;?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            Total de ventas hasta el momento
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="card card-stats">
                    <div class="card-header card-header-success-amosis card-header-icon">
                    <div class="card-icon" data-header-animation="true">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <p class="card-category">Ganancia de Credito</p>
                        <h3 class="card-title"><?=$moneda;?><?=$this->ganancia_credito;?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            Ganancias hasta el momento
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="card card-stats">
                    <div class="card-header card-header-product-amosis card-header-icon">
                    <div class="card-icon" data-header-animation="true">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <p class="card-category">Ganacia Pendientes</p>
                        <h3 class="card-title"><?=$moneda;?><?=$this->ganancia_pendiente;?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            Ganancias hasta el momento
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header card-header-amosis">
                    <h4 class="card-title">Ventas a credito</h4>
                    <p class="card-category">Detalle de las ventas a credito</p>
                </div>
                <div class="card-body table-responsive">
                    <table id="tb-prov" class="table table-hover table-sm table-striped">
                        <thead class="text-primary-amosis">
                            <tr>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Dia Pago</th>
                                <th>Cuota Mensual</th>
                                <th>Inicial</th>
                                <th>Estado</th>
                                <th>Opcion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?=$this->lista_ventas;?>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'view/templeate/footer.php';?>