<?php
    include "../php/conectar_banco_de_dados.php";

    $codigo_sala = $_POST["codigo_sala"];
    $codigo_sala_original = $_POST["codigo_sala_original"];
    $descricao_sala = $_POST["descricao_sala"];
    $quantidade_sala = $_POST["capacidade"];


    $confirmar_edit =  $_POST['confirmar_edit'];
    $confirmar_delete = $_POST['confirmar_delete'];

    $id_sql = mysqli_query($ConexaoSQL, "SELECT id FROM salas WHERE codigo = '$codigo_sala_original'");
    $id_sql_assoc = mysqli_fetch_assoc($id_sql);
    $id_sql_id = $id_sql_assoc['id'];

    if($confirmar_delete == true) {
        $deletar_sala = mysqli_query($ConexaoSQL, "DELETE FROM salas WHERE id = '$id_sql_id'");
        $resetar_primary = mysqli_query($ConexaoSQL, "Set @num := 0;
        Update salas SET id = @num := (@num+1);
        ALTER TABLE salas AUTO_INCREMENT =1;");
        $confirmar_delete = false;

    }
    if($confirmar_edit == true) {
        $edit_row = mysqli_query($ConexaoSQL, "UPDATE salas SET codigo = '$codigo_sala' ,descricao = '$descricao_sala' ,capacidade = '$quantidade_sala' WHERE id = '$id_sql_id'");
        $confirmar_delete = false;
    }

    echo $codigo_sala;
    echo $descricao_sala;
    echo $quantidade_sala;
    echo $confirmar_edit;
    echo $confirmar_delete;

?>