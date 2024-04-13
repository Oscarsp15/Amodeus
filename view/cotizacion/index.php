<?php require 'view/templeate/head.php';
    $parametros = $this->parametros;
    $MONEDA = $parametros["Moneda"];
?>
<?php
    if(!$_SESSION["cotizacion"]){
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
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header card-header-amosis">
                        <h4 class="card-title">COTIZACION</h4>
                        <p class="card-category">Agrege los productos para la cotizacion</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div id="caja" class="col-sm-9"></div>
                            <div class="col-sm-3">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Codigo de Barras</label>
                                    <input id="compra" type="number" class="form-control">
                                </div>
                                <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#verproductos">Ver Productos</button>
                                <button class="btn btn-block btn-success" data-toggle="modal" data-target="#cotizacionModal">Finalizar Cotizacion</button>
                                <div id="verproductos" class="modal fade" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5>Lista de productos</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body table-responsive">
                                                <table id="tb-prov" class="w-100 table table-hover table-sm table-striped">
                                                    <thead class="text-primary-amosis">
                                                        <tr>
                                                            <th>Código</th>
                                                            <th>Producto</th>
                                                            <th>Cod. Barras</th>
                                                            <th>Marca</th>
                                                            <th>Stock</th>
                                                            <th>Opcion</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?=$this->lista_producto;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="shop-panel text-white bg-red">
                                    <h5><i class="fa fa-bars" aria-hidden="true"></i> Total:</h5>
                                    <h3><strong><?=$MONEDA;?></strong><strong class="final-price">0</strong></h3>
                                </div>
                                <div class="form-group mt-4 bmd-form-group">
                                    <label class="bmd-label-floating">N° Identificacion del cliente</label>
                                    <input id="identificacion" name="identificacion" type="number" class="form-control">
                                </div>
                                <div class="form-group bmd-form-group">
                                    <button id="b-cliente" class="btn btn-block btn-primary">Buscar</button>
                                </div>
                                <div class="form-group bmd-form-group">
                                    <label class="control-label bmd-label-static">Nombre del cliente</label>
                                    <input id="nombre" name="nombre-c" type="text" class="form-control">
                                </div>
                                <div class="form-group bmd-form-group">
                                    <label class="control-label bmd-label-static">Direccion del cliente</label>
                                    <input id="direccion" name="direccion-c" type="text" class="form-control">
                                </div>
                            </div>
                            <!-- INPUT PARA CONTAR LA SUMA -->
                            <input type="hidden" id="suma">
                            <input type="hidden" value="<?=$this->codigo_cotizacion;?>" id="cod_cotizacion">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODAL GENERAR COTIZACION -->
<div class="modal fade" id="cotizacionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="margin-top: 10%;">
    <div class="modal-content">
        <div class='modal-header'>Generar Cotizacion</div>
        <div class="modal-body text-center">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label class="bmd-label-floating">Forma de Entrega</label>
                        <select name="unidad_agregar" id = "tipo_entrega"class="custom-select">        
                            <option value="1" selected="">Por Pedido</option>
                            <option value="2">Entrega Imediata</option> 
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
                    <div class="form-group">
                        <label class="">Descuento</label>
                        <input type="number" id="descuento" class="form-control">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="togglebutton">
                        <label>
                        <input type="checkbox" id="ticket" checked="">
                        <span class="toggle"></span>
                            Visualizar
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                       <input type="button" id="finalizar" class="btn btn-primary" value="Finalizar">
                    </div>
                </div> 
            </div>
        </div>
    </div>
  </div>
</div>
<div class="modal fade" id="productoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top: 10%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="modal-body">
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group is-filled">
                                <input type="hidden" name="nombre-agregar" class="form-control" id="id-producto">
                                <label class="">Nombre de Producto</label>
                                <input type="text" name="nombre-agregar" class="form-control" id="productod" disabled>
                                <input type="hidden" name="nombre-agregar" class="form-control" id="producto">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group bmd-form-group is-filled">
                                    <select id="unidad" class="custom-select">
                                        <option>Seleccionar unidad</option>
                                    </select>
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group is-filled">
                                <label class="">Precio por unidad</label>
                                <input type="number" class="form-control" disabled id="preciod">
                                <input type="hidden" class="form-control" id="precio">
                                <input type="hidden" class="form-control" id="stock">
                                <input type="hidden" class="form-control" id="uniequivalent">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group is-filled">
                                <label class="">Cantidad</label>
                                <input type="number" name="cantidadproductomodal" class="form-control" id="cantidadproductomodal" required="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-modal-agregar-producto" class="btn btn-primary">AGREGAR</button>
            </div>
        </div>
    </div>
</div>

<?php require 'view/templeate/footer.php';?>
<script src="<?=SERVERURL;?>view/assets/js/box.js"></script>
<script>
    // Enviar Datos de la coticacion
    function SendDataCotizacion(){
        //capturar los items de la caja
        let usuario = "<?=$_SESSION["usuario"];?>";
        var caja = $('#caja .item-primary').length;
        var data = '';
        //recorrer los items de la caja
        for (i = 1; i < caja + 1; i++){
            // capturar el id del producto
            var idp = $('#caja>.item-primary:nth-child('+i+')').attr('data-id');
            // capturar la cantidad solicidada
            var idc = $('#pro-n-'+idp+' .pro-n').text();
            //detalle del item
            var detallepro = $('#pro-n-'+idp+' .pro-d').text();
            //unidad de medida
            var idum = $('#caja>.item-primary:nth-child('+i+')').attr('data-idum');
            //equivalente de la unidad en unidades
            var equivalente = $('#caja>.item-primary:nth-child('+i+')').attr('data-equi');
            //precio
            var precio = $('#caja>.item-primary:nth-child('+i+')').attr('data-price');
            // llenarlas todo en un arreglo
            data += idp+'|'+detallepro+'|'+idc+'|'+idum+'|'+equivalente+'|'+precio+',';
        };
        //llenar los productos en una variable
        var productos = data;

        //VENTA  CODIGO
        let venta_cod = $("#cod_cotizacion").val();

        // CLIENTE
        let doc = $("#identificacion").val();
        let nombre_c = $("#nombre").val();
        let direccion = $("#direccion").val();

        //Cotizacion
        let descuento = $("#descuento").val();
        var subtotal = $('#suma').val();
        if (descuento == "" || descuento.length == 0){
            descuento = 0.00;
        }
        subtotal = parseFloat(subtotal);
        descuento = parseFloat(descuento);
        let total = subtotal - descuento;
        if (data == ''){
            showNotification('bottom','center','No tienes productos en caja','danger');
            return;
        }
        if(descuento>subtotal){
            showNotification('bottom','center','El descuento no puede ser mayor al total','danger');
            return false;
        }
        let tipo = $("#tipo_entrega").val();
        total = parseFloat(total);
        var sndVenta = 'productos='+data+'&subtotal='+subtotal+'&descuento='+descuento+'&total='+total+'&doc='+doc+'&nombre_c='+nombre_c+'&direccion='+direccion+'&venta='+venta_cod+'&usuario='+usuario+'&tipo='+tipo;        
        $.post("<?=SERVERURL;?>cotizacion/nuevacotizacion/",sndVenta,function(res){
            if(res == 1){
                showNotification('bottom','center','Cotizacion guardada exitosamente','success');
                if($("#ticket").prop('checked')){
                    window.open('<?=SERVERURL;?>cotizacion/imprimircotizacion/'+venta_cod, "_blank", "resizable=yes, scrollbars=yes, titlebar=yes, width=800, height=1000, top=1, left=1");
                }
                setTimeout(function(){
                    location.reload();
                },1000);
            }else{
                showNotification('bottom','center','No se pudo guardar la cotizacion','danger');
                setTimeout(function(){
                    location.reload();
                },1000);
            }
        });
    }
    // Buscar por codigo de barras
    $('#compra').on('change', function(){
        let codigo = $(this).val();
        $.post('<?=SERVERURL;?>caja/barra_producto/',{codigo},function(res){
            if (res == 1){
                showNotification('bottom','center','El producto no existe','danger');
            }else if(res == 2){
                showNotification('bottom','center','El producto ya no cuenta existencia','warning');
            }else{
                var resd = res.split('|');
                let idproducto = resd[2];
                if(document.getElementById("pro-n-"+idproducto)){
                    showNotification('bottom','center','El producto ya fue añadido a la lista','warning');
                    $("#verproductos").modal("hide");
                }else{
                    $("#productoModal").modal("show");
                    $("#verproductos").modal("hide");
                    // htmlpro(resd[0],resd[1],resd[2]);
                    $("#stock").val(resd[1]);
                    $("#id-producto").val(resd[2]);
                    $("#producto").val(resd[0]);
                    $("#productod").val(resd[0]);
                    $("#unidad").html(resd[3]);
                    let id = $("#unidad").val();
                    $.post("<?=SERVERURL;?>unidadmedida/preciou3",{id},function(res){
                        let resq = res.split('|');
                        $("#preciod").val(resq[0]);
                        $("#precio").val(resq[0]);
                        $("#uniequivalent").val(resq[1]);
                    });
                }
            }
            $('#caja>.item:nth-child(1)').on('click', function(){
                var dt = $(this).attr('data-id');
                $('#caja>.item').removeClass('p-active');
                $('#pro-n-'+dt).addClass('p-active');
            });
        });
        ("#compra").val("");
    });
    // buscar clientes
    function buscarcliente(id){
        $.post('<?=SERVERURL;?>caja/buscarcliente/',{id},function(res){
            if (res == 1){
                showNotification('bottom','center','El cliente no existe','danger');
                $("#nombre").val();
                $("#direccion").val();
                return;
            }else{
                var resd = res.split('|');
                $("#nombre").val(resd[1]);
                $("#direccion").val(resd[2]);
            }
        });
    }
    // selecccionar un producto con el boton 
    $(document).on('click','.btn-seleccionar',function(){
        let codigo = $(this).val();
        $.post('<?=SERVERURL;?>caja/barra_producto/',{codigo},function(res){
            if (res == 1){
                showNotification('bottom','center','El producto no existe','danger');
            }else if(res == 2){
                showNotification('bottom','center','El producto ya no cuenta existencia','warning');
            }else{
                var resd = res.split('|');
                let idproducto = resd[2];
                if(document.getElementById("pro-n-"+idproducto)){
                    showNotification('bottom','center','El producto ya fue añadido a la lista','warning');
                    $("#verproductos").modal("hide");
                }else{
                    $("#productoModal").modal("show");
                    $("#verproductos").modal("hide");
                    // htmlpro(resd[0],resd[1],resd[2]);
                    $("#stock").val(resd[1]);
                    $("#id-producto").val(resd[2]);
                    $("#producto").val(resd[0]);
                    $("#productod").val(resd[0]);
                    $("#unidad").html(resd[3]);
                    let id = $("#unidad").val();
                    $.post("<?=SERVERURL;?>unidadmedida/preciou3",{id},function(res){
                        let resq = res.split('|');
                        $("#preciod").val(resq[0]);
                        $("#precio").val(resq[0]);
                        $("#uniequivalent").val(resq[1]);
                    });
                }
            }
            $('#caja>.item:nth-child(1)').on('click', function(){
                var dt = $(this).attr('data-id');
                $('#caja>.item').removeClass('p-active');
                $('#pro-n-'+dt).addClass('p-active');
            });
        });
    });
    // buscar unidades de medida disponibles
    $("#unidad").change(function(){
        let id = $(this).val();
        $.post("<?=SERVERURL;?>unidadmedida/preciou3",{id},function(res){
            let resq = res.split('|');
            $("#preciod").val(resq[0]);
            $("#precio").val(resq[0]);
            $("#uniequivalent").val(resq[1]);
        });
    });
    // agregar productos a caja
    $("#btn-modal-agregar-producto").click(function(){
        let cantidad = $("#cantidadproductomodal").val();
        if(cantidad.length == 0 || cantidad == 0){
            showNotification('bottom','center','Debes de agregar una cantidad','warning');
        }else{
            let stock = parseInt($("#stock").val());
            let equivalente = parseInt($("#uniequivalent").val());
            let precio = $("#precio").val();
            let producto = $("#producto").val();
            let idproducto = $("#id-producto").val();
            let combo = document.getElementById("unidad");
            let selected = combo.options[combo.selectedIndex].text;
            let comboval = combo.value;
            let solicitudtotal = cantidad*equivalente;
            if(solicitudtotal>stock){
                showNotification('bottom','center','La cantidad solicitada excede del stock','warning');
            }else{
                let stock_equivalente = parseInt(stock / equivalente);
                let moneda = "<?=$MONEDA?>";
                htmlpro(producto,stock_equivalente,idproducto,cantidad,comboval,selected,precio,equivalente,moneda);
                $("#productoModal").modal("hide");
                $("#cantidadproductomodal").val("");
                $("#compra").val("");
            }
        }
    });
    // Finalizar
    $('#finalizar').click(function(){
        let numero = $('#identificacion').val();
        let nombre = $('#nombre').val();
        if(numero.length == 0 || nombre.length == 0){
            showNotification('bottom','center','El numero de identificacion y el nombre del cliente es obligatorio','danger');
        }else{
            SendDataCotizacion();
        }
    });
</script>