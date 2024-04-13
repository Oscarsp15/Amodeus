<?php require 'view/templeate/head.php';
    $parametro = $this->parametros; 
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
            <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header card-header-amosis">
                    <h4 class="card-title">Nueva Salida de Producto</h4>
                    <p class="card-category">Complete los datos de la salida</p>
                </div>
                <div class="card-body">
                    <form autocomplete="off" method="POST" ectype="multipart/form-data">       
                        <div class="row">
                            <input type="hidden" id="cod_salida" name="id_agregar" value="<?=$this->codigo_entrada;?>" class="form-control">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Tipo de Salida</label>
                                    <select id="tiposalida" name="tipo_ingreso" class="custom-select">
                                        <option value="1">PEDIDO DE VENTA</option>
                                        <option value="2">PEDIDO DE TRANSFERENCIA</option>
                                        <option value="3">PEDIDO DE DEVOLUCION DE COMPRA</option>
                                        <option value="4">PEDIDO DE SERVICIO</option>
                                        <option value="5">PEDIDO DE EMSAMBLADO</option>
                                        <option value="6">ORDEN DE PRODUCCION</option>
                                        <option value="7">OTRAS SALIDAS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Tipo de Documento</label>
                                    <select id="documento" name="documento" class="custom-select">
                                        <option value="1">FACTURA</option>
                                        <option value="2">BOLETA</option>
                                        <option value="3">NOTA DE ENTRADA</option>
                                        <option value="4">NOTA DE SALIDA</option>
                                        <option value="5">NOTA DE CREDITO</option>
                                        <option value="6">NOTA DE DEBITO</option>
                                        <option value="7">REMISION</option>
                                        <option value="8">OTROS DOCUMENTOS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Tipo de Documento del Destinatario</label>
                                    <select id="tipo_documento_destinatario" name="tipo_documento_destinatario" class="custom-select">
                                        <option value="1">RUC</option>
                                        <option value="2">DNI</option>
                                        <option value="3">CARNET DE EXTRANJERIA</option>
                                        <option value="4">PASAPORTE</option>
                                        <option value="5">PART. DE NACIMIENTO</option>
                                        <option value="6">OTROS DOCUMENTOS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">N° de Documento</label>
                                    <input type="text" id="numero_documento" name="numero_documento" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Nombre del Destinatario</label>
                                    <input type="text" id="nombre_destinatario" name="nombre_destinatario" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">N° Documento del Destinatario</label>
                                    <input type="text" id="numero_documento_destinatario" name="numero_documento_destinatario" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating"> Observación</label>
                                        <textarea id="observacion" name="observacion" class="form-control" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Producto</label>
                                    <select name="producto" id="producto" class="custom-select">
                                        <option>Seleccionar producto</option>
                                        <?=$this->lista_producto?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Unidad de medida</label>
                                    <select name="unidad" id="unidad" class="custom-select">
                                        <option>Seleccionar Unidad</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Precio</label>
                                    <input type="text" id="precio" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Cantidad</label>
                                    <input type="number" id="cantidad" name="cantidad" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <button onclick="agregarproducto()" type="button" class="btn btn-warning btn-sm btn-round">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-gold">
                                        <h4 class="card-title">Ingreso de Productos</h4>
                                        <p class="card-category">Lista de productos en ingreso</p>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <div class="table-responsive">
                                                <table class="table table-hover table-striped" id="table">
                                                    <thead class="text-warning">
                                                        <th>ID</th>
                                                        <th>Producto</th>
                                                        <th>U.M</th>
                                                        <th>Precio</th>
                                                        <th>Cantidad</th>
                                                        <th>Importe</th>
                                                    </thead>
                                                    <tbody id="datos">
                                                        
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4"></td>
                                                            <td colspan="2"><h6 class="font-weight-bolder">Total Neto <?=$parametro["Moneda"];?><span id="total-neto">0.00</span> </h6></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                    
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="gp" class="btn btn-primary pull-right">Guardar Salida</button>                
                        <a href="<?=SERVERURL;?>salidaproducto/" class="btn btn-rose pull-right">Regresar</a>                
                        <div class="RespuestaAjax"></div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<?php require 'view/templeate/footer.php';?>
