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
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header card-header-amosis">
                    <h4 class="card-title">Nuevo Personal</h4>
                    <p class="card-category">Complete los datos del Personal</p>
                </div>
                <div class="card-body">
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
                                    <label class="bmd-label-floating">Nombre</label>
                                    <input type="text" name="nombre_agregar" id="nombre_agregar" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Apellido</label>
                                    <input type="text" name="apellido_agregar" id="apellido_agregar" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">N° Indentificacion</label>
                                    <input type="text" name="dni_agregar" id="dni_agregar" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Direccion</label>
                                    <input type="text" name="direccion_agregar" id="direccion_agregar" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Telefono</label>
                                    <input type="text" name="telefono_agregar" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="alert alert-warning">
                                    <b>IMPORTANTE</b> La foto de tu personal es necesaria.
                                </div>
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
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary pull-right">Guardar Persona</button>                
                        <a href="<?=SERVERURL;?>persona/" class="btn btn-sm btn-rose pull-right">Regresar</a>                
                    </form>
                </div>
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
        let direccion = $("#direccion_agregar").val();
        if(nombre.length == 0 || apellido.length == 0 || dni.length == 0 || direccion.length == 0){
            showNotification('bottom','center','Todos los campos son necesarios ','danger');
        }else{
            if(document.getElementById('file').files.length == 0){
                showNotification('bottom','center','No has seleccionado la foto de perfil ','danger');
            }else{
                var Form = new FormData(document.forms.namedItem("formulario"));
                $.ajax({
                    url: "<?=SERVERURL;?>persona/agregar_personal/",
                    type: "post",
                    data : Form,
                    processData: false,
                    contentType: false,
                    success: function(data)
                    {
                        if(data == 1){
                            showNotification('bottom','center','Personal Agregado correctamente','success');
                            setTimeout(function(){
                                location.reload();
                            },1000);
                        }else{
                            showNotification('bottom','center','Error al agregar el personal','danger');
                            setTimeout(function(){
                                location.reload();
                            },1000);
                        }
                    }
                }); 
            }
        }

    });
</script>