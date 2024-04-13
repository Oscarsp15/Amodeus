<?php require 'view/templeate/head.php';?>
<?php
    if(!$_SESSION["compras"]){
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
                <h4 class="card-title">Proveedores</h4>
                <p class="card-category">Lista de tus Proveedores</p>
            </div>
            <div class="card-body table-responsive">
                <div class="col-md-4 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-gold card-header-icon">
                            <div class="card-icon">
                                <i class="fa fa-truck"></i>
                            </div>
                            <p class="card-category">Proveedores</p>
                            <h3 class="card-title"><?=$this->numero_proveedor;?></h3>
                        </div>
                        <div class="card-footer">
                            <a href="<?=SERVERURL;?>proveedor/nuevoproveedor/" class="btn btn-sm btn-primary text-white">
                                <i class="fa fa-1x fa-plus"></i> Nuevo Proveedor
                            </a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tb-prov" class="table table-sm table-hover table-striped">
                        <thead class="text-primary-amosis">
                            <th>Código</th>
                            <th>RUC</th>
                            <th>R.S</th>
                            <th>Teléfono</th>
                            <th>Opción</th>
                        </thead>
                        <tbody>
                            <?=$this->lista_proveedor;?>
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