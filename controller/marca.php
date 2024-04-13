<?php
    class Marca extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->brand = "Marca";
            $this->view->id_nav_active = "marca-active";
            $this->view->id_collapase_active = "almacen";
            $this->view->lista_marca = $this->lista_marca();
            $this->view->numero_marca = $this->numero_marca();
            $this->view->render('marca/index');
        }
        function nuevamarca(){
            if(isset($_POST["Nombre"]) && isset($_POST["Detalle"])){
                $nombre = mainModel::clean_string($_POST["Nombre"]);
                $detalle = mainModel::clean_string($_POST["Detalle"]);
                $conexion = mainModel::conectar();
                $buscar = $conexion->query("SELECT * FROM marca WHERE NOMBRE = '$nombre'");
                if($buscar->rowCount()>0){
                    echo 2;
                }else{
                    $datos = $conexion->query("INSERT INTO `marca`(`NOMBRE`, `DETALLE`) VALUES ('$nombre','$detalle')");
                    if($datos->rowCount()>0){
                        echo 1;
                    }
                }
            }
        }
        function lista_marca(){
            if(isset($_POST["tokenlistar"])){
                $tabla = "";
                $conexion = mainModel::conectar();
                $datos = $conexion->query("SELECT * FROM marca");
                foreach($datos as $rows){
                    $detalle = substr($rows["DETALLE"],0,15);
                    $tabla .="
                        <tr>
                            <td>".$rows['ID_MARCA']."</td>
                            <td>".$rows['NOMBRE']."</td>
                            <td>".$detalle."</td>
                            <td class='text-center'>                    
                                <button class='btn-editar btn btn-info btn-sm' onclick='marcaeditar(".$rows['ID_MARCA'].")' data-toggle='modal' data-target='#editmarca'>
                                    <i class='fas fa-pen'></i>
                                </button>
                            </td>
                        </tr>
                    ";
                }
                echo $tabla;
            }
        }
        function numero_marca(){
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM marca");
            $datos = $datos->rowCount();
            return $datos;
        }
        function formularioeditar(){
            if(isset($_POST["id"])){
                $id = mainModel::clean_string($_POST["id"]);
                $cn = mainModel::conectar();
                $form = "";
                $data = $cn->query("SELECT * FROM marca WHERE ID_MARCA = '$id'");
                foreach($data as $rows){
                    $marca = $rows["NOMBRE"];
                    $detalle = $rows["DETALLE"];
                    $form .= "
                        <input type='hidden' value='$id' class='form-control is-invalid form-control-sm' id='id-update' name='id-update'>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <label class='bmd-label-floating'>Nombre de la Marca</label>
                                <input type='text' name='nombre-agregar' class='form-control' id='marca-editar' value='$marca' required>
                                <input type='hidden' name='nombre-agregar' class='form-control' id='marcao-editar' value='$marca' required>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <div class='form-group bmd-form-group'>
                                    <label class='bmd-label-floating'> Detalle de la Marca</label>
                                    <textarea name='detalle-agregar' class='form-control' id='detalle-editar' rows='5'>$detalle</textarea>
                                </div>
                            </div> 
                        </div>   
                    "; 
                }
                echo $form;
            }
        }
        function marca_actualizar(){
            $id = mainModel::clean_string($_POST["Id"]);
            $nombre = mainModel::clean_string($_POST["Nombre"]);
            $nombreo = mainModel::clean_string($_POST["Nombreo"]);
            $detalle = mainModel::clean_string($_POST["Detalle"]);
            $conexion = mainModel::conectar();
            $buscar = $conexion->query("SELECT * FROM marca WHERE NOMBRE = '$nombre' AND NOMBRE != '$nombre'");
            if($buscar->rowCount()>0){
                echo 2;
            }else{
                $datos = $conexion->query("UPDATE marca SET NOMBRE = '$nombre' ,DETALLE = '$detalle'  WHERE ID_MARCA = '$id'");
                if($datos->rowCount()>0){
                    echo 1;
                }
            }
        }
    }