<?php
require "../includes/cors.php";
require __DIR__ . "/../includes/funciones.php";

// Recibiendo el JSON con los datos de inicio de sesión y guardandolos
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if($data['tipo'] === "pendientes") {
    $resultado = obtenerComentariosPendientes();
}
if($data['tipo'] === "aprobados") {
    $resultado = obtenerComentariosAprobados();
}
if($data['tipo'] === "eliminar") {
    if($data['id']) {
        $resultado = eliminarComentario($data);
    }
}
if($data['tipo'] === "aprobar") {
    $resultado = aprobarComentario($data);
}
if($data['tipo'] === "enviar") {
    $resultado = crearComentario($data);
}

echo json_encode($resultado);