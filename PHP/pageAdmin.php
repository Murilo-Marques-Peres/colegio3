<?php
require "config.php";

session_start();
$confirmacao = false;
$confirmacao2 = false;

if(isset($_SESSION["loginADM"])){
    if($_SESSION["loginADM"]){
        $confirmacao = $_SESSION["loginADM"];
    }
}
if(isset($_SESSION["logado"])){
    $confirmacao2 = $_SESSION["logado"];
}

if(!$confirmacao){
    header("location: ../index");
    die();
    //Recommended by the teacher to use die()
}
$usuario = $_SESSION["usuario"];
$senha = $_SESSION["senha"];




?>

<html>
    <head>
        <meta charset="utf-8"/>
        <link href="../CSS/estiloAdmin.css" type="text/css" rel="stylesheet"/>
        <title>Page Admin</title>
    </head>
    <body>
        <main>
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
            
            <div class="container">
                <div class="principal">
                    <div class="containerP">
                        <div class="visual">
                            <h1>Visualização</h1>
                        </div>
                        <form class="aluno" method="POST">
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
                            <label for="Ensino">Escolha o Ensino:</label>
                            <select name="ensino" style="width: 100px;">
                                <option>Fundamental</option>
                                <option>Médio</option>
                            </select>
                            <label for="turma">Escolha a turma:</label>
                            <select name="turma">
                                <option>A</option>
                                <option>B</option>
                            </select>
                            <div class="form1">
                                <input type="text" name="nomePesquisado" placeholder="Digite o nome do aluno" style="margin-right:10px;"/>
                                <input type="submit" id="botaoA" name="acao1" value="Pesquisar Nome"/>
                                <input type="text" name="pesquisaCPF" placeholder="Digite o cpf do aluno"/>
                                <input id="submitNotaMateria" type="submit" name="acaoNotasMateria" value="Pesquisar Notas do aluno"/>
                            </div>
                        </form>
                    </div> <!--containerP-->
                    
                    <div class="tableP">
                    <?php
                        function serieTurma(){
                            $serie = $_POST["serie"];
                            $turma = $_POST["turma"];
                            $ensinoPalavra = $_POST["ensino"];

                            if($ensinoPalavra == "Fundamental"){
                                $ensinoNumero = 1;
                            }
                            if($ensinoPalavra == "Médio"){
                                $ensinoNumero = 2;
                            }

                            $serieTurma = $serie.$ensinoNumero.$turma;
                            return $serieTurma;
                            
                        }

                        if(isset($_POST["acao1"])){
                            $serieTurma = serieTurma();
                            $nomePesquisa = $_POST["nomePesquisado"]."%";
                            $sql = $pdo->prepare("SELECT aluno.cpf, aluno.nome, turma.serieturma FROM aluno INNER JOIN turma
                            on aluno.turmaid = turma.id WHERE turma.serieturma = ? && aluno.nome LIKE ?");
                            $sql->execute(array($serieTurma,$nomePesquisa));
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
                    <div class="tableNotas">
                        <?php
                            if(isset($_POST["acaoNotasMateria"])){
                                $cpfPesquisa = $_POST["pesquisaCPF"];
                                $cpfPesquisa = str_replace(" ", "", $cpfPesquisa);
                                $sql = $pdo->prepare("SELECT desempenho.cpfaluno, aluno.nome, materia.nome as materia, desempenho.nota1, desempenho.nota2, desempenho.nota3 FROM desempenho 
                                INNER JOIN materia ON desempenho.idmateria = materia.id
                                INNER JOIN aluno ON desempenho.cpfaluno = aluno.cpf
                                WHERE cpfaluno = ?");
                                $sql->execute(array($cpfPesquisa));
                                $listaNome = $sql->fetchAll();
                                echo "<table>
                                <tr class='table'>
                                <th>CPF</th>
                                <th>Nome</th>
                                <th>Materia</th>
                                <th style='width: 60px;'>Nota 1</th>
                                <th style='width: 60px;'>Nota 2</th>
                                <th style='width: 60px;'>Nota 3</th>
                                </tr>";
                                foreach($listaNome as $element){
                                    echo "<td>";
                                    echo $element["cpfaluno"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $element["nome"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $element["materia"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $element["nota1"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $element["nota2"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $element["nota3"];
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                            }
                        ?>
                    </div><!--tableNotas-->


                </div><!--principal-->
            </div><!--container-->
            <div class="container2">
                <div class="principal2">
                    <div class="visual">
                        <h1>Alteração</h1>
                    </div>
                    <form method="POST">
                        <input name="cpfSelecionado" class="cpfMudar" type="text" placeholder="Digite o CPF do aluno para Alteração"/>
                        <label class="elementoMudar" for="materiaDef">Escolha a matéria a definir nota</label>
                        <select class="mudarSelect" name="materiaDef">
                            <option value="Português">Português</option>
                            <option value="Matemática">Matemática</option>
                            <option value="História">História</option>
                            <option value="Geografia">Geografia</option>
                            <option value="Fisica">Fisica</option>
                            <option value="Química">Química</option>
                            <option value="Sociologia">Sociologia</option>
                            <option value="Literatura">Literatura</option>
                            <option value="Filosofia">Filosofia</option>
                        </select>


                        </select>
                        <label class="elementoMudar" for="notaDef">Escolha a nota a definir:</label>
                        <select class="selectMudar2" name="notaDef" >
                            <option value="Nota 1">Nota 1</option>
                            <option value="Nota 2">Nota 2</option>
                            <option value="Nota 3">Nota 3</option>
                        </select>
                        <label for="campoNota">Defina a nota:</label>
                        <input type="text" name="campoNota" style="width: 30px; text-align:center;"/>
                        <input class="submitMudar" type="submit" name="acaoMudarNota" value="Definir nota" style="margin-left:10px"/>
                    </form>
                    <?php 
                        function inserirNota($notaDefinida, $cpfSelecionado,$materiaSelecionada, $indexNota, $pdo){
                            if($indexNota == "nota1"){
                                $sql = $pdo->prepare("SELECT desempenho.idmateria, materia.nome, desempenho.cpfaluno FROM desempenho
                                INNER JOIN materia ON desempenho.idmateria = materia.id WHERE cpfaluno = ? && nome = ?");
                                $sql->execute(array($cpfSelecionado, $materiaSelecionada));
                                $listaMateria = $sql->FetchAll(PDO::FETCH_ASSOC);
                                $notaDefinidaMudada = str_replace(",",".", $notaDefinida);
                                $notaDefinidaMudadaFinal = floatval($notaDefinidaMudada);
                                $sql2 = $pdo->prepare("SELECT cpf FROM aluno WHERE cpf = ?");
                                $sql2->execute(array($cpfSelecionado));
                                $listaCPF = $sql2->FetchAll(PDO::FETCH_ASSOC);
                                foreach($listaCPF as $elementCPF){
                                    $cpfVerificado = $elementCPF["cpf"];
                                }
                                foreach($listaMateria as $elementMateria){
                                    $indexMateria = $elementMateria["idmateria"];
                                }
                                if($sql->rowCount() > 0){
                                    $updateConfirmation = true;
                                }else{
                                    $updateConfirmation = false;
                                }
                                if($updateConfirmation){
                                    $sql = $pdo->prepare("UPDATE desempenho SET nota1 = ? WHERE cpfaluno = ? && ano = ? && idmateria = ?");
                                    $sql->execute(array($notaDefinidaMudadaFinal, $cpfSelecionado, 2023, $indexMateria));
                                }
                                if(!$updateConfirmation){
                                    $sql3 = $pdo->prepare("SELECT * FROM materia WHERE nome = ?");
                                    $sql3->execute(array($materiaSelecionada));
                                    $listaMateriaPesquisa = $sql3->FetchAll(PDO::FETCH_ASSOC);
                                    foreach($listaMateriaPesquisa as $element){
                                        $indexMateria = $element["id"];
                                    }
                                    $sql5 = $pdo->prepare("SELECT turmaid FROM aluno WHERE cpf = ?");
                                    $sql5->execute(array($cpfVerificado));
                                    $listaIdTurma = $sql5->FetchAll(PDO::FETCH_ASSOC);
                                    foreach($listaIdTurma as $element){
                                        $idTurma = $element["turmaid"];
                                    }
                                    if(isset($cpfVerificado)){
                                        $sql4 = $pdo->prepare("INSERT INTO desempenho (cpfaluno, ano, idmateria, nota1, idturma) values (?,?,?,?,?)");
                                        $sql4->execute(array($cpfVerificado, 2023, $indexMateria, $notaDefinidaMudadaFinal, $idTurma));

                                    }
                                }
                                
                            }
                            if($indexNota == "nota2"){
                                $sql = $pdo->prepare("SELECT desempenho.idmateria, materia.nome, desempenho.cpfaluno FROM desempenho
                                INNER JOIN materia ON desempenho.idmateria = materia.id WHERE cpfaluno = ? && nome = ?");
                                $sql->execute(array($cpfSelecionado, $materiaSelecionada));
                                $listaMateria = $sql->FetchAll(PDO::FETCH_ASSOC);
                                $notaDefinidaMudada = str_replace(",",".", $notaDefinida);
                                $notaDefinidaMudadaFinal = floatval($notaDefinidaMudada);
                                $sql2 = $pdo->prepare("SELECT cpf FROM aluno WHERE cpf = ?");
                                $sql2->execute(array($cpfSelecionado));
                                $listaCPF = $sql2->FetchAll(PDO::FETCH_ASSOC);
                                foreach($listaCPF as $elementCPF){
                                    $cpfVerificado = $elementCPF["cpf"];
                                }
                                foreach($listaMateria as $elementMateria){
                                    $indexMateria = $elementMateria["idmateria"];
                                }
                                if($sql->rowCount() > 0){
                                    $updateConfirmation = true;
                                }else{
                                    $updateConfirmation = false;
                                }
                                if($updateConfirmation){
                                    $sql = $pdo->prepare("UPDATE desempenho SET nota2 = ? WHERE cpfaluno = ? && ano = ? && idmateria = ?");
                                    $sql->execute(array($notaDefinidaMudadaFinal, $cpfSelecionado, 2023, $indexMateria));
                                }
                                if(!$updateConfirmation){
                                    $sql3 = $pdo->prepare("SELECT * FROM materia WHERE nome = ?");
                                    $sql3->execute(array($materiaSelecionada));
                                    $listaMateriaPesquisa = $sql3->FetchAll(PDO::FETCH_ASSOC);
                                    foreach($listaMateriaPesquisa as $element){
                                        $indexMateria = $element["id"];
                                    }
                                    $sql5 = $pdo->prepare("SELECT turmaid FROM aluno WHERE cpf = ?");
                                    $sql5->execute(array($cpfVerificado));
                                    $listaIdTurma = $sql5->FetchAll(PDO::FETCH_ASSOC);
                                    foreach($listaIdTurma as $element){
                                        $idTurma = $element["turmaid"];
                                    }
                                    if(isset($cpfVerificado)){
                                        $sql4 = $pdo->prepare("INSERT INTO desempenho (cpfaluno, ano, idmateria, nota2, idturma) values (?,?,?,?,?)");
                                        $sql4->execute(array($cpfVerificado, 2023, $indexMateria, $notaDefinidaMudadaFinal, $idTurma));

                                    }
                                }
                                
                            }
                            if($indexNota == "nota3"){
                                $sql = $pdo->prepare("SELECT desempenho.idmateria, materia.nome, desempenho.cpfaluno FROM desempenho
                                INNER JOIN materia ON desempenho.idmateria = materia.id WHERE cpfaluno = ? && nome = ?");
                                $sql->execute(array($cpfSelecionado, $materiaSelecionada));
                                $listaMateria = $sql->FetchAll(PDO::FETCH_ASSOC);
                                $notaDefinidaMudada = str_replace(",",".", $notaDefinida);
                                $notaDefinidaMudadaFinal = floatval($notaDefinidaMudada);
                                $sql2 = $pdo->prepare("SELECT cpf FROM aluno WHERE cpf = ?");
                                $sql2->execute(array($cpfSelecionado));
                                $listaCPF = $sql2->FetchAll(PDO::FETCH_ASSOC);
                                foreach($listaCPF as $elementCPF){
                                    $cpfVerificado = $elementCPF["cpf"];
                                }
                                foreach($listaMateria as $elementMateria){
                                    $indexMateria = $elementMateria["idmateria"];
                                }
                                if($sql->rowCount() > 0){
                                    $updateConfirmation = true;
                                }else{
                                    $updateConfirmation = false;
                                }
                                if($updateConfirmation){
                                    $sql = $pdo->prepare("UPDATE desempenho SET nota3 = ? WHERE cpfaluno = ? && ano = ? && idmateria = ?");
                                    $sql->execute(array($notaDefinidaMudadaFinal, $cpfSelecionado, 2023, $indexMateria));
                                }
                                if(!$updateConfirmation){
                                    $sql3 = $pdo->prepare("SELECT * FROM materia WHERE nome = ?");
                                    $sql3->execute(array($materiaSelecionada));
                                    $listaMateriaPesquisa = $sql3->FetchAll(PDO::FETCH_ASSOC);
                                    foreach($listaMateriaPesquisa as $element){
                                        $indexMateria = $element["id"];
                                    }
                                    $sql5 = $pdo->prepare("SELECT turmaid FROM aluno WHERE cpf = ?");
                                    $sql5->execute(array($cpfVerificado));
                                    $listaIdTurma = $sql5->FetchAll(PDO::FETCH_ASSOC);
                                    foreach($listaIdTurma as $element){
                                        $idTurma = $element["turmaid"];
                                    }
                                    if(isset($cpfVerificado)){
                                        $sql4 = $pdo->prepare("INSERT INTO desempenho (cpfaluno, ano, idmateria, nota3, idturma) values (?,?,?,?,?)");
                                        $sql4->execute(array($cpfVerificado, 2023, $indexMateria, $notaDefinidaMudadaFinal, $idTurma));

                                    }
                                }
                                
                            }

                        }
                        
                        if(isset($_POST["acaoMudarNota"])){
                            $notaDefinida = $_POST["campoNota"];
                            $cpfSelecionado = $_POST["cpfSelecionado"];
                            $cpfSelecionado = str_replace(" ", "", $cpfSelecionado);
                            $materiaSelecionada = $_POST["materiaDef"] ;
                            $notaSelecionada = $_POST["notaDef"];
                            $indexNota = "";
                            if($notaSelecionada == "Nota 1"){
                                $indexNota = "nota1";
                            }
                            if($notaSelecionada == "Nota 2"){
                                $indexNota = "nota2";
                            }
                            if($notaSelecionada == "Nota 3"){
                                $indexNota = "nota3";
                            }

                            inserirNota($notaDefinida, $cpfSelecionado,$materiaSelecionada, $indexNota,$pdo);
                        }

                    ?>
                    
                </div><!--principal2-->
            </div><!--container2-->
            </main>
        <footer>
            <p>Todos os direitos reservados</p>
        </footer>
        <script src="../JS/jquery.js"></script>
        <script src="../JS/function.js"></script>
    </body>
</html>