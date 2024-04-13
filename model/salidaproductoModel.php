<?php
  
  class salidaproductoModel extends mainModel{
    function insertar($datos){
      $sql = self::conectar()->prepare("INSERT INTO salida_producto(ID_SALIDA, TIPO_SALIDA, DESTINATARIO, DOC_DESTINATARIO, NUM_DOC_DESTINATARIO, DOCUMENTO, NUMERO, OBSERVACION) VALUES (:ID_SALIDA, :TIPO_SALIDA, :DESTINATARIO, :DOC_DESTINATARIO, :NUM_DOC_DESTINATARIO, :DOCUMENTO, :NUMERO, :OBSERVACION)");
      $sql->bindParam(":ID_SALIDA",$datos['cod_salida']);
      $sql->bindParam(":TIPO_SALIDA",$datos['tipo_salida']);
      $sql->bindParam(":DESTINATARIO",$datos['nombre_destinatario']);
      $sql->bindParam(":DOC_DESTINATARIO",$datos['tipo_documento_destinatario']);
      $sql->bindParam(":NUM_DOC_DESTINATARIO",$datos['numero_documento_destinatario']);
      $sql->bindParam(":DOCUMENTO",$datos['documento']);
      $sql->bindParam(":NUMERO",$datos['numero']);
      $sql->bindParam(":OBSERVACION",$datos['observacion']);
      $sql->execute();
      return $sql;
    }
    function actualizar($datos){
      $sql = self::conectar()->prepare("UPDATE salida_producto SET TIPO_SALIDA= :TIPO_SALIDA ,DESTINATARIO= :DESTINATARIO ,DOC_DESTINATARIO= :DOC_DESTINATARIO ,NUM_DOC_DESTINATARIO= :NUM_DOC_DESTINATARIO ,DOCUMENTO= :DOCUMENTO ,NUMERO= :NUMERO ,OBSERVACION= :OBSERVACION WHERE ID_SALIDA = :ID_SALIDA");
      $sql->bindParam(":ID_SALIDA",$datos['cod_salida']);
      $sql->bindParam(":TIPO_SALIDA",$datos['tipo_salida']);
      $sql->bindParam(":DESTINATARIO",$datos['nombre_destinatario']);
      $sql->bindParam(":DOC_DESTINATARIO",$datos['tipo_documento_destinatario']);
      $sql->bindParam(":NUM_DOC_DESTINATARIO",$datos['numero_documento_destinatario']);
      $sql->bindParam(":DOCUMENTO",$datos['documento']);
      $sql->bindParam(":NUMERO",$datos['numero']);
      $sql->bindParam(":OBSERVACION",$datos['observacion']);
      $sql->execute();
      return $sql;
    }
  }