<?php
header('Content-Type: application/json');
$respuesta ="";
$variables = json_decode(file_get_contents('php://input'), true);
$ruta = $variables['ruta_eliminar']; //recibo la ruta completa

$ruta_eliminar_doc=str_replace(" ","",$ruta);//elimino datos de ruta que no son necesarias
if(unlink($ruta_eliminar_doc)){
    $respuesta = "Archivo Eliminado";
} else{
   $respuesta = "No Eliminado";
}
echo json_encode($respuesta)
?>