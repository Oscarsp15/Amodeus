<?php 
    class parametros extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->id_nav_active = "parametros-active";
            $this->view->id_collapase_active = "";
            $this->view->brand = "Parametros del sistema";
            $this->view->parametros = $this->parametros();
            $this->view->render('parametros/index');
        }
        function parametros(){
            $cn = mainModel::conectar();
            $array = [];
            $data = $cn->query("SELECT * FROM paramatros WHERE ID_PARAMETRO = 1"); 
            if ($data->RowCount() >= 1) {
                foreach ($data as $rows) {
                    $array = [
                        "Moneda" => $rows["MONEDA"],
                        "Empresa" => $rows["EMPRESA"],
                        "Tipo" => $rows["TIPO"],
                        "Num" => $rows["NUMERO"],
                        "Propietario" => $rows["PROPIETARIO"],
                        "Direccion" => $rows["DIRECCION"],
                        "Logo" => $rows["LOGO"]
                    ];
                }
            }
            return $array;
        }
        function actualizar(){
            if(isset($_POST["nombre_empresa"])){
                $cn = mainModel::conectar();
                $nombre = $_POST["nombre_empresa"];
                $tipo = $_POST["tipoi_empresa"];
                $numero = $_POST["n_empresa"];
                $moneda = $_POST["moneda_empresa"];
                $propietario = $_POST["propietario_empresa"];
                $direccion = $_POST["direccion_empresa"];
                if(isset($_FILES["file"]['name']) && !empty($_FILES["file"]['name'])){
                    $name = $_FILES["file"]['name'];
                    $tmp = $_FILES["file"]['tmp_name'];
                    $info = new SplFileInfo( $_FILES["file"]['name']);
                    $extension = $info->getExtension();
                    $name = mainModel::generar_codigo_aleatorio('LOGO',3,rand(0,9)).".".$extension;
                    if(move_uploaded_file($tmp,"archives/assets/$name")){
                        $datos = $cn->query("UPDATE `paramatros` SET `MONEDA`= '$moneda',`EMPRESA`= '$nombre',`TIPO`= '$tipo' ,`NUMERO`= '$numero',`PROPIETARIO`= '$propietario',`DIRECCION`= '$direccion',`LOGO`= '$name' WHERE ID_PARAMETRO = 1");
                        if($datos->rowCount()>0){
                            echo 1;
                        }else{
                            echo 0;
                        }
                    }else{
                        echo 0;
                    }
                }else{
                    $datos = $cn->query("UPDATE `paramatros` SET `MONEDA`= '$moneda',`EMPRESA`= '$nombre',`TIPO`= '$tipo' ,`NUMERO`= '$numero',`PROPIETARIO`= '$propietario',`DIRECCION`= '$direccion' WHERE ID_PARAMETRO = 1");
                    if($datos->rowCount()>0){
                        echo 1;
                    }else{
                        echo 0;
                    }
                }
            }
        }
        function actualizarside(){
            if(isset($_POST["nombre"])){
                $cn = mainModel::conectar();
                $nombre = $_POST["nombre"];
                if(isset($_FILES["file"]['name']) && !empty($_FILES["file"]['name'])){
                    $name = $_FILES["file"]['name'];
                    $tmp = $_FILES["file"]['tmp_name'];
                    $info = new SplFileInfo( $_FILES["file"]['name']);
                    $extension = $info->getExtension();
                    $name = mainModel::generar_codigo_aleatorio('LOGO',15,rand(0,9)).".".$extension;
                    if(move_uploaded_file($tmp,"archives/assets/$name")){
                        $datos = $cn->query("UPDATE `paramatros` SET `LOGOSIDE`= '$name',`NOMBRESIDE`= '$nombre'  WHERE ID_PARAMETRO = 1");
                        if($datos->rowCount()>0){
                            session_name('AMOSIS');
                            session_start();
                            $_SESSION["LOGOSIDE"] = $name;
                            $name = $_SESSION["LOGOSIDE"];
                            $_SESSION["NOMBRESIDE"] = $nombre;
                            $nombre = $_SESSION["NOMBRESIDE"];
                            echo 1;
                        }else{
                            echo 0;
                        }
                    }else{
                        echo 0;
                    }
                }else{
                    $datos = $cn->query("UPDATE `paramatros` SET `NOMBRESIDE`= '$nombre'  WHERE ID_PARAMETRO = 1");
                    if($datos->rowCount()>0){
                        session_name('AMOSIS');
                        session_start();
                        $_SESSION["NOMBRESIDE"] = $nombre;
                        $nombre = $_SESSION["NOMBRESIDE"];
                        echo 1;
                    }else{
                        echo 0;
                    }
                }
            }
        }
    }