<?php
    class login extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $cn = mainModel::conectar();
            $validar = $cn->query("SELECT * FROM `persona`");
            $boton = "";
            if($validar->rowCount() == 0){
                $boton = "<a href='".SERVERURL."login/registrarse' class='btn btn-primary btn-link w-100'>¿No tienes Cuenta?</a>";
            }
            $this->view->registrar = $boton;
            $this->view->render('login/index');
        }
        function iniciar_sesion(){
            if(isset($_POST["usuario"]) && isset($_POST["pass"])){
                $usuario = $_POST["usuario"];
                $pass = mainModel::encryption($_POST["pass"]);
                if($usuario != "" && $pass != ""){
                    $cn = mainModel::conectar();
                    $buscar = $cn->query("SELECT u.ID_USUARIO,p.NOMBRE,u.ID_PERSONA,u.PRIVILEGIO,p.PERFIL,u.DASHBOARD,u.ALMACEN,u.COMPRAS,u.VENTAS,u.TURNOS,u.COTIZACION,u.INVENTARIO,u.ADMIN,u.PARAMETROS,u.BACKUP FROM usuario as u INNER JOIN persona as p on u.ID_PERSONA = p.ID_PERSONA WHERE u.USUARIO = '$usuario' AND u.PASS = '$pass' AND u.ESTADO=1");
                    if($buscar->rowCount()>0){
                        session_name('AMOSIS');
                        session_start();
                        $bitacora = $cn->query("SELECT * FROM bitacora");
                        $bitacora = $bitacora->rowCount();
                        $bitacora = mainModel::generar_codigo_aleatorio('SES',2,$bitacora);
                        $_SESSION['sesion'] = $bitacora;
                        foreach($buscar as $row){
                            $_SESSION['usuario'] = $row['ID_USUARIO'];
                            $_SESSION['nombre'] = $row['NOMBRE'];
                            $_SESSION['persona'] = $row['ID_PERSONA'];
                            $_SESSION['privilegio'] = $row['PRIVILEGIO'];
                            $_SESSION['perfil'] = $row['PERFIL'];
                            $_SESSION['dashboard'] = $row['DASHBOARD'];
                            $_SESSION['almacen'] = $row['ALMACEN'];
                            $_SESSION['compras'] = $row['COMPRAS'];
                            $_SESSION['ventas'] = $row['VENTAS'];
                            $_SESSION['turnos'] = $row['TURNOS'];
                            $_SESSION['cotizacion'] = $row['COTIZACION'];
                            $_SESSION['inventario'] = $row['INVENTARIO'];
                            $_SESSION['admin'] = $row['ADMIN'];
                            $_SESSION['parametros'] = $row['PARAMETROS'];
                            $_SESSION['backup'] = $row['BACKUP'];
                            $_SESSION['turno'] = 0;
                            $_SESSION['idturno'] =  mainModel::generar_codigo_aleatorio('TURN',7,rand(1,9));
                        }
                        // Parametros
                        $data = $cn->query("SELECT * FROM paramatros WHERE ID_PARAMETRO = 1"); 
                        if ($data->RowCount() >= 1) {
                            foreach ($data as $rows) {
                                $_SESSION['LOGOSIDE'] =  $rows["LOGOSIDE"];
                                $_SESSION['NOMBRESIDE'] =  $rows["NOMBRESIDE"];
                            }
                        }
                        // Usuario & Bitacora
                        $usuario = $_SESSION['usuario'];
                        $addBitacora = $cn->query("INSERT INTO bitacora(ID_BITACORA,ID_USUARIO) VALUES('$bitacora','$usuario')");
                        if($addBitacora->rowCount()>0){
                            echo '<script> window.location.href="'.SERVERURL.'dashboard/" ;</script>';
                        }
                    }else{
                        echo "<script>
                            showNotification('bottom','center','Usuario y/o Contraseña Incorrecta o cuenta inactiva','danger');
                        </script>";     
                    }
                }else{
                    echo "<script>
                        showNotification('bottom','center','Los campos estan vacios','danger');
                    </script>";
                }
            }
        }
        function cerrar_sesion(){
            $cn = mainModel::conectar();
            session_name('AMOSIS');
            session_start();
            $bitacora = $_SESSION['sesion'];
            date_default_timezone_set(ZONE);
            $fin = date('Y-m-d G:i:s');
            $updateBitacora = $cn->query("UPDATE bitacora SET F_FIN = '$fin' WHERE ID_BITACORA='$bitacora'");
            if($updateBitacora->rowCount()>0){
                echo '<script> window.location.href="'.SERVERURL.'login/" ;</script>';
            }
            session_destroy();

        }
        function registrarse(){
            $cn = mainModel::conectar();
            $validar = $cn->query("SELECT * FROM persona");
            if($validar->rowCount() == 0){
                $this->view->render('login/registrar');
            }else{
                $validar = $cn->query("SELECT * FROM persona");
                $boton = "";
                if($validar->rowCount() == 0){
                    $boton = "<a href='".SERVERURL."login/registrar' class='btn btn-primary btn-link w-100'>¿No tienes Cuenta?</a>";
                }
                $this->view->registrar = $boton;
                $this->view->render('login/index');
            }
        }
        function registro(){
            if(isset($_POST["nombre_agregar"]) && isset($_POST["apellido_agregar"]) && isset($_POST["usuario_agregar"]) && isset($_POST["pass_agregar"])){
                $nombre = $_POST["nombre_agregar"];
                $apellido = $_POST["apellido_agregar"];
                $usuario = $_POST["usuario_agregar"];
                $pass = mainModel::encryption($_POST["pass_agregar"]);
                $cn = mainModel::conectar();
                $idPer = "PER0001";
                $idUsu = "USU0001";
                $validar = $cn->query("SELECT * FROM persona");
                if($validar->rowCount() == 0){
                    if($nombre!="" && $apellido != "" && $usuario != "" && $pass != ""){
                        $agregarpersona = $cn->query("INSERT INTO persona(ID_PERSONA, NOMBRE, APELLIDO) VALUES ('$idPer','$nombre','$apellido')");
                        if($agregarpersona->rowCount()>0){
                            $agregarUsuario = $cn->query("INSERT INTO usuario(ID_USUARIO, USUARIO, PASS, ID_PERSONA, PRIVILEGIO, ESTADO, DASHBOARD, ALMACEN, COMPRAS, VENTAS, TURNOS, COTIZACION, INVENTARIO, ADMIN, PARAMETROS, BACKUP) VALUES ('$idUsu','$usuario','$pass','$idPer',1,1,1,1,1,1,1,1,1,1,1,1)");
                            if($agregarUsuario->rowCount()>0){
                                echo "
                                    <script>
                                        showNotification('bottom','center','Te registraste correctamente','success');
                                    </script>";
                            }
                        }                    
                    }else{
                        echo "
                        <script>
                            showNotification('bottom','center','Complete Todos los datos','danger');
                        </script>";
                    }
                }else{
                    echo "
                            <script>
                                showNotification('bottom','center','No te puedes registrar','danger');
                            </script>";
                }
            }
        }
    }