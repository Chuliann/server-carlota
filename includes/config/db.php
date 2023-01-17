<?php

include __DIR__ . "/../../variables.php";

function conectarDB(): mysqli
{
    /* $db = new mysqli('localhost', 'root', '', 'carlota'); */
    $db = new mysqli('localhost', 'carlotai_julian', 'UnAcOnTrAdIfIcIl', 'carlotai_website');
    
    if (!$db) {
        echo "Error, no se pudo conectar";
        exit;
    }

    return $db;
}
