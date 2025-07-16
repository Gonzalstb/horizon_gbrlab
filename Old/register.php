<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD']==='POST'){

    $name     = trim($_POST['name']   ?? '');
    $email    = trim($_POST['email']  ?? '');
    $password = $_POST['password']    ?? '';

    $errors=[];
    if(!$name)                                   $errors[]='Nombre obligatorio';
    if(!filter_var($email,FILTER_VALIDATE_EMAIL))$errors[]='Correo inválido';
    if(strlen($password)<6)                      $errors[]='Contraseña ≥ 6 caracteres';

    if(!$errors){
        $stmt=$pdo->prepare('SELECT id FROM users WHERE email=?');
        $stmt->execute([$email]);
        if($stmt->fetch()) $errors[]='Correo ya registrado';
    }

    if(!$errors){
        $hash=password_hash($password,PASSWORD_BCRYPT);
        $stmt=$pdo->prepare('INSERT INTO users(name,email,password) VALUES(?,?,?)');
        $stmt->execute([$name,$email,$hash]);
        $_SESSION['user']=['name'=>$name,'email'=>$email];
        header('Location: index.html'); exit;
    }
}
?>
<!-- El resto del HTML permanece igual -->
