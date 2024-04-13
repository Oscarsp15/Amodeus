<?php require 'view/templeate/head.php';?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header card-header-amosis">
                        <h4 class="card-title">CAJA</h4>
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
                                <div class="shop-panel text-white bg-red">
                                    <h5><i class="fa fa-bars" aria-hidden="true"></i> Total:</h5>
                                    <h4><strong class="final-price"><?=MONEDA;?>0</strong></h4>
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
                                    <h4 class="btn-block"><strong class="cambio"><?=MONEDA;?>0</strong></h4>
                                </div>
                                <div class="form-group bmd-form-group">
                                    <button class="btn btn-block btn-rose">Cancelar Ticket</button>
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
                        <h3 id="paga_contado"><?=MONEDA;?>0.00</h3>
                        <div class="form-group bmd-form-group">
                            <label class="control-label bmd-label-static">Descuento</label>
                            <input id="descuentocontado" type="number" class="form-control">
                        </div>
                        <div class="form-group bmd-form-group">
                            <label class="control-label bmd-label-static">Pago con:</label>
                            <input type="number" id="pagocon" class="form-control text-center">
                        </div> 
                    </div>
                    <div class="tab-pane" id="credito">
                        <h5>Total a Pagar</h5>
                        <h3 id="paga_credito"><?=MONEDA;?>0.00</h3>
                        <div class="form-group bmd-form-group">
                            <label class="control-label bmd-label-static">Fecha de Pago</label>
                            <input id="fechapago" type="number" class="form-control">
                        </div>
                        <div class="form-group bmd-form-group">
                            <label class="control-label bmd-label-static">N° Meses</label>
                            <input id="meses"  type="number" class="form-control">
                        </div>
                        <div class="form-group bmd-form-group">
                            <label class="control-label bmd-label-static">Inicial</label>
                            <input id="inicial" type="number" class="form-control">
                        </div>
                        <div class="form-group bmd-form-group">
                            <label class="control-label bmd-label-static">Tasa de Interes %</label>
                            <input id="interes" type="number" class="form-control">
                        </div>
                        <div class="form-group bmd-form-group">
                            <button id="calcular_credito" class="btn btn-block btn-primary">Calcular</button>
                        </div>
                        <div class="form-group bmd-form-group">
                            <label class="control-label bmd-label-static">Cuota Mensual</label>
                            <input id="cuotamensual" type="number" class="form-control">
                        </div>
                        <div class="form-group bmd-form-group">
                            <label class="control-label bmd-label-static">Descuento</label>
                            <input id="cuotamensual" type="number" class="form-control">
                        </div>
                        Pago la inicial con:
                        <input type="number" id="pagocon2" class="form-control text-center">
                    </div>
                  </div>
                </div>
            </div>
       
      </div>
    </div>
  </div>
</div>

