<?php

    include '../php/conectar_banco_de_dados.php';

    if(session_status() == PHP_SESSION_NONE) {//Verifica se a sessão já foi iniciada
        session_start();//Inicia a sessão
    }
    
    if(isset($_POST['selecionar_edit'])) {//Verifica se tem algum valor dentro da variável, através do comando isset()
        $edit = $_POST['selecionar_edit'];//Recebe o valor do input "name" do HMTL 
    } else {
        $edit = false;//Caso não haja valor na variável, recebe "false"
    }

    if(isset($_POST['codigo_sala'])) {//Verifica se tem algum valor dentro da variável, através do comando isset()
        $codigo_sala = $_POST['codigo_sala'];//Recebe o valor do input "name" do HMTL 
    } else {
        $codigo_sala = "Nenhuma sala selecionada";//Caso não haja valor na variável, recebe "Nenhuma sala selecionada"
    }

    if(isset($_POST['descricao_sala'])) {//Verifica se tem algum valor dentro da variável, através do comando isset()
        $descricao_sala = $_POST['descricao_sala'];//Recebe o valor do input "name" do HMTL 
    } else {
        $descricao_sala = "Nenhuma sala selecionada";//Caso não haja valor na variável, recebe "Nenhuma sala selecionada"
    }

    if(isset($_POST['capacidade'])) {//Verifica se tem algum valor dentro da variável, através do comando isset()
        $capacidade = $_POST['capacidade'];//Recebe o valor do input "name" do HMTL 
    } else {
        $capacidade = "Nenhuma sala selecionada";//Caso não haja valor na variável, recebe "Nenhuma sala selecionada"
    }

    if(isset($_POST['status_sala'])) {//Verifica se tem algum valor dentro da variável, através do comando isset()
        $status_sala = $_POST['status_sala'];//Recebe o valor do input "name" do HMTL 
    } else {
        $status_sala = "Nenhuma sala selecionada";//Caso não haja valor na variável, recebe "fNenhuma sala selecionada"
    }

    
    function select_manutencao($verificador) {//Função para colocar a ssala em manutenção
        if($verificador == "Aberto" || $verificador == 1) {//Coloca a sala em status "disponível"
            return 
            '<select name="status_sala" class="definir_status">'.
            '<option value="0">Aberto</option>'.
            '<option value="2">Manutenção</option>'.
            '<option value="1">Fechado</option>'.
            '</select>';
        } else if($verificador == "Manutenção" || $verificador == 2) {//Coloca a sala em status "interditado"
            return
            '<select name="status_sala" class="definir_status">'.
            '<option value="2">Manutenção</option>'.
            '<option value="0">Aberto</option>'.
            '<option value="1">Fechado</option>'.
            '</select>';
        } else {//Coloca a sala em status "ocupado"
            return
            '<select name="status_sala" class="definir_status">'.
            '<option value="1">Fechado</option>'.
            '<option value="2">Manutenção</option>'.
            '<option value="0">Aberto</option>'.
            '</select>';
        }
    }

    function txt_manutencao($verificador) {
        if($verificador == "Manutenção" || $verificador == 2) {//Verifica o status da sala
            return '<input type="text" placeholder="Motivo da manutenção" id="motivo_manutencao">';//Retorna um input para justificar a manuntenção
        } else {
            return '';//Se não estiver em manutenção, não retorna nada
        }
    }
    
    if($_SESSION['nivel_funcionario'] == 1 && $edit == false) {//Verifica o nível do funcionário, e a variável de 'edit'
        echo   
            '<h3>Editar/Registrar Sala</h3>'.
            '<form action="../php/registrar_sala.php" method="post" class="registrar_sala">'.
            '<input type="text" name="codigo_sala" id="texto_codigo_sala" placeholder="Código da sala" min="3" class="tamanho_fixo">'.
            '<input type="text" name="descricao_sala" id="texto_descricao_sala" placeholder="Descrição da sala" class="tamanho_fixo">'.
            '<input type="number" name="quantidade_sala" id="numero_quantidade_sala" placeholder="Capacidade da sala" min=1 class="tamanho_fixo">'.
            '<input type="submit" value="Cadastrar" id="cadastrar_sala_btn" class="tamanho_fixo">'.
            '</form>';

    } else if($_SESSION['nivel_funcionario'] == 1 && $edit == true){//Verifica o nível do funcionário, e a variável de 'edit', se for verdadeira, gera botões para edição
        $linha_sql = mysqli_query($ConexaoSQL, "SELECT id, status_sala FROM salas WHERE codigo = '$codigo_sala'");//Faz uma requisição ao banco de dados em busca do códigos de sala
        $linha_sql_assoc = mysqli_fetch_assoc($linha_sql);//Transforma um objeto mysqli em um array associativo
        $linha_sql_id = $linha_sql_assoc['id'];//A variável '$linha_sql_id' recebe o valor da key id do array associativo gerado pelo '$linha_sql_assoc'

        switch ($status_sala) {//Ele trnasforma os valores "0", "1", "2" para "Aberto", "Fechado", "Manutenção"
            case 0:
                $status_sala = "Aberto";
            break;

            case 1:
                $status_sala = "Fechado";
            break;
            
            case 2:
                $staus_sala = "Manutenção";
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
        '<div class="edit_btn">'.
            '<input type="button" value="Editar ✏️" id="editar_sala_btn" class="tamanho_fixo">'.
            '<input type="button" value="Apagar ❌" id="apagar_sala_btn" class="tamanho_fixo">'.
        '</div>'.
        '</form>';

    } 


?>