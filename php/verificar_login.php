<?php
    include '../php/conectar_banco_de_dados.php';

    $email = $_POST['login_email'];
    $senha = $_POST['login_password'];

    $verificar_login = mysqli_query($ConexaoSQL, "SELECT * FROM funcionarios WHERE email = '$email' and senha = '$senha'");

    if($verificar_login = mysqli_num_rows($verificar_login) == 1) {
        session_start();
        $_SESSION['error'] = "0";
        header("Location: ../html/home.html");  
    } else {
        session_start();
        $_SESSION['error'] = "1";
        header('Location: ../html/login.php');
    }


?>