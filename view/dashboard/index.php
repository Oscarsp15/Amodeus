
<?php require 'view/templeate/head.php';?>
<?php
    if(!$_SESSION["dashboard"]){
        echo "
        <script>
            location.href = '".SERVERURL."acerca/';
        </script>
        ";
    }
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
              <div class="card card-chart">
                <div class="card-header card-header-success">
                  <div class="ct-chart" id="ventasemanal"></div>
                </div>
                <div class="card-body">
                    <h4 class="card-title">Venta Semanal</h4>
                    <p class="card-category" id="pocentaje_diario">
                        
                    </p>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    Actualizado Ahora
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card card-chart">
                <div class="card-header card-header-info">
                  <div class="ct-chart" id="ventasyear"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Ventas Mensuales</h4>
                  <p class="card-category"  id="porcentaje_mensual">
                   </p>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    Actualizado Ahora
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <div class="card card-stats">
                    <div class="card-header card-header-success-amosis card-header-icon">
                        <div class="card-icon" data-header-animation="true">
                            <i class="fa fa-truck"></i>
                        </div>
                        <p class="card-category">Proveedores</p>
                        <h3 class="card-title"><?=$this->proveedor;?></h3>
                    </div>
                    <div class="card-footer">
                        <a href="<?=SERVERURL;?>proveedor/nuevoproveedor/" class="btn btn-sm btn-primary text-white">
                            <i class="fa fa-1x fa-plus"></i> Nuevo Proveedor
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="card card-stats">
                    <div class="card-header card-header-product-amosis card-header-icon">
                        <div class="card-icon" data-header-animation="true">
                            <i class="fa fa-box-open"></i>
                        </div>
                        <p class="card-category">Productos</p>
                        <h3 class="card-title"><?=$this->producto;?></h3>
                    </div>
                    <div class="card-footer">
                        <a href="<?=SERVERURL;?>productos/nuevoproducto/" class="btn btn-sm btn-primary text-white">
                            <i class="fa fa-1x fa-plus"></i> Nuevo Producto
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="card card-stats">
                    <div class="card-header card-header-marcas-amosis card-header-icon">
                        <div class="card-icon" data-header-animation="true">
                            <i class="fa fa-street-view"></i>
                        </div>
                        <p class="card-category">Marcas</p>
                        <h3 class="card-title"><?=$this->marca;?></h3>
                    </div>
                    <div class="card-footer">
                        <a href="<?=SERVERURL;?>marca/" class="btn btn-sm btn-primary text-white">
                            <i class="fa fa-1x fa-plus"></i> Nueva Marca
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="card card-stats">
                    <div class="card-header card-header-categoria-amosis card-header-icon">
                        <div class="card-icon" data-header-animation="true">
                            <i class="fa fa-book-open"></i>
                        </div>
                        <p class="card-category">Categorias</p>
                        <h3 class="card-title"><?=$this->categoria;?></h3>
                    </div>
                    <div class="card-footer">
                        <a href="<?=SERVERURL;?>categoria/" class="btn btn-sm btn-primary text-white">
                            <i class="fa fa-1x fa-plus"></i> Nueva Categoria
                        </a>
                    </div>
                </div>
            </div> 
            <div class="col-md-3 col-sm-4">
                <div class="card card-stats">
                    <div class="card-header card-header-um-amosis card-header-icon">
                        <div class="card-icon" data-header-animation="true">
                            <i class="fa fa-balance-scale-right"></i>
                        </div>
                        <p class="card-category">Unidades de Medida</p>
                        <h3 class="card-title"><?=$this->unidad_medida;?></h3>
                    </div>
                    <div class="card-footer">
                        <a href="<?=SERVERURL;?>unidadmedida/" class="btn btn-sm btn-primary text-white">
                            <i class="fa fa-1x fa-plus"></i> Nueva UM
                        </a>
                    </div>
                </div>
            </div>        
            <div class="col-md-3 col-sm-4">
                <div class="card card-stats">
                    <div class="card-header card-header-info-amosis card-header-icon">
                        <div class="card-icon" data-header-animation="true">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        <p class="card-category">Productos en Almacén</p>
                        <h3 class="card-title"><?=$this->productos_almacen;?></h3>
                    </div>
                    <div class="card-footer">
                        <a href="<?=SERVERURL;?>almacen/" class="btn btn-sm btn-primary text-white">
                            Ver Productos 
                        </a>
                    </div>
                </div>
            </div>        
            <div class="col-md-3 col-sm-4">
                <div class="card card-stats">
                    <div class="card-header card-header-entrada-amosis card-header-icon">
                        <div class="card-icon" data-header-animation="true">
                            <i class="fas fa-cart-plus"></i>
                        </div>
                        <p class="card-category">Entradas de Producto</p>
                        <h3 class="card-title"><?=$this->entrada_producto;?></h3>
                    </div>
                    <div class="card-footer">
                        <a href="<?=SERVERURL;?>entradaproducto/nuevoentrada/" class="btn btn-sm btn-primary text-white">
                            <i class="fa fa-1x fa-plus"></i> Nueva Entrada
                        </a>
                    </div>
                </div>
            </div>        
            <div class="col-md-3 col-sm-4">
                <div class="card card-stats">
                    <div class="card-header card-header-salida-amosis card-header-icon">
                        <div class="card-icon" data-header-animation="true">
                            <i class="fas fa-cart-arrow-down"></i>
                        </div>
                        <p class="card-category">Salidas de Producto</p>
                        <h3 class="card-title"><?=$this->salida_producto;?></h3>
                    </div>
                    <div class="card-footer">
                        <a href="<?=SERVERURL;?>salidaproducto/nuevosalida/" class="btn btn-sm btn-primary text-white">
                            <i class="fa fa-1x fa-plus"></i> Nueva Salida
                        </a>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</div>
