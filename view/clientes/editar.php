<?php require 'view/templeate/head.php';
    $datos = $this->datocliente;
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
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header card-header-amosis">
                    <h4 class="card-title">Cliente</h4>
                    <p class="card-category">Datos del Cliente</p>
                </div>
                <div class="card-body">
                    <form autocomplete="off" class="FormularioAjax" action = "<?=SERVERURL;?>clientes/actualizarcliente" method="POST" data-form="save" ectype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">N° Documento del cliente</label>
                                    <input type="number" value='<?=$datos["Id"];?>' disabled class="form-control">
                                    <input type="hidden" value='<?=$datos["Id"];?>' name="numero" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Nombre del completo Cliente</label>
                                    <input type="text" id="nombre" value='<?=$datos["Nombre"];?>'  name="nombre_agregar" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Direccion</label>
                                    <input type="text" id="direccion" value='<?=$datos["Direccion"];?>'  name="direccion_agregar" class="form-control">
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