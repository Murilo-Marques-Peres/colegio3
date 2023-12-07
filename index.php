<?php
require __DIR__ . "../PHP/config.php";

session_start();
$confirmacao1 = isset($_SESSION["logado"]);
$confirmacao2 = false;
if(isset($_SESSION["loginADM"])){
    $confirmacao2 = ($_SESSION["loginADM"]);
}
if($confirmacao1 && $confirmacao2){
    header("location: PHP/pageAdmin");
    exit;
}
else if($confirmacao1 && !$confirmacao2){
    header("location: PHP/pageNotas");
    exit;
}
if(isset($_SESSION["erroUser"])){
    if($_SESSION["erroUser"]){
        echo "<div class='errorUser'>Usuário existente não encotrado!</div>";
    }
}
?>
<html>
    <head>
        <link href="CSS/estilo.css" type="text/css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/b6a341c846.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="background"></div>
            <section id = "CampoUsuario">
                <div class="box">
                    <div class="container-box">
                        <h1 class="h1class" > Login </h1>
                            <form method="POST" action="PHP/login_action.php">
                                <div class="mexer">
                                    <i class="fa-solid fa-user"></i>
                                    <input class="espaco" type="text" name="usuario" id=idlogin placeholder="seu usuário"/>
                                    <label for="idlogin"> Usuário</label>
                                </div> <!-- mexer -->
                                <div class="mexer">
                                    <i class="fa-solid fa-lock"></i>
                                    <input class="espaco" type="password" name="senha" id="idsenha" placeholder="sua senha"/>
                                    <label for="idsenha"> Senha</label>
                                </div> <!-- mexer -->
                                    <input class="espaco" type="submit" value="Login"/>
                    </div> <!-- container-box -->
                </div> <!-- box -->
                            </form>
            </section>
        <div> <!--background -->

    </body>