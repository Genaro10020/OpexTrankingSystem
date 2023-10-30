
<?php
session_start();
if(isset($_SESSION['nombre'])){

$arreglo = json_decode(file_get_contents('php://input'), true);
include("conexionGhoner.php");
header('Content-Type: application/json');
$resultado = "";
$departamento = $arreglo['departamento'];
$nombre = $arreglo['nombre'];
$id = $arreglo['id'];



if($departamento=="Planta"){
            //Verificar SI existe usuario
            $actualizar = "UPDATE plantas SET  nombre='$nombre' WHERE id='$id'";
            $query = $conexion->query($actualizar);
            if ($query) {
                $resultado = $query;
            } else {
                $resultado = "Error en la consulta: " . mysqli_error($conexion);
            }
            
}else if($departamento=="Área"){
            //Verificar SI existe usuario
            $actualizar = "UPDATE areas SET nombre='$nombre' WHERE id='$id'";
            $query = $conexion->query($actualizar);
            if ($query) {
                $resultado = $query;
            } else {
                $resultado = "Error en la consulta: " . mysqli_error($conexion);
            }

}else if($departamento=="Subárea"){
            //Verificar SI existe usuario
            $actualizar = "UPDATE subareas SET nombre='$nombre' WHERE id='$id'";
            $query = $conexion->query($actualizar);
            if ($query) {
                $resultado = $query;
            } else {
                $resultado = "Error en la consulta: " . mysqli_error($conexion);
            }

}else{
    
}
             

echo json_encode($resultado);

}else{
    header("Location:index.php");
}
?>