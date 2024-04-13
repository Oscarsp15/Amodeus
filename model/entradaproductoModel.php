<?php
  
  class entradaproductoModel extends mainModel{
    function insertar($datos){
      $sql = self::conectar()->prepare("INSERT INTO entrada_producto(ID_ENTRADA, TIPO_INGRESO, ID_PROVEEDOR, DOCUMENTO, NUMERO, OBSERVACION) VALUES (:ID_ENTRADA, :TIPO_INGRESO, :ID_PROVEEDOR, :DOCUMENTO, :NUMERO, :OBSERVACION)");
      $sql->bindParam(":ID_ENTRADA",$datos['cod_entrada']);
      $sql->bindParam(":TIPO_INGRESO",$datos['tipo_ingreso']);
      $sql->bindParam(":ID_PROVEEDOR",$datos['proveedor']);
      $sql->bindParam(":DOCUMENTO",$datos['documento']);
      $sql->bindParam(":NUMERO",$datos['numero']);
      $sql->bindParam(":OBSERVACION",$datos['observacion']);
      $sql->execute();
      return $sql;
    }
    function actualizar($datos){
      $sql = self::conectar()->prepare("UPDATE entrada_producto SET TIPO_INGRESO=:TIPO_INGRESO,ID_PROVEEDOR=:ID_PROVEEDOR,DOCUMENTO=:DOCUMENTO,NUMERO=:NUMERO,OBSERVACION=:OBSERVACION WHERE ID_ENTRADA = :ID_ENTRADA");
      $sql->bindParam(":ID_ENTRADA",$datos['cod_entrada']);
      $sql->bindParam(":TIPO_INGRESO",$datos['tipo_ingreso']);
      $sql->bindParam(":ID_PROVEEDOR",$datos['proveedor']);
      $sql->bindParam(":DOCUMENTO",$datos['documento']);
      $sql->bindParam(":NUMERO",$datos['numero']);
      $sql->bindParam(":OBSERVACION",$datos['observacion']);
      $sql->execute();
      return $sql;
    }
  }