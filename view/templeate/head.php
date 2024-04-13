<?php
    session_name('AMOSIS');
    session_start();
    if(!isset($_SESSION["usuario"])){
      echo '<script> window.location.href="'.SERVERURL.'login/" ;</script>';
    }

?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <title>AMODEUS | Sistema</title>
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
    <link href="<?=SERVERURL;?>view/assets/datatables/datatables.css" rel="stylesheet" />
    <link href="<?=SERVERURL;?>view/assets/datatables/responsive.bootstrap.css" rel="stylesheet" />
    <link href="<?=SERVERURL;?>view/assets/datatables/fixedHeader.bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet"  type="text/css" href="<?=SERVERURL;?>view/assets/cdatatable/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <link href="<?=SERVERURL;?>view/assets/css/amosis-demo.css" rel="stylesheet" />
    <link href="<?=SERVERURL;?>view/assets/file_upload/file.css" rel="stylesheet" />
    <link href="<?=SERVERURL;?>view/assets/select2/select2.css" rel="stylesheet" />
    <link href="<?=SERVERURL;?>view/assets/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" />
    <link rel="shortcut icon" type="image/png" href="<?=SERVERURL?>archives/assets/AMOSIS-LOGO.png" sizes="64x64">
    <link rel="apple-touch-icon" href="<?=SERVERURL?>archives/icons/apple-icon-60x60.png">
    <link rel="apple-touch-startup-image" href="<?=SERVERURL?>archives/icons/apple-icon-120x120.png">
    <link rel="manifest" href="./manifest.json">
  </head>
  <body>
  <style>
    span.select2-container{
        z-index :120831982;
    }
  </style>
    <div id="preloader">
        <?php
          $logo = $_SESSION["LOGOSIDE"];
        ?>
        <div id="loader" style="background: url('<?=SERVERURL;?>archives/assets/<?=$logo;?>') no-repeat center 0; background-size: 200px;top: 30%;">
        </div>
    </div>
    <div class="wrapper ">
      <div class="sidebar" data-image="<?=SERVERURL;?>archives/assets/sidebar.jpg" data-color="amosis" data-background-color="white">
        <div class="logo">
          <div href="#" class="simple-text logo-mini">
            <img src="<?=SERVERURL;?>archives/assets/<?=$_SESSION['LOGOSIDE']?>" width="80%" alt="">
          </div>
          <div class="logo-normal logo-text-amosis">
            <?=$_SESSION['NOMBRESIDE']?>
          </div>
        </div>
        <div class="sidebar-wrapper" style="overflow: scroll;">
          <div class="user">
            <div class="photo">
              <?php
                $perfil = $_SESSION["perfil"];
                if(empty($perfil)){
              ?>
                <img src="<?=SERVERURL;?>archives/avatars/noneAvatar.jpg" />
              <?php
                }else{
              ?>
                <img src="<?=SERVERURL;?>archives/assets/<?=$perfil?>" />
              <?php
                }
              ?>
            </div>
            <div class="info">
              <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                <span>
                  <?=$_SESSION['nombre']?>
                </span>
              </a>
              <div class="clearfix"></div>
            </div>
          </div>
          <ul class="nav">
            <?php 
              if($_SESSION["dashboard"] == 1){
            ?>
            <li class="nav-item" id="dashboard-active">
              <a class="nav-link" href="<?=SERVERURL;?>dashboard/">
                <i class="fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <?php
              }
            ?>
            <?php 
              if($_SESSION["almacen"] == 1){
            ?>
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
                  <li class="nav-item " id="producto-active">
                    <a class="nav-link" href="<?=SERVERURL;?>productos/">
                      <span class="sidebar-mini"> PR </span>
                      <span class="sidebar-normal"> Productos </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <?php
              }
            ?>
             <?php 
              if($_SESSION["compras"] == 1){
            ?>
            <li class="nav-item ">
              <a class="nav-link" data-toggle="collapse" href="#entrada_salida">
                <i class="fa fa-cart-arrow-down"></i>
                <p>
                  Compras
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
                  <li class="nav-item" id="proveedor-active">
                    <a class="nav-link"  href="<?=SERVERURL;?>proveedor/">
                      <span class="sidebar-mini"> PV </span>
                      <span class="sidebar-normal"> proveedor </span>
                    </a>
                  </li>
                  <li class="nav-item " id="entrada_producto-active">
                    <a class="nav-link" href="<?=SERVERURL;?>entradaproducto/">
                      <span class="sidebar-mini"> EP </span>
                      <span class="sidebar-normal"> Compras</span>
                    </a>
                  </li>
                  <li class="nav-item " id="compras-active">
                    <a class="nav-link" href="<?=SERVERURL;?>entradaproducto/fecha/">
                      <span class="sidebar-mini"> EP </span>
                      <span class="sidebar-normal"> Compras Fecha</span>
                    </a>
                  </li>
                  <li class="nav-item " id="comprasm-active">
                    <a class="nav-link" href="<?=SERVERURL;?>entradaproducto/mes/">
                      <span class="sidebar-mini"> EP </span>
                      <span class="sidebar-normal"> Compras Mes</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <?php
              }
            ?>
            <?php 
              if($_SESSION["ventas"] == 1){
            ?>
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
                  <li class="nav-item" id="turnos-active">
                    <a class="nav-link"  href="<?=SERVERURL;?>turnos/">
                      <span class="sidebar-mini"> TR </span>
                      <span class="sidebar-normal"> Turnos </span>
                    </a>
                  </li>
                  <li class="nav-item" id="caja-active">
                    <a class="nav-link"  href="<?=SERVERURL;?>caja/">
                      <span class="sidebar-mini"> PT </span>
                      <span class="sidebar-normal"> POS </span>
                    </a>
                  </li>
                  <li class="nav-item " id="salida_producto-active">
                    <a class="nav-link" href="<?=SERVERURL;?>salidaproducto/">
                      <span class="sidebar-mini"> SP </span>
                      <span class="sidebar-normal"> Salida Productos </span>
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
            <?php
              }
            ?>
            <?php 
              if($_SESSION["turnos"] == 1){
            ?>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#turnos">
                <i class="fas fa-calendar"></i>
                <p>
                  Turnos
                  <b class="caret"></b>
                </p>
              </a>
              <div class="collapse" id="turnos">
                <ul class="nav">
                  <li class="nav-item" id="historico-active">
                    <a class="nav-link"  href="<?=SERVERURL;?>turnos/historico">
                      <span class="sidebar-mini"> HT </span>
                      <span class="sidebar-normal"> Historico de Turno </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <?php
              }
            ?>
            <?php 
              if($_SESSION["cotizacion"] == 1){
            ?>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#cotizacion">
                <i class="fas fa-file-contract"></i>
                <p>
                  Cotización
                  <b class="caret"></b>
                </p>
              </a>
              <div class="collapse" id="cotizacion">
                <ul class="nav">
                  <li class="nav-item" id="cotizacion-active">
                    <a class="nav-link"  href="<?=SERVERURL;?>cotizacion/">
                      <span class="sidebar-mini"> CT </span>
                      <span class="sidebar-normal"> Cotizacion </span>
                    </a>
                  </li>
                  <li class="nav-item" id="cotizaciones-active">
                    <a class="nav-link"  href="<?=SERVERURL;?>cotizacion/cotizaciones">
                      <span class="sidebar-mini"> VC </span>
                      <span class="sidebar-normal"> ver Cotizaciones </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <?php
              }
            ?>
            <?php 
              if($_SESSION["inventario"] == 1){
            ?>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#inventario">
                <i class="fas fa-box"></i>
                <p>
                  Inventario
                  <b class="caret"></b>
                </p>
              </a>
              <div class="collapse" id="inventario">
                <ul class="nav">
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
              }
            ?>
            <?php 
              if($_SESSION["admin"] == 1){
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
            <?php 
              if($_SESSION["parametros"] == 1){
            ?>
            <li class="nav-item" id="parametros-active">
              <a class="nav-link" href="<?=SERVERURL;?>parametros/">
                <i class="fas fa-cogs"></i>
                <p>Parametros</p>
              </a>
            </li>
            <?php
              }
            ?>
            <?php 
              if($_SESSION["backup"] == 1){
            ?>
            <li class="nav-item" id="backup-active">
              <a class="nav-link" href="<?=SERVERURL;?>backup/">
                <i class="fas fa-database"></i>
                <p>Backup</p>
              </a>
            </li>
            <?php
              }
            ?>
            <li class="nav-item" id="acerca-active" style="margin-bottom: 50%;">
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
            <div class="navbar-brand"><?=$this->brand;?></div>
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