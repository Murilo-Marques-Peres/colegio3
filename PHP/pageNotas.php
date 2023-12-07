<?php
require "config.php";

session_start();
$usuario = $_SESSION["usuario"];
$senha = $_SESSION["senha"];
$logado = isset($_SESSION["logado"]);

if(!$logado){
    header("location: ../index");
    exit;
    //Recommended by the teacher to use die()
}


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
WHERE desempenho.cpfaluno = '$cpf' && ano = 2023");

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
        nav{
            position: absolute;
            right: 10;
            top: 0;
            cursor: pointer;
            width: 32px;
            height: 32px;
            background-color: red;
            background-image: url("../images/ligar.png");
            background-size: 100% 100%;
            border-radius: 32px;
            border: 3px solid black;
        }
        nav ul{
            display: none;
            position: absolute;
            right:0px;
            top: 0;
            margin-top:30px;
            height: 40px;
            width: 150px;
            list-style-type: none; 
            
        }
        nav li{
            background-color: rgb(250,245,245);
            border-bottom: 1px solid black;
        }
        #meu_nav #atividade input[type=submit]{
            position: absolute;
            width: 100%;
            height: 30px;
            cursor: pointer;
            background: linear-gradient(red, black);
            color: gray;
            font-weight: bold;
        }
        <script src="https://kit.fontawesome.com/b6a341c846.js" crossorigin="anonymous"></script>
    </style>
</head>

<body>
    <main>
    <nav id="meu_nav">
        <ul id="atividade">
            <li>
                <form method="POST">
                    <input type="submit" name="acao" value="Fazer Logout" />
                    <?php
                        if(isset($_POST["acao"])){
                            session_destroy();
                            header("location: ../index");
                        }
                    ?>
                </form>    
            </li>
        </ul>
        <i class="fa-solid fa-circle-xmark"></i>
    </nav>
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
    <script src="../JS/jquery.js"></script>
    <script src="../JS/function.js"></script>
</body>