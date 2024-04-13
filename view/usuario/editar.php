<?php require 'view/templeate/head.php';
    $dato = $this->datos;
?>
<?php
    if(!$_SESSION["admin"]){
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
                    <h4 class="card-title">Usuario <?=$this->codigo_usuario;?></h4>
                    <p class="card-category">Datos del Usuario</p>
                </div>
                <div class="card-body">
                    <form  id="formulario" name="formulario">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">ID del Usuario</label>
                                    <input type="text" disabled value="<?=$this->codigo_usuario;?>" class="form-control">
                                    <input type="hidden" name="id_agregar" value="<?=$this->codigo_usuario;?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Usuario</label>
                                    <input type="text" value='<?=$dato["Usuario"]?>' name="usuario_agregar" class="form-control" required>
                                    <input type="hidden" value='<?=$dato["Usuario"]?>' name="usuario_original" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Password</label>
                                    <input type="text" value='<?=$dato["Pass"]?>' name="pass_agregar" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Persona</label>
                                    <select name="persona_agregar" disabled class="custom-select">
                                    <?=$this->option_persona;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Cargo</label>
                                    <select name="privilegio_agregar" class="custom-select">
                                    <?php
                                        if($dato["Privilegio"]== "0"){
                                    ?>
                                        <option value="0" selected>Asistente de Almacen</option> 
                                        <option value="1">Administrador</option>
                                        <option value="2">Vendedor</option>
                                    <?php
                                        }else if($dato["Privilegio"]== "1"){
                                    ?>
                                        <option value="0">Asistente de Almacen</option> 
                                        <option value="1" selected>Administrador</option>
                                        <option value="2" >Vendedor</option>
                                    <?php      
                                        }else{
                                    ?>
                                        <option value="0">Asistente de Almacen</option> 
                                        <option value="1" >Administrador</option>
                                        <option value="2" selected>Vendedor</option>
                                    <?php
                                        }
                                    ?>    
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Estado</label>
                                    <select name="estado_agregar" class="custom-select">
                                    <?php
                                        if($dato["Activo"] == "0"){
                                    ?>
                                        <option value="1">Activo</option>
                                        <option value="0" selected>Inactivo</option>
                                    <?php
                                        }else{
                                    ?>
                                            <option value="1" selected>Activo</option> 
                                            <option value="0" >Inactivo</option>
                                    <?php      
                                        }
                                    ?>    
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-2 mb-2">
                                <h4 class="title">Permisos</h4>
                                <div class="row">
                                    <div class="col-sm-4">
                                    <div class="row">
                                            <div class="col-md-6">
                                                <div class="togglebutton">
                                                    <label>
                                                    <?php
                                                        if($dato["Dashboard"]==1){
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="dashboard" checked="">
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="dashboard">
                                                    <?php
                                                        }
                                                    ?>
                                                    <span class="toggle"></span>
                                                        Dashboard
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="togglebutton">
                                                    <label>
                                                    <?php
                                                        if($dato["Almacen"]==1){
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="almacen" checked="">
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="almacen">
                                                    <?php
                                                        }
                                                    ?>
                                                    <span class="toggle"></span>
                                                        Almacén
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="togglebutton">
                                                    <label>
                                                    <?php
                                                        if($dato["Compras"]==1){
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="compras" checked="">
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="compras">
                                                    <?php
                                                        }
                                                    ?>
                                                    <span class="toggle"></span>
                                                        Compras
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="togglebutton">
                                                    <label>
                                                    <?php
                                                        if($dato["Ventas"]==1){
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="ventas" checked="">
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="ventas">
                                                    <?php
                                                        }
                                                    ?>
                                                    <span class="toggle"></span>
                                                        Ventas
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="togglebutton">
                                                    <label>
                                                    <?php
                                                        if($dato["Turnos"]==1){
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="turnos" checked="">
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="turnos">
                                                    <?php
                                                        }
                                                    ?>
                                                    <span class="toggle"></span>
                                                    Turnos
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="togglebutton">
                                                    <label>
                                                    <?php
                                                        if($dato["Cotizacion"]==1){
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="cotizacion" checked="">
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="cotizacion">
                                                    <?php
                                                        }
                                                    ?>
                                                    <span class="toggle"></span>
                                                        Cotización
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="togglebutton">
                                                    <label>
                                                    <?php
                                                        if($dato["Inventario"]==1){
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="inventario" checked="">
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="inventario">
                                                    <?php
                                                        }
                                                    ?>
                                                    <span class="toggle"></span>
                                                        Inventario
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="togglebutton">
                                                    <label>
                                                    <?php
                                                        if($dato["Admin"]==1){
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="admin" checked="">
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="admin">
                                                    <?php
                                                        }
                                                    ?>
                                                    <span class="toggle"></span>
                                                        Admin
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="togglebutton">
                                                    <label>
                                                    <?php
                                                        if($dato["Parametros"]==1){
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="parametros" checked="">
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="parametros">
                                                    <?php
                                                        }
                                                    ?>
                                                    <span class="toggle"></span>
                                                        Parametros
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="togglebutton">
                                                    <label>
                                                    <?php
                                                        if($dato["Backup"]==1){
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="backup" checked="">
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <input type="checkbox" id="ticket"  name="backup">
                                                    <?php
                                                        }
                                                    ?>
                                                    <span class="toggle"></span>
                                                        Backup
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary pull-right">Guardar</button>                
                        <a href="<?=SERVERURL;?>usuario/" class="btn btn-sm btn-rose pull-right">Regresar</a>                
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<?php require 'view/templeate/footer.php';?>

<script>
    $("#formulario").submit(function(e){
        e.preventDefault();
        var Form = new FormData(document.forms.namedItem("formulario"));
        $.ajax({
            url: "<?=SERVERURL;?>usuario/actualizar_usuario/",
            type: "post",
            data : Form,
            processData: false,
            contentType: false,
            success: function(data)
            {
                if(data == 1){
                    showNotification('bottom','center','El usuario ya existe','danger');
                }else if(data == 2){
                    showNotification('bottom','center','Usuario actualizado correctamente','success');
                    setTimeout(function(){
                        location.reload();
                    },1000);
                }else{
                    showNotification('bottom','center','No se pudo actualizar','danger');
                }
            }
        }); 
    });
</script>