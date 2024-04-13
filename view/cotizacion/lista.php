<?php
require 'view/templeate/head.php';
?>
<?php
    if(!$_SESSION["cotizacion"]){
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
                        <h4 class="card-title">Cotizaciones</h4>
                        <p class="card-category">Lista de Cotizaciones realizadas</p>
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
                                    <th>Fecha</th>
                                    <th>Numero</th>
                                    <th>A Nombre de</th>
                                    <th>Entrega</th>
                                    <th>Total</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody id="table">
                                <?=$this->lista_cotizacion?>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                $.post('<?=SERVERURL;?>cotizacion/buscar/',{inicio,fin},function(res){
                    let table = $("#example").DataTable();
                    table.destroy();
                    $("#table").html(res);
                    $("#example").DataTable({
                        "oLanguage": {
                        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                        "sInfo": "Mostrando pagina _PAGE_ de _PAGES_",
                        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
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
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
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

</script>