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
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($estiloTituloColumnas);
$objPHPExcel->getActiveSheet()->getStyle('A2:H101')->applyFromArray($Estiloceldas);
echo date('d-m-Y H:i:s') , "Formateando y dando estilos al documento" , EOL;
// Establecer los tamaños a las columnas
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(47);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

// Darle Datos a las celdas
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'NOMBRE');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'STOCK_MINIMO');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'CODIGO_BARRA');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'PRESENTACION');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'MARCA');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'CATEGORIA');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'PRECIO_COSTO');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'PRECIO_VENTA');

// LLenar los datos de las unidades de medida disponibles
$U_fila_inicio=2;
$fila_inicio_unidad=2;
$U_fila_fin = 0;
$unidades = $cn->query("SELECT * FROM `unidad_medida`");
echo date('d-m-Y H:i:s') , " Estableciendo las unidades de medida disponibles" , EOL;
// Recorrer la consulta de unidades
foreach($unidades as $row){
	$objPHPExcel->getActiveSheet()->setCellValue('J' . $fila_inicio_unidad, $row['PREFIJO']);
	$U_fila_fin = $fila_inicio_unidad;
	$fila_inicio_unidad++;
}
// Ocultar datos 
$objPHPExcel->getActiveSheet()
    ->getColumnDimension('J')
	->setVisible(false);
	
// Establecer el rango de Unidades 
$objPHPExcel->addNamedRange(
    new PHPExcel_NamedRange(
        'Unidades', 
        $objPHPExcel->getActiveSheet(),"J$U_fila_inicio:J$U_fila_fin"
    )
);
// LLenar los datos de las Marcas disponibles
echo date('d-m-Y H:i:s') , " Estableciendo las marcas disponibles" , EOL;
$M_fila_inicio=2;
$fila_inicio_marcas=2;
$M_fila_fin = 0;
$marcas = $cn->query("SELECT * FROM `marca`");
// Recorrer la consulta de marcas
foreach($marcas as $row){
	$objPHPExcel->getActiveSheet()->setCellValue('K' . $fila_inicio_marcas, $row['NOMBRE']);
	$M_fila_fin = $fila_inicio_marcas;
	$fila_inicio_marcas++;
}
// Ocultar datos 
$objPHPExcel->getActiveSheet()
    ->getColumnDimension('K')
	->setVisible(false);

// Establecer el rango de Marcas
$objPHPExcel->addNamedRange(
    new PHPExcel_NamedRange(
        'Marcas', 
        $objPHPExcel->getActiveSheet(),"K$M_fila_inicio:K$M_fila_fin"
    )
);
echo date('d-m-Y H:i:s') , " Estableciendo las categorias disponibles" , EOL;
// LLenar los datos de las Categorias disponibles
$C_fila_inicio=2;
$fila_inicio_categorias=2;
$C_fila_fin = 0;
$categorias = $cn->query("SELECT * FROM `categoria`");
// Recorrer la consulta de categorias
foreach($categorias as $row){
	$objPHPExcel->getActiveSheet()->setCellValue('L' . $fila_inicio_categorias, $row['NOMBRE']);
	$C_fila_fin = $fila_inicio_categorias;
	$fila_inicio_categorias++;
}
// Ocultar datos 
$objPHPExcel->getActiveSheet()
    ->getColumnDimension('L')
	->setVisible(false);
// Establecer el rango de Marcas
$objPHPExcel->addNamedRange(
    new PHPExcel_NamedRange(
        'Categorias', 
        $objPHPExcel->getActiveSheet(),"L$C_fila_inicio:L$C_fila_fin"
    )
);

$CeldaInicio = 2;
$CeldaFin = 101;
for($i = 2 ; $CeldaInicio<=$CeldaFin ;$i++){
	// Dropdows unidades
	$objValidation = $objPHPExcel->getActiveSheet()
		->getCell("D$i")
		->getDataValidation();
	$objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST )
		->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION )
		->setAllowBlank(false)
		->setShowInputMessage(true)
		->setShowErrorMessage(true)
		->setShowDropDown(true)
		->setErrorTitle('Unidad de medida no econtrada')
		->setError('Esa unidad de Medida no esta en la lista.')
		->setPromptTitle('Seleccione la Presentacion')
		->setPrompt('Porfavor Seleccione la unidad de medida de su presentacion.')
		->setFormula1('=Unidades');
	// Dropdows marcas
	$objValidation = $objPHPExcel->getActiveSheet()
		->getCell("E$i")
		->getDataValidation();
	$objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST )
		->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION )
		->setAllowBlank(false)
		->setShowInputMessage(true)
		->setShowErrorMessage(true)
		->setShowDropDown(true)
		->setErrorTitle('Marca no econtrada')
		->setError('Esa marca no esta en la lista.')
		->setPromptTitle('Seleccione la marca')
		->setPrompt('Porfavor Seleccione la marca de su presentacion.')
		->setFormula1('=Marcas');
	// Dropdows Categorias
	$objValidation = $objPHPExcel->getActiveSheet()
		->getCell("F$i")
		->getDataValidation();
	$objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST )
		->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION )
		->setAllowBlank(false)
		->setShowInputMessage(true)
		->setShowErrorMessage(true)
		->setShowDropDown(true)
		->setErrorTitle('Categoria no econtrada')
		->setError('Esa categoria no esta en la lista.')
		->setPromptTitle('Seleccione la categoria')
		->setPrompt('Porfavor Seleccione la categroria de su presentacion.')
		->setFormula1('=Categorias');
	$CeldaInicio++;

}

// Activar la Primera Pagina
$objPHPExcel->setActiveSheetIndex(0);
// Save Excel 2007 file
// This linked validation list method only seems to work for Excel2007, not for Excel5
// Redirect output to a client’s web browser (Excel2007)
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
header('Content-Type: application/vnd.ms-exel');
header('Content-Disposition: attachment;filename="PlantillaProducto.xlsx"');
$objWriter->save('php://output');
exit;