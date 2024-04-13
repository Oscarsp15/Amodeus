<?php
    class ticket extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->brand = "Ticket";
            $this->view->id_nav_active = "ticket-active";
            $this->view->id_collapase_active = "ventas";
            $this->view->datosticket = $this->datosticket();
            $this->view->render('ticket/editar');
        }
        function datosticket(){
            $cn = mainModel::conectar();
            $array = [];
            $data = $cn->query("SELECT * FROM ticket WHERE ID = 1"); 
            if ($data->RowCount() >= 1) {
                foreach ($data as $rows) {
                    $array = [
                        "Titulo" => $rows["TITULO"],
                        "Direccion" => $rows["DIRECCION"],
                        "Telefono" => $rows["TELEFONO"],
                        "Pie" => $rows["PIE"]
                    ];
                }
            }
            return $array;
        }
        function actualizar(){
            if(isset($_POST["titulo"]) && isset($_POST["direccion"])){
                $cn = mainModel::conectar();
                $titulo = $_POST["titulo"];
                $direccion = $_POST["direccion"];
                $telefono = $_POST["telefono"];
                $pie = $_POST["pie"];
                $actualizar = $cn->query("UPDATE ticket SET TITULO = '$titulo',TELEFONO = '$telefono' ,DIRECCION = '$direccion',PIE = '$pie' WHERE ID = 1");
                if($actualizar->rowCount()>0){
                    echo "
                    <script>
                        showNotification('bottom','center','Datos del Ticket fue actualizado correctamente','success');
                    </script>";
                }else{
                    echo "
                    <script>
                        showNotification('bottom','center','No se pudo actualizar','danger');
                    </script>";
                }
            }
        }
    }