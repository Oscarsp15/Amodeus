$(document).ready(function() {
  var tablecc =$('#cctable').DataTable({
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

  new $.fn.dataTable.FixedHeader( tablecc );
});