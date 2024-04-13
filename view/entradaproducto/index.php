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
                        <h4 class="card-title">Compra de productos</h4>
                        <p class="card-category">Lista de compras de productos</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-entrada-amosis card-header-icon">
                                        <div class="card-icon">
                                            <i class="fas fa-cart-plus"></i>
                                        </div>
                                        <p class="card-category">Entradas</p>
                                        <h3 class="card-title"><?=$this->numeros_entradas;?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <a href="<?=SERVERURL;?>entradaproducto/nuevoentrada/" class="btn btn-sm btn-primary text-white">
                                            <i class="fa fa-1x fa-plus"></i> Nuevo Compra
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
                                        <th>Proveedor</th>
                                        <th>Documento</th>
                                        <th>N° Doc</th>
                                        <th>Total Neto</th>
                                        <th>F.Registro</th>
                                        <th>Opcion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?=$this->lista_entradas;?>
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