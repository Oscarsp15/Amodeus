<?php require 'view/templeate/head.php';?>
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
                    <h4 class="card-title">Nuevo Usuario</h4>
                    <p class="card-category">Complete los datos del Usuario</p>
                </div>
                <div class="card-body">
                    <form autocomplete="off" id="formulario" name="formulario">
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
                                    <input type="text" name="usuario_agregar" id="usuario"  class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Password</label>
                                    <input type="text" name="pass_agregar"  id="pass" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Persona</label>
                                    <select name="persona_agregar" class="custom-select">
                                    <?=$this->listarPersona;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Cargo</label>
                                    <select name="privilegio_agregar" class="custom-select">
                                        <option value="0">Asistente de Almacen</option> 
                                        <option value="1">Administrador</option>
                                        <option value="2">Vendedor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Estado</label>
                                    <select name="estado_agregar" class="custom-select">
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
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
                                                    <input type="checkbox" id="ticket"  name="dashboard" checked="">
                                                    <span class="toggle"></span>
                                                        Dashboard
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="togglebutton">
                                                    <label>
                                                    <input type="checkbox" id="ticket" name="almacen" checked="">
                                                    <span class="toggle"></span>
                                                        Almacén
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="togglebutton">
                                                    <label>
                                                    <input type="checkbox" id="ticket" name="compras" checked="">
                                                    <span class="toggle"></span>
                                                        Compras
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="togglebutton">
                                                    <label>
                                                    <input type="checkbox" id="ticket"  name="ventas" checked="">
                                                    <span class="toggle"></span>
                                                        Ventas
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="togglebutton">
                                                    <label>
                                                    <input type="checkbox" id="ticket"  name="turnos" checked="">
                                                    <span class="toggle"></span>
                                                        Turnos
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="togglebutton">
                                                    <label>
                                                    <input type="checkbox" id="ticket" name="cotizacion" checked="">
                                                    <span class="toggle"></span>
                                                        Cotización
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="togglebutton">
                                                    <label>
                                                    <input type="checkbox" id="ticket"  name="inventario" checked="">
                                                    <span class="toggle"></span>
                                                        Inventario
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="togglebutton">
                                                    <label>
                                                    <input type="checkbox" id="ticket"  name="admin" checked="">
                                                    <span class="toggle"></span>
                                                        Admin
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="togglebutton">
                                                    <label>
                                                    <input type="checkbox" id="ticket"  name="parametros" checked="">
                                                    <span class="toggle"></span>
                                                        Parametros
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="togglebutton">
                                                    <label>
                                                    <input type="checkbox" id="ticket"  name="backup" checked="">
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
                        <button type="submit" class="btn btn-sm btn-primary pull-right">Guardar Usuario</button>                
                        <a href="<?=SERVERURL;?>usuario/" class="btn btn-sm btn-rose pull-right">Regresar</a>                
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
    $("#formulario").submit(function(e){
        e.preventDefault();
        let usuario = $("#usuario").val();
        let pass = $("#pass").val();
        if(usuario.length == 0 || pass.length == 0 ){
            showNotification('bottom','center','El usuario y el pass son necesarios ','danger');
        }else{
            var Form = new FormData(document.forms.namedItem("formulario"));
            $.ajax({
                url: "<?=SERVERURL;?>usuario/agregar_usuario/",
                type: "post",
                data : Form,
                processData: false,
                contentType: false,
                success: function(data)
                {
                    if(data == 1){
                        showNotification('bottom','center','Esta persona ya tiene un usuario','danger');
                    }else if(data == 2){
                        showNotification('bottom','center','El usuario ya existe','danger');
                    }else if(data == 3){
                        showNotification('bottom','center','Usuario Agregado correctamente','success');
                        setTimeout(function(){
                            location.reload();
                        },1000);
                    }
                }
            }); 
        }
    });
    $(document).ready(function(){
        let tocken = "evaluar";
        $.post('<?=SERVERURL;?>persona/existenciapersona/',{tocken},function(response){
            if(response == 1){
                showNotification('bottom','center','No tienes personas','danger');
                setTimeout(function(){
                    location.href = "<?=SERVERURL;?>persona/nuevopersonal/";
                },1000);
            }
        });
    });
</script>