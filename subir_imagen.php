<?php

session_start();
$plantaBD = $_SESSION['planta'];
include "conexionGhoner.php"; 
// Para almacenar la ruta de los archivos cargados
$files_arr = array();

if(isset($_FILES['files']['name'])){

///////////////////////////header("Content-Type: application/json");
$cantidad=0;
$suma=0;
 
// Contar archivos totales
$countfiles = count($_FILES['files']['name']);
//$suma=$countfiles + $cantidad;

$path = "imagenes/";

//verificar si existe directorio de$path = "sample/path/newfolder";
if (!file_exists($path)) {
    mkdir($path, 0777, true);
}

// Ciclo todos los archivos
    for($index = 0;$index < $countfiles;$index++)
            {
                if(isset($_FILES['files']['name'][$index]) && $_FILES['files']['name'][$index] != '')
                    {
                            // Nombre del archivo
                            $filename = $_FILES['files']['name'][$index];
                            
                            // Obtener la extención del archivo
                            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                            // Validar extensiones permitidas
                            $valid_ext = array("jpeg","jpg","png");//entension valida para 
                         
                            // Revisar extension
                            if(in_array($ext, $valid_ext)){

                            $ruta_y_doc= $path."imagen.jpg";

                            // Subir archivos
                            if(move_uploaded_file($_FILES['files']['tmp_name'][$index],$ruta_y_doc)){
                            $files_arr[] = $ruta_y_doc;
                            }
                        }
                    }
            }

}

echo json_encode($files_arr);
?>