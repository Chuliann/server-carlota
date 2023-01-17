<?php

require __DIR__ . "./includes/config/db.php";

$db = conectarDB();

$usuario = "fernando";
$password = "Unacontra";

$passwordHash = password_hash($password, PASSWORD_BCRYPT);


$query = " INSERT INTO admin (user, password) VALUES ($usuario, $passwordHash); ";

echo $query;

mysqli_query($db, $query);