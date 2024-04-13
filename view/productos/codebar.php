<?php
    require 'view/vendor/fpdf/pdf_barcode.php';
    $pdf=new PDF_BARCODE('p','mm',[55,170]);
    $pdf->AddPage();
    $cn = $this->conexion;
    $id = $this->id;
    $code = $cn->query("SELECT CODIGO_BARRA FROM producto WHERE ID_PRODUCTO = '$id'");
    foreach($code as $row){
        $cb = $row["CODIGO_BARRA"];
        $pdf->EAN13(10,10,$cb);
        $pdf->EAN13(10,40,$cb);
        $pdf->EAN13(10,70,$cb);
        $pdf->EAN13(10,100,$cb);
        $pdf->EAN13(10,130,$cb);
    }
    $pdf->Output();
?>