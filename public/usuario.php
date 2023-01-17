<?php


if(!empty($_GET['contra']) && !empty($_GET['token'])) {
    $resultado = cambiarContraseña($_GET['contra'], $_GET['token']);
}
echo $resultado;