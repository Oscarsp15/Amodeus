<?php 
    require 'view/templeate/head.php';
    $parametros = $this->parametros;
    $MONEDA = $parametros["Moneda"];
?>
<?php
    if(!$_SESSION["ventas"]){
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
                        <h4 class="card-title">POS</h4>
                        <p class="card-category">Agrege los productos para una venta</p>
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
                                <button class="btn btn-block btn-success" id="finalizarventa" >Confirmar Venta</button>
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
                                    <h3><strong ><?=$MONEDA;?></strong><strong class="final-price">0</strong></h3>
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
                                <div class="shop-panel mt-2  text-white bg-blue">
                                    <h5><i class="fa fa-bars" aria-hidden="true"></i> Cambio:</h5>
                                    <h4 class="btn-block"><strong class="cambio"><?=$MONEDA;?>0</strong></h4>
                                </div>
                                <div class="form-group bmd-form-group">
                                    <button class="btn btn-block btn-rose" data-toggle="modal" data-target="#cancelarticket">Cancelar Ticket</button>
                                    
                                    <div id="cancelarticket" class="modal fade" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5>Cancelar Ticket</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group bmd-form-group">
                                                                <label class="bmd-label-floating">N° Ticket</label>
                                                                <input type="text" id="nticket" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- INPUT PARA CONTAR LA SUMA -->
                            <input type="hidden" id="suma">
                            <input type="hidden" value="<?=$this->codigo_venta;?>" id="cod_venta">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODAL GENERAR COMPRA -->
<div class="modal fade" id="pagoconModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="margin-top: 10%;">
    <div class="modal-content">
        <div class="modal-body text-center">
            <div class="card card-nav-tabs">
                <div class="card-header card-header-amosis">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="nav-item">
                          <a class="nav-link active" href="#contado" data-toggle="tab">
                            Pago al contado
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#credito" data-toggle="tab">
                            Pago a credito
                          <div class="ripple-container"></div></a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body ">
                  <div class="tab-content text-center">
                    <div class="tab-pane active" id="contado">
                        <h5>Total a Pagar</h5>
                        <h3><?=$MONEDA;?><span  id="paga_contado"> 0.00</span></h3>
                        <div class="form-group bmd-form-group">
                            <label class="control-label bmd-label-static">Descuento</label>
                            <input id="descuentocontado" value = "0.00" type="number" class="form-control">
                        </div>
                        <div class="form-group bmd-form-group">
                            <label class="control-label bmd-label-static">Pago con:</label>
                            <input type="number" placeholder="100.00" id="pagocon" class="form-control">
                        </div> 
                        <div class="col-md-12">
                            <div class="togglebutton">
                                <label>
                                <input type="checkbox" id="ticket">
                                <span class="toggle"></span>
                                    Visualizar Ticket
                                </label>
                            </div>
                            <div class="togglebutton">
                                <label>
                                <input type="checkbox" id="ticket2" checked="">
                                <span class="toggle"></span>
                                    Imprimir Ticket
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="credito">
                        <h5>Total a Pagar</h5>
                        <h3><?=$MONEDA;?><span  id="paga_credito"> 0.00</span></h3>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group bmd-form-group">
                                    <label class="control-label bmd-label-static">Fecha de Pago</label>
                                    <input id="fechapago" type="number" placeholder="12" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group bmd-form-group">
                                    <label class="control-label bmd-label-static">N° Meses</label>
                                    <input id="meses" placeholder="5"  type="number" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group bmd-form-group">
                                    <label class="control-label bmd-label-static">Descuento</label>
                                    <input id="descuentocredito" value="0.00" type="number" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="control-label bmd-label-static">Inicial</label>
                                    <input id="inicial" value="0.00" type="number" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="control-label bmd-label-static">Tasa de Interes %</label>
                                    <input id="interes" value="0.00" type="number" class="form-control">
                                </div>
                            </div>   
                            <div class="col-sm-12 form-group bmd-form-group">
                                <button id="calcular_credito" class="btn btn-block btn-primary">Calcular Cuota Mensual</button>
                            </div>
                            <div class="col-sm-12 form-group bmd-form-group">
                                <div class="form-group bmd-form-group">
                                    <label class="control-label bmd-label-static">Cuota Mensual</label>
                                    <input id="cuotamensual" type="number" placeholder="23.00" class="form-control">
                                </div>
                            </div>
                        </div>
                        Pago la inicial con:
                        <input type="number" id="pagocon2" placeholder="21.00"  class="form-control text-center">
                        <div class="col-md-12 text-left">
                            <div class="togglebutton">
                                <label>
                                <input type="checkbox" id="ticket_inicial">
                                <span class="toggle"></span>
                                    Visualizar Ticket de la Inicial
                                </label>
                            </div>
                            <div class="togglebutton">
                                <label>
                                <input type="checkbox" id="ticket_inicial_imprimir" checked="">
                                <span class="toggle"></span>
                                    Imprimir Ticket de la Inicial
                                </label>
                            </div>
                            <div class="togglebutton">
                                <label>
                                <input type="checkbox" id="cronograma_inicial_imprimir" checked="">
                                <span class="toggle"></span>
                                    Visualizar Cronograma de Pagos
                                </label>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="container">
                <button type="button" id="btn_terminar_venta" class="btn btn-primary">TERMINAR VENTA</button>
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
                                <input type="number" name="cantidadproductomodal" value = "1" class="form-control" id="cantidadproductomodal" required="">
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
    $(document).ready(function () {
        let evaluarcaja = <?=$_SESSION['turno']?>;
        if(!evaluarcaja){
            showNotification('bottom','center','Aun no has abierto tu turno','danger');
            setTimeout(function(){
                location.href = "<?=SERVERURL;?>turnos/";
            },2000);
        }
    });
    function SendDataCaja(){
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
        if($("#contado").hasClass("active")){  
            //VENTA  CODIGO
            let venta_cod = $("#cod_venta").val();
            // CLIENTE
            let doc = $("#identificacion").val();
            let nombre_c = $("#nombre").val();
            let direccion = $("#direccion").val();
            //VENTA
            let descuento = $("#descuentocontado").val();
            var subtotal = $('#suma').val();
            var pagocon = $('#pagocon').val();
            if(pagocon == ""){
                 // LA CANTIDAD A PAGAR NO PUEDE SER MENOR
                showNotification('bottom','center','La cantidad a pagar no puede ser menor a el total de la compra','danger');
                return;
            }
            if (descuento == ""){
                descuento = 0.00;
            }
            subtotal = parseFloat(subtotal);
            descuento = parseFloat(descuento);
            let total = subtotal - descuento;
            var op1 = parseFloat(pagocon);
            var op2 = parseFloat(total);
            var turno = "<?=$_SESSION['idturno']?>";
            //vuelto
            var check = pagocon - total;
            //evaluar pago
            if (op1 < op2){
                // LA CANTIDAD A PAGAR NO PUEDE SER MENOR
                showNotification('bottom','center','La cantidad a pagar no puede ser menor a el total de la compra','danger');
                return;
            }
            //cambio
            var cambio = op1 - op2;
            if (cambio == 0){
                var cambio = 0.00;
            }
            if (data == ''){
                showNotification('bottom','center','No tienes productos en caja','danger');
                return;
            }
            $('.cambio').text('<?=$MONEDA;?>'+cambio);
            var sndVenta = p[0]+'productos='+data+'&subtotal='+subtotal+'&descuento='+descuento+'&total='+total+'&pagocon='+op1+'&cambio='+cambio+'&doc='+doc+'&nombre_c='+nombre_c+'&direccion='+direccion+'&venta='+venta_cod+'&usuario='+usuario+'&turno='+turno;        
            $.post("<?=SERVERURL;?>caja/pago_contado",sndVenta,function(res){
                if($("#ticket2").prop('checked')){
                    window.open('<?=SERVERURL;?>contado/imprimirticket/'+venta_cod, "_blank", "resizable=yes, scrollbars=yes, titlebar=yes, width=20, height=20, top=1, left=1");
                }
                if($("#ticket").prop('checked')){
                    window.open('<?=SERVERURL;?>caja/verticket/'+venta_cod, "_blank", "resizable=yes, scrollbars=yes, titlebar=yes, width=400, height=800, top=1, left=1");
                }
                $('#pagocon').prop('disabled', false);
                $('#pagoconModal').modal('toggle');
                $('#suma').val('0');
                $('#pagocon').val('');
                $('#caja').html('');
                $('#compra').focus();
                setTimeout(function(){
                    $('.final-price').text('0');
                    $('.cambio').text('');
                    location.reload();
                },2000);
            });
        }else if($("#credito").hasClass("active")){
            //VENTA  CODIGO
            let venta_cod = $("#cod_venta").val();
            let doc = $("#identificacion").val();
            let nombre_c = $("#nombre").val();
            let direccion = $("#direccion").val();
            if(nombre_c == "" || doc == ""){
                showNotification('bottom','center','Los datos del cliente son obligatorios','danger');
                return;
            }else{
                let fecha = $("#fechapago").val();
                if(fecha == ""){
                    showNotification('bottom','center','La fecha debe ser rellenada','danger');
                    return;
                }else{
                    let meses = $("#meses").val();
                    let inicial = $("#inicial").val();
                    let subtotal = $("#suma").val();
                    let descuentocredito = $("#descuentocredito").val();
                    if(descuentocredito == ""){
                        descuentocredito = 0.00;
                    }
                    let interes = $("#interes").val();
                    if(interes == ""){
                        interes = 0.00;
                    }
                    if(inicial == ""){
                        inicial = 0.00;
                    }
                    subtotal = parseFloat(subtotal);
                    descuentocredito = parseFloat(descuentocredito);
                    subtotal = subtotal - descuentocredito;
                    let total = $("#suma").val();
                    let pagocon = $("#pagocon2").val();
                    pagocon = parseFloat(pagocon);
                    let cuotamensual = $("#cuotamensual").val();
                    if(inicial == "" || cuotamensual == "" || meses == "" ){
                        showNotification('bottom','center','Todos los campos deben ser completados','danger');
                        return;
                    }else{
                        if(pagocon < inicial){
                            showNotification('bottom','center','El pago no puede ser menor a la inicial','danger');
                            return;
                        }else{
                            let cambio = pagocon - inicial;
                            $('.cambio').text('Q'+cambio);
                            var sndVenta = p[0]+'productos='+data+'&subtotal='+subtotal+'&descuentocredito='+descuentocredito+'&interes='+interes+'&total='+total+'&pagocon='+pagocon+'&cambio='+cambio+'&doc='+doc+'&nombre_c='+nombre_c+'&direccion='+direccion+'&venta='+venta_cod+'&usuario='+usuario+'&fecha='+fecha+'&meses='+meses+'&inicial='+inicial+'&cuotamensual='+cuotamensual;        
                            $.post("<?=SERVERURL;?>caja/pago_credito",sndVenta,function(res){
                                if($("#ticket_inicial_imprimir").prop('checked')){
                                    window.open('<?=SERVERURL;?>credito/imprimir_ticket_inicial/'+venta_cod, "_blank", "resizable=yes, scrollbars=yes, titlebar=yes, width=400, height=800, top=1, left=1");
                                }
                                if($("#ticket_inicial").prop('checked')){
                                    window.open('<?=SERVERURL;?>credito/ticketinicial/'+venta_cod, "_blank", "resizable=yes, scrollbars=yes, titlebar=yes, width=400, height=800, top=1, left=1");
                                }
                                if($("#cronograma_inicial_imprimir").prop('checked')){
                                    window.open('<?=SERVERURL;?>credito/cronogramapago/'+venta_cod, "_blank", "resizable=yes, scrollbars=yes, titlebar=yes,  width=700, height=485, top=1, left=1");
                                }
                                $('#pagocon').prop('disabled', false);
                                $('#pagoconModal').modal('toggle');
                                $('#suma').val('0');
                                $('#pagocon').val('');
                                $('#caja').html('');
                                $('#compra').focus();
                                setTimeout(function(){
                                    $('.final-price').text('0');
                                    $('.cambio').text('');
                                    location.reload();
                                },4000);
                            });
                        }
                    }

                }
            }
        }

    }

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
    $("#calcular_credito").click(function(){
        let meses = $("#meses").val();
        let inicial = $("#inicial").val();
        let subtotal = $("#suma").val();
        let descuentocredito = $("#descuentocredito").val();
        if(descuentocredito == ""){
            descuentocredito = 0.00;
        }
        let interes = $("#interes").val();
        if(interes == ""){
            interes = 0.00;
        }
        if(inicial == ""){
            inicial = 0.00;
        }
        let tasa = interes/12;
        subtotal = parseFloat(subtotal);
        descuentocredito = parseFloat(descuentocredito);
        subtotal = subtotal - descuentocredito;
        let total = subtotal - inicial;
        if(total == 0){
            showNotification('bottom','center','No puedes avanzar si el credito es igual a 0','danger');
            return;
        }else{
            if(inicial == "" || meses == ""){
                showNotification('bottom','center','Complete todos los campos','danger');
                return;
            }else{
                let preciocuota = pmt(tasa,meses,total);
                preciocuota = preciocuota.toFixed(2);
                $("#cuotamensual").val(preciocuota);
            }
        }
    });
    $("#nticket").on('change',function(e){
        let num = $("#nticket").val();
        $.post('<?=SERVERURL;?>caja/cancelarticket/',{num},function(res){
            if(res == 1){
                showNotification('bottom','center','El ticket fue cancelado','success');
                $("#nticket").val("");
            }else{
                showNotification('bottom','center','No se pudo cancelar el ticket','danger');
                $("#nticket").val("");
            }
        });
    });
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
    $("#unidad").change(function(){
        let id = $(this).val();
        $.post("<?=SERVERURL;?>unidadmedida/preciou3",{id},function(res){
            let resq = res.split('|');
            $("#preciod").val(resq[0]);
            $("#precio").val(resq[0]);
            $("#uniequivalent").val(resq[1]);
        });
    });
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
                let moneda = "<?=$MONEDA;?>";
                let stock_equivalente = parseInt(stock / equivalente);
                htmlpro(producto,stock_equivalente,idproducto,cantidad,comboval,selected,precio,equivalente,moneda);
                $("#productoModal").modal("hide");
                $("#cantidadproductomodal").val(1);
                $("#compra").val("");
            }
        }
    });
    $("#finalizarventa").click(function(){
        FinalizarVenta();
    });
    $("#btn_terminar_venta").click(function(){
        SendDataCaja();
    });
</script>