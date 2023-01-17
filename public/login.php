<?php
/* require_once 'vendor/autoload.php'; //importando la librería de JWT */
require "../includes/cors.php";
require __DIR__ . "/../includes/funciones.php";


// Recibiendo el JSON con los datos de inicio de sesión y guardandolos
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if($data['tipo'] === "login") {
    $resultado = autenticar($data);
} 
if($data['tipo'] === 'autenticar') {
    $resultado = estaAutenticado($data['token']);
}

/* Respuesta */
echo json_encode($resultado);