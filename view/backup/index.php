<?php 
    require 'view/templeate/head.php';
?>
<?php
    if(!$_SESSION["backup"]){
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
                    <h4 class="card-title">Respaldo y Restauración del Sistema</h4>
                    <p class="card-category">Amosis Backup</p>
                </div>
                <div class="card-body">
                    <form autocomplete="off" name="formulario" id="formulario">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <button type="button" id="gen_copy" class="btn btn-primary pull-right">Realizar Copia de Seguridad</button>                     
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Lista de Backups</label>
                                    <select name="backups" id="backups" class="custom-select">
                                        <option value="" disabled="" selected="">Selecciona un punto de restauración</option>
                                        <?php
                                             $ruta = "archives/backup/";
                                             if (is_dir($ruta)) {
                                                 if ($aux = opendir($ruta)) {
                                                     while (($archivo = readdir($aux)) !== false) {
                                                         if ($archivo != "." && $archivo != "..") {
                                                             $nombrearchivo = str_replace(".sql", "", $archivo);
                                                             $nombrearchivo = str_replace("-", ":", $nombrearchivo);
                                                             $ruta_completa = $ruta . $archivo;
                                                             if (is_dir($ruta_completa)) {
                                                             } else {
                                                                 echo '<option value="' .$ruta_completa. '">' . $nombrearchivo . '</option>';
                                                             }
                                                         }
                                                     }
                                                     closedir($aux);
                                                 }
                                             } else {
                                                 echo $ruta . " No es ruta válida";
                                             }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary pull-right">RESTAURAR</button>                     
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<?php require 'view/templeate/footer.php';?>
<script>
    $('#gen_copy').click(function(){
        var token = "amosis";
        showNotification('bottom','center','Espere... Se esta creando la Copia de Seguridad...','info');
        $.post("<?=SERVERURL;?>backup/respaldo/",{token},function(res){
            if(res == 1){
                showNotification('bottom','center','La copia de seguridad se realizo correctamente','success');
                setTimeout(function(){
                    location.reload();
                },1000);
            }else{
                showNotification('bottom','center','No se pudo crear la copia de seguridad, Si el problema persiste por favor presione F5','danger');
            }
        });
    });
    $("#formulario").submit(function(e){
        e.preventDefault();
        let select = document.getElementById("backups");
        if(select.value == 0 || select.value == ""){
            showNotification('bottom','center','Debes seleccionar una opcion','danger');
        }else{
            showNotification('bottom','center','Restaurando... ','success');
            $("#preloader").fadeIn(300);
            var Form = new FormData(document.forms.namedItem("formulario"));
            $.ajax({
                url: "<?=SERVERURL;?>backup/restauracion/",
                type: "post",
                data : Form,
                processData: false,
                contentType: false,
                success: function(data)
                {
                    if(data == 1){
                        showNotification('bottom','center','Restauración completada con éxito','success');
                        setTimeout(function(){
                            location.reload();
                        },1000);
                    }else{
                        showNotification('bottom','center','Ocurrio un error inesperado, no se pudo hacer la restauración completamente','danger');
                        setTimeout(function(){
                            location.reload();
                        },1000);
                    }
                }
            }); 
        }
    });
</script>