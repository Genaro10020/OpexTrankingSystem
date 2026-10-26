<?php
header('Content-Type: application/json; charset=utf-8');

$hostname = 'localhost';
$database = 'ead';
$username = 'root';
$password = '';

$conexionEAD = new mysqli($hostname, $username, $password, $database);

if ($conexionEAD->connect_errno) {
    echo json_encode(["status" => "error", "message" => "Error al conectarse con la BD EAD"]);
    exit;
}
$conexionEAD->set_charset("utf8");

$accion = $_GET['accion'] ?? '';

if ($accion === 'listarProyectos') {
    $query = "SELECT id_equipo, nombre_indicador, GROUP_CONCAT(id) as ids_impactos FROM reportes_impactos_ambientales_proyectos WHERE nombre_indicador IS NOT NULL AND nombre_indicador != '' GROUP BY nombre_indicador, id_equipo";
    $result = $conexionEAD->query($query);
    
    $proyectos = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $proyectos[] = $row;
        }
    }
    echo json_encode(["status" => "success", "proyectos" => $proyectos]);

} elseif ($accion === 'obtenerImpactosProyecto') {
    $id_equipo = $_GET['id_equipo'] ?? '';
    
    if ($id_equipo === '') {
        echo json_encode(["status" => "error", "message" => "ID de equipo no proporcionado"]);
        exit;
    }

    $stmt = $conexionEAD->prepare("SELECT * FROM reportes_impactos_ambientales_proyectos WHERE id_equipo = ?");
    $stmt->bind_param("s", $id_equipo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $impactos = [];
    while ($row = $result->fetch_assoc()) {
        $impactos[] = $row;
    }
    
    echo json_encode(["status" => "success", "impactos" => $impactos]);
    $stmt->close();

} else {
    echo json_encode(["status" => "error", "message" => "Acción no válida"]);
}

$conexionEAD->close();
?>