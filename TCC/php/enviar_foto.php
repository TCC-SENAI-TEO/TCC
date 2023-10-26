<?php
    include '../php/conectar_banco_de_dados.php';

    session_start();//Inicia sessão

    try {
        $email = $_SESSION['email_funcionario'];//Pega a variável 'email_funcionario'
        $img = $_FILES['img'];//Pega a variável 'img'
    
        if($img['size'] > 2000000) {//Verifica o tamanho da imagem
            echo "imagem nao suportada, Tamanho do arquivo maior que 2 MB";
        } else {
            $img_transformada = addslashes(file_get_contents($_FILES['img']['tmp_name']));//0 'addslashes()'adiciona barras invertidas(\), enquanto o 'file_get_contents()' é usado para ler o conteudo da imagem
            $enviar_img = mysqli_query($ConexaoSQL, "UPDATE funcionarios SET img = '$img_transformada' WHERE email = '$email'");//Faz a requisição de update de uma linha do banco de dados
        
        
        }

    } catch (\Throwable $th) {
        
    }

    header("Location: ../html/home.php");//Encaminha para a página inicial




?>