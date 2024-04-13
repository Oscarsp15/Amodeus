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
                        <h4 class="card-title">Clientes</h4>
                        <p class="card-category">Lista de tus Clientes</p>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-info card-header-icon">
                                        <div class="card-icon">
                                            <i class="fa fa-user-check"></i>
                                        </div>
                                        <p class="card-category">Clientes</p>
                                        <h3 class="card-title"><?=$this->numero_cliente;?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <a href="<?=SERVERURL;?>clientes/nuevocliente" class="btn btn-sm btn-primary">
                                            <i class="fa fa-plus"></i> Nuevo Cliente
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="tb-prov" class=" table table-sm table-hover table-striped">
                            <thead class="text-primary-amosis">
                                <tr>
                                    <th>N°</th>
                                    <th>Documento</th>
                                    <th>Nombre</th>
                                    <th>Direccion</th>
                                    <th>Opcion</th>
                                </tr>
                            </thead>
                            <tbody id="table">
                                <?=$this->lista_cliente;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'view/templeate/footer.php';?>