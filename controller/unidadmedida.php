<?php
    class UnidadMedida extends Controller{
        function __construct()
        {
            parent::__construct();
        }
        function render(){
            $this->view->brand = "Unidad de medida";
            $this->view->lista_unidad = $this->lista_unidad();
            $this->view->id_nav_active = "unidadmedida-active";
            $this->view->id_collapase_active = "almacen";
            $this->view->numero_unidad = $this->numero_unidad();
            $this->view->render('unidadmedida/index');
        }
        function nuevaunidad(){
            if(isset($_POST["Prefijo"]) && isset($_POST["Detalle"])){
                $nombre = mainModel::clean_string($_POST["Prefijo"]);
                $detalle = mainModel::clean_string($_POST["Detalle"]);
                $conexion = mainModel::conectar();
                $buscar = $conexion->query("SELECT * FROM unidad_medida WHERE PREFIJO = '$nombre'");
                if($buscar->rowCount()>0){
                    echo 2;
                }else{
                    $datos = $conexion->query("INSERT INTO `unidad_medida`(`PREFIJO`, `DETALLE`) VALUES ('$nombre','$detalle')");
                    if($datos->rowCount()>0){
                        echo 1;
                    }
                }
            }
        }
        function lista_unidad(){
            if(isset($_POST["tokenlistar"])){
                $tabla = "";
                $conexion = mainModel::conectar();
                $datos = $conexion->query("SELECT * FROM unidad_medida");
                foreach($datos as $rows){
                    $tabla .="
                        <tr>
                            <td>".$rows['ID_UNIDAD']."</td>
                            <td>".$rows['PREFIJO']."</td>
                            <td>".$rows['DETALLE']."</td>
                            <td class='text-center'>                    
                                <button class='btn-editar btn btn-info btn-sm' onclick='unidadeditar(".$rows['ID_UNIDAD'].")' data-toggle='modal' data-target='#modal-editar'>
                                    <i class='fas fa-pen'></i>
                                </button>
                            </td>
                        </tr>
                    ";
                }
                echo $tabla;
            }
        }
        function numero_unidad(){
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM unidad_medida");
            $datos = $datos->rowCount();
            return $datos;
        }
        public function formularioeditar(){
            $id = $_POST["id"];
            $cn = mainModel::conectar();
            $form = "";
            $data = $cn->query("SELECT * FROM unidad_medida WHERE ID_UNIDAD = '$id'");
            foreach($data as $rows){
                $nombre = $rows["PREFIJO"];
                $detalle = $rows["DETALLE"];
                $form .= "
                    <input type='hidden' value='".$rows['ID_UNIDAD']."' class='form-control is-invalid form-control-sm' id='id-update' name='id-update'>
                    <div class='col-md-12'>
                            <div class='form-group'>
                                <label class='bmd-label-floating'>Prefijo de la Unidad</label>
                                <input type='text' name='nombre-agregar' class='form-control' id='marca-editar' value='$nombre' required>
                                <input type='hidden' name='nombre-agregar' class='form-control' id='marcao-editar' value='$nombre' required>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <div class='form-group bmd-form-group'>
                                    <label class='bmd-label-floating'> Detalle de la Unidad</label>
                                    <textarea name='detalle-agregar' class='form-control' id='detalle-editar' rows='5'>$detalle</textarea>
                                </div>
                            </div> 
                        </div>   
                "; 
            }
            echo $form;
        }
        function unidad_actualizar(){
            $id = mainModel::clean_string($_POST["Id"]);
            $nombreo = mainModel::clean_string($_POST["Nombreo"]);
            $nombre = mainModel::clean_string($_POST["Nombre"]);
            $detalle = mainModel::clean_string($_POST["Detalle"]);
            $conexion = mainModel::conectar();
            $buscar = $conexion->query("SELECT * FROM unidad_medida WHERE PREFIJO = '$nombre' AND PREFIJO != '$nombreo'");
            if($buscar->rowCount()>0){
                echo 2;
            }else{
                $datos = $conexion->query("UPDATE unidad_medida SET PREFIJO = '$nombre' ,DETALLE = '$detalle'  WHERE ID_UNIDAD = $id");
                if($datos->rowCount()>0){
                    echo 1;
                }
            }
        }
        function precioxunidad(){
            if(isset($_POST["id"])){
                $option = "";
                $id = $_POST["id"];
                $cn = mainModel::conectar();
                $datos = $cn->query("SELECT pp.ID_PRECIO,u.PREFIJO FROM precio_producto as pp INNER JOIN unidad_medida as u ON pp.ID_UNIDAD = u.ID_UNIDAD WHERE pp.ID_PRODUCTO = '$id'");
                foreach($datos as $row){
                    $option .= "
                        <option value=".$row['ID_PRECIO'].">".$row['PREFIJO']."</option>
                    ";
                }
                echo $option;
            }else{
                echo "Peticion Invalida";
            }
        }
        function preciounidad(){
            if(isset($_POST["id"])){
                $option = "";
                $id = $_POST["id"];
                $cn = mainModel::conectar();
                $datos = $cn->query("SELECT pp.ID_UNIDAD,u.PREFIJO,pp.PRECIO_COSTO FROM precio_producto as pp INNER JOIN unidad_medida as u ON pp.ID_UNIDAD = u.ID_UNIDAD WHERE pp.ID_PRODUCTO = '$id' LIMIT 1");
                foreach($datos as $row){
                    $option = $row["PRECIO_COSTO"];
                }
                echo $option;
            }else{
                echo "Peticion Invalida";
            }
        }
        function preciounidad2(){
            if(isset($_POST["id"])){
                $option = "";
                $id = $_POST["id"];
                $cn = mainModel::conectar();
                $datos = $cn->query("SELECT pp.ID_UNIDAD,u.PREFIJO,pp.PRECIO FROM precio_producto as pp INNER JOIN unidad_medida as u ON pp.ID_UNIDAD = u.ID_UNIDAD WHERE pp.ID_PRODUCTO = '$id' LIMIT 1");
                foreach($datos as $row){
                    $option = $row["PRECIO"];
                }
                echo $option;
            }else{
                echo "Peticion Invalida";
            }
        }
        function preciou(){
            if(isset($_POST["id"])){
                $option = "";
                $id = $_POST["id"];
                $cn = mainModel::conectar();
                $datos = $cn->query("SELECT PRECIO_COSTO FROM precio_producto WHERE ID_PRECIO = '$id'");
                foreach($datos as $row){
                    $option = $row["PRECIO_COSTO"];
                }
                echo $option;
            }else{
                echo "Peticion Invalida";
            }
        }
        function preciou2(){
            if(isset($_POST["id"])){
                $option = "";
                $id = $_POST["id"];
                $cn = mainModel::conectar();
                $datos = $cn->query("SELECT PRECIO FROM precio_producto WHERE ID_PRECIO = '$id'");
                foreach($datos as $row){
                    $option = $row["PRECIO"];
                }
                echo $option;
            }else{
                echo "Peticion Invalida";
            }
        }
        function preciou3(){
            if(isset($_POST["id"])){
                $option = "";
                $id = $_POST["id"];
                $cn = mainModel::conectar();
                $datos = $cn->query("SELECT PRECIO,UNIDADES FROM precio_producto WHERE ID_PRECIO = '$id'");
                foreach($datos as $row){
                    $option = $row["PRECIO"];
                    $option2 = $row["UNIDADES"];
                }
                echo $option."|".$option2;
            }else{
                echo "Peticion Invalida";
            }
        }
        function evaluarunidades(){
            if(isset($_POST["tocken"])){
                $cn = mainModel::conectar();
                $marcas = $cn->query("SELECT * FROM `unidad_medida`");
                if($marcas->rowCount()==0){
                    echo "1";
                }
            }
        }
    }