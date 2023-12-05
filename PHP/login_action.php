<?php
require "config.php";
session_start();
$usuario = filter_input(INPUT_POST, "usuario");
$senha = filter_input(INPUT_POST, "senha");

$_SESSION["usuario"] = $usuario;
$_SESSION["senha"] = $senha;




$sql = $pdo->prepare("SELECT * FROM login WHERE usuario = :usuario AND senha = :senha");
$sql->bindValue(':usuario', $usuario);
$sql->bindValue(':senha', $senha);
$sql->execute();

$info = $sql->fetchAll();
foreach($info as $key => $element){
    $tipo = $element["tipo"];
}

if($usuario && $senha){
    if($sql->rowCount() > 0 && $tipo == "Aluno"){
        header("Location: pageNotas");
        $_SESSION["loginADM"] = false;
        $_SESSION["logado"] = true;
        exit;
    }
    if($sql->rowCount() > 0 && $tipo == "Admin"){
        header("Location: pageAdmin");
        $_SESSION["loginADM"] = true;
        $_SESSION["logado"] = true;
        exit;
    }
}



