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
            <div class="col-md-3">
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header card-header-amosis">
                    <h4 class="card-title">Nuevo Cliente</h4>
                    <p class="card-category">Complete los datos del Cliente</p>
                </div>
                <div class="card-body">
                    <form autocomplete="off" class="FormularioAjax" action = "<?=SERVERURL;?>clientes/nuevo_cliente" method="POST" data-form="save" ectype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">N° Documento del cliente</label>
                                    <input type="number" id="numero" name="numero" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Nombre del completo Cliente</label>
                                    <input type="text" id="nombre" name="nombre_agregar" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Direccion</label>
                                    <input type="text" id="direccion" name="direccion_agregar" class="form-control">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary pull-right">Guardar Cliente</button>                
                        <a href="<?=SERVERURL;?>clientes/" class="btn btn-sm btn-rose pull-right">Regresar</a>                
                        <div class="RespuestaAjax"></div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<?php require 'view/templeate/footer.php';?>
<script>
</script>