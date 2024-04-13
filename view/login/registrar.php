<?php
    session_name('AMOSIS');
    session_start();
    if(isset($_SESSION["usuario"])){
        $usuario = $_SESSION["usuario"];
        if($usuario != ""){
            echo '<script> window.location.href="'.SERVERURL.'dashboard/" ;</script>';
        }
    }

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>AMOSIS | Registrarse</title>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <link rel="icon" type="image/png" href="<?=SERVERURL?>archives/assets/AMOSIS-LOGO.png" sizes="64x64"/>
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link href="<?=SERVERURL;?>view/assets/fontawesome-free-5.12.1-web/css/all.css" rel="stylesheet" />
        <link href="<?=SERVERURL;?>view/assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
        <link href="<?=SERVERURL;?>view/assets/datatables/datatables.css" rel="stylesheet" />
        <link href="<?=SERVERURL;?>view/assets/datatables/responsive.bootstrap.css" rel="stylesheet" />
        <link href="<?=SERVERURL;?>view/assets/datatables/fixedHeader.bootstrap.css" rel="stylesheet" />
        <link href="<?=SERVERURL;?>view/assets/css/amosis-demo.css" rel="stylesheet" />
    </head>
    <body>
    <div id="preloader">
        <div id="loader" style="background: url('<?=SERVERURL;?>archives/assets/AMOSIS-LOGO.png') no-repeat center 0; background-size: 200px;top: 30%;">
        </div>
    </div>
    <div class="container mt-5">
        <div class="row mt-5">
            <div class="col-lg-4 col-md-6 ml-auto mr-auto mt-5">
                <div class="card card-login">
                    <form autocomplete="off" class="FormularioAjax" action = "<?php echo SERVERURL;?>login/registro" method="POST" data-form="save" ectype="multipart/form-data">
                        <div class="card-header card-header-amosis text-center">
                            <h4 class="card-title">Registrar Cuenta</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <img width="100%"src="<?=SERVERURL;?>archives/assets/AMOSIS-LOGO.png" alt="Logo del Sistema">
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Nombre</label>
                                        <input type="text" name="nombre_agregar" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Apellido</label>
                                        <input type="text" name="apellido_agregar" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Usuario</label>
                                        <input type="text" name="usuario_agregar" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Contraseña</label>
                                        <input type="password" name="pass_agregar" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Registrarme</button>
                            <a href="<?=SERVERURL;?>login/" class="btn btn-primary btn-link w-100">Ya tengo Cuenta</a>
                        </div>
                        <div class="RespuestaAjax">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </body>
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
  <script src="<?=SERVERURL;?>view/assets/datatables/datatables.js"></script>
  <script src="<?=SERVERURL;?>view/assets/datatables/datatables.bootstrap4.js"></script>
  <script src="<?=SERVERURL;?>view/assets/datatables/datatables.responsive.js"></script>
  <script src="<?=SERVERURL;?>view/assets/datatables/resposive.bootstrap.js"></script>
</html>