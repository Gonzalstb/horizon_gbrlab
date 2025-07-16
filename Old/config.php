<?php
/* config.php — ajusta con los datos de tu panel MySQL */
$host   = 'localhost';
$dbname = 'horizon_db';     // <-- tu base de datos
$user   = 'horizon_user';   // <-- tu usuario
$pass   = '********';       // <-- tu contraseña
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    http_response_code(500);
    exit('Error de conexión: '.$e->getMessage());
}
