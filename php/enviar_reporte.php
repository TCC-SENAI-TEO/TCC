<?php

include '../php/conectar_banco_de_dados.php';

session_start();//Inicia sessão

$email = $_SESSION['email_funcionario'];//Pega o valor da vatiável global '$_SESSION['email_funcionario']
$codigo_sala = $_SESSION['codigo_sala'];//Pega o valor da vatiável global '$_SESSION['codigo_sala']
$nivel_denuncia = $_POST['nivel_denuncia'];//Pega o valor da varíaveis do input 'name'
$denuncia = $_POST['txt_reporte'];//Pega o valor da varíaveis do input 'name'
$data_denuncia = date('Y/m/d');

if(isset($email) && isset($codigo_sala) && isset($nivel_denuncia) && $denuncia != "") { 
    $enviar_dados = mysqli_query($ConexaoSQL, "INSERT INTO manutencao(data_denuncia, codigo_sala, reclamante, denuncia, nivel_urgencia, status_denuncia) VALUES ('$data_denuncia', '$codigo_sala', '$email', '$denuncia' ,'$nivel_denuncia', '1')");//Faz uma requisição de inserção de novos dados no banco de dados
    $_SESSION['erro_reporte'] = 0;//Variável recebe 0

} else {
    $_SESSION['erro_reporte'] = 1;//Variável recebe 1
}



header("Location: ../html/reportar_sala.php");//Encaminha para a 'reportar_sala.php'

?>