<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/registro.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
</head>
<body>

    <main id="main">
        <div class="title">
            <h1>Login</h1>
        </div>
        <form action="../php/verificar_login.php" method="post">
            <input type="email" name="login_email" placeholder="Email">
            <input type="password" name="login_password" placeholder="Senha">
            <input type="submit" value="Entrar">
        </form>
    </main>
        <?php 
            session_start();
            if(@$_SESSION['error'] == 1) {
                echo"<div class='erro'> 
                        <span>Login ou senha inválidos</span> 
                    </div>";
            } else {
                echo "";
            }
        ?>
    
</body>
</html>