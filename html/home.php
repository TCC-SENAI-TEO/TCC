<?php 
session_start(); //inicia a sessão do usuario para que se possa pegar as informações contidas nela posteriormente
if($_SESSION['login'] != true) { //verifica se o usuario fez login anteriormente
    header("Location: ../html/login.php");
}
include "../php/conectar_banco_de_dados.php"
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/home.css">
        <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
        <title>Home</title>
    </head>
    <body>

        <header>
            <img src="../img/senai.png" alt="Logo Senai" class="senai_logo">
            <h1 class="titulo">Painel central</h1>
            <div class="perfil">
                <div class="img_perfil"></div>
                <div class="teste">
                    <?php
                       echo "<p class='registro'>".$_SESSION['email_funcionario']."</p>";
                    ?>
                    <a href="../php/logout_login.php">Sair</a>
                </div>
            </div>
        </header>

        <main>
            <ul class="salas_status">
                <li><h3 class=" salas_totais">Salas: </h3></li>
                <li><h3 class=" sala_disponiveis">Salas disponiveis: </h3></li>
                <li><h3 class=" sala_interditadas">Salas interditadas: </h3></li>
                <li><h3 class=" sala_ocupadas">Salas ocupadas: </h3></li>
                <a href="add_sala.html" target="_blank" class="link add_sala" id="add_sala">Adicionar sala</a>
            </ul>
            <div class="tela_criar_sala" id="tela_criar_sala">
                <form action="../php/registrar_sala.php" method="post">
                    <input type="text" name="codigo_sala" id="texto_codigo_sala" placeholder="Código da sala" min="3">
                    <input type="text" name="descricao_sala" id="texto_descricao_sala" placeholder="Descrição da sala" >
                    <input type="number" name="quantidade_sala" id="numero_quantidade_sala" placeholder="Capacidade da sala" min=1>
                    <input type="submit" value="Cadastrar" id="cadastrar_sala_btn">
                </form>
                <?php 
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
                ?>
            </div>
            <!-- <div class="salas"  id="salas">
                <div class="sala">
                    <h4 class="tag">Sala 102E - Informatica</h4>
                    <p class="tag">Responsavel: Claudio</p>
                    <p class="tag">Data/hora Inicio: 26/07/23 - 13:00</p>       #VOU USAR DE BASE PARA TESTE
                    <p class="tag">Data/hora Fim:  26/07/23 - 13:50</p>
                    <p class="tag">Qtd: 40</p>
                    <input type="button" value="-----------" class="botao reservar desocupar">
                </div>
            </div> !-->
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

                        echo "<div class='sala'>
                                <h4 class='tag'>Sala ".$codigo." - ".$descricao."</h4>".
                                "<p class='tag'> Responsavel Claudio ".$i."</p>".
                                "<p class='tag'>Data/hora Inicio: 00/00</p>".
                                "<p class='tag'>Data/hora Fim: 00/00</p>".
                                "<p class='tag'>Qtd: ".$capacidade."</p>".
                                "<input type='button' value='----------' class'botao reservar desocupar'>".
                                "</div>";
                                
                    }
                ?>
            </div>
        </main>

        <script src="../js/gerador_de_salas.js"></script>
        <script src="../js/fechar_janela.js"></script>
    </body>
</html>