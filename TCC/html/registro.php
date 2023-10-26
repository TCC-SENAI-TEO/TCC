<?php 
session_start(); //inicia a sessão do usuario para que se possa pegar as informações contidas nela posteriormente
include '../php/conectar_banco_de_dados.php';
$email = $_SESSION['email_funcionario']; //Armazena a informaçãoda variável SESSION['email_funcionario']
$verificar = mysqli_query($ConexaoSQL, "SELECT nivel FROM funcionarios WHERE email = '$email'"); //Faz uma requisição ao banco de dados, no qual, seleciona a coluna nivel da tabela funcionarios onde a coluna email seja igual a variável $email 
$verificar = mysqli_fetch_assoc($verificar); //Transforma o objeto sql retornado pela variavel $verificar e transforma em um array associativo
$verificar = $verificar['nivel']; //Armazena o valor da key 'nivel' do array associativo

if($_SESSION['login'] != true || $verificar != 1) { //verifica se o usuario fez login anteriormente
    header("Location: ../html/login.php"); //caso não tenha, o usuario retornara a tela de login
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../css/registro.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">

</head>
<body>

    <main>
        <div class="title">
            <h1>Registro</h1>
        </div>
        <form action="../php/registrar_funcionario.php" method="post">
            <input type="text" placeholder="Nome Completo" name="registrar_nome">
            <input type="email" placeholder="Email" name="registrar_email">
            <ul>
                <label for="registrar_nivel">Nivel: </label>
                <select name="registrar_nivel">
                    <option value="Administrador" selected>Adminsitrador</option>
                    <option value="Docente">Docente</option>
                </select>
            </ul>
            <input type="password" placeholder="Senha" name="registrar_senha" min="6" id="senha">
            <input type="password" placeholder="Confirmar Senha" min="6" id="confirmar_senha">
            <input type="submit" value="Salvar" id="botao">
        </form>
    </main>
        <?php 
            if(@$_SESSION['error'] == 1) {  //Verifica se houve algum erro, caso exista algum erro, ele tera um valor que sera usado como base para imprimir um especifico erro ao usuario
                echo"<div class='erro'> 
                        <span>Verifique novamente se inseriou corretamente os dados</span> 
                    </div>";

            } else if(@$_SESSION['error'] == 2) {
                echo"<div class='erro'> 
                        <span>O Email inserido já está registrado</span> 
                    </div>";
            }   else if(@$_SESSION['error'] == 3) { 
                echo"<div class='certo'> 
                        <span>O registro foi feito com sucesso!</span> 
                    </div>";
            }
        ?>
    <script src="../js/fechar_janelas.js"></script>
</body>
</html>