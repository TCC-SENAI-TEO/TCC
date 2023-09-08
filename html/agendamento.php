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
            echo "<input type='hidden' id='codigo_sala' value=".$_SESSION['codigo_sala'].">"
        ?>
        <a class="voltar" href="home.php">Voltar</a>
    </header>
    <main>
        <form action="../php/agendar_sala.php" method="post">
            <?php 
                $email = $_SESSION['email_funcionario'];
                echo "<input type='email' disabled placeholder='email' value='$email'>";
            ?>
            <aside>
            <ul class='div_horario'>
                <label class="data_txt" for="data_inicio">Data de inicio: </label>
                <input type="date" name="data_inicio" class='date' id="data_escolhida">
            </ul>
        </aside>
            <section id="info">
                <!--aqui recebe as informações do ajax para escrever as informações ao usuario e podendo ligar ou desligar as checkbox-->
            </section>

            <input type="submit" name="submit" value="Agendar">
        </form>

        <?php
            if(@$_SESSION['error_agendar_sala'] == 1) {
            echo "<div class='erro' id='erro'>
                    <span> Ocorreu um erro durante a criação da sala, tente novamente</span>
                    <div class='fechar' id='fechar_erro'>X</div>
                </div>";
                $_SESSION['error_agendar_sala'] = 0;
            } else if(@$_SESSION['error_agendar_sala'] == 2){
                echo "<div class='certo' id='certo'>
                <span> O agendamento da sala foi bem sucedido!</span>
                <div class='fechar' id='fechar_certo'>X</div>
            </div>";
            $_SESSION['error_agendar_sala'] = 0;
            } else {
                echo "";
            }
        ?>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="../js/ajax_agendar_salas.js"></script>
        <script src="../js/fechar_janelas.js"></script>
    </main>
</body>
</html>