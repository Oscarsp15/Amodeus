<?php
    session_name('AMOSIS');
    date_default_timezone_set(ZONE);
    session_start();
    if(!isset($_SESSION["usuario"])){
      echo '<script> window.location.href="'.SERVERURL.'login/" ;</script>';
    }

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

<!DOCTYPE html>
<html lang="es">
  <head>
    <title>Reporte de Venta <?=date('Y-m-d H:i:s');?></title>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="theme-color" content="#eee"/>
    <meta name="description" content="Amosis, es un sistema web desarrollado con el objetivo que el usuario pueda tener un control automatizado y eficiente de sus bienes en almacén">
    <meta name="HandheldFriendly" content="true">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="icon" type="image/png" href="<?=SERVERURL?>archives/assets/AMOSIS-LOGO.png" sizes="64x64"/>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link href="<?=SERVERURL;?>view/assets/fontawesome-free-5.12.1-web/css/all.css" rel="stylesheet" />
    <link href="<?=SERVERURL;?>view/assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
    <link href="<?=SERVERURL;?>view/assets/css/amosis-demo.css" rel="stylesheet" />
    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="<?=SERVERURL;?>view/assets/cdatatable/datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="<?=SERVERURL;?>view/assets/cdatatable/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="shortcut icon" type="image/png" href="<?=SERVERURL?>archives/assets/AMOSIS-LOGO.png" sizes="64x64">
    <link rel="apple-touch-icon" href="<?=SERVERURL?>archives/icons/apple-icon-60x60.png">
    <link rel="apple-touch-startup-image" href="<?=SERVERURL?>archives/icons/apple-icon-120x120.png">
    <link rel="manifest" href="./manifest.json">
  </head>
  <body>
    <div id="preloader">
        <div id="loader">
        </div>
    </div>
    <div class="wrapper ">
      <div class="sidebar" data-image="<?=SERVERURL;?>archives/assets/sidebar.jpg" data-color="amosis" data-background-color="white">
        <div class="logo">
          <a href="#" class="simple-text logo-mini">
            <img src="<?=SERVERURL;?>archives/assets/AMOSIS-LOGO.png" width="100%" alt="">
          </a>
          <div class="logo-normal logo-text-amosis">
            AMOSIS
          </div>
        </div>
        <div class="sidebar-wrapper">
          <ul class="nav">
            <li class="nav-item" id="dashboard-active">
              <a class="nav-link" href="<?=SERVERURL;?>dashboard/">
                <i class="fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#almacen">
                <i class="fa fa-store-alt"></i>
                <p>
                  Almacén
                  <b class="caret"></b>
                </p>
              </a>
              <div class="collapse" id="almacen">
                <ul class="nav">
                  <li class="nav-item" id="proveedor-active">
                    <a class="nav-link"  href="<?=SERVERURL;?>proveedor/">
                      <span class="sidebar-mini"> PV </span>
                      <span class="sidebar-normal"> proveedor </span>
                    </a>
                  </li>
                  <li class="nav-item " id="producto-active">
                    <a class="nav-link" href="<?=SERVERURL;?>productos/">
                      <span class="sidebar-mini"> PR </span>
                      <span class="sidebar-normal"> Productos </span>
                    </a>
                  </li>
                  <li class="nav-item " id="marca-active">
                    <a class="nav-link" href="<?=SERVERURL;?>marca/">
                      <span class="sidebar-mini"> MC </span>
                      <span class="sidebar-normal"> Marca </span>
                    </a>
                  </li>
                  <li class="nav-item " id="categoria-active">
                    <a class="nav-link" href="<?=SERVERURL;?>categoria/">
                      <span class="sidebar-mini"> CT </span>
                      <span class="sidebar-normal"> Categoria </span>
                    </a>
                  </li>
                  <li class="nav-item " id="unidadmedida-active">
                    <a class="nav-link" href="<?=SERVERURL;?>unidadmedida/">
                      <span class="sidebar-mini"> UM </span>
                      <span class="sidebar-normal"> Unidad De Medida </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ventas">
                <i class="fas fa-shopping-basket"></i>
                <p>
                  Ventas
                  <b class="caret"></b>
                </p>
              </a>
              <div class="collapse" id="ventas">
                <ul class="nav">
                  <li class="nav-item" id="clientes-active">
                    <a class="nav-link"  href="<?=SERVERURL;?>clientes/">
                      <span class="sidebar-mini"> CL </span>
                      <span class="sidebar-normal"> Clientes </span>
                    </a>
                  </li>
                  <li class="nav-item" id="caja-active">
                    <a class="nav-link"  href="<?=SERVERURL;?>caja/">
                      <span class="sidebar-mini"> CJ </span>
                      <span class="sidebar-normal"> Caja </span>
                    </a>
                  </li>
                  <li class="nav-item" id="contado-active">
                    <a class="nav-link"  href="<?=SERVERURL;?>contado/">
                      <span class="sidebar-mini"> VC </span>
                      <span class="sidebar-normal"> Contado </span>
                    </a>
                  </li>
                  <li class="nav-item" id="reporte-active">
                    <a class="nav-link"  href="<?=SERVERURL;?>contado/reporte/">
                      <span class="sidebar-mini"> VC </span>
                      <span class="sidebar-normal"> Reporte Mensual</span>
                    </a>
                  </li>
                  <li class="nav-item" id="anual-active">
                    <a class="nav-link"  href="<?=SERVERURL;?>contado/anual/">
                      <span class="sidebar-mini"> VA </span>
                      <span class="sidebar-normal"> Reporte Anual </span>
                    </a>
                  </li>
                  <li class="nav-item" id="credito-active">
                    <a class="nav-link"  href="<?=SERVERURL;?>credito/">
                      <span class="sidebar-mini"> VT </span>
                      <span class="sidebar-normal"> Credito </span>
                    </a>
                  </li>
                  <li class="nav-item" id="pagosxhoy-active">
                    <a class="nav-link"  href="<?=SERVERURL;?>credito/pagosdehoy">
                      <span class="sidebar-mini"> PH </span>
                      <span class="sidebar-normal"> Pagos para Hoy </span>
                    </a>
                  </li>
                  <li class="nav-item" id="ticket-active">
                    <a class="nav-link"  href="<?=SERVERURL;?>ticket/">
                      <span class="sidebar-mini"> TC</span>
                      <span class="sidebar-normal"> Ticket </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item ">
              <a class="nav-link" data-toggle="collapse" href="#entrada_salida">
                <i class="fa fa-cart-arrow-down"></i>
                <p>
                  Entrada y Salida
                  <b class="caret"></b>
                </p>
              </a>
              <div class="collapse" id="entrada_salida">
                <ul class="nav">
                  <li class="nav-item " id="almacen-active">
                    <a class="nav-link" href="<?=SERVERURL;?>almacen/">
                      <span class="sidebar-mini"> Al </span>
                      <span class="sidebar-normal"> Almacén </span>
                    </a>
                  </li>
                  <li class="nav-item " id="entrada_producto-active">
                    <a class="nav-link" href="<?=SERVERURL;?>entradaproducto/">
                      <span class="sidebar-mini"> EP </span>
                      <span class="sidebar-normal"> Entrada Productos </span>
                    </a>
                  </li>
                  <li class="nav-item " id="salida_producto-active">
                    <a class="nav-link" href="<?=SERVERURL;?>salidaproducto/">
                      <span class="sidebar-mini"> SP </span>
                      <span class="sidebar-normal"> Salida Productos </span>
                    </a>
                  </li>
                  <li class="nav-item " id="kardex-active">
                    <a class="nav-link" href="<?=SERVERURL;?>kardex/">
                      <span class="sidebar-mini"> KD </span>
                      <span class="sidebar-normal"> Kardex </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <?php 
              $privilegio = $_SESSION["privilegio"];
              if($privilegio){
                ?>
            <li class="nav-item ">
              <a class="nav-link" data-toggle="collapse" href="#admin">
                <i class="fa fa-user-cog"></i>
                <p>
                  admin
                  <b class="caret"></b>
                </p>
              </a>
              <div class="collapse" id="admin">
                <ul class="nav">
                  <li class="nav-item " id="usuario-active">
                    <a class="nav-link" href="<?=SERVERURL;?>usuario/">
                      <span class="sidebar-mini"> US </span>
                      <span class="sidebar-normal"> Usuario </span>
                    </a>
                  </li>
                  <li class="nav-item" id="persona-active">
                    <a class="nav-link" href="<?=SERVERURL;?>persona/">
                      <span class="sidebar-mini"> PE </span>
                      <span class="sidebar-normal"> Personal</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <?php
              }
            ?>
            <li class="nav-item" id="acerca-active">
              <a class="nav-link" href="<?=SERVERURL;?>acerca/">
                <i class="fas fa-tachometer-alt"></i>
                <p>Acerca del Sistema</p>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="main-panel">
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-brand">Reporte de ventas del mes</div>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <div class="navbar-form">
            </div>
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-user"></i>
                  <p class="d-lg-none d-md-block">
                    Cuenta
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="<?=SERVERURL;?>bitacora">Bitacora de Sesion</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="<?=SERVERURL;?>login/cerrar_sesion">Cerrar Sesion</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
        <!-- End Navbar -->
        <div class="content">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-md-3">
                      <div class="card card-stats">
                          <div class="card-header card-header-info-amosis card-header-icon">
                              <div class="card-icon" data-header-animation="true">
                                  <i class="fa fa-ticket-alt"></i>
                              </div>
                              <p class="card-category">Ventas</p>
                              <h3 class="card-title"><?=$this->ventas;?></h3>
                          </div>
                          <div class="card-footer">
                              <div class="stats">
                                  Total de ventas hasta el momento
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="card card-stats">
                          <div class="card-header card-header-marcas-amosis card-header-icon">
                          <div class="card-icon" data-header-animation="true">
                                  <i class="fas fa-dollar-sign"></i>
                              </div>
                              <p class="card-category">Total de ventas</p>
                              <h3 class="card-title"><?=MONEDA;?><?=$this->total_ventas;?></h3>
                          </div>
                          <div class="card-footer">
                              <div class="stats">
                                  Ganancias hasta el momento
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="card card-stats">
                          <div class="card-header card-header-success-amosis card-header-icon">
                          <div class="card-icon" data-header-animation="true">
                                  <i class="fas fa-dollar-sign"></i>
                              </div>
                              <p class="card-category">Ganacia de Ventas</p>
                              <h3 class="card-title"><?=MONEDA;?><?=$this->ganancia_ventas;?></h3>
                          </div>
                          <div class="card-footer">
                              <div class="stats">
                                  Ganancias hasta el momento
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="card card-stats">
                          <div class="card-header card-header-categoria-amosis card-header-icon">
                          <div class="card-icon" data-header-animation="true">
                              <i class="fa fa-ban"></i>
                          </div>
                          <p class="card-category">Ventas Canceladas</p>
                          <h3 class="card-title"><?=$this->ventas_canceladas;?></h3>
                          </div>
                          <div class="card-footer">
                              <div class="stats">
                                Ventas canceladas hasta el momento
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="card">
                      <div class="card-header card-header-amosis">
                          <h4 class="card-title">Ventas al contado</h4>
                          <p class="card-category">Detalle de las ventas al contado</p>
                      </div>
                      <div class="card-body table-responsive">
                          <table id="example" class="table table-hover table-sm table-striped">
                              <thead class="text-primary-amosis">
                                  <tr>
                                      <th>Fecha / Hora</th>
                                      <th>Usuario</th>
                                      <th>Cliente</th>
                                      <th>SubTotal</th>
                                      <th>Descuento</th>
                                      <th>Total</th>
                                      <th>Efectivo</th>
                                      <th>Cambio</th>
                                      <th>Estado</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?=$this->lista_ventas;?>
                              </tbody>
                          </table>
                      </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
        <footer class="footer">
          <div class="container-fluid">
            <nav class="float-left">
              <ul>
                <li>
                  <a href="#">
                    Jhony Creativo
                  </a>
                </li>
              </ul>
            </nav>
            <div class="copyright float-right">
              &copy;
              <script>
                document.write(new Date().getFullYear());
              </script>
              , Desarrollado con <i class="fa fa-heart"></i> por
              <a href="#" target="_blank"
                >Jhony Creativo</a
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
  <script src="<?=SERVERURL;?>view/assets/js/material-kit.js"></script>
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
  <script src="<?=SERVERURL;?>view/assets/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
  <script src="<?=SERVERURL;?>view/assets/js/main.js"></script>
  <script src="<?=SERVERURL;?>view/assets/demo/demo.js"></script>
  <script type="text/javascript" src="<?=SERVERURL;?>view/assets/cdatatable/datatables/datatables.min.js"></script>    
  <script src="<?=SERVERURL;?>view/assets/cdatatable/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>  
  <script src="<?=SERVERURL;?>view/assets/cdatatable/datatables/JSZip-2.5.0/jszip.min.js"></script>    
  <script src="<?=SERVERURL;?>view/assets/cdatatable/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>    
  <script src="<?=SERVERURL;?>view/assets/cdatatable/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
  <script src="<?=SERVERURL;?>view/assets/cdatatable/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
  <script>
    $('#<?=$this->id_nav_active;?>').addClass('active');
    $('#<?=$this->id_collapase_active;?>').addClass('show');
    $(document).ready(function() {    
    $('#example').DataTable({        
        language: {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast":"Último",
                    "sNext":"Siguiente",
                    "sPrevious": "Anterior"
			     },
			     "sProcessing":"Procesando...",
            },
        //para usar los botones   
        responsive: "true",
        dom: 'Bfrtilp',       
        buttons:[ 
        {
          extend:    'excelHtml5',
          text:      '<i class="fas fa-file-excel"></i> ',
          titleAttr: 'Exportar a Excel',
          className: 'btn btn-success'
        },
        {
          extend:    'pdfHtml5',
          text:      '<i class="fas fa-file-pdf"></i> ',
          titleAttr: 'Exportar a PDF',
          className: 'btn btn-danger'
        },
        {
          extend:    'print',
          text:      '<i class="fa fa-print"></i> ',
          titleAttr: 'Imprimir',
          className: 'btn btn-info'
        },
        ]	        
        });     
    });
  </script>
</html>