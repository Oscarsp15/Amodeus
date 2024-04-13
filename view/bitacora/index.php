<?php
require 'view/templeate/head.php';
$cn = $this->cn;
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
              <div class="card">
                <div class="card-header card-header-amosis">
                  <h4 class="card-title">Bitacora de Sesion</h4>
                  <p class="card-category">Lista de Inicio de Sesion</p>
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover text-center table-striped">
                    <thead class="text-amosis">
                      <tr>
                        <th>ID</th>
                        <th>F.Inicio</th>
                        <th>F.Fin</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $persona = $_SESSION["usuario"];
                        $bit = $_SESSION["sesion"];
                        $bitacora = $cn->query("SELECT * FROM `bitacora` WHERE ID_USUARIO = '$persona' ORDER BY `bitacora`.`F_INICIO` DESC");
                        foreach ($bitacora as $row){
                          $id = $row["ID_BITACORA"];
                          $fi = $row["F_INICIO"];
                          $ff = $row["F_FIN"];
                          if($ff == ""){
                            $ff = "No registrado";
                          }
                          if($id == $bit){
                            $ff = "Sesion Actual";
                          }
                          echo "
                          <tr>
                            <td>$id</td>
                            <td>$fi</td>
                            <td>$ff</td>
                          </tr>";
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<?php
require 'view/templeate/footer.php';
?>