<?php
    require 'view/templeate/head.php';
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card">
            <div class="card-header card-header-amosis">
                <h4 class="card-title">Precio por unidad para <?=$this->nombre_producto;?></h4>
                <p class="card-category">Lista de tus Unidades de Medida y sus precios</p>
            </div>
            <div class="card-body table-responsive">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="card card-stats">
                    <div class="card-header card-header-info-amosis card-header-icon" >
                        <div class="card-icon" >
                        <i class="fa fa-balance-scale-right"></i>
                        </div>
                        <p class="card-category">Unidades de Medida</p>
                        <h3 class="card-title"><?=$this->numero_unidad;?></h3>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal">
                        <i class="fa fa-plus"></i> Nueva Unidad de Medida
                        </button>
                        <div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>Nueva Unidad de Medida</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form autocomplete="off" class="FormularioAjax">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Unidad Medida</label>
                                                        <select name="unidad_agregar" id="unidad" class="custom-select">
                                                        <?=$this->list_unidad;?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Equivalencia en unidades</label>
                                                            <input type="number" id="unidades-agregar" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Precio Costo</label>
                                                            <input type="number" id="precioc-agregar" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Precio Venta</label>
                                                            <input type="number" id="preciov-agregar" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="btn-modal-agregar" class="btn btn-sm btn-primary">Guardar</button>
                                        </div>
                                        <div class="RespuestaAjax"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
                <table id="tb-prov" class="table table-sm table-hover table-striped">
                <thead class="text-primary-amosis">
                    <tr>
                        <th>N°</th>
                        <th>Unidad</th>
                        <th>Unidades</th>
                        <th>Precio Venta</th>
                        <th>Precio Costo</th>
                        <th class="text-center">Opcion</th>
                    </tr>
                </thead>
                    <tbody id="table">
                        
                    </tbody>
                </table>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editunidad" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">EDITAR UNIDAD DE MEDIDA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="modal-body">
                            
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-modal-actualizar" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<?php
    require 'view/templeate/footer.php';
?>
<script>
    $(document).ready(function(){
        
        let tocken = "evaluar";
        $.post('<?=SERVERURL;?>unidadmedida/evaluarunidades/',{tocken},function(response){
            if(response == 1){
                showNotification('bottom','center','No tienes unidades','danger');
                setTimeout(function(){
                    location.href = "<?=SERVERURL;?>unidadmedida/";
                },1000);
            }
        });
    });

    let tabla = function(){
        let id = "<?=$this->id;?>";
        $.post('<?php echo SERVERURL;?>productos/lista_unidad_precio',{id},function(response){
            let table = $("#tb-prov").DataTable();
            table.destroy();
            $("#table").html(response);
            var tablecc =$('#tb-prov').DataTable({
                responsive: true,
                "language": {
                    "lengthMenu": "Mostrar _MENU_  registros por pagina",
                    "zeroRecords": "No se encontraron resultados - Lo sentimos",
                    "info": "Mostrar pagina _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "decimal":        "",
                    "emptyTable":     "No hay datos disponibles en la tabla",
                    "info":           "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    "infoEmpty":      "Mostrando 0 a 0 de 0 entradas",
                    "infoFiltered":   "(filtrado de _MAX_ entradas totales)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Mostrar _MENU_ entradas",
                    "loadingRecords": "Cargando ...",
                    "processing":     "procesando...",
                    "search":         "Buscar:",
                    "zeroRecords":    "No se encontraron registros coincidentes",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "Ultimo",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    },
                    "aria": {
                        "sortAscending":  ": active para ordenar la columna ascendente",
                        "sortDescending": ": active para ordenar la columna descendente"
                    }
                },
            });
        });
    } 
    $(document).ready(function(){
        tabla();
    });
    let unidadeditar = function(id){
        $.post('<?=SERVERURL;?>productos/formularioeditarunidad',{id},function(response){
            $("#modal-body").html(response);
        });
    }
    $("#btn-modal-actualizar").click(function(){
        if($("#unidades-editar").val().lenght == 0 || $("#unidades-editar").val() == 0 || $("#precioc-editar").val().lenght == 0 || $("#precioc-editar").val() == 0 || $("#preciov-editar").val().lenght == 0 || $("#preciov-editar").val() == 0){
            showNotification('bottom','center','Complete los campos con datos validos','danger');
        }else{
            let datos = {
                "Unidad" : $("#ided-unidad").val(),
                "Equivalencia" : $("#unidades-editar").val(),
                "Precioc" : $("#precioc-editar").val(),
                "Preciov" : $("#preciov-editar").val(),
                "Precio" : $("#ided-producto").val()
            }
            $.post('<?=SERVERURL;?>productos/updateprecioxunidad',datos,function(response){
                if(response == 1){
                    showNotification('bottom','center','Esta Unidad y su precio fue actualizada correctamente','success');
                    tabla();
                }else{
                    showNotification('bottom','center','No se pudo agregar','danger');
                }
            });
        }
    });
    $("#btn-modal-agregar").click(function(e){
        e.preventDefault();
        if($("#unidades-agregar").val().lenght == 0 || $("#unidades-agregar").val() == 0 || $("#precioc-agregar").val().lenght == 0 || $("#precioc-agregar").val() == 0 || $("#preciov-agregar").val().lenght == 0 || $("#preciov-agregar").val() == 0){
            showNotification('bottom','center','Complete los campos con datos validos','danger');
        }else{
            let datos = {
                "Unidad" : $("#unidad").val(),
                "Equivalencia" : $("#unidades-agregar").val(),
                "Precioc" : $("#precioc-agregar").val(),
                "Preciov" : $("#preciov-agregar").val(),
                "Producto" : "<?=$this->id;?>"
            }   
            $.post('<?=SERVERURL;?>productos/precioxunidad',datos,function(response){
                if(response == 1){
                    showNotification('bottom','center','Esta Unidad y su precio fue agregada correctamente','success');
                    $('.FormularioAjax')[0].reset();
                    tabla();
                }else if(response == 2){
                    showNotification('bottom','center','Esta unidad ya existe en este producto','danger');
                }else{
                    showNotification('bottom','center','No se pudo agregar','danger');
                }
            });
        }
    });
</script>