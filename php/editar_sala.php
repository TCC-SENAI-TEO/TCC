<?php

    include '../php/conectar_banco_de_dados.php';

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    if(isset($_POST['selecionar_edit'])) {
        $edit = $_POST['selecionar_edit'];
    } else {
        $edit = false;
    }

    if(isset($_POST['codigo_sala'])) {
        $codigo_sala = $_POST['codigo_sala'];
    } else {
        $codigo_sala = "Nenhuma Sala Selecionada";
    }

    if(isset($_POST['descricao_sala'])) {
        $descricao_sala = $_POST['descricao_sala'];
    } else {
        $descricao_sala = "Nenhuma Sala Selecionada";
    }

    if(isset($_POST['capacidade'])) {
        $capacidade = $_POST['capacidade'];
    } else {
        $capacidade = "Nenhuma Sala Selecionada";
    }

    if(isset($_POST['status_sala'])) {
        $status_sala = $_POST['status_sala'];
    } else {
        $status_sala = "Nenhuma Sala Selecionada";
    }

    
    function select_manutencao($verificador) {
        if($verificador == "Aberto" || $verificador == 1) {
            return 
            '<select name="status_sala" class="definir_status">'.
            '<option value="0">Aberto</option>'.
            '<option value="2">Manutenção</option>'.
            '<option value="1">Fechado</option>'.
            '</select>';
        } else if($verificador == "Manutenção" || $verificador == 2) {
            return
            '<select name="status_sala" class="definir_status">'.
            '<option value="2">Manutenção</option>'.
            '<option value="0">Aberto</option>'.
            '<option value="1">Fechado</option>'.
            '</select>';
        } else {
            return
            '<select name="status_sala" class="definir_status">'.
            '<option value="1">Fechado</option>'.
            '<option value="2">Manutenção</option>'.
            '<option value="0">Aberto</option>'.
            '</select>';
        }
    }

    function txt_manutencao($verificador) {
        if($verificador == 2 || $verificador == "Manutenção") {
            return '<input type="text" placeholder="Motivo da manutenção" id="motivo_manutencao">';
        } else {
            return '';
        }
    }
    
    if($_SESSION['nivel_funcionario'] == 1 && $edit == false) {
        echo   
            '<h3>Editar/Registrar Sala</h3>'.
            '<form action="../php/registrar_sala.php" method="post" class="registrar_sala">'.
            '<input type="text" name="codigo_sala" id="texto_codigo_sala" placeholder="Código da sala" min="3" class="tamanho_fixo">'.
            '<input type="text" name="descricao_sala" id="texto_descricao_sala" placeholder="Descrição da sala" class="tamanho_fixo">'.
            '<input type="number" name="quantidade_sala" id="numero_quantidade_sala" placeholder="Capacidade da sala" min=1 class="tamanho_fixo">'.
            '<input type="submit" value="Cadastrar" id="cadastrar_sala_btn" class="tamanho_fixo">'.
            '</form>';

    } else if($_SESSION['nivel_funcionario'] == 1 && $edit == true){
        $linha_sql = mysqli_query($ConexaoSQL, "SELECT id, status_sala FROM salas WHERE codigo = '$codigo_sala'");
        $linha_sql_assoc = mysqli_fetch_assoc($linha_sql);
        $linha_sql_id = $linha_sql_assoc['id'];

        switch ($status_sala) {
            case 0:
                $status_sala = "Aberto";
            break;
            
            case 2:
                $staus_sala = "Manutenção";
            break;

            case 1:
                $status_sala = "Fechado";
            break;
        }

        echo   
        '<h3>Editar/Registrar Sala</h3>'.
        '<form action="" method="post" class="registrar_sala">'.
        '<input type="text" name="codigo_sala" id="texto_codigo_sala" placeholder="'.$codigo_sala.'" min="3" class="tamanho_fixo" value='.$codigo_sala.'>'.
        '<input type="text" name="descricao_sala" id="texto_descricao_sala" placeholder="'.$descricao_sala.'" class="tamanho_fixo" value='.$descricao_sala.'>'.
        '<input type="number" name="quantidade_sala" id="numero_quantidade_sala" placeholder="'.$capacidade.'" min=1 class="tamanho_fixo" value='.$capacidade.'>'.
        select_manutencao($status_sala).
        txt_manutencao($status_sala).
        '<input type="hidden" name="linha_sql" value='.$linha_sql_id.'>'.
        '<ul>'.
            '<li><input type="button" value="Editar ✏️" id="editar_sala_btn" class="tamanho_fixo"></li>'.
            '<li><input type="button" value="Apagar ❌" id="apagar_sala_btn" class="tamanho_fixo"></li>'.
        '</ul>'.
        '</form>';

    } 


?>