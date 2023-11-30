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
                    <label for="serie">Escolha a série:</label>
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
                    <label for="turma">Escolha a turma:</label>
                    <select name="turma">
                        <option>A</option>
                        <option>B</option>
                    </select>

                    <form method="POST">
                        <input type="text" name="nomePesquisado" placeholder="Digite o nome do aluno">
                        <input type="submit" id="botaoA" name="acao1" value="Pesquisar Nome"/>
                    </form>

                    
                    <div class="tableP">
                    <?php
                        if(isset($_POST["acao1"])){
                            $nomePesquisa = $_POST["nomePesquisado"]."%";
                            $sql = $pdo->prepare("SELECT aluno.cpf, aluno.nome, turma.serieturma FROM aluno INNER JOIN turma
                            on aluno.turmaid = turma.id WHERE aluno.nome LIKE ?");
                            $sql->execute(array($nomePesquisa));
                            $listaNome = $sql->fetchAll();
                            echo "<table>
                            <tr class='table'>
                            <th>CPF</th>
                            <th>Nome</th>
                            <th>Turma</th>
                            </tr>";
                            foreach($listaNome as $element){
                                echo "<td>";
                                echo $element["cpf"];
                                echo "</td>";
                                echo "<td>";
                                echo $element["nome"];
                                echo "</td>";
                                echo "<td>";
                                echo $element["serieturma"];
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                        }
                            
                    ?>
                    </div> <!--tableP-->

                </div><!--principal-->
            </div><!--container-->

            <nav id="meu_nav">
                <ul id="atividade">
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