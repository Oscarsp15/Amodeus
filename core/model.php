<?php
    class mainModel{
       function __construct()
        {
            
        }
        static function conectar(){
			$cn = new PDO(SGDB,USER,PASS);
            return $cn;
        }
        static function clean_string($string){
			$string = trim($string);
			$string = stripslashes($string);
			$string = str_ireplace("<script>","",$string);
			$string = str_ireplace("</script>","",$string);
			$string = str_ireplace("<script src=>","",$string);
			$string = str_ireplace("<script type=>","",$string);
			$string = str_ireplace("SELECT * FROM","",$string);
			$string = str_ireplace("DELETE FROM","",$string);
			$string = str_ireplace("INSERT INTO","",$string);
			$string = str_ireplace("[","",$string);
			$string = str_ireplace("]","",$string);
			$string = str_ireplace("^","",$string);
			$string = str_ireplace("==","",$string);
			$string = str_ireplace(";","",$string);
			return $string;
		}
        static function sweet_alert($dato){
			if($dato['Alerta']=='simple'){
				$alerta = "
					<script>
						swal({
							title: '".$dato['Titulo']."',
							text: '".$dato['Texto']."',
							type: '".$dato['Tipo']."'
						});
					</script>				
				";
			}elseif($dato['Alerta']=='recargar'){
				$alerta = "
					<script>
						swal({
							title: '".$dato['Titulo']."',
							text: '".$dato['Texto']."',
							type: '".$dato['Tipo']."',
							confirmButtonText: 'Aceptar'
						}).then(function(){
							location.reload();
						});
					</script>				
				";
			}elseif($dato['Alerta']=='limpiar'){
				$alerta = "
				<script> 
					swal({
						title: '".$dato['Titulo']."',   
						text: '".$dato['Texto']."',   
						type: '".$dato['Tipo']."',    
						confirmButtonText: 'Aceptar',
					}).then(function(){
						$('.FormularioAjax')[0].reset();
					});
				</script>";
			}
			return $alerta;
		}
        static function guardar_bitacora($datos){
			$sql = self::conectar()->prepare("INSERT INTO bitacora(	BCODIGO,BFECHA,BHINICIO,BHFIN,BANO,ID_USUARIO) VALUES(:BCODIGO,:BFECHA,:BHINICIO,:BHFIN,:BYEAR,:ID_USUARIO)");
			$sql->bindParam(":BCODIGO",$datos["codigo"]);
			$sql->bindParam(":BFECHA",$datos["fecha"]);
			$sql->bindParam(":BHINICIO",$datos["inicio"]);
			$sql->bindParam(":BHFIN",$datos["fin"]);
			$sql->bindParam(":BYEAR",$datos["year"]);
			$sql->bindParam(":ID_USUARIO",$datos["usuario"]);
			$sql->execute();
			return $sql;
		}
		static function agregar_cuenta($datos){
			$sql = self::conectar()->prepare("INSERT INTO usuario(ID_USUARIO,ID_PERSONA,USUARIO,CONTRASENA,PERFIL,PRIVILEGIO,ESTADO) VALUES (:ID_USUARIO,:ID_PERSONA,:USUARIO,:CONTRASENA,:PERFIL,:PRIVILEGIO,1)");
			$sql->bindParam(":ID_USUARIO",$datos["id_usuario"]);
			$sql->bindParam(":ID_PERSONA",$datos["id_persona"]);
			$sql->bindParam(":USUARIO",$datos["usuario"]);
			$sql->bindParam(":CONTRASENA",$datos["contrasena"]);
			$sql->bindParam(":PERFIL",$datos["perfil"]);
			$sql->bindParam(":PRIVILEGIO",$datos["privilegio"]);
			$sql->execute();
			return $sql;
		}
		function eliminar_cuenta($id){
			$sql = self::conectar()->prepare("DELETE FROM usuario WHERE ID_USUARIO = :CODIGO");
			$sql->bindParam(":CODIGO",$id);
			$sql->execute();
			return $sql;
		}
		function actualizar_bitacora($codigo,$hora){
			$sql = self::conectar()->prepare("UPDATE bitacora SET BHFIN = :HORA WHERE BCODIGO = :CODIGO");
			$sql->bindParam(":HORA",$hora);
			$sql->bindParam(":CODIGO",$codigo);
			$sql->execute();
			return $sql;
		}
        static function encryption($string){
			$output = FALSE;
			$key = hash('sha256', SECRET_KEY);
			$iv = substr(hash('sha256', SECRET_IV), 0, 16);
			$output = openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output = base64_encode($output);
			return $output;
		}
		static function ejecutar_consulta_simple($query){
			$response = self::conectar()->prepare($query);
			$response->execute();
			return $response;
		}
		static function decryption($string){
			$key = hash('sha256', SECRET_KEY);
			$iv = substr(hash('sha256', SECRET_IV), 0, 16);
			$output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
		}
		static function generar_codigo_aleatorio($letra,$longitud,$num){
			for ($i=0; $i < $longitud ; $i++) { 
				$numero = rand(0,9);
				$letra.= $numero;
			}
			return $letra.$num;
		}
		static function parametros(){
			$cn = self::conectar();
			$array = [];
			$data = $cn->query("SELECT * FROM paramatros WHERE ID_PARAMETRO = 1"); 
			if ($data->RowCount() >= 1) {
				foreach ($data as $rows) {
					$logo = $rows["LOGO"];
					if(empty($logo)){
						$logo = "AMOSIS-LOGO-pdf.png";
					}
					$tipo = $rows["TIPO"];
					if($tipo == 1){
						$tipo = "RUC";
					}else{
						$tipo = "NIT";
					}
					$array = [
						"Moneda" => $rows["MONEDA"],
						"Empresa" => $rows["EMPRESA"],
						"Tipo" => $tipo,
						"Num" => $rows["NUMERO"],
						"Propietario" => $rows["PROPIETARIO"],
						"Direccion" => $rows["DIRECCION"],
						"Logo" => $logo
					];
				}
			}
			return $array;
		}
    }