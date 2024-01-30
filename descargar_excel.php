<?php
session_start();
include '../excel/Classes/PHPExcel.php'; // al subir en linea
//include 'PHPExcel/Classes/PHPExcel.php'; //local
include "conexionGhoner.php";

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()
        ->setCreator("Opex Tracking System")
        ->setLastModifiedBy("GV")
        ->setTitle("Excel en PHP")
        ->setSubject("Reporte Impacto Ambiental")
        ->setDescription("Documento generado")
        ->setKeywords("excel phpexcel php")
        ->setCategory("datos");

        $nuevaHoja = $objPHPExcel->createSheet()->setTitle('Valores');

        $consultaValores = "SELECT * FROM valores";
        $resultado = $conexion->query($consultaValores);
        
        $valores[] = 'Mes/Año';
        while ($fila = $resultado->fetch_assoc()) {
            $valores[] = $fila['valor'];
        }
        
        // Agregar los valores a la hoja "Valores" en la fila 1 desde la celda A1 hasta la celda G1
        $nuevaHoja->fromArray($valores, null, 'A1');


$consulta = "SELECT proyectos_creados.id, impacto_ambiental_proyecto.impacto_ambiental, proyectos_creados.nombre_proyecto, registros_impacto_ambiental.dato, registros_impacto_ambiental.ahorro_duro, registros_impacto_ambiental.ahorro_suave, registros_impacto_ambiental.mes, registros_impacto_ambiental.anio 
FROM registros_impacto_ambiental JOIN impacto_ambiental_proyecto ON registros_impacto_ambiental.id_impacto_ambiental_proyecto = impacto_ambiental_proyecto.id 
JOIN proyectos_creados ON impacto_ambiental_proyecto.id_proyecto = proyectos_creados.id ORDER BY `registros_impacto_ambiental`.`anio` ASC";
$query = $conexion->query($consulta);





$datos = array(
    array('ID', 'Mes', 'Año','Impacto Ambiental', 'Cántidad','Nombre Proyecto', 'Ahorro Duro','Ahorro Suave'),
);

// Añadir los resultados de la consulta a la matriz $datos
while ($fila = $query->fetch_assoc()) {
    $datos[] = array(
        $fila['id'],
        $fila['mes'],
        $fila['anio'],
        $fila['impacto_ambiental'],
        $fila['dato'],
        $fila['nombre_proyecto'],
        $fila['ahorro_duro'],
        $fila['ahorro_suave'],
    );
}

// Centrar el contenido de las columnas B a D
$objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('1:1')->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

// Usar fromArray para escribir los datos en el archivo de Excel
$objPHPExcel->getActiveSheet()->fromArray($datos, null, 'A1');

// Establecer el ancho de las columnas A a H
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10); // Ancho
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Ancho
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15); // Ancho
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40); // Ancho
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15); // Ancho
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(60); // Ancho
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15); // Ancho
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15); // Ancho

// Get the active sheet in your PHPExcel object



// Aplicar formato en negrita a la fila 1
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);

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