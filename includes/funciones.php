<?php

require __DIR__. '/../vendor/autoload.php';
require __DIR__ . '/../variables.php';
require 'config/db.php';

use ReallySimpleJWT\Token;

function autenticar($data) {
    $db = conectarDB();
    $query = " SELECT * FROM admin WHERE user= '" . $data['user'] . "' LIMIT 1 ";
    $resultado = mysqli_query($db, $query);

    /* Compruebo usuario */
    if (!$resultado->num_rows) {
        return ['status' => 'error'];
    } else {
        $usuario = $resultado->fetch_object();
        $autenticado = password_verify($data['password'], $usuario->password);

        /* Compruebo contraseña */
        if (!$autenticado) {
            return ['status' => 'error'];
        }


        /* Creo y firmo el token, id: 1, secreto, tiempo de expiracion, desde donde se emite */
        $token = Token::create(1, SECRET_TOKEN_SIGNATURE, time() + 3600, 'localhost');

        return [
            'token' => $token,
            'status' => 'ok'
        ];

    }
}

function estaAutenticado($token) {
    try {
        if(Token::validateExpiration($token)) {
            $result = Token::validate($token, SECRET_TOKEN_SIGNATURE);
            return ['status' => $result];
        } else {
            return ['status' => "expirado"];
        }
    } catch (\Throwable $th) {
        return ['status' => false];
    }
    return ['status' => false];
}


/* COMENTARIOS */
function obtenerComentariosPendientes() {
    $db = conectarDB();

    $resultado = $db->query("SELECT * FROM comentarios WHERE aprobado = 0");
        
    if($resultado->num_rows > 0) {
        while($row = $resultado->fetch_assoc()) {
            $comentarios[] = $row;
        }
    } else {
        $comentarios = [];
    }
    return $comentarios;
}

function obtenerComentariosAprobados() {
    $db = conectarDB();

    $resultado = $db->query("SELECT * FROM comentarios WHERE aprobado = 1");
        
    if($resultado->num_rows > 0) {
        while($row = $resultado->fetch_assoc()) {
            $comentarios[] = $row;
        }
    } else {
        $comentarios = [];
    }
    return $comentarios;
}

function eliminarComentario($data) {
    if(!estaAutenticado($data['token'])) {
        return ['status' => 'error'];
    }
    $db = conectarDB();
    $id = $data['id'];
    $resultado = $db->query("DELETE FROM comentarios WHERE id = $id");
    return $resultado;
}

function aprobarComentario($data) {
    if(!estaAutenticado($data['token'])) {
        return ['status' => 'error'];
    }
    $db = conectarDB();
    $id = $data['id'];
    $resultado = $db->query("UPDATE comentarios SET aprobado = 1 WHERE id = $id");
    return $resultado;
}

function crearComentario($data) {
    $nombre = $data['campos']['nombre'];
    $correo = $data['campos']['correo'];
    $mensaje = $data['campos']['mensaje'];
    $db = conectarDB();
    $query = $db->prepare("INSERT INTO comentarios (nombre, correo, mensaje) VALUES (?, ?, ?) ");
    $query->bind_param("sss", $nombre, $correo, $mensaje);
    return ['status' => $query->execute()];
}


function debuguear($var, $si = false) {
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    if($si) {
        exit;
    }
}


