<?php 
    require 'view/templeate/head.php';
    $paramatros = $this->parametros;
    $Moneda = $paramatros["Moneda"];
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
            <div class="col-md-3">
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
            <div class="col-md-3">
                <div class="card card-stats">
                    <div class="card-header card-header-marcas-amosis card-header-icon">
                    <div class="card-icon" data-header-animation="true">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <p class="card-category">Total de ventas</p>
                        <h3 class="card-title"><?=$Moneda;?><?=$this->total_ventas;?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            Ganancias hasta el momento
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats">
                    <div class="card-header card-header-success-amosis card-header-icon">
                    <div class="card-icon" data-header-animation="true">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <p class="card-category">Ganacia de Ventas</p>
                        <h3 class="card-title"><?=$Moneda;?><?=$this->ganancia_ventas;?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            Ganancias hasta el momento
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats">
                    <div class="card-header card-header-categoria-amosis card-header-icon">
                    <div class="card-icon" data-header-animation="true">
                        <i class="fa fa-ban"></i>
                    </div>
                    <p class="card-category">Ventas Canceladas</p>
                    <h3 class="card-title"><?=$this->ventas_canceladas;?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                           Ventas canceladas hasta el momento
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header card-header-amosis">
                    <h4 class="card-title">Ventas al contado</h4>
                    <p class="card-category">Detalle de las ventas al contado</p>
                </div>
                <div class="card-body table-responsive">
                    <table id="tb-prov" class="table table-hover table-sm table-striped">
                        <thead class="text-primary-amosis">
                            <tr>
                                <th>Fecha / Hora</th>
                                <th>Usuario</th>
                                <th>Cliente</th>
                                <th>SubTotal</th>
                                <th>Descuento</th>
                                <th>Total</th>
                                <th>Efectivo</th>
                                <th>Cambio</th>
                                <th>Estado</th>
                                <th class="text-center">Ticket</th>
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