<?php require 'view/templeate/footer.php';?>

<script>
    $(document).ready(function(){
        let lunes = 0;
        let martes = 0;
        let miercoles = 0;
        let jueves = 0;
        let viernes = 0;
        let sabado = 0;
        let domingo = 0;
        $.post('<?=SERVERURL;?>dashboard/dia',{},function(res){
            var resd = res.split('|');
            lunes = parseInt(resd[0]);
            martes =  parseInt(resd[1]);
            miercoles =  parseInt(resd[2]);
            jueves =  parseInt(resd[3]);
            viernes =  parseInt(resd[4]);
            sabado =  parseInt(resd[5]);
            domingo = parseInt(resd[6]);
            new Chartist.Line("#ventasemanal",{
                labels: ['L','M','M','J','V','S','D'],
                series: [
                    [lunes,martes,miercoles,jueves,viernes,sabado,domingo]
                ]
            },{
                fullWidth: true
            }
            );
            $.post('<?=SERVERURL;?>dashboard/porcentaje_diario',{},function(res){
                $("#pocentaje_diario").html(res);
            });
        });
        $.post('<?=SERVERURL;?>dashboard/mes',{},function(res){
            var resd = res.split('|');
            let m1 = parseInt(resd[0]);
            let m2 =  parseInt(resd[1]);
            let m3 =  parseInt(resd[2]);
            let m4 =  parseInt(resd[3]);
            let m5 =  parseInt(resd[4]);
            let m6 =  parseInt(resd[5]);
            let m7 = parseInt(resd[6]);
            let m8 = parseInt(resd[7]);
            let m9 = parseInt(resd[8]);
            let m10 = parseInt(resd[9]);
            let m11 = parseInt(resd[10]);
            let m12 = parseInt(resd[11]);
            new Chartist.Line("#ventasyear",{
                labels: ['E','F','M','A','M','J','J','A','S','O','N','D'],
                series: [
                    [m1,m2,m3,m4,m5,m6,m7,m8,m9,m10,m11,m12]
                ]
                },{
                    fullWidth: true
                }
            );
            $.post('<?=SERVERURL;?>dashboard/porcentaje_mensual',{},function(res){
                $("#porcentaje_mensual").html(res);
            });
        });
    });
</script>
<!-- ,{
            fullWidth: true,
            chartPadding:{
                right:40
            }
        } -->