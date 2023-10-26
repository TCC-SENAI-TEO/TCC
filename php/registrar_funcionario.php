<?php
    include '../php/conectar_banco_de_dados.php'; 

    $nome = mysqli_real_escape_string($ConexaoSQL, $_POST['registrar_nome']);   //Recebe as informações do HTML e armazena
    $email = mysqli_real_escape_string($ConexaoSQL, $_POST['registrar_email']);
    $nivel = mysqli_real_escape_string($ConexaoSQL, $_POST['registrar_nivel']);
    $senha = mysqli_real_escape_string($ConexaoSQL, $_POST['registrar_senha']);

    if($nome == "" || $email == "" || $nivel == "" || $senha == "") { //Verifica se as variáveis estão vazias
        session_start(); //Inicia a sessão
        $_SESSION['error'] = 1;
        header("Location: ../html/registro.php");

    } else {
        
        switch ($nivel) {   //Transforma a varável texto para numero
        case 'Administrador':
                $nivel = 1;
            break;
        
        case 'Docente':
                $nivel = 2;
            break;
    }

        $verificar_email = mysqli_query($ConexaoSQL, "SELECT email FROM funcionarios WHERE email = '$email'"); //Verifica se o email já foi registrado, através 
        if($verificar_email = mysqli_num_rows($verificar_email) >= 1) { //Caso retorne alguma linha da requisição do banco, ele ira retornar um erro ao usuario
            session_start(); //Inicia a sessão
            $_SESSION['mensagem_erro'] = "O Email inserido já existe";
            $_SESSION['error'] = 2;
            header("Location:../html/registro.php");
        } else {
            $EnviandoDados = mysqli_query($ConexaoSQL,"INSERT INTO funcionarios(nome,email,nivel,senha) VALUES ('$nome','$email','$nivel','$senha')"); //Faz uma Inserção no Banco de dADOS
            session_start(); //Inicia a sessão
            $_SESSION['error'] = 3; //false
            header("Location: ../html/registro.php");

        }

}

?>