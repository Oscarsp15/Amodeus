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
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header card-header-amosis">
                        <h4 class="card-title">Salida de producto</h4>
                        <p class="card-category">Lista de salida de productos</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-salida-amosis card-header-icon">
                                        <div class="card-icon">
                                            <i class="fas fa-cart-arrow-down"></i>
                                        </div>
                                        <p class="card-category">Salidas</p>
                                        <h3 class="card-title"><?=$this->numeros_salidas;?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <a href="<?=SERVERURL;?>salidaproducto/nuevosalida/" class="btn btn-sm btn-primary text-white">
                                            <i class="fa fa-1x fa-plus"></i> Nueva Salida
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="tb-prov" class="table table-hover table-sm table-striped">
                                <thead class="text-primary-amosis">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tipo</th>
                                        <th>Destino</th>
                                        <th>Documento</th>
                                        <th>N° Doc</th>
                                        <th>Total Neto</th>
                                        <th>F.Registro</th>
                                        <th>Opcion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?=$this->lista_salidas;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'view/templeate/footer.php';?>