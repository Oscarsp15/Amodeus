<?php
    class proveedor extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->brand = "Proveedores";
            $this->view->id_nav_active = "proveedor-active";
            $this->view->id_collapase_active = "entrada_salida";
            $this->view->lista_proveedor = $this->lista_proveedor();
            $this->view->numero_proveedor = $this->numero_proveedor();
            $this->view->render('proveedor/index');
        }
        function nuevoproveedor(){
            $this->view->brand = "Nuevo Proveedor";
            $this->view->id_nav_active = "proveedor-active";
            $this->view->id_collapase_active = "entrada_salida";
            $this->view->codigo_proveedor = $this->generar_codigo_proveedor();
            $this->view->render('proveedor/nuevo');
        }
        function verproveedor($id = null){
            $id = $id[0];
            $this->view->brand = "Ver Proveedor";
            $this->view->id_nav_active = "proveedor-active";
            $this->view->id_collapase_active = "entrada_salida";
            $this->view->codigo_proveedor = $id;
            $this->view->datos_proveedor = $this->datos_proveedor($id);
            $this->view->render('proveedor/editar');
        }
        function datos_proveedor($id){
            $cn = mainModel::conectar();
            $array = [];
            $data = $cn->query("SELECT * FROM proveedor WHERE ID_PROVEEDOR = '$id'"); 
            if ($data->RowCount() >= 1) {
                foreach ($data as $rows) {
                    $array = [
                        "Id" => $rows["ID_PROVEEDOR"],
                        "Ruc" => $rows["RUC"],
                        "RS" => $rows["RAZON_SOCIAL"],
                        "Email" => $rows["EMAIL"],
                        "Telefono" => $rows["TELEFONO"],
                        "Direccion" => $rows["DIRECCION"],
                        "Dni_re" => $rows["DNI_R"],
                        "Nombre_re" => $rows["NOMBRE_R"],
                        "Dir_re" => $rows["DIRECCION_R"],
                        "Telefono_re" => $rows["TELEFONO_R"],
                    ];
                }
            }
            return $array;
        }
        function lista_proveedor(){
            $tabla = "";
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM proveedor");
            foreach($datos as $rows){
                $id  = $rows["ID_PROVEEDOR"];
                $tabla .="
                    <tr>
                        <td>".$rows['ID_PROVEEDOR']."</td>
                        <td>".$rows['RUC']."</td>
                        <td>".substr($rows['RAZON_SOCIAL'],0,14)."...</td>
                        <td>".$rows['TELEFONO']."</td>
                        <td class='text-center'>                    
                            <a href='".SERVERURL."proveedor/verproveedor/$id' class='btn btn-info btn-sm' data-toggle='tooltip' data-placement='top' title='Editar' data-container='body'>
                                <i class='fas fa-pen'> </i>
                            </a>
                        </td>
                    </tr>
                ";
            }
            return $tabla;
        }
        function numero_proveedor(){
            $cn = mainModel::conectar();
            $numero = $cn->query("SELECT * FROM proveedor");
            $numero = $numero->rowCount();
            return $numero;
        }
        function generar_codigo_proveedor(){
            $numero = $this->numero_proveedor();
            $codigo = mainModel::generar_codigo_aleatorio('PROV',5,$numero);
            return $codigo;
        }
        function agregar_proveedor(){
            if(isset($_POST["id_agregar"]) && isset($_POST["ruc_agregar"]) && isset($_POST["rs_agregar"])){
                $id = mainModel::clean_string($_POST['id_agregar']);
                $ruc = mainModel::clean_string($_POST['ruc_agregar']);
                $rs = mainModel::clean_string($_POST['rs_agregar']);
                $email = mainModel::clean_string($_POST['email_agregar']);
                $telefono = mainModel::clean_string($_POST['telefono_agregar']);
                $direccion = mainModel::clean_string($_POST['direccion_agregar']);
                $dnir = mainModel::clean_string($_POST['dnir_agregar']);
                $nombrer = mainModel::clean_string($_POST['nombrer_agregar']);
                $direccionr = mainModel::clean_string($_POST['direccionr_agregar']);
                $telefonor = mainModel::clean_string($_POST['telefonor_agregar']);       
                $dataP = [
                    "id" => $id,
                    "ruc" => $ruc,  
                    "rs" => $rs,
                    "email" => $email,
                    "telefono" => $telefono,
                    "direccion" => $direccion,
                    "dnir" => $dnir,
                    "nombrer" => $nombrer,
                    "direccionr" => $direccionr,
                    "telefonor" => $telefonor
                ];
                $guardarProveedor = $this->model->insertar($dataP);
                if($guardarProveedor->rowCount()>0){
                    echo "
                    <script>
                        showNotification('bottom','center','Tu proveedor <b>$rs</b> fue agregado correctamente','success');
                    </script>";
                }else{
                    echo " 
                    <script>
                        showNotification('bottom','center','No puedes agregar un proveedor con el mismo Id','danger');
                    </script>";
                }
            }else{
                echo "Petición Denegada";
            }
        }
        function actualizar_proveedor(){
            if(isset($_POST["id_agregar"]) && isset($_POST["ruc_agregar"]) && isset($_POST["rs_agregar"])){
                $id = mainModel::clean_string($_POST['id_agregar']);
                $ruc = mainModel::clean_string($_POST['ruc_agregar']);
                $rs = mainModel::clean_string($_POST['rs_agregar']);
                $email = mainModel::clean_string($_POST['email_agregar']);
                $telefono = mainModel::clean_string($_POST['telefono_agregar']);
                $direccion = mainModel::clean_string($_POST['direccion_agregar']);
                $dnir = mainModel::clean_string($_POST['dnir_agregar']);
                $nombrer = mainModel::clean_string($_POST['nombrer_agregar']);
                $direccionr = mainModel::clean_string($_POST['direccionr_agregar']);
                $telefonor = mainModel::clean_string($_POST['telefonor_agregar']);       
                $dataP = [
                    "id" => $id,
                    "ruc" => $ruc,  
                    "rs" => $rs,
                    "email" => $email,
                    "telefono" => $telefono,
                    "direccion" => $direccion,
                    "dnir" => $dnir,
                    "nombrer" => $nombrer,
                    "direccionr" => $direccionr,
                    "telefonor" => $telefonor
                ];
                $guardarProveedor = $this->model->actualizar($dataP);
                if($guardarProveedor->rowCount()>0){
                    echo "
                    <script>
                        showNotification('bottom','center','Tu proveedor <b>$rs</b> fue actualizado correctamente','success');
                    </script>";
                }else{
                    echo " 
                    <script>
                        showNotification('bottom','center','No puedes actualizar tu proveedor, actualize la pagina','danger');
                    </script>";
                }
            }else{
                echo "Petición Denegada";
            }
        }
        function existenciaproveedor(){
            if(isset($_POST["tocken"])){
                $cn = mainModel::conectar();
                $marcas = $cn->query("SELECT * FROM `proveedor`");
                if($marcas->rowCount()==0){
                    echo "1";
                }
            }
        }
    }
    