<?php 
session_start(); //inicia a sessão do usuario para que se possa pegar as informações contidas nela posteriormente
if($_SESSION['login'] != true) { //verifica se o usuario fez login anteriormente
    header("Location: ../html/login.php");
}
include "../php/conectar_banco_de_dados.php"
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/home.css">
        <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
        <title>Home</title>
    </head>
    <body>

        <header>
            <img src="../img/senai.png" alt="Logo Senai" class="senai_logo">
            <h1 class="titulo">Painel central</h1>
            <div class="perfil">
                <div><img src="../img/imagem_funcionario.png" alt="imagem_funcionario" class="img_perfil"></div>
                <div class="div_sair">
                    <?php
                       echo "<p class='registro'>".$_SESSION['email_funcionario']."</p>";
                    ?>
                    <a href="../php/logout_login.php">Sair</a>
                </div>
            </div>
        </header>

                <div class="salas_status">
                    <h3 class=" salas_totais">Salas: </h3>
                    <h3 class=" sala_salas_disponiveis">Salas disponiveis: </h3>
                    <h3 class=" sala_interditadas">Salas interditadas: </h3>
                    <h3 class=" sala_ocupadas">Salas ocupadas: </h3>
                </div>

        <main>
            <div>
                <ul class="ul_data">
                    <form action="../php/verificar_sala_disponivel.php" method="post">
                        <li><input type="date" id="data" name="data"></li>
                        <label for="horario">Horario</label>
                            <select name="horario">
                                <option value="7:00">7:00</option>
                                <option value="7:50">7:50</option>
                                <option value="8:40">8:40</option>
                                <option value="9:50">9:50</option>
                                <option value="10:40">10:40</option>
                                <option value="11:30">11:30</option>
                            </select>
                            <li><input type="submit" value="Verificar"></li>
                    </form>
                </select>
                    </li>
                </ul>
            <a class="encaminhar_usuario" href="../html/usuario_interface.php">Meus agendamentos</a>
                <?php

                    $verificar = $_SESSION['email_funcionario'];
                    $nivel = mysqli_query($ConexaoSQL, "SELECT nivel FROM funcionarios WHERE email = '$verificar'");
                    $nivel = mysqli_fetch_assoc($nivel);
                    $nivel = $nivel['nivel'];
                    if($nivel == 1) {
                            echo'<div class="tela_criar_sala">'.            
                                '<form action="../php/registrar_sala.php" method="post" class="registrar_sala">'.
                                '<input type="text" name="codigo_sala" id="texto_codigo_sala" placeholder="Código da sala" min="3">'.
                                '<input type="text" name="descricao_sala" id="texto_descricao_sala" placeholder="Descrição da sala">'.
                                '<input type="number" name="quantidade_sala" id="numero_quantidade_sala" placeholder="Capacidade da sala" min=1>'.
                                '<input type="submit" value="Cadastrar" id="cadastrar_sala_btn">'.
                                '</form>';

                    }
                    if(@$_SESSION['error_codigo'] == 1) {
                        echo"<div class='erro' id='erro'>
                                <span>A sala inserida já foi registrada</span>
                                <div class='fechar' id='fechar_erro'>X</div>
                            </div>";
                            $_SESSION['error_codigo'] = 0;
            
                    } else if(@$_SESSION['error_codigo'] == 2) {
                        echo"<div class='certo' id='certo'>
                                <span>A criação da sala foi bem sucedida</span>
                                <div class='fechar' id='fechar_certo'>X</div>
                            </div>";
                            $_SESSION['error_codigo'] = 0;

                    }
                    if($nivel == 1) {
                        echo '</div>';
                    }
                    ?>
                </div>
            <div class="salas">
                <?php 
                    $quantidade_salas = mysqli_query($ConexaoSQL, "SELECT * from salas");   //faz o query no banco de dados
                    $quantidade_salas = mysqli_num_rows($quantidade_salas); //pega o numero de linhas afetadas pelo query
                    
                    for ($i=1; $i <= $quantidade_salas; $i++) { 

                        $codigo = mysqli_query($ConexaoSQL, "SELECT codigo FROM salas WHERE id = '$i'");
                        $codigo = mysqli_fetch_array($codigo);
                        $codigo = $codigo['codigo']; //usar esse
                        
                        $descricao = mysqli_query($ConexaoSQL, "SELECT descricao FROM salas WHERE id = '$i'");
                        $descricao = mysqli_fetch_array($descricao);
                        $descricao = $descricao['descricao']; //usar esse
                        
                        $capacidade = mysqli_query($ConexaoSQL, "SELECT capacidade FROM salas WHERE id = '$i'");
                        $capacidade = mysqli_fetch_array($capacidade);
                        $capacidade = $capacidade['capacidade']; //usar esse
                        
                        if(isset($_SESSION['horario'])) {
                            $horario = $_SESSION['horario'];
                        } else {
                            $horario = 1;
                        }

                        if(isset($_SESSION['data'])) {
                            $data = $_SESSION['data'];
                        } else {
                            $data = date('y-m-d');
                        }

                        $salas_disponiveis = mysqli_query($ConexaoSQL, "SELECT * FROM agendamentos WHERE id_horario = '$horario' and inicio = '$data' and id_sala = '$i'");
                        $horario_incio = mysqli_query($ConexaoSQL, "SELECT horario.inicio FROM agendamentos inner join horario on agendamentos.id_horario = horario.id WHERE id_horario = '$horario' and agendamentos.inicio = '$data' and id_sala = '$i'");
                        $horario_incio_assoc = mysqli_fetch_array($horario_incio);
                        @$horario_inico_result = $horario_incio_assoc['inicio'];

                        $horario_termino = mysqli_query($ConexaoSQL, "SELECT horario.fim FROM agendamentos inner join horario on agendamentos.id_horario = horario.id WHERE id_horario = '$horario' and agendamentos.inicio = '$data' and id_sala = '$i'");
                        $horario_termino_assoc = mysqli_fetch_array($horario_termino);
                        @$horario_termino_result = $horario_termino_assoc['fim'];

                        $professor = mysqli_query($ConexaoSQL, "SELECT * FROM agendamentos inner join funcionarios on agendamentos.id_funcionarios = funcionarios.id WHERE id_horario = '$horario' and agendamentos.inicio = '$data' and id_sala = '$i'");
                        $professor_assoc = mysqli_fetch_array($professor);
                        @$professor_result = $professor_assoc['nome'];


                        if($salas_disponiveis = mysqli_num_rows($salas_disponiveis) > 0) {
                            echo "<div class='salas salas_fechado'>".
                                    "<form /action='../php/agendar_sala_tratamento.php' class='agendamentos' method='post'>".
                                    "<h4 class='tag'>Sala ".$codigo." - ".$descricao."</h4>".
                                    "<p class='tag'><strong>Responsável:</strong> ".$professor_result."</p>".
                                    "<p class='tag'><strong>Inicio:</strong> ".$horario_inico_result."</p>".
                                    "<p class='tag'><strong>Termino</strong> ".$horario_termino_result."</p>".
                                    "<p class='tag'><strong>Quantidade</strong>: ".$capacidade."</p>".
                                    "<input type='hidden' name='codigo_sala' value='$codigo'>".
                                    "<input type='hidden' name='descricao_sala' value='$descricao'>".
                                    "<input type='submit' value='Agendar' class='botao'>".
                                    "</form>".
                                "</div>";         
                        } else {
                            echo "<div class='salas salas_disponivel'>".
                                    "<form action='../php/agendar_sala_tratamento.php' class='agendamentos' method='post'>".
                                        "<h4 class='tag'>Sala ".$codigo." - ".$descricao."</h4>".
                                        "<p class='tag'><strong>Responsável:</strong> Livre </p>".
                                        "<p class='tag'><strong>Inicio:</strong>: Livre</p>".
                                        "<p class='tag'><strong>Termino</strong>: Livre</p>".
                                        "<p class='tag'><strong>Quantidade</strong>: ".$capacidade."</p>".
                                        "<input type='hidden' name='codigo_sala' value='$codigo'>".
                                        "<input type='hidden' name='descricao_sala' value='$descricao'>".
                                        "<input type='submit' value='Agendar' class='botao'>".
                                        "</form>".
                                    "</div>";   
                        }            
                                                      
                    }
                ?>
            </div>
        </main>
        <script src="../js/data.js"></script>
        <script src="../js/fechar_janela.js"></script>
    </body>
</html>
