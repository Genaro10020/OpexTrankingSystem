<?php
session_start();
$arreglo = json_decode(file_get_contents('php://input'), true);
include("conexionGhoner.php");
header('Content-Type: application/json');

$usuario = $arreglo['usuario'];
$contrasena = $arreglo['contrasena'];
 
  
    //Verificar SI existe usuario
   
        $consulta = "SELECT * FROM usuarios WHERE nomina = '$usuario' AND contrasena = '$contrasena' AND (tipo_acceso = 'Admin' OR tipo_acceso='Financiero' OR tipo_acceso='SymaUser')";
        $query=$conexion->query($consulta);
                if(mysqli_num_rows($query)>0){
                        while ($dato=mysqli_fetch_array($query)) {
                            $_SESSION['nombre']=$dato['nombre'];
                            $_SESSION['nomina']=$dato['nomina'];
                            $_SESSION['acceso']=$dato['tipo_acceso'];
                                if($dato['tipo_acceso']=="Financiero"){
                                        $_SESSION['acceso']='Financiero';
                                }else{
                                        $_SESSION['acceso']=$dato['tipo_acceso'];
                                }
                    $resultado = "Autorizado";
                            }
                }else{

                    $consulta = "SELECT * FROM responsables WHERE numero_nomina = '$usuario' AND contrasena = '$contrasena'";
                    $query=$conexion->query($consulta);
                            if(mysqli_num_rows($query)>0){
                                    while ($dato=mysqli_fetch_array($query)) {
                                        $_SESSION['nombre']=$dato['nombre'];
                                        $_SESSION['nomina']=$dato['numero_nomina'];
                                        $_SESSION['acceso']='Usuario';
                                $resultado = "Autorizado";
                                        }
                        }else{
                            $resultado = "Verifique";
                        }
                }
     
   

echo json_encode($resultado);
?>