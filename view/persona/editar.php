<?php require 'view/templeate/head.php';
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
<?php
    $dato = $this->datos;
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
        </div>
        <div class="col-md-4">
            <div class="card card-profile">
                <div class="card-avatar" style="width: 150px;height: 150px;">
                    <div>
                        <img class="img" src="<?=SERVERURL;?>archives/assets/<?=$dato['Perfil']?>">
                    </div>
                </div>
                <div class="card-content p-3">
                    <form autocomplete="off" name="formulario" id="formulario">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">ID de la Persona</label>
                                    <input type="text" disabled value="<?=$this->codigo_persona;?>" class="form-control">
                                    <input type="hidden" name="id_agregar" value="<?=$this->codigo_persona;?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Nombre</label>
                                    <input type="text" value='<?=$dato["Nombre"];?>' name="nombre_agregar" id="nombre_agregar" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Apellido</label>
                                    <input type="text" value='<?=$dato["Apellido"];?>' name="apellido_agregar" id="apellido_agregar" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">DNI</label>
                                    <input type="text" value='<?=$dato["Dni"];?>' name="dni_agregar" id="dni_agregar" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Direccion</label>
                                    <input type="text" value='<?=$dato["Direccion"];?>' name="direccion_agregar" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Telefono</label>
                                    <input type="text" value='<?=$dato["Telefono"];?>' name="telefono_agregar" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12 text-left">
                                <div class="custom-file-container" data-upload-id="myFirstImage">
                                    <label>Subir Foto de perfil  <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                    <label class="custom-file-container__custom-file" >
                                        <input type="file" id="file" type="file" name="file" class="custom-file-container__custom-file__custom-file-input" accept="*">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                                    </label>
                                    <div class="custom-file-container__image-preview"></div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-round">GUARDAR</button>
                                <a href="<?=SERVERURL;?>persona/" class="btn btn-rose btn-round">REGRESAR</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'view/templeate/footer.php';?>
<script>
    $(document).ready(function(){
        var firstUpload = new FileUploadWithPreview('myFirstImage');
    });
    $('#formulario').submit(function(e){
        e.preventDefault();
        let nombre = $("#nombre_agregar").val();
        let apellido = $("#apellido_agregar").val();
        let dni = $("#dni_agregar").val();

        if(nombre.length == 0 || apellido.length == 0 || dni.length == 0){
            showNotification('bottom','center','Todos los campos son necesarios ','danger');
        }else{
            var Form = new FormData(document.forms.namedItem("formulario"));
            $.ajax({
                url: "<?=SERVERURL;?>persona/actualizar_personal/",
                type: "post",
                data : Form,
                processData: false,
                contentType: false,
                success: function(data)
                {
                    if(data == 1){
                        showNotification('bottom','center','Datos actualizados correctamente','success');
                        setTimeout(function(){
                            location.reload();
                        },1000);
                    }else{
                        showNotification('bottom','center','Error al actualizar el personal','danger');
                        setTimeout(function(){
                            location.reload();
                        },1000);
                    }
                }
            }); 
        }

    });
</script>