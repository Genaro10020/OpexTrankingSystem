<?php
session_start();

// Para almacenar la ruta de los archivos cargados
$files_arr = array();

if(isset($_FILES['files']['name'])){

///////////////////////////header("Content-Type: application/json");
$cantidad=0;
$suma=0;
 
// Contar archivos totales
$countfiles = count($_FILES['files']['name']);
//$suma=$countfiles + $cantidad;
if($_POST['cual_documento']=="Seguimiento"){
    //echo "LLEGARON".$_POST['id']."y el documento sera:".$_POST['cual_documento'];
    $path = "seguimiento/".$_POST['id']."/";
}else{
    $path = "imagenes/";
}




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
                            if($_POST['cual_documento']=="Seguimiento"){
                                $valid_ext = array("png","jpeg","jpg","pdf","doc","docx","ppt","pptx","xls","xlsx");
                            }else{
                                $valid_ext = array("jpeg","jpg","png");//entension valida para 
                            }
                         
                            // Revisar extension
                            if(in_array($ext, $valid_ext)){

                                if($_POST['cual_documento']=="Seguimiento"){
                                    $filename = str_replace(" ","_", $filename);
                                    $newfilename = $filename;
                                    $ruta_y_doc= $path.$newfilename;
                                }else{
                                    $ruta_y_doc = $path."imagen.jpg";///entension valida para 
                                }

                            // Eliminado Espacios al Nombre
                               

                                // Subir archivos
                                if(move_uploaded_file($_FILES['files']['tmp_name'][$index],$ruta_y_doc))
                                {
                                $files_arr[] = $ruta_y_doc;
                                }
                        }
                    }
            }

}

echo json_encode($files_arr);
?>