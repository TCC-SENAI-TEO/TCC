<?php
    session_start(); //Incia a session
    session_unset(); //Limpa todas as variáveis globais do estilo SESSION
    session_destroy(); //Destroi todos os dados da sessão
    header('Location: ../html/login.php'); //Retorna para a tela de login
?>