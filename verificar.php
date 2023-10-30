<?php
session_start();
$arreglo = json_decode(file_get_contents('php://input'), true);
include("conexionGhoner.php");
header('Content-Type: application/json');

$usuario = $arreglo['usuario'];
$contrasena = $arreglo['contrasena'];
 
  
    //Verificar SI existe usuario
   
        $consulta = "SELECT * FROM usuarios WHERE nomina = '$usuario' AND contrasena = '$contrasena' AND tipo_acceso = 'Admin'";
        $query=$conexion->query($consulta);
                if(mysqli_num_rows($query)>0){
                        while ($dato=mysqli_fetch_array($query)) {
                            $_SESSION['nombre']=$dato['nombre'];
                            $_SESSION['nomina']=$dato['nomina'];
                            $_SESSION['planta']=$dato['planta'];
                    $resultado = "Autorizado";
                            }
                }else{
                    $resultado = "Verifique";
                }
     
   

echo json_encode($resultado);
?>