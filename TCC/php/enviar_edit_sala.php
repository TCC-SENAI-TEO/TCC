<?php
    include "../php/conectar_banco_de_dados.php";

    $codigo_sala = $_POST["codigo_sala"];//Recebe o valor do input, com compenent "name" especifico do HTML 
    $codigo_sala_original = $_POST["codigo_sala_original"];//Recebe o valor do input, com compenent "name" especifico do HTML 
    $descricao_sala = $_POST["descricao_sala"];//Recebe o valor do input, com compenent "name" especifico do HTML 
    $quantidade_sala = $_POST["capacidade"];//Recebe o valor do input, com compenent "name" especifico do HTML 
    $status_sala = $_POST["status_sala"];//Recebe o valor do input, com compenent "name" especifico do HTML 
    @$motivo_manutencao = $_POST["motivo_manutencao"];//Recebe o valor do input, com compenent "name" especifico do HTML 


    @$confirmar_edit =  $_POST['confirmar_edit'];//Recebe o valor do input, com compenent "name" especifico do HTML 
    @$confirmar_delete = $_POST['confirmar_delete'];//Recebe o valor do input, com compenent "name" especifico do HTML 

    $id_sql = mysqli_query($ConexaoSQL, "SELECT id FROM salas WHERE codigo = '$codigo_sala_original'");//Faz uam requisição ao banco de dados aonde 'codigo' da tabela 'salas' deve ser igual a variavel '$codigo_sala_original'
    $id_sql_assoc = mysqli_fetch_assoc($id_sql);//Trnasforma um array comum em um array associativo
    $id_sql_id = $id_sql_assoc['id'];//Recebe o valor da key 'id' do array associativo
    
    if($confirmar_delete == "true") {//Verifica a confirmação do 'delete'

        try {
            $deletar_sala = mysqli_query($ConexaoSQL, "DELETE FROM salas WHERE id = '$id_sql_id'");//Faz uma requisição ao banco de dados para deletar uma linha aonde o id deve ser igual ao '$id_sql_id' 
            throw new Exception($ConexaoSQL->error);//Caso haja erros no banco de dados ele criará uma excessão e será enviada para o catch

            $confirmar_delete = false;//Retorna 'false'
            
        } catch(Exception $log) {
            echo $log->getMessage();//Imprimire o erro
        }
    } else {
        //Faz nada
    }




    if($confirmar_edit == true) {//Verfiica o '$confirmar_edit'
        $edit_row = mysqli_query($ConexaoSQL, "UPDATE salas SET codigo = '$codigo_sala' ,descricao = '$descricao_sala' ,capacidade = '$quantidade_sala' ,status_sala = '$status_sala',motivo_manutencao = '$motivo_manutencao' WHERE id = '$id_sql_id'");//Faz uma requisição de update de uma linha no banco de dados
        $confirmar_delete = false;//Retorna 'false'
    }


?>