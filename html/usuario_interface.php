<?php 
session_start(); //inicia a sessão do usuario para que se possa pegar as informações contidas nela posteriormente
if($_SESSION['login'] != true) { //verifica se o usuario fez login anteriormente
    header("Location: ../html/login.php"); //Caso não tenha feito o login, volta para a tela de login

}
include "../php/conectar_banco_de_dados.php"
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/usuario.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <title>Meus Agendamentos</title>
</head>
<body>
    <header>
        <a class="voltar" href="home.php">Voltar</a>
        <h1 class='titulo'>Usuário</h1>
    </header>
    <main>
        
        <div id="info">
            <!--Recebe as informações do AJAX e imprimi aqui-->
        </div>
            
        <div class="content-opções">
            <select id="selecionar_funcionarios" class="opções">
                <option style="display:none;" selected>Selecionar Funcionario</option>
                <?php
                    include '../php/conectar_banco_de_dados.php';
                    $funcionarios = mysqli_query($ConexaoSQL, "SELECT * FROM funcionarios"); //Faz uma requisição ao banco de dados
                    $quantidade_funcionarios = mysqli_num_rows($funcionarios); //Verifica quantas linhas foram retornadas da requisição
            
                    for($a = 1; $a <= $quantidade_funcionarios; $a++) {
                        $nome_funcionarios_assoc = mysqli_fetch_assoc($funcionarios); //Transforma o objeto sql em um array associativo
                        $nome_funcionarios = $nome_funcionarios_assoc['nome']; //Armazena o valor da key 'nome' do array associativo
                        echo
                        "<option value='$nome_funcionarios'>".$nome_funcionarios."</option>"; //Imprimi o valor da variável $nome_funcionarios
                    }
            
                ?>
            </select>
            
            <div class="opções">
                <label>Selecionar Todos</label>
                <input type="checkbox" id="checar" value="checado">
            </div>
            <div class="opções">
                <label>Selecionar Data</label>
                <input type="date" id="escolher_data">
            </div>
            <select id="selecionar_sala" class="opções">
                <option style="display:none;" selected>Selecionar Sala</option>
                <?php
                    include '../php/conectar_banco_de_dados.php';
                    $salas = mysqli_query($ConexaoSQL, "SELECT * FROM salas"); //Faz uma requisição ao banco de dados
                    $quantidade_salas = mysqli_num_rows($salas); //Verifica quantas linhas retornaram da requisição
            
                    for($a = 1; $a <= $quantidade_salas; $a++) {
                        $codigo_salas_assoc = mysqli_fetch_assoc($salas); //Transforma o objeto sql em um array associativo
                        $codigo_salas = $codigo_salas_assoc['codigo']; //Armazena o valor da key 'codigo' do array associativo
                        echo
                        "<option value='$codigo_salas'>".$codigo_salas."</option>"; //Imprimi o valor da variável $codigo_salas
                    }
            
                ?>
            </select>
        </div>
            
    </main>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="../js/selecionar_professor.js"></script>
</body>
</html>