<?php

include '../php/conectar_banco_de_dados.php';

session_start();

$email = $_SESSION['email_funcionario'];
$codigo_sala = $_SESSION['codigo_sala'];
$nivel_denuncia = $_POST['nivel_denuncia'];
$denuncia = $_POST['txt_reporte'];

if(isset($email) && isset($codigo_sala) && isset($nivel_denuncia) && isset($denuncia)) {
    $enviar_dados = mysqli_query($ConexaoSQL, "INSERT INTO manuntencao(codigo_sala, reclamante, denuncia, nivel_urgencia, status_sala) VALUES ('$codigo_sala', '$email', '$denuncia' ,'$nivel_denuncia', '1')");

}

header('Location: ../html/reportar_sala.php');

?>