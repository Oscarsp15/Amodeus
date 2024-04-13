<?php require 'view/templeate/head.php';?>
<?php
    if(!$_SESSION["admin"]){
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
                <h4 class="card-title">Usuario</h4>
                <p class="card-category">Lista de tus usuarios</p>
            </div>
            <div class="card-body table-responsive">
                <div class="col-md-4 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-amosis card-header-icon">
                            <div class="card-icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <p class="card-category">Usuario</p>
                            <h3 class="card-title"><?=$this->usuario;?></h3>
                        </div>
                        <div class="card-footer">
                            <a href="<?=SERVERURL;?>usuario/nuevousuario/" class="btn btn-sm btn-primary text-white">
                                <i class="fa fa-1x fa-plus"></i> Nuevo Usuario
                            </a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tb-prov" class="table table-sm table-hover">
                        <thead class="text-primary-amosis">
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Pass</th>
                            <th>Privilegio</th>
                            <th>Estado</th>
                            <th>Opcion</th>
                        </thead>
                        <tbody>
                            <?=$this->listaPersona;?>
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