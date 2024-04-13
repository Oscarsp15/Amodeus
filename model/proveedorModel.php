<?php
  class proveedorModel extends MainModel{
    function insertar($datos){
      $sql = self::conectar()->prepare("INSERT INTO proveedor(ID_PROVEEDOR, RUC, RAZON_SOCIAL, EMAIL, TELEFONO, DIRECCION, DNI_R, NOMBRE_R, DIRECCION_R, TELEFONO_R) VALUES (:ID_PROVEEDOR, :RUC, :RAZON_SOCIAL, :EMAIL, :TELEFONO, :DIRECCION, :DNI_R, :NOMBRE_R, :DIRECCION_R, :TELEFONO_R)");
      $sql->bindParam(":ID_PROVEEDOR",$datos['id']);
      $sql->bindParam(":RUC",$datos['ruc']);
      $sql->bindParam(":RAZON_SOCIAL",$datos['rs']);
      $sql->bindParam(":EMAIL",$datos['email']);
      $sql->bindParam(":TELEFONO",$datos['telefono']);
      $sql->bindParam(":DIRECCION",$datos['direccion']);
      $sql->bindParam(":DNI_R",$datos['dnir']);
      $sql->bindParam(":NOMBRE_R",$datos['nombrer']);
      $sql->bindParam(":DIRECCION_R",$datos['direccionr']);
      $sql->bindParam(":TELEFONO_R",$datos['telefonor']);
      $sql->execute();
      return $sql;
    }
    function actualizar($datos){
      $sql = self::conectar()->prepare("UPDATE proveedor SET RUC = :RUC, RAZON_SOCIAL = :RAZON_SOCIAL, EMAIL = :EMAIL,TELEFONO = :TELEFONO,DIRECCION=:DIRECCION,DNI_R = :DNI_R,NOMBRE_R = :NOMBRE_R, DIRECCION_R = :DIRECCION_R, TELEFONO_R = :TELEFONO_R WHERE ID_PROVEEDOR=:ID_PROVEEDOR");
      $sql->bindParam(":ID_PROVEEDOR",$datos['id']);
      $sql->bindParam(":RUC",$datos['ruc']);
      $sql->bindParam(":RAZON_SOCIAL",$datos['rs']);
      $sql->bindParam(":EMAIL",$datos['email']);
      $sql->bindParam(":TELEFONO",$datos['telefono']);
      $sql->bindParam(":DIRECCION",$datos['direccion']);
      $sql->bindParam(":DNI_R",$datos['dnir']);
      $sql->bindParam(":NOMBRE_R",$datos['nombrer']);
      $sql->bindParam(":DIRECCION_R",$datos['direccionr']);
      $sql->bindParam(":TELEFONO_R",$datos['telefonor']);
      $sql->execute();
      return $sql;
    }
  }