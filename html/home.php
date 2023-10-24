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
        <div id="teste123"></div>
        <header>
            <img src="../img/senai.png" alt="Logo Senai" class="senai_logo">
            <h1 class="titulo">Painel central</h1>
            <div class="perfil">
                <div>
                    <?php
                        $email = $_SESSION['email_funcionario'];

                        $pegar_img = mysqli_query($ConexaoSQL, "SELECT img FROM funcionarios WHERE email = '$email'");
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

                       $verificar = $_SESSION['email_funcionario'];
                       $nivel = mysqli_query($ConexaoSQL, "SELECT nivel FROM funcionarios WHERE email = '$verificar'");
                       $nivel = mysqli_fetch_assoc($nivel);
                       $nivel = $nivel['nivel'];
                       
                       $_SESSION['nivel_funcionario'] = $nivel;

                       if($_SESSION['nivel_funcionario'] == 1) {
                        echo "<a href='../html/reclamacoes_adm.php'>Reclamações</a>";
                       }
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
                    <h3>Verificar Horario disponível</h3>
                    <ul class="ul_data, verificador_sala">
                            <li><input type="date" id="data" class="tamanho_fixo" name="data"></li>
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
                    <div id="container-editar-salas">
                        <div id="editar_salas">
                            <!--recebe o ajaz de ediçao das salas--->
                        </div>
                    </div>
                    <div id="registrar_funcionario">
                    <?php
                        if(@$_SESSION['error_codigo'] == 1) {
                            echo"<div class='erro' id='erro'>
                                    <span>A sala inserida já foi registrada</span>
                                    <div class='fechar' id='fechar_erro'>X</div>
                                </div>";
                                $_SESSION['error_codigo'] = 0;
                
                        } else if(@$_SESSION['error_codigo'] == 3) {
                            echo"<div class='certo' id='certo'>
                                    <span>A criação da sala foi bem sucedida</span>
                                    <div class='fechar' id='fechar_certo'>X</div>
                                </div>";
                                $_SESSION['error_codigo'] = 0;

                        } else if(@$_SESSION['error_codigo'] == 2){
                            echo"<div class='erro' id='erro'>
                            <span>Insira dados validos para a criação da sala</span>
                            <div class='fechar' id='fechar_erro'>X</div>
                            </div>";
                        $_SESSION['error_codigo'] = 0;
                        }
                        if($nivel == 1) {
                            echo 
                            "<h3>Regitrar Funcionario</h3>".
                            '<a href="../html/registro.php" class="registro_funcionario_btn tamanho_fixo">Registrar</a>';
                        }
                        ?>
                    </div>
                </aside>
            <div class="salas">
                    <!--Aqui onde é mostrado as informações -->
            </div>
        </main>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="../js/home.js"></script>
        <script src="../js/fechar_janelas.js"></script>
    </body>
</html>