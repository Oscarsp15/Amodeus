<?php
    class Productos extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->brand = "Productos";
            $this->view->numero_producto = $this->numero_producto();
            $this->view->id_nav_active = "producto-active";
            $this->view->id_collapase_active = "almacen";
            $this->view->lista_producto = $this->lista_producto();
            $this->view->render('productos/index');
        }
        function nuevoproducto(){
            $this->view->brand = "Nuevo Producto";
            $this->view->id_nav_active = "producto-active";
            $this->view->id_collapase_active = "almacen";
            $this->view->codigo_producto = $this->generar_codigo_producto();
            $this->view->list_marca = $this->list_marca();
            $this->view->list_categoria = $this->list_categoria();
            $this->view->list_unidad = $this->list_unidad();
            $this->view->render('productos/nuevo');
        }
        function agregar_producto(){
            if(isset($_POST["id_agregar"]) && isset($_POST["nombre_agregar"])){
                $id = mainModel::clean_string($_POST["id_agregar"]);
                $nombre = mainModel::clean_string($_POST["nombre_agregar"]);
                $stock = mainModel::clean_string($_POST["stock_agregar"]);
                $barra = mainModel::clean_string($_POST["cod_agregar"]);
                $marca = mainModel::clean_string($_POST["marca_agregar"]);
                $unidad = mainModel::clean_string($_POST["unidad_agregar"]);
                $precioc = mainModel::clean_string($_POST["pc_agregar"]);
                $preciov = mainModel::clean_string($_POST["pv_agregar"]);
                $categoria = mainModel::clean_string($_POST["categoria_agregar"]);
                $conexion = mainModel::conectar();
                $buscar = $conexion->query("SELECT * FROM producto WHERE CODIGO_BARRA = '$barra'");
                if($buscar->rowCount()==0){
                    $datos = $conexion->query("INSERT INTO `producto`(`ID_PRODUCTO`, `NOMBRE`, `STOCK_MINIMO`, `CODIGO_BARRA`,  `ID_UNIDAD`, `ID_MARCA`, `ID_CATEGORIA`, `PRECIO_COSTO`, `PRECIO_VENTA`) VALUES ('$id','$nombre','$stock','$barra','$unidad','$marca','$categoria','$precioc','$preciov')");
                    if($datos->rowCount()>0){
                        $preciounidad = $conexion->query("INSERT INTO `precio_producto`(`ID_PRODUCTO`, `ID_UNIDAD`, `UNIDADES`, `PRECIO`, `PRECIO_COSTO`) VALUES ('$id','$unidad',1,'$preciov','$precioc')");
                        if($preciounidad->rowCount()>0){
                            echo 1;
                        }else{
                            echo 2;
                        }
                    }
                }else{
                    echo 0;
                }
            }else{
                echo 'Peticion invalida';
            }
        }
        function numero_producto(){
            $cn = mainModel::conectar();
            $numero = $cn->query("SELECT * FROM producto");
            $numero = $numero->rowCount();
            return $numero;
        }
        function lista_producto(){
            $table = "";
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT P.ID_PRODUCTO as id ,P.CODIGO_BARRA ,P.NOMBRE as producto, M.NOMBRE as marca , C.NOMBRE as categoria , P.STOCK_MINIMO as stock FROM producto as P INNER JOIN marca as M on P.ID_MARCA = M.ID_MARCA INNER JOIN categoria as C on P.ID_CATEGORIA = C.ID_CATEGORIA");
            foreach($datos as $rows){
                $id = $rows['id'];
                $table .="
                    <tr>
                        <td>".$rows['id']."</td>
                        <td>".$rows['producto']."</td>
                        <td>".$rows['CODIGO_BARRA']."</td>
                        <td>".$rows['marca']."</td>
                        <td>".$rows['categoria']."</td>
                        <td>".$rows['stock']."</td>
                        <td class='text-center'>                    
                            <a href='".SERVERURL."productos/preciounidad/$id' class='btn-editar btn btn-success btn-sm'  data-toggle='tooltip' data-placement='top' title='Unidades de medida' data-container='body'>
                                <i class='fa fa-balance-scale-right'></i>
                            </a>
                        </td>
                        <td class='text-center'>                    
                            <a href='".SERVERURL."productos/codebar/$id' target='_blank' class='btn-editar btn btn-warning btn-sm'  data-toggle='tooltip' data-placement='top' title='Codigo de Barra' data-container='body'>
                                <i class='fa fa-barcode'></i>
                            </a>
                        </td>
                        <td class='text-center'>                    
                            <a href='".SERVERURL."productos/verproducto/$id' class='btn-editar btn btn-info btn-sm'  data-toggle='tooltip' data-placement='top' title='Editar' data-container='body'>
                                <i class='fas fa-pen'></i>
                            </a>
                        </td>
                    </tr>
                ";
            }
            return $table;
        }
        function generar_codigo_producto(){
            $numero = $this->numero_producto();
            $codigo = mainModel::generar_codigo_aleatorio('PROD',5,$numero);
            return $codigo;
        }
        function list_marca(){
            $option = "";
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM marca");
            foreach($datos as $rows){
                $option .="
                    <option value='".$rows['ID_MARCA']."'>".$rows['NOMBRE']."</option>
                ";
            }
            return $option;
        }
        function list_categoria(){
            $option = "";
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM categoria");
            foreach($datos as $rows){
                $option .="
                    <option value='".$rows['ID_CATEGORIA']."'>".$rows['NOMBRE']."</option>
                ";
            }
            return $option;
        }
        function list_unidad(){
            $option = "";
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM unidad_medida");
            foreach($datos as $rows){
                $option .="
                    <option value='".$rows['ID_UNIDAD']."'>".$rows['PREFIJO']."</option>
                ";
            }
            return $option;
        }
        function verproducto($param = null){
            $id = $param[0];
            $this->view->brand = "Nuevo Producto";
            $this->view->id_nav_active = "producto-active";
            $this->view->id_collapase_active = "almacen";
            $this->view->codigo_producto = $id;
            $this->view->datos_producto = $id;
            $this->view->datos_producto = $this->datos_producto($id);
            $marca = $this->datos_producto($id);
            $categoria = $this->datos_producto($id);
            $unidad = $this->datos_producto($id);
            $this->view->list_marca = $this->list_marca_producto($marca['Marca']);
            $this->view->list_categoria = $this->list_categoria_producto($categoria['Categoria']);
            $this->view->list_unidad = $this->list_unidad_producto($unidad['Unidad']);
            $this->view->render('productos/editar');
        }
        function datos_producto($id){
            $cn = mainModel::conectar();
            $array = [];
            $data = $cn->query("SELECT * FROM producto WHERE ID_PRODUCTO = '$id'"); 
            if ($data->RowCount() >= 1) {
                foreach ($data as $rows) {
                    $array = [
                        "Id" => $rows["ID_PRODUCTO"],
                        "Nombre" => $rows["NOMBRE"],
                        "Stock" => $rows["STOCK_MINIMO"],
                        "Barra" => $rows["CODIGO_BARRA"],
                        "Unidad" => $rows["ID_UNIDAD"],
                        "Marca" => $rows["ID_MARCA"],
                        "Categoria" => $rows["ID_CATEGORIA"],
                        "Precio" => $rows["PRECIO_COSTO"],
                        "PrecioV" => $rows["PRECIO_VENTA"],
                    ];
                }
            }
            return $array;
        }
        function list_marca_producto($marca){
            $option = "";
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM marca");
            foreach($datos as $rows){
                $id = $rows['ID_MARCA'];
                if($id == $marca){
                    $option .="
                        <option value='".$rows['ID_MARCA']."' selected>".$rows['NOMBRE']."</option>
                    ";
                }else{
                    $option .="
                        <option value='".$rows['ID_MARCA']."'>".$rows['NOMBRE']."</option>
                    ";
                }
            }
            return $option;
        }
        function list_categoria_producto($categoria){
            $option = "";
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM categoria");
            foreach($datos as $rows){
                $id = $rows["ID_CATEGORIA"];
                if($id == $categoria){
                    $option .="
                        <option value='".$rows['ID_CATEGORIA']."' selected>".$rows['NOMBRE']."</option>
                    ";
                }else{
                    $option .="
                        <option value='".$rows['ID_CATEGORIA']."'>".$rows['NOMBRE']."</option>
                    ";
                }
            }
            return $option;
        }
        function list_unidad_producto($unidad){
            $option = "";
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT * FROM unidad_medida");
            foreach($datos as $rows){
                $id = $rows['ID_UNIDAD'];
                if($id == $unidad){               
                    $option .="
                        <option value='".$rows['ID_UNIDAD']."' selected>".$rows['PREFIJO']."</option>
                    ";
                }else{
                    $option .="
                        <option value='".$rows['ID_UNIDAD']."'>".$rows['PREFIJO']."</option>
                    ";
                }
            }
            return $option;
        }
        function actualizar_producto(){
            if(isset($_POST["id_agregar"]) && isset($_POST["nombre_agregar"])){
                $id = mainModel::clean_string($_POST["id_agregar"]);
                $nombre = mainModel::clean_string($_POST["nombre_agregar"]);
                $stock = mainModel::clean_string($_POST["stock_agregar"]);
                $barra_o = mainModel::clean_string($_POST["cod_original"]);
                $barra = mainModel::clean_string($_POST["barra"]);
                $precioc = mainModel::clean_string($_POST["pc_agregar"]);
                $preciov = mainModel::clean_string($_POST["pv_agregar"]);
                $marca = mainModel::clean_string($_POST["marca_agregar"]);
                $unidad = mainModel::clean_string($_POST["unidad_agregar"]);
                $categoria = mainModel::clean_string($_POST["categoria_agregar"]);
                $conexion = mainModel::conectar();
                if($barra == $barra_o){
                    $datos = $conexion->query("UPDATE producto SET NOMBRE='$nombre',STOCK_MINIMO= $stock,CODIGO_BARRA = $barra_o,PRECIO_COSTO='$precioc',ID_MARCA='$marca',ID_CATEGORIA='$categoria',ID_UNIDAD='$unidad',PRECIO_VENTA = '$preciov' WHERE ID_PRODUCTO = '$id' ");
                        if($datos->rowCount()>0){
                            echo "
                            <script>
                                showNotification('bottom','center','Tu producto <b>$nombre</b> fue actualizado correctamente','success');
                            </script>";
                        }else{
                            echo "
                            <script>
                                showNotification('bottom','center','Tu producto <b>$barra</b> no fue actualizado ','danger');
                            </script>";
                        }
                }else{
                    $buscar_barra = $conexion->query("SELECT * FROM producto WHERE CODIGO_BARRA = $barra");
                    if($buscar_barra->rowCount()>0){
                        echo "
                        <script>
                            showNotification('bottom','center','El codigo de barras ya existe','danger');
                        </script>";
                    }else{
                        $datos = $conexion->query("UPDATE producto SET NOMBRE='$nombre',STOCK_MINIMO= $stock,CODIGO_BARRA = $barra,PRECIO_COSTO='$precioc',ID_MARCA='$marca',ID_CATEGORIA='$categoria' WHERE ID_PRODUCTO = '$id' ");
                        if($datos->rowCount()>0){
                            echo "
                            <script>
                                showNotification('bottom','center','Tu producto <b>$nombre</b> fue actualizado correctamente','success');
                            </script>";
                        }else{
                            echo "
                            <script>
                                showNotification('bottom','center','Tu producto <b>$barra</b> no fue actualizado ','danger');
                            </script>";
                        }
                    }
                }
            }else{
                echo 'Peticion invalida';
            }
        }
        function imprimir(){
            $this->view->parametros = mainModel::parametros();
            $this->view->conexion = mainModel::conectar();
            $this->view->render('productos/imprimir');
        }
        function preciounidad($param = null){
            $id = $param[0];
            $this->view->brand = "Unidades de medida";
            $this->view->id = $id;
            $this->view->id_nav_active = "producto-active";
            $this->view->id_collapase_active = "almacen";
            $this->view->numero_unidad = $this->numero_unidad($id);
            $this->view->nombre_producto = $this->nombre_producto($id);
            $this->view->list_unidad = $this->list_unidad();
            $this->view->render('productos/precioxunidad');
        }
        function nombre_producto($id){
            $cn = mainModel::conectar();
            $dato = $cn->query("SELECT nombre FROM producto WHERE ID_PRODUCTO ='$id' ");
            return $dato->fetchColumn(0);
        }
        function numero_unidad($id){
            $cn = mainModel::conectar();
            $unidades = $cn->query("SELECT * FROM precio_producto WHERE ID_PRODUCTO = '$id'");
            return $unidades->rowCount();
        }
        function lista_unidad_precio(){
            if(isset($_POST['id'])){
                $id = $_POST['id'];
                $table = "";
                $conexion = mainModel::conectar();
                $datos = $conexion->query("SELECT p.ID_PRECIO,u.PREFIJO,p.UNIDADES,p.PRECIO,p.PRECIO_COSTO FROM precio_producto as p INNER JOIN unidad_medida as u ON u.ID_UNIDAD = p.ID_UNIDAD WHERE p.ID_PRODUCTO = '$id'");
                $n = 1;
                foreach($datos as $rows){
                    $table .="
                        <tr>
                            <td>".$n."</td>
                            <td>".$rows['PREFIJO']."</td>
                            <td>".$rows['UNIDADES']."</td>
                            <td>".$rows['PRECIO']."</td>
                            <td>".$rows['PRECIO_COSTO']."</td>
                            <td class='text-center'>                    
                                <button class='btn-editar btn btn-success btn-sm' onclick='unidadeditar(".$rows['ID_PRECIO'].")' data-toggle='modal' data-target='#editunidad'>
                                    <i class='fas fa-pen'></i>
                                </button>
                            </td>
                        </tr>
                    ";
                    $n++;
                }
                echo $table;
            }
        }
        function precioxunidad(){
            if(isset($_POST["Unidad"]) && isset($_POST["Equivalencia"])){
                $unidad = $_POST["Unidad"];
                $unidades = $_POST["Equivalencia"];
                $costo = $_POST["Precioc"];
                $venta = $_POST["Preciov"];
                $producto = $_POST["Producto"];
                $conexion = mainModel::conectar();
                $evun = $conexion->query("SELECT * FROM precio_producto WHERE ID_PRODUCTO = '$producto' AND ID_UNIDAD = '$unidad'");
                if($evun->rowCount()>0){
                    echo 2;
                }else{
                    $datos = $conexion->query("INSERT INTO `precio_producto`(`ID_PRODUCTO`, `ID_UNIDAD`, `UNIDADES`, `PRECIO`, `PRECIO_COSTO`) VALUES ('$producto','$unidad','$unidades','$venta','$costo')");
                    if($datos->rowCount()>0){
                        echo 1;
                    }
                }
            }
        }
        function formularioeditarunidad(){
            if(isset($_POST["id"])){
                $id = mainModel::clean_string($_POST["id"]);
                $cn = mainModel::conectar();
                $form = "";
                $data = $cn->query("SELECT pp.ID_PRECIO,pp.ID_UNIDAD,um.PREFIJO,pp.PRECIO,pp.PRECIO_COSTO,pp.UNIDADES FROM precio_producto as pp INNER JOIN unidad_medida as um ON um.ID_UNIDAD = pp.ID_UNIDAD WHERE ID_PRECIO = '$id'");
                foreach($data as $rows){
                    $idp = $rows["ID_PRECIO"];
                    $idu = $rows["ID_UNIDAD"];
                    $prefijo = $rows["PREFIJO"];
                    $precio = $rows["PRECIO"];
                    $precio_costo = $rows["PRECIO_COSTO"];
                    $unidades = $rows["UNIDADES"];
                    $form .= "
                        <input type='hidden' value='$idu' class='form-control is-invalid form-control-sm' id='ided-unidad' name='id-update'>
                        <input type='hidden' value='$idp' class='form-control is-invalid form-control-sm' id='ided-producto' name='id-update'>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <label class='bmd-label-floating'>Unidad Medida</label>
                                <select name='unidad_agregar' class='custom-select' disabled>
                                    <option>$prefijo</option>
                                </select>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <div class='form-group'>
                                    <label class='bmd-label-floating'>Equivalencia en unidades</label>
                                    <input type='number' id='unidades-editar' value='$unidades' class='form-control'>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <div class='form-group'>
                                    <label class='bmd-label-floating'>Precio Costo</label>
                                    <input type='number' id='precioc-editar' value='$precio_costo' class='form-control'>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <div class='form-group'>
                                    <label class='bmd-label-floating'>Precio Venta</label>
                                    <input type='number' id='preciov-editar' value='$precio' class='form-control'>
                                </div>
                            </div>
                        </div>  
                    "; 
                }
                echo $form;
            }
        }
        function updateprecioxunidad(){
            if(isset($_POST["Unidad"]) && isset($_POST["Equivalencia"])){
                $unidad = $_POST["Unidad"];
                $unidades = $_POST["Equivalencia"];
                $costo = $_POST["Precioc"];
                $venta = $_POST["Preciov"];
                $precio = $_POST["Precio"];
                $conexion = mainModel::conectar();
                $datos = $conexion->query("UPDATE precio_producto SET UNIDADES = '$unidades', PRECIO = '$venta', PRECIO_COSTO = '$costo' WHERE ID_PRECIO = '$precio' AND ID_UNIDAD = '$unidad'");
                if($datos->rowCount()>0){
                    echo 1;
                }
            }
        }
        function marca_categoria(){
            if(isset($_POST["tocken"])){
                $cn = mainModel::conectar();
                $marcas = $cn->query("SELECT * FROM `marca`");
                if($marcas->rowCount()==0){
                    echo "1";
                }else{
                    $categoria = $cn->query("SELECT * FROM `categoria`");
                    if($categoria->rowCount()==0){
                        echo "2";
                    }else{
                        $unidades = $cn->query("SELECT * FROM `unidad_medida`");
                        if($unidades->rowCount()==0){
                            echo "3";
                        }
                    }
                }
            }
        }
        function exceltomysql(){
            include 'view/vendor/simplexlsx/simplexlsx.class.php';
            $cn  = mainModel::conectar();
            $files_post = $_FILES['file'];
            // crear un array[];
            $files = array();
            // contar la cantidad de ficheros;
            $file_count = count($files_post['name']);
            $n = intval($file_count);
            // retorna un arrar con todas las claves del array
            $file_keys = array_keys($files_post);
            for ($i=0; $i < $file_count; $i++) 
            { 
                foreach ($file_keys as $key) 
                {
                    $files[$i][$key] = $files_post[$key][$i];
                }
            }
            foreach ($files as $fileID => $file)
            {
                $fileContent = file_get_contents($file['tmp_name']);
                $info = new SplFileInfo($file['name']);
                $extension = $info->getExtension();
                $name = mainModel::generar_codigo_aleatorio('EXCEL',7,rand(1,9)).".".$extension;
                file_put_contents("archives/documents/$name", $fileContent);
                $xlsx = new SimpleXLSX("archives/documents/$name");
                foreach ($xlsx->rows() as $fields)
                {
                    $id = $this->generar_codigo_producto();
                    $nombre = $fields[0];
                    $stock = $fields[1];
                    $codigo_barra = $fields[2];
                    $unidad = $fields[3];
                    $marca = $fields[4];
                    $categoria = $fields[5];
                    $unidad = $cn->query("SELECT ID_UNIDAD FROM unidad_medida WHERE PREFIJO = '$unidad'");
                    $id_unidad = $unidad->fetchColumn(0);
                    $marca = $cn->query("SELECT ID_MARCA FROM marca WHERE NOMBRE = '$marca'");
                    $id_marca = $marca->fetchColumn(0);
                    $categoria = $cn->query("SELECT ID_CATEGORIA FROM categoria WHERE NOMBRE = '$categoria'");
                    $id_categoria = $categoria->fetchColumn(0);
                    $precio_costo = $fields[6];
                    $precio_venta = $fields[7];
                    if($nombre != "NOMBRE" && $stock != "STOCK_MINIMO" && $codigo_barra != "CODIGO_BARRA" && $nombre != "" && $stock != "" && $codigo_barra != ""){
                        $producto = $cn->query("INSERT INTO `producto`(`ID_PRODUCTO`, `NOMBRE`, `STOCK_MINIMO`, `CODIGO_BARRA`, `ID_UNIDAD`, `ID_MARCA`, `ID_CATEGORIA`, `PRECIO_COSTO`, `PRECIO_VENTA`) VALUES ('$id','$nombre','$stock','$codigo_barra','$id_unidad','$id_marca','$id_categoria','$precio_costo','$precio_venta')");
                        if($producto->rowCount()>0){
                            $precio_unidad = $cn->query("INSERT INTO `precio_producto`(`ID_PRODUCTO`, `ID_UNIDAD`, `UNIDADES`, `PRECIO`, `PRECIO_COSTO`) VALUES ('$id','$id_unidad',1,'$precio_venta','$precio_costo')");
                        }
                    }
                }
            }
            echo 1;
        }
        function templeate(){
            $this->view->conexion = mainModel::conectar();
            $this->view->render('productos/plantillaexcel');
        }
        function codebar($param = null){
            $id = $param[0];
            $this->view->id = $id;
            $this->view->conexion = mainModel::conectar();
            $this->view->render('productos/codebar');
        }
        function ticket(){
            $this->view->render('productos/ticket');
        }
    }