<?php require 'view/templeate/footer.php';?>
<script src="<?=SERVERURL;?>view/assets/js/box.js"></script>
<script>
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
            // llenarlas todo en un arreglo
            data += idp+'|'+idc+',';
        }
        //llenar los productos en una variable
        var productos = data;
        var subtotal = $('#suma').val();

        if($("#contado").hasClass("active")){
            // capturar el valor de lo cual se esta pagando
            var pagocon = $('#pagocon').val();
            //capturar el precio total de la venta
            //parseo de las variables
            var op1 = parseFloat(pagocon);
            var op2 = parseFloat(total);
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
            let venta_cod = $("#cod_venta").val();
            let doc = $("#identificacion").val();
            let nombre_c = $("#nombre").val();
            let direccion = $("#direccion").val();
            let descuento = $("#descuentocontado").val();
            if (descuento == ""){
                descuento = 0.00;
            }
            let total = parseFloat(subtotal - descuento);
            $('.cambio').text('Q'+cambio);
            var sndVenta = p[0]+'productos='+data+'&subtotal='+subtotal+'&descuento='+descuento+'&total='+total+'&pagocon='+op1+'&cambio='+cambio+'&doc='+doc+'&nombre_c='+nombre_c+'&direccion='+direccion+'&venta='+venta_cod+'&usuario='+usuario;        
            $.post("<?=SERVERURL;?>caja/pago_contado",sndVenta,function(res){
                console.log(res);
                window.open('<?=SERVERURL;?>caja/verticket/'+venta_cod, "_blank", "resizable=yes, scrollbars=yes, titlebar=yes, width=400, height=800, top=1, left=1");
                $('#pagocon').prop('disabled', false);
                $('#pagoconModal').modal('toggle');
                $('#suma').val('0');
                $('#pagocon').val('');
                $('#caja').html('');
                $('#compra').focus();
                setTimeout(function(){
                    $('.final-price').text('Q0');
                    $('.cambio').text('');
                    location.reload();
                },3000);
            });
        }else if($("#credito").hasClass("active")){
            let nombre = $("#nombre").val();
            let identificacion = $("#identificacion").val();
            if(nombre == "" || identificacion == ""){
                showNotification('bottom','center','Los datos del cliente son obligatorios','danger');
                return;
            }else{
                let fecha = $("#fechapago").val();
                if(fecha == ""){
                    showNotification('bottom','center','La fecha debe ser rellenada','danger');
                    return;
                }else{
                    let venta_cod = $("#cod_venta").val();
                    let doc = $("#identificacion").val();
                    let nombre_c = $("#nombre").val();
                    let direccion = $("#direccion").val();
                    let meses = $("#meses").val();
                    let inicial = $("#inicial").val();
                    let total = $("#suma").val();
                    let pagocon2 = $("#pagocon2").val();
                    let cuotamensual = $("#cuotamensual").val();
                    if(inicial == "" || cuotamensual == "" || meses == "" ){
                        showNotification('bottom','center','Todos los campos deben ser completados','danger');
                        return;
                    }else{
                        var op1 = parseFloat(pagocon2);
                        var op2 = parseFloat(inicial);
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
                        var sndVenta = p[0]+'productos='+data+'&total='+total+'&pagocon='+op1+'&cambio='+cambio+'&doc='+doc+'&nombre_c='+nombre_c+'&direccion='+direccion+'&venta='+venta_cod+'&usuario='+usuario+'&fecha='+fecha+'&meses='+meses+'&inicial='+inicial+'&cuotamensual='+cuotamensual;        
                        $.post("<?=SERVERURL;?>caja/pago_credito",sndVenta,function(res){
                            window.open('<?=SERVERURL;?>credito/ticketinicial/'+venta_cod, "_blank", "resizable=yes, scrollbars=yes, titlebar=yes, width=400, height=800, top=1, left=1");
                            $('#pagocon').prop('disabled', false);
                            $('#pagoconModal').modal('toggle');
                            $('#suma').val('0');
                            $('#pagocon').val('');
                            $('#caja').html('');
                            $('#compra').focus();
                            setTimeout(function(){
                                $('.final-price').text('Q0');
                                $('.cambio').text('');
                                location.reload();
                                window.open('<?=SERVERURL;?>credito/estadoventa/'+venta_cod, "_blank", "resizable=yes, scrollbars=yes, titlebar=yes,  width=700, height=485, top=1, left=1");
                            },2000);
                        });
                    }
                }
            }
        }

    }
    $('#compra').on('change', function(){
        var inpt = $('#compra');
        let codigo = $(this).val();
        $.post('<?=SERVERURL;?>caja/barra_producto/',{codigo},function(res){
            if (res == 1){
                inpt.val('');
                inpt.focus();
                showNotification('bottom','center','El producto no existe','danger');
            }else if(res == 2){
                showNotification('bottom','center','El producto ya no cuenta existencia','warning');
            }else{
                var resd = res.split('|');
                htmlpro(resd[0],resd[1],resd[2],resd[3]);
                inpt.val('');
                inpt.focus();
            }
            $('#caja>.item:nth-child(1)').on('click', function(){
                var dt = $(this).attr('data-id');
                $('#caja>.item').removeClass('p-active');
                $('#pro-n-'+dt).addClass('p-active');
            });
        });
    });
    function buscarcliente(id){
        $.post('<?=SERVERURL;?>caja/buscarcliente/',{id},function(res){
            if (res == 1){
                GETDATA();
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
        let total = $("#suma").val();
        if(total == 0){
            showNotification('bottom','center','No puedes avanzar si el credito es igual a 0','danger');
            return;
        }else{
            if(inicial == "" || meses == ""){
                showNotification('bottom','center','Complete todos los campos','danger');
                return;
            }else{
                let tasa = 0.2/12;
                let preciofinal = total-inicial;
                let preciocuota = pmt(tasa,meses,preciofinal);
                preciocuota = preciocuota.toFixed(2);
                $("#cuotamensual").val(preciocuota);
            }
        }
    });
</script>