<?php
// Script para crear la base de datos y un usuario admin
try {
    $db = new PDO('sqlite:users.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec('CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, name TEXT, email TEXT UNIQUE, password TEXT)');
    $email = 'admin@sistema.com';
    $name = 'Administrador';
    $password = 'admin123';
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo 'El usuario admin@sistema.com ya existe.';
    } else {
        $stmt = $db->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$name, $email, $hash]);
        echo 'Usuario admin@sistema.com creado con contraseña admin123.';
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
// Por seguridad, elimina este archivo después de usarlo. 