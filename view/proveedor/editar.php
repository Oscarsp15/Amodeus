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
<?php
    $dato = $this->datos_proveedor;
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1">
            </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header card-header-amosis">
                        <h4 class="card-title">Proveedor <?=$this->codigo_proveedor;?></h4>
                        <p class="card-category">Datos del Proveedor</p>
                    </div>
                    <div class="card-body">
                        <form autocomplete="off" class="FormularioAjax" action = "<?php echo SERVERURL;?>proveedor/actualizar_proveedor" method="POST" data-form="save" ectype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">ID Proveedor</label>
                                        <input type="text" value="<?=$this->codigo_proveedor;?>" disabled class="form-control">
                                        <input name="id_agregar" type="hidden" value="<?=$this->codigo_proveedor;?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Ruc</label>
                                        <input name="ruc_agregar" type="text" value='<?=$dato['Ruc'];?>' class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Razón Social</label>
                                        <input name="rs_agregar" type="text" class="form-control" value='<?=$dato['RS'];?>'>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">E-mail</label>
                                        <input name="email_agregar" type="email" class="form-control" value='<?=$dato['Email'];?>'>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Teléfono</label>
                                        <input name="telefono_agregar" type="text" class="form-control" value='<?=$dato['Telefono'];?>'>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Dirección</label>
                                        <input name="direccion_agregar" type="text" class="form-control" value='<?=$dato['Direccion'];?>'>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">DNI del Reprentante</label>
                                        <input name="dnir_agregar" type="text" class="form-control" value='<?=$dato['Dni_re'];?>'>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Nombre del Representante</label>
                                        <input name="nombrer_agregar" type="text" class="form-control" value='<?=$dato['Nombre_re'];?>'>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Dirección del Representante</label>
                                        <input name="direccionr_agregar" type="text" class="form-control" value='<?=$dato['Dir_re'];?>'>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Telefono del Reprentante</label >
                                        <input name="telefonor_agregar" type="text" class="form-control" value='<?=$dato['Telefono_re'];?>'>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary pull-right">Guardar Proveedor</button>
                            <a class="btn btn-rose btn-sm pull-right" href="<?=SERVERURL;?>proveedor/">Regresar</a>
                            <div class="RespuestaAjax">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'view/templeate/footer.php';?>