<?php
    require 'view/templeate/head.php';
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
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card">
            <div class="card-header card-header-amosis">
                <h4 class="card-title">Unidades de Medida</h4>
                <p class="card-category">Lista de tus Unidades de Medida</p>
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
                                                        <label class="bmd-label-floating">Prefijo</label>
                                                        <input type="text" id="prefijo-agregar" required class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Detalle de la Unidad de Medida</label>
                                                            <input type="text" id="detalle-agregar" class="form-control">
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
                        <th>Id</th>
                        <th>Prefijo</th>
                        <th>Detalle</th>
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
<div class="modal fade" id="modal-editar" tabindex="-1" role="dialog">
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
       let tabla = function(){
        let tokenlistar = "ListaUnidad";
        $.post('<?php echo SERVERURL;?>unidadmedida/lista_unidad',{tokenlistar},function(response){
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
        $.post('<?=SERVERURL;?>unidadmedida/formularioeditar',{id},function(response){
            $("#modal-body").html(response);
        });
    }
    $("#btn-modal-actualizar").click(function(){
        let prefijo = $("#marca-editar").val();
        let detalle = $("#detalle-editar").val();
        if(prefijo.length == 0 || detalle.length  == 0){
            showNotification('bottom','center','Los campos deben estar llenos','danger');
        }else{
            let datos = {
                "Id" : $("#id-update").val(),
                "Nombre" : $("#marca-editar").val(),
                "Nombreo" : $("#marcao-editar").val(),
                "Detalle" : $("#detalle-editar").val()
            }
            $.post('<?=SERVERURL;?>unidadmedida/unidad_actualizar',datos,function(response){
                if(response == 1){
                    showNotification('bottom','center','Tu Unidad fue actualizada correctamente','success');
                    tabla();
                }else{
                    showNotification('bottom','center','Esta unidad ya extiste','danger');
                }

            });
        }
    });
    $("#btn-modal-agregar").click(function(e){
        e.preventDefault();
        let prefijo = $("#prefijo-agregar").val();
        let detalle = $("#detalle-agregar").val();
        if(prefijo.length == 0 || detalle.length  == 0){
            showNotification('bottom','center','Los campos deben estar llenos','danger');
        }else{
            let datos = {
                "Prefijo" : $("#prefijo-agregar").val(),
                "Detalle" : $("#detalle-agregar").val()
            }
            $.post('<?=SERVERURL;?>unidadmedida/nuevaunidad',datos,function(response){
                if(response == 1){
                    showNotification('bottom','center','Tu Unidad fue agregada correctamente','success');
                    $('.FormularioAjax')[0].reset();
                    tabla();
                }else{
                    showNotification('bottom','center','La unidad ya existe','danger');
                }
            });
        }
    });
</script>