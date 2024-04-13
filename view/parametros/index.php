<?php 
    require 'view/templeate/head.php';
    $dato = $this->parametros;
?>
<?php
    if(!$_SESSION["parametros"]){
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
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header card-header-amosis">
                        <h4 class="card-title">Parametros del Sidebar</h4>
                        <p class="card-category">Configuracion del Sidebar</p>
                    </div>
                    <div class="card-body">
                        <form autocomplete="off" name="formulario2" id="formulario2">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Nombre del Sistema</label>
                                        <input type="text" name="nombre" value="<?=$_SESSION['NOMBRESIDE']?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="custom-file-container" data-upload-id="myFirstImage2">
                                        <label>Subir logo de tu empresa  <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                        <label class="custom-file-container__custom-file" >
                                            <input type="file" id="file" type="file" name="file" class="custom-file-container__custom-file__custom-file-input" accept="*">
                                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                                        </label>
                                        <div class="custom-file-container__image-preview"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary pull-right">Guardar</button>                     
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header card-header-amosis">
                        <h4 class="card-title">Datos de la Empresa</h4>
                        <p class="card-category">Configuracion de los datos del ticket</p>
                    </div>
                    <div class="card-body">
                        <form autocomplete="off" name="formulario" id="formulario">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Nombre de la Empresa</label>
                                        <input type="text" name="nombre_empresa" value="<?=$dato['Empresa']?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Tipo de identificacion</label>
                                        <select name="tipoi_empresa" class="custom-select">
                                            <?php
                                                if($dato['Tipo']==1){
                                            ?>
                                            <option value="1" selected>RUC</option>
                                            <option value="2">NIT</option>
                                            <?php
                                                }else{
                                            ?>
                                            <option value="1">RUC</option>
                                            <option value="2" selected>NIT</option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">N° de Identificacion</label>
                                        <input type="text" name="n_empresa" value="<?=$dato['Num']?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Propietario de la empresa</label>
                                        <input type="text" name="propietario_empresa" value="<?=$dato['Propietario']?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Moneda</label>
                                        <input type="text" name="moneda_empresa" value="<?=$dato['Moneda']?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Direccion</label>
                                        <input type="text" name="direccion_empresa" value="<?=$dato['Direccion']?>" class="form-control">
                                    </div>
                                </div>
                                <!---div class="col-sm-12">
                                    <div class="alert alert-warning">
                                        <b>IMPORTANTE</b> el logo de tu empresa se mostrara en los reportes que genera este sistema, te recomendamos subir la imagen en fondo blanco y que sea de forma cuadrada.
                                    </div>
                                    <div class="custom-file-container" data-upload-id="myFirstImage">
                                        <label>Subir logo de tu empresa  <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                        <label class="custom-file-container__custom-file" >
                                            <input type="file" id="file" type="file" name="file" class="custom-file-container__custom-file__custom-file-input" accept="*">
                                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                                        </label>
                                        <div class="custom-file-container__image-preview"></div>
                                    </div>
                                </div---->
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary pull-right">Guardar</button>                     
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="footer">
                        <div class="card-avatar" style="width: 100rem;height: 100rem;">
                            <div>
                                <?php 
                                    if(empty($dato['Logo'])){
                                ?>
                                    <img class="img" src="<?=SERVERURL;?>archives/assets/logo-amodeus.png">
                                <?php
                                    }else{
                                ?>
                                        <img class="img" src="<?=SERVERURL;?>archives/assets/logo-amodeus.png">
                                <?php
                                    }
                                ?>
                            <div class="ripple-container"></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'view/templeate/footer.php';?>
<script>
    $(document).ready(function(){
        var firstUpload2 = new FileUploadWithPreview('myFirstImage2');
        var firstUpload = new FileUploadWithPreview('myFirstImage');
    });
    $('#formulario').submit(function(e){
        e.preventDefault();
        var Form = new FormData(document.forms.namedItem("formulario"));
        $.ajax({
            url: "<?=SERVERURL;?>parametros/actualizar/",
            type: "post",
            data : Form,
            processData: false,
            contentType: false,
            success: function(data)
            {
                if(data==1){
                    showNotification('bottom','center','La actualizacion se hizo correctamente','success');
                    setTimeout(function(){
                        location.reload();
                    },1000);
                }else{
                    showNotification('bottom','center','No se pudo actualizar los datos, Si el problema persiste por favor presione F5','danger');
                }
            }
        }); 
    });
    $('#formulario2').submit(function(e){
        e.preventDefault();
        var Form = new FormData(document.forms.namedItem("formulario2"));
        $.ajax({
            url: "<?=SERVERURL;?>parametros/actualizarside/",
            type: "post",
            data : Form,
            processData: false,
            contentType: false,
            success: function(data)
            {
                if(data==1){
                    showNotification('bottom','center','La actualizacion se hizo correctamente','success');
                    setTimeout(function(){
                        location.reload();
                    },1000);
                }else{
                    showNotification('bottom','center','No se pudo actualizar los datos, Si el problema persiste por favor presione F5','danger');
                }
            }
        }); 
    });
</script>