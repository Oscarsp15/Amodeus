<?php require 'view/templeate/head.php';?>
<?php
    $param =  $this->datos_salida;   
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
            <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header card-header-amosis">
                    <h4 class="card-title">Salida de Producto <?=$this->id_salida;?></h4>
                    <p class="card-category">Complete los datos de la salida</p>
                </div>
                <div class="card-body">
                    <form autocomplete="off" class="FormularioAjax" action = "<?php echo SERVERURL;?>salidaproducto/actualizarsalida" method="POST" data-form="save" ectype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" id="cod_salida" name="id_agregar" value="<?=$this->id_salida;?>" class="form-control">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Tipo de Salida</label>
                                    <select id="tiposalida" name="tipo_ingreso" class="custom-select">
                                        <?=$this->tipo_lista_salida;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Tipo de Documento</label>
                                    <select id="documento" name="documento" class="custom-select">
                                        <?=$this->documento_lista_salida;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Tipo de Documento del Destinatario</label>
                                    <select id="tipo_documento_destinatario" name="tipo_documento_destinatario" class="custom-select">
                                        <?=$this->documento_destinatario_lista_salida;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">N° de Documento</label>
                                    <input type="text" id="numero_documento" name="numero_documento" value="<?=$param['Numero']?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Nombre del Destinatario</label>
                                    <input type="text" id="nombre_destinatario" name="nombre_destinatario" value="<?=$param['Destinatario']?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">N° Documento del Destinatario</label>
                                    <input type="text" id="numero_documento_destinatario" name="numero_documento_destinatario" value="<?=$param['num_doc_Destinatario']?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating"> Observación</label>
                                        <textarea id="observacion" name="observacion" class="form-control" rows="5"><?=$param['Observacion']?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-gold">
                                        <h4 class="card-title">Ingreso de Productos</h4>
                                        <p class="card-category">Lista de productos en ingreso</p>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <div class="table-responsive">
                                                <table class="table table-hover table-striped" id="table">
                                                    <thead class="text-warning">
                                                        <th>ID</th>
                                                        <th>Producto</th>
                                                        <th>U.M</th>
                                                        <th>Precio</th>
                                                        <th>Cantidad</th>
                                                        <th>Importe</th>
                                                    </thead>
                                                    <tbody id="datos">
                                                        <?=$this->lista_productos_salida;?>    
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                    
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="gp" class="btn btn-primary pull-right">Guardar Salida</button>                
                        <a href="<?=SERVERURL;?>salidaproducto/imprimirsalida/<?=$this->id_salida;?>" target="_blank" class="btn btn-danger pull-right">Imprimir</a>           
                        <a href="<?=SERVERURL;?>salidaproducto/" class="btn btn-rose pull-right">Regresar</a>                
                        <div class="RespuestaAjax"></div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<?php require 'view/templeate/footer.php';?>