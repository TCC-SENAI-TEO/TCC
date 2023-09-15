<?php 
session_start(); //inicia a sessão do usuario para que se possa pegar as informações contidas nela posteriormente
if($_SESSION['login'] != true) { //verifica se o usuario fez login anteriormente
    header("Location: ../html/login.php");
} elseif($_SESSION['nivel_funcionario'] != 1) {
    header("Location: ../html/home.php");
}

include "../php/conectar_banco_de_dados.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/usuario.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <title>Reclamações</title>
</head>
<body>
    <header>
        <a class="voltar" href="home.php">Voltar</a>
        <h1 class='titulo'>Reclamações</h1>
    </header>

    <main>
        <table id="tabela_info">
            <!--Table que receba a resposta do ajax para mostrar as informações ao ADM-->
        </table>

        <div class="filtro-tabela">
            <label>Filtrar Status</label><br>

            <input type="checkbox" id="Pendente" value="Pendente">
            <label for="Pendente"> Pendente </label><br>

            <input type="checkbox" id="Em_Andamento" value="Em Andamento">
            <label for="Em Andamento"> Em Andamento </label><br>

            <input type="checkbox" id="Concluido" value="Concluido">
            <label for="Concluido"> Concluido </label>

        </div>

    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="../js/ajax_reclamacoes.js"></script>
</body>
</html>