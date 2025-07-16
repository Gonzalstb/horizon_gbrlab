<?php
session_start();
require 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD']!=='POST') {
    http_response_code(405);
    echo json_encode(['ok'=>false,'msg'=>'Método no permitido']);
    exit;
}

$email    = trim($_POST['email']??'');
$password = $_POST['password']??'';

if (!filter_var($email,FILTER_VALIDATE_EMAIL) || !$password){
    http_response_code(422);
    echo json_encode(['ok'=>false,'msg'=>'Datos inválidos']);
    exit;
}

$stmt=$pdo->prepare('SELECT id,name,email,password,role FROM users WHERE email=?');
$stmt->execute([$email]);

$user=$stmt->fetch();
if ($user && password_verify($password,$user['password'])){
    unset($user['password']);               // no exponer el hash
    $_SESSION['user']=$user;
    echo json_encode(['ok'=>true,'user'=>$user]);
} else {
    http_response_code(401);
    echo json_encode(['ok'=>false,'msg'=>'Credenciales incorrectas']);
}
