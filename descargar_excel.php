<?php
session_start();

include 'PHPExcel/Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()
        ->setCreator("Opex Tracking Sytem")
        ->setLastModifiedBy("GV")
        ->setTitle("Excel en PHP")
        ->setSubject("Reporte Impacto Ambiental")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("excel phpexcel php")
        ->setCategory("Ejemplos");

// Añadir datos al archivo

include "conexionGhoner.php";

$consulta = "SELECT proyectos_creados.id, impacto_ambiental_proyecto.impacto_ambiental, proyectos_creados.nombre_proyecto, registros_impacto_ambiental.ahorro_duro, registros_impacto_ambiental.mes, registros_impacto_ambiental.anio 
FROM registros_impacto_ambiental JOIN impacto_ambiental_proyecto ON registros_impacto_ambiental.id_impacto_ambiental_proyecto = impacto_ambiental_proyecto.id 
JOIN proyectos_creados ON impacto_ambiental_proyecto.id_proyecto = proyectos_creados.id WHERE impacto_ambiental_proyecto.impacto_ambiental !='Sin Impacto' ORDER BY `registros_impacto_ambiental`.`anio` ASC";

$query = $conexion->query($consulta);

$datos = array(
    array('ID', 'Impacto Ambiental', 'Nombre Proyecto', 'Ahorro Duro', 'Mes', 'Año'),
);

// Añadir los resultados de la consulta a la matriz $datos
while ($fila = $query->fetch_assoc()) {
    $datos[] = array(
        $fila['id'],
        $fila['impacto_ambiental'],
        $fila['nombre_proyecto'],
        $fila['ahorro_duro'],
        $fila['mes'],
        $fila['anio'],
    );
}

// Centrar el contenido de las columnas B a D
$objPHPExcel->getActiveSheet()->getStyle('1:1')->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

// Usar fromArray para escribir los datos en el archivo de Excel
$objPHPExcel->getActiveSheet()->fromArray($datos, null, 'A1');

// Establecer el ancho de las columnas A a F
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10); // Ancho
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40); // Ancho
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(60); // Ancho
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Ancho
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15); // Ancho
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15); // Ancho

// Aplicar formato en negrita a la fila 1
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

$ruta = "reportes/";
if(!is_dir($ruta)){
    mkdir($ruta,0775,true);
}
// Guardar el archivo en el sistema de archivos
$date = date('Y-m-d');
$nombreArchivo = 'reporte_impacto_ambiental'.$date.'.xlsx';
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($ruta.$nombreArchivo);

// El archivo se guardó correctamente
if(file_exists($ruta.$nombreArchivo)){
    echo json_encode(array("success" => true, "archivo" => $nombreArchivo));
}else{
    echo json_encode(array("success" => false, "archivo" => $nombreArchivo));
}



?>