<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        include("conexionGhoner.php");
        header('Content-Type: application/json');
        $resultado = "";
        $departamento = $arreglo['departamento'];
        $nuevo_departamento = $arreglo['nuevo_departamento'];



        if($departamento=="Planta"){
                    //Verificar SI existe usuario
                    $insertar = "INSERT INTO plantas  (id,nombre) VALUES ('','$nuevo_departamento')";
                    $query = $conexion->query($insertar);
                    if ($query) {
                        $resultado = $query;
                    } else {
                        $resultado = "Error en la consulta: " . mysqli_error($conexion);
                    }
                    
        }else if($departamento=="Área"){
                    //Verificar SI existe usuario
                    $insertar = "INSERT INTO areas  (id,nombre) VALUES ('','$nuevo_departamento')";
                    $query = $conexion->query($insertar);
                    if ($query) {
                        $resultado = $query;
                    } else {
                        $resultado = "Error en la consulta: " . mysqli_error($conexion);
                    }

        }else if($departamento=="Subárea"){
                    //Verificar SI existe usuario
                    $insertar = "INSERT INTO subareas  (id,nombre) VALUES ('','$nuevo_departamento')";
                    $query = $conexion->query($insertar);
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