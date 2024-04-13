<?php
    class usuario extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->id_nav_active = "usuario-active";
            $this->view->id_collapase_active = "admin";
            $this->view->listaPersona = $this->listaUsuario();
            $this->view->usuario = $this->usuario();
            $this->view->brand = "Usuarios";
            $this->view->render('usuario/index');
        }
        function usuario(){
            $cn = mainModel::conectar();
            $datos = $cn->query("SELECT * FROM usuario WHERE ID_USUARIO !='USU0001'");
            $num = $datos->rowCount();
            return $num;
        }
        function nuevousuario(){
            $this->view->id_nav_active = "usuario-active";
            $this->view->id_collapase_active = "admin";
            $this->view->brand = "Usuario";
            $this->view->codigo_usuario = $this->codigo_usuario();
            $this->view->listarPersona = $this->listarPersona();
            $this->view->render('usuario/nuevo');
        }
        function listarPersona(){
            $option = "";
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM persona WHERE ID_PERSONA != 'PER0001'");
            foreach($datos as $rows){
                $id = $rows['ID_PERSONA'];
                $nombre = $rows['NOMBRE'];
                $apellido = $rows['APELLIDO'];
                $option .="
                    <option value='$id'>$nombre $apellido</option>
                ";
            }
            return $option;
        }
        function listaUsuario(){
            $tabla = "";
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT U.ID_USUARIO,P.NOMBRE,U.USUARIO,U.PASS,U.PRIVILEGIO,U.ESTADO FROM usuario U INNER JOIN persona P ON U.ID_PERSONA = P.ID_PERSONA WHERE U.ID_USUARIO != 'USU0001'");
            foreach($datos as $rows){
                $id = $rows['ID_USUARIO'];
                $privilegio = $rows['PRIVILEGIO'];
                if($privilegio == 0){
                    $privilegio = '<h6 class="badge badge-info">Asistente de almacén</h6>';
                }else if($privilegio == 1){
                    $privilegio = '<h6 class="badge badge-primary">Administrador</h6>';
                }else{
                    $privilegio = '<h6 class="badge badge-success">Vendedor</h6>';
                }
                $estado = $rows['ESTADO'];
                if($estado == 0){
                    $estado = '<h6 class="badge badge-danger">Inactivo</h6>';
                }else{
                    $estado = '<h6 class="badge badge-success">Activo</h6>';
                }
                $tabla .="
                    <tr>
                        <td>".$rows['ID_USUARIO']."</td>
                        <td>".$rows['NOMBRE']."</td>
                        <td>".$rows['USUARIO']."</td>
                        <td>".$rows['PASS']."</td>
                        <td>".$privilegio."</td>
                        <td>".$estado."</td>
                        <td class='text-center'>                    
                            <a href='".SERVERURL."usuario/verusuario/$id' class='btn btn-info btn-sm' data-toggle='tooltip' data-placement='top' title='Editar' data-container='body'>
                                <i class='fas fa-pen'> </i>
                            </a>
                        </td>
                    </tr>
                ";
            }
            return $tabla;
        }
        function codigo_usuario(){
            $n = $this->usuario();
            return mainModel::generar_codigo_aleatorio('USU',2,$n);
        }
        function actualizar_usuario(){
            if(isset($_POST["id_agregar"]) && isset($_POST["usuario_agregar"])){
                $id = mainModel::clean_string($_POST["id_agregar"]);
                $usuario = mainModel::clean_string($_POST["usuario_agregar"]);
                $usuario_original = mainModel::clean_string($_POST["usuario_original"]);
                $pass = mainModel::encryption($_POST["pass_agregar"]);
                $privilegio = mainModel::clean_string($_POST["privilegio_agregar"]);
                $estado = mainModel::clean_string($_POST["estado_agregar"]);
                $dashboard = filter_input(INPUT_POST,'dashboard',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $dashboard = $dashboard == 1? 1:0;
                $almacen = filter_input(INPUT_POST,'almacen',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $almacen = $almacen == 1? 1:0;
                $compras = filter_input(INPUT_POST,'compras',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $compras = $compras == 1? 1:0;
                $ventas = filter_input(INPUT_POST,'ventas',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $ventas = $ventas == 1? 1:0;
                $turnos = filter_input(INPUT_POST,'turnos',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $turnos = $turnos == 1? 1:0;
                $cotizacion = filter_input(INPUT_POST,'cotizacion',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $cotizacion = $cotizacion == 1? 1:0;
                $inventario = filter_input(INPUT_POST,'inventario',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $inventario = $inventario == 1? 1:0;
                $admin = filter_input(INPUT_POST,'admin',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $admin = $admin == 1? 1:0;
                $parametros = filter_input(INPUT_POST,'parametros',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $parametros = $parametros == 1? 1:0;
                $backup = filter_input(INPUT_POST,'backup',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $backup = $backup == 1? 1:0;
                $conexion = mainModel::conectar();
                if($usuario_original != $usuario){
                    $bu = $conexion->query("SELECT*FROM usuario WHERE USUARIO = '$usuario'");
                    if($bu->rowCount()>0){
                        echo "1";
                    }else{
                        $datos = $conexion->query("UPDATE usuario SET USUARIO='$usuario',PASS='$pass',PRIVILEGIO=$privilegio,ESTADO=$estado ,`DASHBOARD`= '$dashboard',`ALMACEN`='$almacen',`COMPRAS`='$compras',`VENTAS`='$ventas',`COTIZACION`='$cotizacion',`INVENTARIO`= '$inventario',`ADMIN`= '$admin',`PARAMETROS`= '$parametros',`BACKUP`= '$backup' ,`TURNOS`= '$turnos' WHERE ID_USUARIO='$id' ");
                        if($datos->rowCount()>0){
                            echo "2";
                        }
                    }
                }else{
                    $datos = $conexion->query("UPDATE usuario SET USUARIO='$usuario',PASS='$pass',PRIVILEGIO=$privilegio,ESTADO=$estado ,`DASHBOARD`= '$dashboard',`ALMACEN`='$almacen',`COMPRAS`='$compras',`VENTAS`='$ventas',`COTIZACION`='$cotizacion',`INVENTARIO`= '$inventario',`ADMIN`= '$admin',`PARAMETROS`= '$parametros',`BACKUP`= '$backup' ,`TURNOS`= '$turnos' WHERE ID_USUARIO='$id' ");
                    if($datos->rowCount()>0){
                        echo "2";
                    }
                }
            }else{
                echo 'Peticion invalida';
            }
        }
        function agregar_usuario(){
            if(isset($_POST["id_agregar"]) && isset($_POST["usuario_agregar"])){
                $id = mainModel::clean_string($_POST["id_agregar"]);
                $usuario = mainModel::clean_string($_POST["usuario_agregar"]);
                $pass = mainModel::encryption($_POST["pass_agregar"]);
                $persona = mainModel::clean_string($_POST["persona_agregar"]);
                $privilegio = mainModel::clean_string($_POST["privilegio_agregar"]);
                $estado = mainModel::clean_string($_POST["estado_agregar"]);
                $dashboard = filter_input(INPUT_POST,'dashboard',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $dashboard = $dashboard == 1? 1:0;
                $almacen = filter_input(INPUT_POST,'almacen',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $almacen = $almacen == 1? 1:0;
                $compras = filter_input(INPUT_POST,'compras',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $compras = $compras == 1? 1:0;
                $ventas = filter_input(INPUT_POST,'ventas',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $ventas = $ventas == 1? 1:0;
                $turnos = filter_input(INPUT_POST,'turnos',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $turnos = $turnos == 1? 1:0;
                $cotizacion = filter_input(INPUT_POST,'cotizacion',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $cotizacion = $cotizacion == 1? 1:0;
                $inventario = filter_input(INPUT_POST,'inventario',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $inventario = $inventario == 1? 1:0;
                $admin = filter_input(INPUT_POST,'admin',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $admin = $admin == 1? 1:0;
                $parametros = filter_input(INPUT_POST,'parametros',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $parametros = $parametros == 1? 1:0;
                $backup = filter_input(INPUT_POST,'backup',FILTER_VALIDATE_BOOLEAN,FILTER_SANITIZE_ADD_SLASHES);
                $backup = $backup == 1? 1:0;
                $conexion = mainModel::conectar();
                $evaluar_existencia = $conexion->query("SELECT*FROM usuario WHERE ID_PERSONA ='$persona'");
                if($evaluar_existencia->rowCount()>0){
                    echo "1";
                }else{
                    $evaluar_usuario = $conexion->query("SELECT * FROM usuario WHERE USUARIO = '$usuario'");
                    if($evaluar_usuario->rowCount()>0){
                        echo "2";
                    }else{
                        $datos = $conexion->query("INSERT INTO usuario(ID_USUARIO, USUARIO, PASS, ID_PERSONA, PRIVILEGIO, ESTADO , DASHBOARD, ALMACEN, COMPRAS, VENTAS, TURNOS, COTIZACION, INVENTARIO, ADMIN, PARAMETROS, BACKUP) VALUES ('$id','$usuario','$pass','$persona',$privilegio,$estado,$dashboard,$almacen,$compras,$ventas,$turnos,$cotizacion,$inventario,$admin,$parametros,$backup)");
                        if($datos->rowCount()>0){
                            echo "3";
                        }
                    }
                }
            }else{
                echo 0;
            }
        }
        function verusuario($param = null){
            $id = $param[0];
            $this->view->id_nav_active = "usuario-active";
            $this->view->id_collapase_active = "admin";
            $this->view->brand = "Usuario";
            $this->view->codigo_usuario = $id;
            $this->view->datos = $this->datoUsuario($id);
            $this->view->option_persona = $this->option_persona($id);
            $this->view->render('usuario/editar');
        }
        function option_persona($id){
            $cn = mainModel::conectar();
            $array = "";
            $data = $cn->query("SELECT p.NOMBRE,p.APELLIDO FROM usuario as u INNER JOIN persona as p on u.ID_PERSONA = p.ID_PERSONA WHERE u.ID_USUARIO = '$id'"); 
            if ($data->RowCount() >= 1) {
                foreach ($data as $rows) {
                    $nombre = $rows["NOMBRE"];
                    $apellido = $rows["APELLIDO"];
                    $array = "<option>$nombre $apellido</option>";
                }
            }
            return $array;
        }
        function datoUsuario($id){
            $cn = mainModel::conectar();
            $array = [];
            $data = $cn->query("SELECT * FROM usuario WHERE ID_USUARIO = '$id'"); 
            if ($data->RowCount() >= 1) {
                foreach ($data as $rows) {
                    $array = [
                        "Usuario" => $rows["USUARIO"],
                        "Pass" => mainModel::decryption($rows["PASS"]),
                        "Privilegio" => $rows["PRIVILEGIO"],
                        "Activo" => $rows["ESTADO"],
                        "Dashboard" => $rows["DASHBOARD"],
                        "Almacen" => $rows["ALMACEN"],
                        "Compras" => $rows["COMPRAS"],
                        "Ventas" => $rows["VENTAS"],
                        "Turnos" => $rows["TURNOS"],
                        "Cotizacion" => $rows["COTIZACION"],
                        "Inventario" => $rows["INVENTARIO"],
                        "Admin" => $rows["ADMIN"],
                        "Parametros" => $rows["PARAMETROS"],
                        "Backup" => $rows["BACKUP"]
                    ];
                }
            }
            return $array;
        }
    }