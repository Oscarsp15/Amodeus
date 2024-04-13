<?php
require 'view/templeate/head.php';
?>
<?php
    if(!$_SESSION["compras"]){
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
                        <h4 class="card-title">Compras</h4>
                        <p class="card-category">Buscar compras por fecha</p>
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
                        <table id="tb-prov" class="table table-hover table-sm table-striped">
                            <thead class="text-primary-amosis">
                                <tr>
                                    <th>ID</th>
                                    <th>Tipo</th>
                                    <th>Proveedor</th>
                                    <th>Documento</th>
                                    <th>N° Doc</th>
                                    <th>Total Neto</th>
                                    <th>F.Registro</th>
                                    <th>Opcion</th>
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
                $.post('<?=SERVERURL;?>entradaproducto/buscarfecha/',{inicio,fin},function(res){
                    let table = $("#tb-prov").DataTable();
                    table.destroy();
                    $("#table").html(res);
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
        }
    });   

</script>