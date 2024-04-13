<?php
    class Clientes extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->brand = "Clientes";
            $this->view->id_nav_active = "clientes-active";
            $this->view->id_collapase_active = "ventas";
            $this->view->lista_cliente = $this->lista_cliente();
            $this->view->numero_cliente = $this->numero_cliente();
            $this->view->render('clientes/index');
        }
        function nuevocliente(){
            $this->view->brand = "Clientes";
            $this->view->id_nav_active = "clientes-active";
            $this->view->id_collapase_active = "ventas";
            $this->view->render('clientes/nuevo');
        }
        function nuevo_cliente(){
            if(isset($_POST["numero"]) && isset($_POST["nombre_agregar"])){
                $id = mainModel::clean_string($_POST["numero"]);
                $nombre = mainModel::clean_string($_POST["nombre_agregar"]);
                $direccion = mainModel::clean_string($_POST["direccion_agregar"]);
                $conexion = mainModel::conectar();
                $search=$conexion->query("SELECT * FROM `cliente` WHERE ID_CLIENTE = '$id'");
                if($search->rowCount()>=1){
                    echo "
                        <script>
                            showNotification('bottom','center','Tu cliente <b>$nombre</b> no fue agregado, revise que el documento no exista','danger');
                            setTimeout(function(){
                                location.reload();
                            },1000);
                        </script>";
                }else{
                    $datos = $conexion->query("INSERT INTO `cliente`(`ID_CLIENTE`, `NOMBRE`, `DIRECCION`) VALUES ('$id','$nombre','$direccion')");
                    if($datos->rowCount()>0){
                        echo "
                        <script>
                            showNotification('bottom','center','Tu cliente <b>$nombre</b> fue agregado correctamente','success');
                        </script>";
                    }
                }
            }
        }
        function lista_cliente(){
            $tabla = "";
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM cliente");
            $n = 1;
            foreach($datos as $rows){
                $nombre = substr($rows["NOMBRE"],0,25);
                $direccion = substr($rows["DIRECCION"],0,25);
                $id = $rows['ID_CLIENTE'];
                $tabla .="
                    <tr>
                        <td>".$n."</td>
                        <td>".$rows['ID_CLIENTE']."</td>
                        <td>".$nombre."</td>
                        <td>".$direccion."</td>
                        <td class='text-center'>                    
                            <a href='".SERVERURL."clientes/vercliente/$id' class='btn-editar btn btn-info btn-sm'  data-toggle='tooltip' data-placement='top' title='Editar' data-container='body'>
                                <i class='fas fa-pen'></i>
                            </a>
                        </td>
                    </tr>
                ";
                $n++;
            }
            return $tabla;
        }
        function numero_cliente(){
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM cliente");
            $datos = $datos->rowCount();
            return $datos;
        }
        function vercliente($param = null){
            $id = $param[0];
            $this->view->brand = "Clientes";
            $this->view->id_nav_active = "clientes-active";
            $this->view->id_collapase_active = "ventas";
            $this->view->datocliente = $this::datoscliente($id);
            $this->view->render('clientes/editar');
        }
        function datoscliente($id){
            $cn = mainModel::conectar();
            $array = [];
            $data = $cn->query("SELECT * FROM cliente WHERE ID_CLIENTE = '$id'"); 
            if ($data->RowCount() >= 1) {
                foreach ($data as $rows) {
                    $array = [
                        "Id" => $rows["ID_CLIENTE"],
                        "Nombre" => $rows["NOMBRE"],
                        "Direccion" => $rows["DIRECCION"]
                    ];
                }
            }
            return $array;
        }
        function actualizarcliente(){
            if(isset($_POST["numero"]) && isset($_POST["nombre_agregar"])){
                $id = mainModel::clean_string($_POST["numero"]);
                $nombre = mainModel::clean_string($_POST["nombre_agregar"]);
                $direccion = mainModel::clean_string($_POST["direccion_agregar"]);
                $conexion = mainModel::conectar();
                $datos = $conexion->query("UPDATE cliente SET NOMBRE = '$nombre' ,DIRECCION = '$direccion' WHERE ID_CLIENTE = '$id' ");
                if($datos->rowCount()>0){
                    echo "
                    <script>
                        showNotification('bottom','center','Tu cliente <b>$nombre</b> fue actualizado correctamente','success');
                    </script>";
                }else{
                    echo "
                    <script>
                        showNotification('bottom','center','Tu cliente <b>$nombre</b> no fue actualizado','danger');
                    </script>";
                }
            }
        }
    }