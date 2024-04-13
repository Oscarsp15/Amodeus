        <footer class="footer">
          <div class="container-fluid">
            <nav class="float-left">
              <ul>
                <li>
                  <a href="#">
                   
                  </a>
                </li>
              </ul>
            </nav>
            <div class="copyright float-right">
              &copy;
              <script>
                document.write(new Date().getFullYear());
              </script>
             
              <a href="#" target="_blank"
                ></a
              >
            </div>
          </div>
        </footer>
      </div>
    </div>
  </body>
  <!--   Core JS Files   -->
  <script src="<?=SERVERURL;?>view/assets/js/core/jquery.min.js"></script>
  <script src="<?=SERVERURL;?>view/assets/js/core/popper.min.js"></script>
  <script src="<?=SERVERURL;?>view/assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="<?=SERVERURL;?>view/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="<?=SERVERURL;?>view/assets/js/plugins/moment.min.js"></script>
  <script src="<?=SERVERURL;?>view/assets/js/plugins/sweetalert2.js"></script>
  <script src="<?=SERVERURL;?>view/assets/js/plugins/jquery.validate.min.js"></script>
  <script src="<?=SERVERURL;?>view/assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <script src="<?=SERVERURL;?>view/assets/js/plugins/bootstrap-selectpicker.js"></script>
  <script src="<?=SERVERURL;?>view/assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <script src="<?=SERVERURL;?>view/assets/js/plugins/bootstrap-tagsinput.js"></script>
  <script src="<?=SERVERURL;?>view/assets/js/plugins/jasny-bootstrap.min.js"></script>
  <script src="<?=SERVERURL;?>view/assets/js/plugins/fullcalendar.min.js"></script>
  <script src="<?=SERVERURL;?>view/assets/js/plugins/jquery-jvectormap.js"></script>
  <script src="<?=SERVERURL;?>view/assets/js/plugins/nouislider.min.js"></script>
  <script src="<?=SERVERURL;?>view/assets/js/plugins/arrive.min.js"></script>
  <script src="<?=SERVERURL;?>view/assets/js/plugins/chartist.min.js"></script>
  <script src="<?=SERVERURL;?>view/assets/js/plugins/bootstrap-notify.js"></script>
  <script src="<?=SERVERURL;?>view/assets/js/material-dashboard.js" type="text/javascript"></script>
  <script src="<?=SERVERURL;?>view/assets/demo/demo.js"></script>
  <script src="<?=SERVERURL;?>view/assets/js/main.js"></script>
  <script src="<?=SERVERURL;?>view/assets/datatables/datatables.js"></script>
  <script src="<?=SERVERURL;?>view/assets/datatables/datatables.bootstrap4.js"></script>
  <script src="<?=SERVERURL;?>view/assets/datatables/dataTables.responsive.js"></script>
  <script src="<?=SERVERURL;?>view/assets/datatables/responsive.bootstrap.js"></script>
  <script src="<?=SERVERURL;?>view/assets/file_upload/file.js"></script>
  
  <script type="text/javascript" src="<?=SERVERURL;?>view/assets/cdatatable/datatables/datatables.min.js"></script>    
  <script src="<?=SERVERURL;?>view/assets/cdatatable/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>  
  <script src="<?=SERVERURL;?>view/assets/cdatatable/datatables/JSZip-2.5.0/jszip.min.js"></script>    
  <script src="<?=SERVERURL;?>view/assets/cdatatable/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>    
  <script src="<?=SERVERURL;?>view/assets/cdatatable/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
  <script src="<?=SERVERURL;?>view/assets/cdatatable/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
  <script src="<?=SERVERURL;?>view/assets/select2/select2.js"></script>
  <script src="<?=SERVERURL;?>view/assets/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script>
    let moneda = "<?=MONEDA;?>";
    $('#<?=$this->id_nav_active;?>').addClass('active');
    $('#<?=$this->id_collapase_active;?>').addClass('show');
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
  </script>
</html>