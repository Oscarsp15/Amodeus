<?php
/**
 * Establecer la conexion a la base de datos
 */

$cn = $this->conexion;
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Lima');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Incluir PHPExcel */
require_once 'view/vendor/excel/PHPExcel.php';


// Crear nuevo object PHPExcel 
echo date('d-m-Y H:i:s') , " Creando nuevo Objeto de PHPExcel" , EOL;
$objPHPExcel = new PHPExcel();

// Establecer Propiedades al document
echo date('d-m-Y H:i:s') , " Estableciendo Propiedades al documento" , EOL;

$objPHPExcel->getProperties()
    ->setCreator("Jhony Creativo")
	->setLastModifiedBy("Jhony Creativo")
	->setTitle("Plantilla para agregar productos")
	->setSubject("Plantilla para agregar productos")
	->setDescription("Este Documento esta especializado para la importacion de porductos")
	->setKeywords("Jhony Creativo | Plantilla | Excel")
	->setCategory("ImportacionProductos");

// Establecer la hoja activa y darle nombre
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle("Productos");

// Darle Estilos a las columnas
$estiloTituloColumnas = array(
	'font' => array(
		'name'  => 'Arial',
		'bold'  => true,
		'size' =>10,
		'color' => array(
		'rgb' => 'FFFFFF'
		)
	),
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'color' => array('rgb' => '538DD5')
		),
		'borders' => array(
		'allborders' => array(
		'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	),
	'alignment' =>  array(
		'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
	)
);
$Estiloceldas = array(
	'font' => array(
		'name'  => 'Arial',
		'bold'  => true,
		'size' =>10,
		'color' => array(
		'rgb' => '000000'
		)
	),
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'color' => array('rgb' => 'FFFFFF')
		),
		'borders' => array(
		'allborders' => array(
		'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	),
	'alignment' =>  array(
		'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
	)
);
// Establecer los estilos a la columna
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($estiloTituloColumnas);
echo date('d-m-Y H:i:s') , "Formateando y dando estilos al documento" , EOL;
// Establecer los tamaños a las columnas
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(47);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

// Darle Datos a las celdas
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'CODIGO');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'NOMBRE');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'STOCK');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'CODIGO_BARRA');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'PRESENTACION');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'MARCA');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'CATEGORIA');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'PRECIO_COSTO');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'PRECIO_VENTA');

// LLenar los datos de las unidades de medida disponibles
$fila_inicio=2;
$fila_inicio_producto=2;
$fila_fin = 0;
$producto = $cn->query("SELECT p.ID_PRODUCTO,p.NOMBRE,pa.STOCK,p.CODIGO_BARRA,um.PREFIJO,m.NOMBRE as MARCA,c.NOMBRE as CATEGORIA ,p.PRECIO_COSTO,p.PRECIO_VENTA FROM productos_almacen as pa INNER JOIN producto as p on pa.ID_PRODUCTO = p.ID_PRODUCTO INNER JOIN unidad_medida as um ON p.ID_UNIDAD = um.ID_UNIDAD INNER JOIN marca as m on p.ID_MARCA = m.ID_MARCA INNER JOIN categoria as c on c.ID_CATEGORIA = p.ID_CATEGORIA");
echo date('d-m-Y H:i:s') , " Estableciendo las unidades de medida disponibles" , EOL;
// Recorrer la consulta de unidades
foreach($producto as $row){
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $fila_inicio_producto, $row['ID_PRODUCTO']);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $fila_inicio_producto, $row['NOMBRE']);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $fila_inicio_producto, $row['STOCK']);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $fila_inicio_producto, $row['CODIGO_BARRA']);
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $fila_inicio_producto, $row['PREFIJO']);
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $fila_inicio_producto, $row['MARCA']);
	$objPHPExcel->getActiveSheet()->setCellValue('G' . $fila_inicio_producto, $row['CATEGORIA']);
	$objPHPExcel->getActiveSheet()->setCellValue('H' . $fila_inicio_producto, $row['PRECIO_COSTO']);
	$objPHPExcel->getActiveSheet()->setCellValue('I' . $fila_inicio_producto, $row['PRECIO_VENTA']);
	$fila_fin = $fila_inicio_producto;
	$fila_inicio_producto++;
}

$objPHPExcel->getActiveSheet()->getStyle("A$fila_inicio:I$fila_fin")->applyFromArray($Estiloceldas);
// Activar la Primera Pagina
$objPHPExcel->setActiveSheetIndex(0);
// Save Excel 2007 file
// This linked validation list method only seems to work for Excel2007, not for Excel5
// Redirect output to a client’s web browser (Excel2007)
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
header('Content-Type: application/vnd.ms-exel');
header('Content-Disposition: attachment;filename="Reporte_excel_productos.xlsx"');
$objWriter->save('php://output');
exit;