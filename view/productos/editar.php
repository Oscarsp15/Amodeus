<?php 
    require 'view/templeate/head.php';
    $dato = $this->datos_producto;
?>
<?php
    if(!$_SESSION["almacen"]){
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
                    <h4 class="card-title">Producto <?=$this->codigo_producto;?></h4>
                    <p class="card-category">Datos del Producto</p>
                </div>
                <div class="card-body">
                    <form autocomplete="off" class="FormularioAjax" action = "<?php echo SERVERURL;?>productos/actualizar_producto" method="POST" data-form="save" ectype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="bmd-label-floating">ID del Producto</label>
                                    <input type="text" disabled value="<?=$this->codigo_producto;?>" class="form-control">
                                    <input type="hidden" name="id_agregar" value="<?=$this->codigo_producto;?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Nombre del Producto</label>
                                    <input type="text" name="nombre_agregar" class="form-control" value='<?=$dato['Nombre']?>'>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Cod. Barras</label>
                                    <input type="number" name="barra" class="form-control" value='<?=$dato['Barra']?>'>
                                    <input type="hidden" name="cod_original" class="form-control" value='<?=$dato['Barra']?>'>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Stock Minimo</label>
                                    <input type="number" name="stock_agregar" class="form-control" value='<?=$dato['Stock']?>'>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Precio costo x unidad</label>
                                    <input type="text" name="pc_agregar" class="form-control" value='<?=$dato['Precio']?>'>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Precio venta x unidad</label>
                                    <input type="text" name="pv_agregar" class="form-control" value='<?=$dato['PrecioV']?>'>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Presentacion</label>
                                    <select name="unidad_agregar" class="custom-select">
                                    <?=$this->list_unidad?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Marca</label>
                                    <select name="marca_agregar" class="custom-select">
                                    <?=$this->list_marca?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Categoria</label>
                                    <select name="categoria_agregar" class="custom-select">
                                        <?=$this->list_categoria?>  
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary pull-right">Guardar Producto</button>                
                        <a href="<?=SERVERURL;?>productos/" class="btn btn-sm btn-rose pull-right">Regresar</a>                
                        <div class="RespuestaAjax"></div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<?php require 'view/templeate/footer.php';?>