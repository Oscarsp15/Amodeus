<?php require 'view/templeate/head.php';
$parametros = $this->parametro;
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header card-header-amosis">
                    <h4 class="card-title">Nueva entrada de Producto</h4>
                    <p class="card-category">Complete los datos de la entrada</p>
                </div>
                <div class="card-body">
                    <form autocomplete="off" method="POST" ectype="multipart/form-data">       
                        <div class="row">
                            <input type="hidden" id="cod_entrada" name="id_agregar" value="<?=$this->codigo_entrada;?>" class="form-control">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Tipo de Ingreso</label>
                                    <select id="tipoingreso" name="tipo_ingreso" class="custom-select">
                                        <option value="1">INGRESO POR COMPRA</option>
                                        <option value="2">INGRESO POR DONACION</option>
                                        <option value="3">INGRESO POR DEVOLUCION</option>
                                        <option value="4">INGRESO POR TRASPASO ALMACÉN</option>
                                        <option value="5">INGRESO POR AJUSTE DE INVENTARIOS</option>
                                        <option value="6">OTRAS ENTRADAS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Proveedor</label>
                                    <select id="proveedor" name="proveedor" class="custom-select">
                                        <?=$this->lista_proveedor?>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">N° de Documento</label>
                                    <input type="text" id="numero_documento" name="numero_documento" class="form-control">
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
                                <button onclick="agregarproducto()" class="btn btn-sm btn-warning btn-round" type="button">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-warning">
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
                                                        <th>Opcion</th>
                                                    </thead>
                                                    <tbody id="datos">
                                                        
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4"></td>
                                                            <td colspan="2"><h6 class="font-weight-bolder">Total Neto <?=$parametros["Moneda"];?><span id="total-neto">0.00</span> </h6></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                    
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="gp" class="btn btn-primary pull-right">Guardar Entrada</button>                
                        <a href="<?=SERVERURL;?>entradaproducto/" class="btn btn-rose pull-right">Regresar</a>                
                        <div class="RespuestaAjax"></div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="modal fade" id="editcantidad" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">EDITAR PRODUCTO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                   <div class="row">
                       <div class="col-12">
                            <div class="form-group">
                                <input type="hidden" id="codigo-modal" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Producto</label>
                                <input type="text" disabled id="producto-modal" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Precio</label>
                                <input type="text" id="precio-modal" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="text" id="cantidad-modal" class="form-control">
                            </div>
                       </div>
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-modal" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'view/templeate/footer.php';?>
<script>
    $(document).ready(function(){
        let tocken = "evaluar";
        $.post('<?=SERVERURL;?>proveedor/existenciaproveedor/',{tocken},function(response){
            if(response == 1){
                showNotification('bottom','center','No tienes proveedores','danger');
                setTimeout(function(){
                    location.href = "<?=SERVERURL;?>proveedor/nuevoproveedor/";
                },1000);
            }
        });

        $("#producto").select2({
            allowClear: true
        });

    });
    function totalneto(){
        let numero = 0;
        $("#datos tr").each(function(){
            var importe = $(this).find('td').eq(5).html();
            importe = parseFloat(importe);
            numero = numero + importe;
        });
        $("#total-neto").html(numero.toFixed(2));
    }
    function agregarproducto(){
        let combo = document.getElementById("producto");
        let selected = combo.options[combo.selectedIndex].text;
        let comboval = combo.value;
        let combo2 = document.getElementById("unidad");
        let selected2 = combo2.options[combo2.selectedIndex].text;
        let comboval2 = combo2.value;
        let precio = $("#precio").val();
        let cantidad = $("#cantidad").val();
        if(precio == "" || cantidad == "" || cantidad<0 ){
            showNotification('bottom','center','No puedes agregar producto intente con nuevos valores','info');
        }else{
            let num_coincidencia = false;
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
                var fila = "<tr><td>"+comboval+"</td><td>"+selected+"</td><td>"+selected2+"</td><td>"+precio+"</td><td>"+cantidad+"</td><td>"+importe.toFixed(2)+"</td><td><button type='button' data-toggle='modal' data-target='#editcantidad' value='"+comboval+"'class='btn btn-modal btn-warning btn-link'><i class='fa fa-pen'></i></button></td></tr>";
                var btn = document.createElement("TR");
                btn.innerHTML = fila;
                document.getElementById("datos").appendChild(btn);
            }
            totalneto();
        }
    }
    $("#gp").click(function(e){
        e.preventDefault();
        let contar_tabla = 0;
        $("#datos tr").each(function(){contar_tabla++;});
        if(contar_tabla>0){
            var cod_entrada = $("#cod_entrada").val();
            var tipoingreso = $("#tipoingreso").val();
            var proveedor = $("#proveedor").val();
            var documento = $("#documento").val();
            var numero_documento = $("#numero_documento").val();
            var observacion = $("#observacion").val();
            var datos = [];
            $("#datos tr").each(function(){
                var v1 = $(this).find('td').eq(0).html();
                var v2 = $(this).find('td').eq(1).html();
                var v3 = $(this).find('td').eq(2).html();
                var v4 = $(this).find('td').eq(3).html();
                var v5 = $(this).find('td').eq(4).html();
                let objeto = {
                    id: v1,
                    unidad: v3,
                    precio: v4,
                    cantidad : v5
                }
                datos.push(objeto);
            });
            let objectform = {
                cod_entrada : cod_entrada,
                tipo_ingreso : tipoingreso,
                proveedor : proveedor,
                documento : documento,
                numero : numero_documento,
                observacion : observacion,
                tabla : datos
            }
            console.log(objectform);
            $.post('<?=SERVERURL;?>entradaproducto/nuevaentrada/',objectform,function(response){
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
            var precio = $(this).find('td').eq(3).html();
            var cantidad = $(this).find('td').eq(4).html();
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
        $("#datos tr").each(function(){
            var cod = $(this).find('td').eq(0).html();
            if(cod == codigo){
                $(this).find('td').eq(3).html(precio);
                $(this).find('td').eq(4).html(cantidad);
                $(this).find('td').eq(5).html(importe.toFixed(2));
            }
        });
        totalneto();
        showNotification('bottom','center','Se actualizó la cantidad del producto','success');
    });
    $("#producto").change(function(){
        let id = $(this).val();
        $.post('<?=SERVERURL;?>unidadmedida/precioxunidad',{id},function(response){
            $("#unidad").html(response);
            $.post('<?=SERVERURL;?>unidadmedida/preciounidad',{id},function(response){
                $("#precio").val(response);
            });
        });
    });
    $("#unidad").change(function(){
        let id = $(this).val();
        $.post('<?=SERVERURL;?>unidadmedida/preciou',{id},function(response){
            $("#precio").val(response);
        });
    });
</script>