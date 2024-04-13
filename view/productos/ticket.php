<?php
    require 'view/vendor/ticket/autoload.php';
    use Mike42\Escpos\Printer;
    use Mike42\Escpos\EscposImage;
    use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

    /*Conectamos con la impresora*/
    $nombre_impresora = trim(file('print/print.ini')[0]);
    $connector = new WindowsPrintConnector($nombre_impresora);
    $printer = new Printer($connector);

    // /*Cargamos el logo*/
    // $ruta_imagen_logo = "archives/assets/LOGO6553874532237223.png";
    // $logo = EscposImage::load($ruta_imagen_logo, false);

    // /*Le decimos que centre lo que vaya a imprimir*/
    // $printer->setJustification(Printer::JUSTIFY_CENTER);

    // /*Imprimimos imagen y avanzamos el papel*/
    // $printer->bitImage($logo);

    $printer->setTextSize(2,2);
    $printer->text("Ticket con PHP");
    $printer->setTextSize(2,1);
    $printer->feed();
    $printer->text("Hola Mundo");
    $printer->feed(15);
    $printer->cut();
    $printer->pulse();
    $printer->close();
