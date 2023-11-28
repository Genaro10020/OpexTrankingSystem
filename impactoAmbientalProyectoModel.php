<?php
include("conexionGhoner.php");
    function consultarProyectos(){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM proyectos_creados ORDER BY folio ASC";
            $query = $conexion->query($consulta);
            if($query){
                while ($datos=mysqli_fetch_array($query)){
                    $resultado [] = $datos;
                }
                    $estado  = true;
            }else{
                    $estado  = false;
            }
            return array ($resultado,$estado);
    }

    function consultarImpactosXproyectoID($id_proyecto){
        global $conexion;
        $resultado = [];
        $error="";
        $id = (int)$id_proyecto;
        $estado = false;
                $query = "SELECT registros.*, impactos.* FROM impacto_ambiental_proyecto impactos INNER JOIN  registros_impacto_ambiental registros  ON  impactos.id = registros.id_impacto_ambiental_proyecto WHERE impactos.id_proyecto = ?";
                $stmt = $conexion->prepare($query);
                
                if (!$stmt) {
                    return $error = "Error en la consulta".$conexion->error;;
                } else {
                    $stmt->bind_param("i", $id);
                    if ($stmt->execute()) {
                        $estado = true;
                        $recuperando = $stmt->get_result();
                        while ($fila = $recuperando->fetch_assoc()) {
                            $resultado[] = $fila;
                        }
                        $stmt->close();
                        return array($resultado, $estado, $id_proyecto, $error);
                    } else {
                        return $error = "Error en la ejecución de la consulta";
                    }
                }
            
           
    }
   

    function insertarProyecto(){}

    function actualizarArea(){}

    function eliminarArea(){}
       
?>