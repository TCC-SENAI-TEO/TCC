<?php
    include '../php/conectar_banco_de_dados.php';

    $email = mysqli_real_escape_string($ConexaoSQL, $_POST['login_email']);
    $senha = mysqli_real_escape_string($ConexaoSQL, $_POST['login_password']);

    $verificar_login = mysqli_query($ConexaoSQL, "SELECT * FROM funcionarios WHERE email = '$email' and senha = '$senha'");

    if($verificar_login = mysqli_num_rows($verificar_login) == 1) { //verifica se o login existe e leva para a pagina home
        session_start();
        $_SESSION['error'] = "0";
        $_SESSION['email_funcionario'] = $email;
        $_SESSION['nivel_funcionario'] = $nivel;
        $_SESSION['login'] = true;
        header("Location: ../html/home.php");
    } else {
        session_start();
        $_SESSION['error'] = "1";
        header('Location: ../html/login.php');
    }

?>