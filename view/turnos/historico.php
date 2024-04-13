<?php
require 'view/templeate/head.php';
?>
<?php
    if(!$_SESSION["turnos"]){
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
                        <h4 class="card-title">Turnos</h4>
                        <p class="card-category">Lista de Turnos</p>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Fecha Inicio:</td>
                                    <td><input type="date" id="min" class="form-control datepicker" name="min"></td>
                                </tr>
                                <tr>
                                    <td>Fecha Fin:</td>
                                    <td><input type="date" id="max" class="form-control datepicker" name="max"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-center">
                            <button type="button" id="consultar" class="btn btn-primary mt-3 mb-5">Consultar</button>
                        </div>
                        <table id="example" class="table table-hover table-sm table-striped">
                            <thead class="text-primary-amosis">
                                <tr>
                                    <th>Fecha Apertura</th>
                                    <th>Monto Apertura</th>
                                    <th>Usuario</th>
                                    <th>Fecha Cierre</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody id="table">
                                <?=$this->lista_turno?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modals -->
<div class="modal fade" id="cerrar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">CERRAR TURNO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <p>¿Estas seguro de cerrar el turno?, No podras restablecer los cambios.</p>
                        <input type="hidden" id="idturno">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" id="cerrar_turno" class="btn btn-success">Cerrar Turno</button>
            </div>
        </div>
    </div>
</div>
<?php
require 'view/templeate/footer.php';
?>
<script>
    $("#consultar").click(function(){
        let inicio = $("#min").val();
        let fin = $("#max").val();
        if(inicio.length == 0 || fin.length == 0){
            showNotification('bottom','center','Fechas no valida','danger');
            return;
        }else{
            let fecha1 = Date.parse(inicio);
            let fecha2 = Date.parse(fin);
            fecha1 = new Date(fecha1).toISOString('dd-mm-yyyy');
            fecha2 = new Date(fecha2).toISOString('dd-mm-yyyy');
            if(fecha2 < fecha1){
                showNotification('bottom','center','La fecha fin no puede ser menor a la fecha inicio','danger');
            }else{
                $.post('<?=SERVERURL;?>turnos/buscar/',{inicio,fin},function(res){
                    let table = $("#example").DataTable();
                    table.destroy();
                    $("#table").html(res);
                    $("#example").DataTable({
                        "oLanguage": {
                        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                        "sInfo": "Mostrando pagina _PAGE_ de _PAGES_",
                        "sSearchPlaceholder": "Buscar...",
                        "sLengthMenu": "Resultados :  _MENU_",
                    },
                    "stripeClasses": [],
                    "lengthMenu": [10, 20, 50,100],
                    "pageLength": 20
                    });
                });
            }
        }
    });
    $(document).ready(function() {
        var table = $('#example').DataTable({
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Mostrando pagina _PAGE_ de _PAGES_",
                "sSearchPlaceholder": "Buscar...",
                "sLengthMenu": "Resultados :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [10, 20, 50,100],
            "pageLength": 20
        });             
        // Event listener to the two range filtering inputs to redraw on input
        $('#min, #max').keyup( function() { table.draw(); } );
    } ); 
    $(document).on('click','.btn-cerrar',function(){
        let id = $(this).val();
        $("#idturno").val(id);
    });
    $("#cerrar_turno").click(function(){
        let id = $("#idturno").val();
        let data = {
            "turno" : id
        }
        $.post('<?=SERVERURL;?>turnos/cerrarturno',data,function(estado){
            if(estado == 1){
                showNotification('bottom','center','El turno se cerro con éxito','success');
                setTimeout(function(){
                    location.reload();
                },1000);
            }else{
                showNotification('bottom','center','Hubo un error precione F5','danger');
            }
        });
    });
</script>