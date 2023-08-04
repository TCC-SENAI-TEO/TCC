<?php
    include '../php/conectar_banco_de_dados.php';

    session_start();

    try {
        $email = $_SESSION['email_funcionario'];
        $img = $_FILES['img'];
    
        if($img['size'] > 2000000) {
            echo "imagem nao suportada, Tamanho do arquivo maior que 2 MB";
        } else {
            $img_transformada = addslashes(file_get_contents($_FILES['img']['tmp_name']));
            $enviar_img = mysqli_query($ConexaoSQL, "UPDATE funcionarios SET img = '$img_transformada' WHERE email = '$email'");
        
        
        }

    } catch (\Throwable $th) {
        
    }

    header("Location: ../html/home.php");




?>