<?php
    include "../php/conectar_banco_de_dados.php";

    $codigo_sala = $_POST["codigo_sala"];
    $codigo_sala_original = $_POST["codigo_sala_original"];
    $descricao_sala = $_POST["descricao_sala"];
    $quantidade_sala = $_POST["capacidade"];
    $status_sala = $_POST["status_sala"];
    $motivo_manutencao = $_POST["motivo_manutencao"];


    $confirmar_edit =  $_POST['confirmar_edit'];
    $confirmar_delete = $_POST['confirmar_delete'];

    $id_sql = mysqli_query($ConexaoSQL, "SELECT id FROM salas WHERE codigo = '$codigo_sala_original'");
    $id_sql_assoc = mysqli_fetch_assoc($id_sql);
    $id_sql_id = $id_sql_assoc['id'];

    echo 
    $codigo_sala."<br>".
    $codigo_sala_original."<br>".
    $descricao_sala."<br>".
    $quantidade_sala."<br>".
    $status_sala."<br>".
    $motivo_manutencao."<br>".
    $confirmar_delete."<br>".
    $id_sql_id."<br>";

    if($confirmar_delete == true) {
        $deletar_sala = mysqli_query($ConexaoSQL, "DELETE FROM salas WHERE id = '$id_sql_id'");
        $confirmar_delete = false;

    }
    if($confirmar_edit == true) {
        $edit_row = mysqli_query($ConexaoSQL, "UPDATE salas SET codigo = '$codigo_sala' ,descricao = '$descricao_sala' ,capacidade = '$quantidade_sala' status_sala = '$status_sala',motivo_manutencao = '$motivo_manutencao' WHERE id = '$id_sql_id'");
        $confirmar_delete = false;
    }


?>