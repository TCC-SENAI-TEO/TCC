<?php
    $host = 'localhost';
    $nome = 'root';
    $password = '';
    $nomeSQL = 'tcc';
    $ConexaoSQL = new mysqli($host, $nome, $password, $nomeSQL);

    $nome = $_GET['registrar_nome'];
    $email = $_GET['registrar_email'];
    $nivel = $_GET['registrar_nivel'];
    $senha = $_GET['registrar_senha'];

    $EnviandoDados = mysqli_query($ConexaoSQL,"INSERT INTO funcionarios(nome,email,nivel,senha) VALUES ('$nome','$email','$nivel','$senha')");

    header("Location: ../html/login.html")
?>