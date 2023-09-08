<?php
    session_start();
    if($_SESSION['login'] != true) { //verifica se o usuario fez login anteriormente
        header("Location: ../html/login.php");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link rel="stylesheet" href="../css/agendamento.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <title>Agendamento</title>
</head>
<body>
    <header>
        <?php
            echo "<h1 class='titulo'> Sala ".$_SESSION['descricao_sala']." - ".$_SESSION['codigo_sala']."</h1>";
        ?>
        <a class="voltar" href="home.php">Voltar</a>
    </header>
    
    <main>
        <h1>Faça sua reclamação</h1>
        <form action="../php/enviar_reporte.php" method="post" id='formulario'>
            <?php
                $email = $_SESSION['email_funcionario'];
                $codigo_sala = $_SESSION['codigo_sala'];
                echo
                "<input type='email' disabled placeholder='email' value='$email'>".
                "<input type='text' disabled placeholder='$codigo_sala' value='$codigo_sala'>".
                "<ul>
                    <label for='nivel_denuncia'>Gravidade do problema: </label>
                    <select name='nivel_denuncia'>
                        <option value='1'>Leve</option>
                        <option value='2'>Mediano</option>
                        <option value='3'>Grave</option>
                    </select>
                </ul>".
                "<textarea rows='4' cols='50' name='txt_reporte' form='formulario' placeholder='Digite Sua Reclamação'></textarea>".
                "<input type='submit' value='Enviar'>".
                "</form>";

            ?>
        <?php
        
        if(isset($_SESSION['erro_reporte'])) {
            $erro = $_SESSION['erro_reporte'];
            if($erro == 0) {
                echo
                "<div class='certo' id='certo'>
                    <span>A sua reclamação foi enviada com Sucesso</span>
                    <div class='fechar' id='fechar_certo'>X</div>
                </div>";
                unset($_SESSION['erro_reporte']);
                
            } else if($erro == 1) {
                echo
                "<div class='erro' id='erro'>
                    <span>Não foi possível enviar sua reclamação</span>
                    <div class='fechar' id='fechar_erro'>X</div>
                </div>";
                unset($_SESSION['erro_reporte']);
                
            }

        }
        
        ?>
        <script src="../js/fechar_janelas.js"></script>
    </main>