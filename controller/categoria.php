<?php
    class Categoria extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->brand = "Categoría";
            $this->view->lista_categoria = $this->lista_categoria();
            $this->view->id_nav_active = "categoria-active";
            $this->view->id_collapase_active = "almacen";
            $this->view->numero_categoria = $this->numero_categoria();
            $this->view->render('categoria/index');
        }
        function nuevacategoria(){
            if(isset($_POST["Nombre"]) && isset($_POST["Detalle"])){
                $nombre = mainModel::clean_string($_POST["Nombre"]);
                $detalle = mainModel::clean_string($_POST["Detalle"]);
                $conexion = mainModel::conectar();
                $buscar = $conexion->query("SELECT * FROM categoria WHERE NOMBRE = '$nombre'");
                if($buscar->rowCount()>0){
                    echo 2;
                }else{
                    $datos = $conexion->query("INSERT INTO `categoria`(`NOMBRE`, `DETALLE`) VALUES ('$nombre','$detalle')");
                    if($datos->rowCount()>0){
                        echo 1;
                    }
                }
            }
        }
        function lista_categoria(){
            if(isset($_POST["tokenlistar"])){
                $tabla = "";
                $conexion = mainModel::conectar();
                $datos = $conexion->query("SELECT * FROM categoria");
                foreach($datos as $rows){
                    $tabla .="
                        <tr>
                            <td>".$rows['ID_CATEGORIA']."</td>
                            <td>".$rows['NOMBRE']."</td>
                            <td>".$rows['DETALLE']."</td>
                            <td class='text-center'>                    
                                <button class=' btn btn-info btn-sm' onclick='categoriaeditar(".$rows['ID_CATEGORIA'].")' data-toggle='modal' data-target='#modal-editar'>
                                    <i class='fas fa-pen'></i>
                                </button>
                            </td>
                        </tr>
                    ";
                }
                echo $tabla;
            }
        }
        function numero_categoria(){
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM categoria");
            $datos = $datos->rowCount();
            return $datos;
        }
        function formularioeditar(){
            if(isset($_POST["id"])){
                $id = mainModel::clean_string($_POST["id"]);
                $cn = mainModel::conectar();
                $form = "";
                $data = $cn->query("SELECT * FROM categoria WHERE ID_CATEGORIA = '$id'");
                foreach($data as $rows){
                    $marca = $rows["NOMBRE"];
                    $detalle = $rows["DETALLE"];
                    $form .= "
                        <input type='hidden' value='$id' class='form-control is-invalid form-control-sm' id='id-update' name='id-update'>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <label class='bmd-label-floating'>Nombre de la Categoria</label>
                                <input type='text' name='nombre-agregar' class='form-control' id='marca-editar' value='$marca' required>
                                <input type='hidden' name='nombre-agregar' class='form-control' id='marcao-editar' value='$marca' required>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <div class='form-group bmd-form-group'>
                                    <label class='bmd-label-floating'> Detalle de la Categoria</label>
                                    <textarea name='detalle-agregar' class='form-control' id='detalle-editar' rows='5'>$detalle</textarea>
                                </div>
                            </div> 
                        </div>   
                    "; 
                }
                echo $form;
            }
        }
        function categoria_actualizar(){
            $id = mainModel::clean_string($_POST["Id"]);
            $nombre = mainModel::clean_string($_POST["Nombre"]);
            $nombreo = mainModel::clean_string($_POST["Nombreo"]);
            $detalle = mainModel::clean_string($_POST["Detalle"]);
            $conexion = mainModel::conectar();
            $buscar = $conexion->query("SELECT * FROM categoria WHERE NOMBRE = '$nombre' AND NOMBRE != '$nombreo'");
            if($buscar->rowCount()>0){
                echo 2;
            }else{
                $datos = $conexion->query("UPDATE categoria SET NOMBRE = '$nombre' ,DETALLE = '$detalle'  WHERE ID_CATEGORIA = '$id'");
                if($datos->rowCount()>0){
                    echo 1;
                }
            }
        }
    }