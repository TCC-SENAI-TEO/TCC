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
                <div>
                    <?php
                        $email = $_SESSION['email_funcionario'];

                        $pegar_img = mysqli_query($ConexaoSQL, "SELECT img FROM funcionarios img WHERE email = '$email'");
                        $pegar_img_assoc = mysqli_fetch_assoc($pegar_img);
                    
                        file_put_contents('image.png',$pegar_img_assoc['img']);

                        if($pegar_img_assoc['img'] == "") {
                            echo '<img src="../img/imagem_funcionario.png" alt="imagem_funcionario" class="img_perfil">';
                        } else {
                            echo '<img src="image.png" alt="imagem_funcionario" class="img_perfil">';
                        }

                     ?>
                </div>
                <div class="div_sair">
                    <?php
                       echo "<p class='registro'>".$_SESSION['email_funcionario']."</p>";
                    ?>
                    <a class="encaminhar_usuario_btn" href="../html/usuario_interface.php">Meus agendamentos</a>
                    <a href="../php/logout_login.php">Sair</a>
                    <span class="chamar_upload" id="upload_foto_btn">Upload foto de perfil</span>
                </div>
            </div>
        </header>

        <div class="salas_status">
            <div class="salas_status_coluna">
                <h3 class=" salas_totais" id="salas_totais"></h3>
                <h3 class=" sala_disponiveis" id="salas_disponiveis"></h3>
            </div>
            <div class="salas_status_coluna">
            <h3 class=" sala_interditadas" id="salas_interditadas"></h3>
            <h3 class=" sala_ocupadas" id="salas_ocupadas"></h3>
            </div>
        </div>

        <main>
            <form action="../php/enviar_foto.php" method="post" class="tela_upload" enctype="multipart/form-data" id="tela_upload">
            <div class="fechar fechar_tela" id="fechar_upload">X</div>
                <h3>Faça upload da sua foto de perfil abaixo(Max: 2MB): </h3>
                <input type="file" class="upload_foto" accept="image/png, image/jpeg, image/jpg" name="img">
                <input type="submit" class="enviar_foto">
            </form>
            <aside>
                    <ul class="ul_data, verificador_sala" >
                            <li><input type="date" id="data" class="tamanho_fixo" name="data"></li>
                            <label for="horario">Horario</label>
                                <select name="horario" class="tamanho_fixo" id="selecionar_horario">
                                    <option value="7:00">7:00</option>
                                    <option value="7:50">7:50</option>
                                    <option value="8:40">8:40</option>
                                    <option value="9:50">9:50</option>
                                    <option value="10:40">10:40</option>
                                    <option value="11:30">11:30</option>
                                </select>
                            </li>
                    </ul>
                    <?php
                        $verificar = $_SESSION['email_funcionario'];
                        $nivel = mysqli_query($ConexaoSQL, "SELECT nivel FROM funcionarios WHERE email = '$verificar'");
                        $nivel = mysqli_fetch_assoc($nivel);
                        $nivel = $nivel['nivel'];
                        if($nivel == 1) {
                                echo           
                                    '<form action="../php/registrar_sala.php" method="post" class="registrar_sala">'.
                                    '<input type="text" name="codigo_sala" id="texto_codigo_sala" placeholder="Código da sala" min="3" class="tamanho_fixo">'.
                                    '<input type="text" name="descricao_sala" id="texto_descricao_sala" placeholder="Descrição da sala" class="tamanho_fixo">'.
                                    '<input type="number" name="quantidade_sala" id="numero_quantidade_sala" placeholder="Capacidade da sala" min=1 class="tamanho_fixo">'.
                                    '<input type="submit" value="Cadastrar" id="cadastrar_sala_btn" class="tamanho_fixo">'.
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
                            echo 
                            '<a href="../html/registro.php" class="registro_funcionario_btn tamanho_fixo">Registrar</a>';
                        }
                        ?>
                </aside>
            <div class="salas">
                
            </div>
        </main>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        <script src="../js/pegar_numeros_sala.js"></script>
        <script src="../js/janelas.js"></script>
        <script src="../js/verificar_horario_home.js"></script>
    </body>
</html>