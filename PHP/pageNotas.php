<?php
require "config.php";

session_start();
$usuario = $_SESSION["usuario"];
$senha = $_SESSION["senha"];


$sql3 = $pdo->prepare("SELECT * FROM login WHERE usuario = ? AND senha = ?");
$sql3->execute(array($usuario, $senha));


$lista3 = [];
$lista3 = $sql3->FetchAll(PDO::FETCH_ASSOC);

foreach ($lista3 as $aluno2){
    $cpf = $aluno2["cpf"];
}

$lista2 = [];
$sql = $pdo->query("SELECT aluno.cpf, aluno.nome, materia.nome as materia, desempenho.nota1, desempenho.nota2, desempenho.nota3
from desempenho INNER JOIN materia 
ON desempenho.idmateria = materia.id
INNER JOIN aluno
ON desempenho.cpfaluno = aluno.cpf
WHERE desempenho.cpfaluno = '$cpf'");

if($sql->rowCount() > 0){
    $lista2 = $sql->FetchAll(PDO::FETCH_ASSOC);
}
?>

<head>
    <style>
        *{
            margin:0px;
            padding:0px;
        }
        html, body{
            height:100%;
        }
        td{
            border: 1px solid black;
            padding: 20px;

        }
        table{
            border-collapse: collapse;
        }
        main{
            background-image: linear-gradient(gray, white);
            height:100hv;
        }
        .box{
            height:100%;
            margin-left:500px;
        }
        h1{
            margin-bottom:40px;
        }
    </style>
</head>

<body>
    <main>
        <div class="box">
            <table>
                <h1> Boletim </h1>
                <tr>
                    <th>Materia</th>
                    <th>Nota 1</th>
                    <th>Nota 2</th>
                    <th>Nota 3</th>
                </tr>
                <?php foreach($lista2 as $aluno):?>
                <tr>
                    <td class="sequenciaNota"><?=$aluno["materia"];?></td>
                    <td class="sequenciaNota"><?=$aluno['nota1'];?></td>
                    <td class="sequenciaNota"><?=$aluno['nota2'];?></td>
                    <td class="sequenciaNota"><?=$aluno['nota3'];?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
</body>