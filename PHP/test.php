<?php
require "config.php";
?>
<html>
    <head>
        <meta charset = utf-8/>
    </head>
    <body>
    <form method="POST">
        <input type="text" name="nomePesquisado">
        <input type="submit" id="botaoA" name="acao" value="Pesquisar Nome"/>
        <?php
            if(isset($_POST["acao"])){
                $nomePesquisa = "Murilojfjfj"."%";
                $sql = $pdo->prepare("SELECT * FROM aluno WHERE nome LIKE ?");
                $sql->execute(array($nomePesquisa));
                $info = $sql->fetchAll();
                if(!$info){
                    echo "Minha ideia funcionou!!!";
                }
                if($info){
                    echo "what??";
                }
                echo "<select class='caixa'>";
                foreach($info as $element){
                    echo "<option>".$element["nome"]."<option>";
                }
                echo "</select>";
                }
        ?>
    </form>
        

    </body>
</html>