<script>
    function totalneto(){
        let numero = 0;
        $("#datos tr").each(function(){
            var importe = $(this).find('td').eq(5).html();
            importe = parseFloat(importe);
            numero = numero + importe;
        });
        $("#total-neto").html(numero.toFixed(2));
    }
    $("#producto").change(function(){
        let id = $(this).val();
        $.post('<?=SERVERURL;?>unidadmedida/precioxunidad',{id},function(response){
            $("#unidad").html(response);
            $.post('<?=SERVERURL;?>unidadmedida/preciounidad2',{id},function(response){
                $("#precio").val(response);
            });
        });
    });
    $("#unidad").change(function(){
        let id = $(this).val();
        $.post('<?=SERVERURL;?>unidadmedida/preciou2',{id},function(response){
            $("#precio").val(response);
        });
    });
    function agregarproducto(){
        let combo = document.getElementById("producto");
        let selected = combo.options[combo.selectedIndex].text;
        let comboval = combo.value;
        let combo2 = document.getElementById("unidad");
        let selected2 = combo2.options[combo2.selectedIndex].text;
        let comboval2 = combo2.value;
        let precio = $("#precio").val();
        let cantidad = $("#cantidad").val();
        let num_coincidencia = false;
        let object = {
            idpro : comboval,
            idunidad: comboval2
        }
        $.post('<?=SERVERURL;?>salidaproducto/producto_cantidad/',object,function(response){
            var resd = response.split('|');
            var stock = resd[0];
            var unidades = resd[1];
            var cantidadsolicitada = cantidad*unidades;
            if(cantidadsolicitada>stock){
                showNotification('bottom','center','La cantidad Solicitada excede el stock minimo','danger');
                $("#cantidad").val("");
            }else{
                $("#datos tr").each(function(){
                    var v1 = $(this).find('td').eq(0).html();
                    if(v1 == comboval){
                        num_coincidencia = true;
                    }
                });
                if(num_coincidencia){
                    showNotification('bottom','center','El producto '+selected+' ya esta en la tabla de ingreso de producto','info');
                }else{
                    let importe = parseFloat(precio) * parseFloat(cantidad);
                    var fila = "<tr><td>"+comboval+"</td><td>"+selected+"</td><td>"+selected2+"</td><td>"+precio+"</td><td>"+cantidad+"</td><td>"+importe.toFixed(2)+"</td></tr>";
                    var btn = document.createElement("TR");
                    btn.innerHTML = fila;
                    document.getElementById("datos").appendChild(btn);
                }
                totalneto();
            }
        });
    }
    $("#gp").click(function(e){
        e.preventDefault();
        let contar_tabla = 0;
        $("#datos tr").each(function(){contar_tabla++;});
        if(contar_tabla>0){
            var cod_salida = $("#cod_salida").val();
            var tiposalida = $("#tiposalida").val();
            var proveedor = $("#proveedor").val();
            var documento = $("#documento").val();
            var numero_documento = $("#numero_documento").val();
            var nombre_destinatario = $("#nombre_destinatario").val();
            var tipo_documento_destinatario = $("#tipo_documento_destinatario").val();
            var numero_documento_destinatario = $("#numero_documento_destinatario").val();
            var observacion = $("#observacion").val();
            var datos = [];
            $("#datos tr").each(function(){
                var v1 = $(this).find('td').eq(0).html();
                var v2 = $(this).find('td').eq(3).html();
                var v3 = $(this).find('td').eq(4).html();
                var v4 = $(this).find('td').eq(2).html();
                let objeto = {
                    id: v1,
                    precio:v2,
                    cantidad : v3,
                    unidad: v4
                }
                datos.push(objeto);
            });
            let objectform = {
                cod_salida : cod_salida,
                tipo_salida : tiposalida,
                documento : documento,
                numero : numero_documento,
                nombre_destinatario : nombre_destinatario,
                tipo_documento_destinatario : tipo_documento_destinatario,
                numero_documento_destinatario : numero_documento_destinatario,
                observacion : observacion,
                tabla : datos
            }
            $.post('<?=SERVERURL;?>salidaproducto/nuevasalida/',objectform,function(response){
                $(".RespuestaAjax").html(response);
            });
        }else{
            showNotification('bottom','center','No tienes productos en lista','danger');
        }
        
    });
    $(document).on('click','.btn-modal',function(){
        let value = this.value;
        $("#datos tr").each(function(){
            var codigo = $(this).find('td').eq(0).html();
            var producto = $(this).find('td').eq(1).html();
            var precio = $(this).find('td').eq(2).html();
            var cantidad = $(this).find('td').eq(3).html();
            if(codigo == value){
                $("#codigo-modal").val(codigo);
                $("#producto-modal").val(producto);
                $("#precio-modal").val(precio);
                $("#cantidad-modal").val(cantidad);
            }
        });
    });
    $("#btn-modal").click(function(){
        let codigo = $("#codigo-modal").val();
        let producto = $("#producto-modal").val();
        let precio = $("#precio-modal").val();
        let cantidad = $("#cantidad-modal").val();
        let importe = precio * cantidad;
        let object = {
            idpro : codigo
        }
        $.post('<?=SERVERURL;?>salidaproducto/producto_cantidad/',object,function(response){
            let cantidadreal_producto = parseInt(response);
            cantidad = parseInt(cantidad);
            if(cantidad<0){
                showNotification('bottom','center','La cantidad Solicitada no es valida','info');
                $("#cantidad-modal").val(response);
            }else{
                if(cantidad>cantidadreal_producto){
                    showNotification('bottom','center','La cantidad Solicitada excede el stock minimo','danger');
                    $("#cantidad-modal").val(response);
                }else{
                    $("#datos tr").each(function(){
                        var cod = $(this).find('td').eq(0).html();
                        if(cod == codigo){
                            $(this).find('td').eq(2).html(precio);
                            $(this).find('td').eq(3).html(cantidad);
                            $(this).find('td').eq(4).html(importe);
                        }
                    });
                    totalneto();
                    showNotification('bottom','center','Se actualizó la cantidad del producto','success');
                }
            }
        });
    });
</script>