<?php
require 'config.php';

$email    = 'admin@sistema.com';
$name     = 'Administrador';
$password = password_hash('admin123', PASSWORD_BCRYPT);

$stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
$stmt->execute([$email]);

if ($stmt->fetch()) {
    echo 'El usuario ya existe.';
} else {
    $stmt = $pdo->prepare(
        'INSERT INTO users (name, email, password, role) VALUES (?,?,?,?)'
    );
    $stmt->execute([$name, $email, $password, 'admin']);
    echo 'Usuario admin@sistema.com creado.';
}
