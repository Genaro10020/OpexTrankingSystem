
<?php
header("Content-Type: application/json");
$variables = json_decode(file_get_contents('php://input'), true);
$respuesta = [];
//ruta para buacar
$ruta = "imagenes";
if (is_dir($ruta)){
    // Abre un gestor de directorios para la ruta indicada
    $gestor = opendir($ruta);

    // Recorre todos los archivos del directorio
    while (($archivo = readdir($gestor)) !== false)  {
        // Solo buscamos archivos sin entrar en subdirectorios
        if (is_file($ruta."/".$archivo)) {
                $respuesta [] =  "http://localhost/OpexTrackingSystem/".$ruta."/".$archivo;
               // $respuesta [] =  $ruta."/".$archivo;
        }    
    }
    // Cierra el gestor de directorios
    closedir($gestor);
} else {
    $respuesta = [];
}
echo json_encode($respuesta);
?>