<?php
    class persona extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->id_nav_active = "persona-active";
            $this->view->id_collapase_active = "admin";
            $this->view->listaPersona = $this->listarPersona();
            $this->view->persona = $this->persona();
            $this->view->brand = "Personal";
            $this->view->render('persona/index');
        }
        function persona(){
            $cn = mainModel::conectar();
            $datos = $cn->query("SELECT * FROM persona WHERE ID_PERSONA !='PER0001'");
            $num = $datos->rowCount();
            return $num;
        }
        function nuevopersonal(){
            $this->view->id_nav_active = "persona-active";
            $this->view->id_collapase_active = "admin";
            $this->view->brand = "Personal";
            $this->view->codigo_persona = $this->codigo_persona();
            $this->view->render('persona/nuevo');
        }
        function listarPersona(){
            $tabla = "";
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM persona WHERE ID_PERSONA != 'PER0001'");
            foreach($datos as $rows){
                $id = $rows['ID_PERSONA'];
                $perfil = $rows['PERFIL'];
                $tabla .="
                    <tr>
                        <td class='text-center'>
                            <img class='profile-img' src='".SERVERURL."archives/assets/$perfil' style='width: 50px;height: 50px;'>
                        </td>
                        <td>".$rows['NOMBRE']."</td>
                        <td>".$rows['APELLIDO']."</td>
                        <td>".$rows['DNI']."</td>
                        <td>".$rows['DIRECCION']."</td>
                        <td>".$rows['TELEFONO']."</td>
                        <td class='text-center'>                    
                            <a href='".SERVERURL."persona/verpersona/$id' class='btn btn-info btn-sm' data-toggle='tooltip' data-placement='top' title='Editar' data-container='body'>
                                <i class='fas fa-pen'> </i>
                            </a>
                        </td>
                    </tr>
                ";
            }
            return $tabla;
        }
        function codigo_persona(){
            $n = $this->persona();
            return mainModel::generar_codigo_aleatorio('PERS',2,$n);
        }
        function actualizar_personal(){
            if(isset($_POST["id_agregar"]) && isset($_POST["nombre_agregar"])){
                $id = mainModel::clean_string($_POST["id_agregar"]);
                $nombre = mainModel::clean_string($_POST["nombre_agregar"]);
                $apellido = mainModel::clean_string($_POST["apellido_agregar"]);
                $dni = mainModel::clean_string($_POST["dni_agregar"]);
                $direccion = mainModel::clean_string($_POST["direccion_agregar"]);
                $telefono = mainModel::clean_string($_POST["telefono_agregar"]);
                $cn = mainModel::conectar();
                if(isset($_FILES["file"]['name']) && !empty($_FILES["file"]['name'])){
                    // Recibir el archivo
                    $name = $_FILES["file"]['name'];
                    $tmp = $_FILES["file"]['tmp_name'];
                    // Extraer la extension
                    $info = new SplFileInfo( $_FILES["file"]['name']);
                    $extension = $info->getExtension();
                    // Crecando Nombre Aleatorio del archivo
                    $name = mainModel::generar_codigo_aleatorio('PERFIL',3,rand(0,9)).".".$extension;
                    if(move_uploaded_file($tmp,"archives/assets/$name")){
                        $datos = $cn->query("UPDATE `persona` SET `NOMBRE`= '$nombre',`APELLIDO`='$apellido',`DNI`='$dni',`DIRECCION`='$direccion',`TELEFONO`='$telefono' ,`PERFIL`='$name' WHERE  `ID_PERSONA`='$id'");
                        if($datos->rowCount()>0){
                            echo 1;
                        }else{
                            echo 0;
                        }
                    }else{
                        echo 0;
                    }
                }else{
                    $datos = $cn->query("UPDATE `persona` SET `NOMBRE`= '$nombre',`APELLIDO`='$apellido',`DNI`='$dni',`DIRECCION`='$direccion',`TELEFONO`='$telefono' WHERE  `ID_PERSONA`='$id'");
                    if($datos->rowCount()>0){
                        echo 1;
                    }else{
                        echo 0;
                    }
                }
            }else{
                echo 'Peticion invalida';
            }
        }
        function agregar_personal(){
            if(isset($_POST["id_agregar"]) && isset($_POST["nombre_agregar"])){
                $cn = mainModel::conectar();
                $id = mainModel::clean_string($_POST["id_agregar"]);
                $nombre = mainModel::clean_string($_POST["nombre_agregar"]);
                $apellido = mainModel::clean_string($_POST["apellido_agregar"]);
                $dni = mainModel::clean_string($_POST["dni_agregar"]);
                $direccion = mainModel::clean_string($_POST["direccion_agregar"]);
                $telefono = mainModel::clean_string($_POST["telefono_agregar"]);
                if(isset($_FILES["file"]['name']) && !empty($_FILES["file"]['name'])){
                    $name = $_FILES["file"]['name'];
                    $tmp = $_FILES["file"]['tmp_name'];
                    $info = new SplFileInfo( $_FILES["file"]['name']);
                    $extension = $info->getExtension();
                    $name = mainModel::generar_codigo_aleatorio('PERFIL',3,rand(0,9)).".".$extension;
                    if(move_uploaded_file($tmp,"archives/assets/$name")){
                        $datos = $cn->query("INSERT INTO `persona`(`ID_PERSONA`, `NOMBRE`, `APELLIDO`, `DNI`, `DIRECCION`, `TELEFONO`, `PERFIL`) VALUES ('$id','$nombre','$apellido','$dni','$direccion','$telefono','$name')");
                        if($datos->rowCount()>0){
                            echo 1;
                        }else{
                            echo 0;
                        }
                    }else{
                        echo 0;
                    }
                }
            }else{
                echo 'Peticion invalida';
            }
        }
        function verPersona($param = null){
            $id = $param[0];
            $this->view->id_nav_active = "persona-active";
            $this->view->id_collapase_active = "admin";
            $this->view->brand = "Personal";
            $this->view->codigo_persona = $id;
            $this->view->datos = $this->datoPersonal($id);
            $this->view->render('persona/editar');
        }
        function datoPersonal($id){
            $cn = mainModel::conectar();
            $array = [];
            $data = $cn->query("SELECT * FROM persona WHERE ID_PERSONA = '$id'"); 
            if ($data->RowCount() >= 1) {
                foreach ($data as $rows) {
                    $array = [
                        "Id" => $rows["ID_PERSONA"],
                        "Nombre" => $rows["NOMBRE"],
                        "Apellido" => $rows["APELLIDO"],
                        "Dni" => $rows["DNI"],
                        "Direccion" => $rows["DIRECCION"],
                        "Telefono" => $rows["TELEFONO"],
                        "Perfil" => $rows["PERFIL"]
                    ];
                }
            }
            return $array;
        }
        function existenciapersona(){
            if(isset($_POST["tocken"])){
                $cn = mainModel::conectar();
                $persona = $cn->query("SELECT * FROM `persona`");
                if($persona->rowCount()==1){
                    echo "1";
                }
            }
        }
    }