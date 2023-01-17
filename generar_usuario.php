<?php

require __DIR__ . "./includes/config/db.php";

/* $2y$10$ZfjMQN6me2idocJ5r3EEFO4nfOfG0Dyunqy5xUpCzpsraBdDLoTxC */

$db = conectarDB();



$query = " UPDATE admin SET password = $passwordHash WHERE id = 1 ";

echo $query;

mysqli_query($db, $query);
