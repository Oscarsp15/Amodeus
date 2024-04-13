<?php
    class Almacen extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->id_nav_active = "almacen-active";
            $this->view->id_collapase_active = "entrada_salida";
            $this->view->listarAlmacen = $this->listarAlmacen();
            $this->view->producto_stock_bajo = $this->producto_stock_bajo();
            $this->view->producto = $this->producto();
            $this->view->valor_inventario = $this->valor_inventario();
            $this->view->parametros = mainModel::parametros();
            $this->view->brand = "Almacén";
            $this->view->render('almacen/index');
        }
        function valor_inventario(){
            $total = 0;
            $conexion = mainModel::conectar();
            $datos = $conexion->query("SELECT pp.STOCK,p.PRECIO_COSTO FROM productos_almacen as pp INNER JOIN producto as p ON pp.ID_PRODUCTO = p.ID_PRODUCTO");
            foreach($datos as $rows){
                $stock = $rows["STOCK"];
                $precio = $rows["PRECIO_COSTO"];
                $total += $stock*$precio;
            }
            return number_format($total,2);
        }
        function producto_stock_bajo(){
            $cn = mainModel::conectar();
            $datos = $cn->query("SELECT pp.STOCK,p.STOCK_MINIMO FROM productos_almacen as pp INNER JOIN producto as p on pp.ID_PRODUCTO = p.ID_PRODUCTO WHERE pp.STOCK <= p.STOCK_MINIMO");
            $num = $datos->rowCount();
            return $num;
        }
        function producto(){
            $cn = mainModel::conectar();
            $datos = $cn->query("SELECT * FROM productos_almacen ");
            $num = $datos->rowCount();
            return $num;
        }
        public function listarAlmacen(){
            $tabla = "";
            $conexion = mainModel::conectar();
            $parametros = mainModel::parametros();
            $MONEDA = $parametros["Moneda"];
            $datos = $conexion->query("SELECT a.ID_PA,p.PRECIO_COSTO,p.PRECIO_VENTA, p.NOMBRE , um.PREFIJO , a.STOCK,m.NOMBRE as 'MARCA', c.NOMBRE as 'CATEGORIA' FROM productos_almacen as a INNER JOIN producto as p ON a.ID_PRODUCTO = p.ID_PRODUCTO INNER JOIN marca as m on p.ID_MARCA = m.ID_MARCA INNER JOIN categoria as c on p.ID_CATEGORIA = c.ID_CATEGORIA INNER JOIN unidad_medida as um ON p.ID_UNIDAD = um.ID_UNIDAD");
            foreach($datos as $rows){
                $tabla .="
                    <tr>
                        <td>".$rows['ID_PA']."</td>
                        <td>".$rows['NOMBRE']."</td>
                        <td>".$rows['STOCK']." ".$rows['PREFIJO']."</td>
                        <td>".$MONEDA.$rows['PRECIO_COSTO']."</td>
                        <td>".$MONEDA.$rows['PRECIO_VENTA']."</td>
                        <td>".$rows['MARCA']."</td>
                        <td>".$rows['CATEGORIA']."</td>
                    </tr>
                ";
            }
            return $tabla;
        }
        public function excelproducto(){
            $this->view->conexion = mainModel::conectar();
            $this->view->render('almacen/reporteexcel');
        }
    }