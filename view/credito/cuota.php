<?php require 'view/templeate/head.php';
    $cn = $this->conexion;
    $idcuota = $this->cuotaid;
    $parametros = $this->parametros;
    $moneda = $parametros['Moneda'];
    $cuota = $cn->query("SELECT * FROM cuotas_credito WHERE ID_CUOTA = '$idcuota'");
    $monto = "";
    $ncuota = "";
    $cliente = "";
    $nombrecliente = "";
    foreach($cuota as $row){
        $ncuota = $row["NUM_CUOTA"];
        $cliente = $row["ID_CLIENTE"];
        $datocliente = $cn->query("SELECT NOMBRE FROM cliente WHERE ID_CLIENTE = '$cliente'");
        $nombrecliente = $datocliente->fetchColumn(0);
        $monto = number_format($row["MONTOCUOTA"],2);
    }   
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
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-amosis">
                        <h4 class="card-title">Pagar Cuota</h4>
                        <p class="card-category">Complete todos los campos</p>
                    </div>
                    <div class="card-body text-center">
                        <h5>Total a Pagar</h5>
                        <h3 id="paga_contado"><?=$moneda.$monto;?></h3>
                        <div class="form-group bmd-form-group">
                            <label class="control-label bmd-label-static">Cuota N°</label>
                            <input id="cuota" type="number" disabled value="<?=$ncuota;?>" class="form-control">
                            <input id="montocuota" type="hidden" value="<?=$monto;?>" class="form-control">
                        </div>
                        <div class="form-group bmd-form-group">
                            <label class="control-label bmd-label-static">N° Documento Cliente</label>
                            <input id="cliente" type="number" disabled value="<?=$cliente;?>" class="form-control">
                        </div>
                        <div class="form-group bmd-form-group">
                            <label class="control-label bmd-label-static">Nombre Cliente</label>
                            <input id="ncliente" type="text" disabled value="<?=$nombrecliente;?>" class="form-control">
                        </div>
                        <div class="form-group bmd-form-group">
                            <label class="control-label bmd-label-static">Pago con:</label>
                            <input type="number" id="pagocon" placeholder="50.00" class="form-control text-center">
                        </div> 
                        <div class="col-md-12 text-left">
                            <h4 class="title">Opciones</h4> 
                            <div class="togglebutton">
                                <label>
                                <input type="checkbox" id="ticket_cuota_imprimir" checked="">
                                <span class="toggle"></span>
                                    Imprimir Ticket de cuota
                                </label>
                            </div>
                            <div class="togglebutton">
                                <label>
                                <input type="checkbox" id="ticket_visualizar">
                                <span class="toggle"></span>
                                    Visualizar Ticket de cuota
                                </label>
                            </div>
                        </div>
                        <div class="form-group bmd-form-group">
                            <button type="button" id="pago" class="btn btn-primary" >Realizar Pago</button>
                        </div> 
                        <div class="form-group bmd-form-group mt-4">
                            <label class="control-label bmd-label-static">Cambio:</label>
                            <input type="number" id="cambio" class="form-control text-center">
                            <input type="hidden" id="usuario" value='<?=$_SESSION["usuario"]?>' class="form-control text-center">
                            <input type="hidden" id="cuota" value='<?=$idcuota;?>' class="form-control text-center">
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'view/templeate/footer.php';?>
<script>
    $("#pago").click(function(){
        let cuota = <?=$idcuota;?>;
        let usuario = $("#usuario").val();
        let pagocon = $("#pagocon").val();
        let montocuota = $("#montocuota").val();
        if(pagocon == ""){
            showNotification('bottom','center','Complete todos los campos','danger');
        }else{
            pagocon = parseFloat(pagocon);
            let cambio = parseFloat(pagocon-montocuota);
            cambio = cambio.toFixed(2);
            var sndPago ='usuario='+usuario+'&pagocon='+pagocon+'&cambio='+cambio+'&cuota='+cuota;   
            if(pagocon>=montocuota){
                $("#cambio").val(cambio);
                $.post('<?=SERVERURL;?>credito/pagocuota/',sndPago,function(res){
                    if(res == 1){
                        showNotification('bottom','center','El pago se realizo con exito','success');
                        if($("#ticket_cuota_imprimir").prop('checked')){
                            window.open('<?=SERVERURL;?>credito/imprimir_ticket_cuota/'+cuota, "_blank", "resizable=yes, scrollbars=yes, titlebar=yes, width=400, height=800, top=1, left=1");
                        }
                        if($("#ticket_visualizar").prop('checked')){
                            window.open('<?=SERVERURL;?>credito/vercuotaticket/'+cuota, "_blank", "resizable=yes, scrollbars=yes, titlebar=yes, width=400, height=800, top=1, left=1");
                        } 
                        setTimeout(function(){
                            location.href = '<?=SERVERURL;?>credito';
                        },1000);
                    }else{
                        showNotification('bottom','center','El pago no se pudo realizar','danger');
                    }
                });
            }else{
                showNotification('bottom','center','El pago no puede ser menor al monto de la cuota','danger');
            }
        }
    });
</script>