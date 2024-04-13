<?php require 'view/templeate/head.php';?>
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
            <div class="col-md-12">
                <div class="card">
                <div class="card-header card-header-amosis">
                    <h4 class="card-title">Pagos de cuotas para hoy</h4>
                    <p class="card-category">Lista de cuotas pendientes para hoy</p>
                </div>
                <div class="card-body table-responsive">
                    <table id="tb-prov" class="table table-hover table-sm table-striped">
                        <thead class="text-primary-amosis">
                            <tr>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>N° Cuota</th>
                                <th>Cuota Mensual</th>
                                <th>Opcion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?=$this->lista_cotashoy;?>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'view/templeate/footer.php';?>