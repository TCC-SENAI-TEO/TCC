<?php
    include '../php/conectar_banco_de_dados.php'; 



    $nome = $_POST['registrar_nome'];
    $email = $_POST['registrar_email'];
    $nivel = $_POST['registrar_nivel'];
    $senha = $_POST['registrar_senha'];

    if($nome == "" || $email == "" || $nivel == "" || $senha == "") {
        session_start();
        $_SESSION['error'] = 1;
        header("Location: ../html/registro.php");

    } else {
        switch ($nivel) {
        case 'Administrador':
                $nivel = 1;
            break;
        
        case 'Docente':
                $nivel = 2;
            break;
    }

        $verificar_email = mysqli_query($ConexaoSQL, "SELECT email FROM funcionarios WHERE email = '$email'");
        if($verificar_email = mysqli_num_rows($verificar_email) >= 1) {
            session_start();
            $_SESSION['mensagem_erro'] = "O Email inserido já existe";
            $_SESSION['error'] = 2;
            header("Location:../html/registro.php");
        } else {
            $EnviandoDados = mysqli_query($ConexaoSQL,"INSERT INTO funcionarios(nome,email,nivel,senha) VALUES ('$nome','$email','$nivel','$senha')");
            session_start();
            $_SESSION['error'] = 3; //false
            header("Location: ../html/registro.php");

        }

}

?>