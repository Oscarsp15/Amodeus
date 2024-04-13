<?php 
    require 'view/templeate/head.php';
    $dato = $this->datosticket;
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
            <div class="col-md-4">
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header card-header-amosis">
                    <h4 class="card-title">Ticket </h4>
                    <p class="card-category">Configuracion de los datos del ticket</p>
                </div>
                <div class="card-body">
                    <form autocomplete="off" class="FormularioAjax" action = "<?php echo SERVERURL;?>ticket/actualizar" method="POST" data-form="save" ectype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Titulo</label>
                                    <input type="text" name="titulo" value="<?=$dato['Titulo']?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Telefono</label>
                                    <input type="text" name="telefono" class="form-control" value='<?=$dato['Telefono']?>'>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Direccion</label>
                                    <input type="text" name="direccion" class="form-control" value='<?=$dato['Direccion']?>'>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Pie de Pagina</label>
                                    <input type="text" name="pie" class="form-control" value='<?=$dato['Pie']?>'>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary pull-right">Guardar</button>                     
                        <div class="RespuestaAjax"></div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<?php require 'view/templeate/footer.php';?>