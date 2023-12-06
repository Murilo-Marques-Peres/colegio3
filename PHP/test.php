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
            if(!isset($variavel)){
                echo "não existe confirmado";
            }
        ?>
    </form>
        

    </body>
</html>