<?php
class backup extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function render()
    {
        $this->view->brand = "Backup";
        $this->view->id_nav_active = "backup-active";
        $this->view->id_collapase_active = "";
        $this->view->render('backup/index');
    }
    public function respaldo()
    {
        // Establecer conexion de la base de datos
        $cn = mainModel::conectar();
        // Datos del dia
        $day = date("d");
        $mont = date("m");
        $year = date("Y");
        $hora = date("H-i-s");
        $fecha = $day . '_' . $mont . '_' . $year;
        // Nombre del archivo
        $DataBASE = "BACKUP_AMOSIS_" . $fecha . "_(" . $hora . "_hrs).sql";
        // Arreglo de tablas
        $tables = array();
        $result = $cn->query('SHOW TABLES');
        if ($result->rowCount()) {
            $sql = 'SET FOREIGN_KEY_CHECKS=0;' . "\n\n";
            $sql .= 'CREATE DATABASE IF NOT EXISTS ' . DB . ";\n\n";
            $sql .= 'USE ' . DB . ";\n\n";
            foreach ($result as $row) {
                $tables[] = $row[0];
            }
            foreach ($tables as $table) {
                $sql .= "DROP TABLE IF EXISTS $table;\n\n";
                $resultado_filas = $cn->query("SELECT * FROM $table");
                $numero_filas = $resultado_filas->columnCount();
                $creartable = $cn->query("SHOW CREATE TABLE $table");
                $creartable = $creartable->fetchColumn(1);
                $sql .= $creartable . ";\n\n";
                for ($i = 0; $i < $numero_filas; $i++) {
                    foreach ($resultado_filas as $row) {
                        // Creando sql de insertar datos
                        $sql .= 'INSERT INTO ' . $table . ' VALUES(';
                        for ($j = 0; $j < $numero_filas; $j++) {
                            $row[$j] = addslashes($row[$j]);
                            $row[$j] = str_replace("\n", "\\n", $row[$j]);
                            if (isset($row[$j])) {
                                $sql .= '"' . $row[$j] . '"';
                            } else {
                                $sql .= '""';
                            }
                            if ($j < ($numero_filas - 1)) {
                                $sql .= ',';
                            }
                        }
                        $sql .= ");\n";
                    }
                }
                $sql .= "\n\n";
            }
            chmod("archives/backup/", 0777);
            $sql .= 'SET FOREIGN_KEY_CHECKS=1;';
            $handle = fopen("archives/backup/" . $DataBASE, 'w+');
            if (fwrite($handle, $sql)) {
                fclose($handle);
                echo '1';
            } else {
                echo '0';
            }
        } else {
            echo "0";
        }

    }
    public function restauracion(){
        if(isset($_POST["backups"])){
            // Traendo los archivos
            $restorePoint = $_POST['backups'];
            $sql = explode(";",file_get_contents($restorePoint));
            $totalErrors=0;
            set_time_limit (60);
            $cn = mainModel::conectar();
            $cn->query("SET FOREIGN_KEY_CHECKS=0");
            for($i = 0; $i < (count($sql)-1); $i++){
                if($cn->query($sql[$i].";")){  }else{ $totalErrors++; }
            }
            $cn->query("SET FOREIGN_KEY_CHECKS=1");
            if($totalErrors<=0){
                echo 1;
            }else{
                echo 0;
            }
        }
    }
}
