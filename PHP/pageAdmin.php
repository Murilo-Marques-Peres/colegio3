<?php
require "config.php";
require "confirmacao.php";

session_start();
$usuario = $_SESSION["usuario"];
$senha = $_SESSION["senha"];
$confirmacao = $_SESSION["login"];

if($confirmacao == false){
    header("location: ../index");
}


?>

<html>
    <head>
        <meta charset="utf-8"/>
        <link href="../CSS/estiloAdmin.css" type="text/css" rel="stylesheet"/>
        <title>Page Admin</title>
    </head>
    <body>
        <main>
            <div class="container">
                <div class="principal">
                    <label for="serie">Escolha a série</label>
                    <select name="serie">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                    </select>
                    <label for="turma">Escolha a turma</label>
                    <select name="turma">
                        <option>A</option>
                        <option>B</option>
                    </select>

                    
                    
                    <form method="POST">
                        <input type="text" name="nomePesquisado">
                        <input type="submit" id="botaoA" name="acao" value="Pesquisar Nome"/>
                    </form>

                    <?php
                        if(isset($_POST["acao"])){
                            $nomePesquisa = "Murilo"."%";
                            $sql = $pdo->prepare("SELECT * FROM aluno WHERE nome LIKE ?");
                            $sql->execute(array($nomePesquisa));
                            $info = $sql->fetchAll();
                            echo "<select class='caixa'>";
                            foreach($info as $element){
                                echo "<option>".$element["nome"]."<option>";
                            }
                            echo "</select>";
                            }
                            
                    ?>


                </div><!--principal-->
            </div><!--container-->

            <nav id="meu_nav">
                <ul id="atividade">
                    <li><button id="notas">Notas</button></li>   
                    <li><button id="atualiza">Atualizações</button></li>
                    <li>
                        <form method="POST">
                            <input type="submit" name="acao" value="Fazer Logout"/>
                            <?php
                                if(isset($_POST["acao"])){
                                    session_destroy();
                                    header("location: ../index");
                                }
                            ?>
                        </form>    
                    </li>
                </ul>
            </nav>
            </main>
        <footer>
            <p>Todos os direitos reservados</p>
        </footer>

        <script src="../JS/jquery.js"></script>
        <script src="../JS/function.js"></script>
    </body>
</html>