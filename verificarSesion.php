<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION["acceso"])) {
    // Devolver la respuesta en formato JSON
    echo json_encode([
        'success' => true,
        'acceso' => $_SESSION["acceso"],
    ]);
} else {
    // Si no hay sesión activa
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'mensaje' => 'No hay sesión activa',
    ]);
}


?>