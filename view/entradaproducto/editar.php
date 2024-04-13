<?php require 'view/templeate/head.php';?>
<?php
    $param =  $this->datos_entrada_entrada;    
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header card-header-amosis">
                    <h4 class="card-title">Detalle de la compra de Producto con codigo <?=$this->id_entrada;?></h4>
                    <p class="card-category">Complete los datos de la entrada</p>
                </div>
                <div class="card-body">
                    <form autocomplete="off" class="FormularioAjax" action = "<?php echo SERVERURL;?>entradaproducto/actualizarentrada" method="POST" data-form="save" ectype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" id="cod_entrada" name="id_agregar" value="<?=$this->id_entrada;?>" class="form-control">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Tipo de Ingreso</label>
                                    <select id="tipoingreso" name="tipo_ingreso" class="custom-select">
                                        <?=$this->tipo_lista_entrada;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Proveedor</label>
                                    <select id="proveedor" name="proveedor" class="custom-select">
                                        <?=$this->provedor_lista_entrada;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Tipo de Documento</label>
                                    <select id="documento" name="documento" class="custom-select">
                                    <?=$this->documento_lista_entrada;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">N° de Documento</label>
                                    <input type="text" id="numero_documento" value="<?=$param['Numero'];?>" name="numero_documento" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating"> Observación</label>
                                        <textarea id="observacion" name="observacion" class="form-control" rows="5"><?=utf8_encode($param['Observacion']);?></textarea>
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
                                                    <tbody>
                                                        <?=$this->lista_productos_entrada;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                    
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="gp" class="btn btn-primary pull-right">Guardar Entrada</button>                
                        <a href="<?=SERVERURL;?>entradaproducto/imprimirentrada/<?=$this->id_entrada;?>" target="_blank" class="btn btn-danger pull-right">Imprimir</a>                
                        <a href="<?=SERVERURL;?>entradaproducto/" class="btn btn-rose pull-right">Regresar</a>                
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