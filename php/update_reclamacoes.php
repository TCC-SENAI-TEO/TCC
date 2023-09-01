<?php
session_start(); //inicia a sessão do usuario para que se possa pegar as informações contidas nela posteriormente
include "../php/conectar_banco_de_dados.php";


    $update = $_POST['linha_sql'];
    echo $update;

?>