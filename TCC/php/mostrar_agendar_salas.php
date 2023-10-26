<?php

    if(session_status() == PHP_SESSION_NONE) {//Verifica se a sessão já foi iniciada
        session_start();//Inicia a sessão
    }

    include "../php/conectar_banco_de_dados.php";

    if(isset($_POST['data_escolhida'])) {//Verifica se tem algum valor dentro da variável, através do comando isset
        $data_escolhida = $_POST['data_escolhida'];

    } else {
        $data_escolhida = date("Y-m-d");
    }

    $codigo_sala = $_POST['codigo_sala'];//Recebe o valor do input com "name" do HTML
    

    $verificar_horario_disponivel = mysqli_query($ConexaoSQL, "SELECT * FROM agendamentos inner join salas on agendamentos.id_sala = salas.id WHERE inicio = '$data_escolhida' AND codigo = '$codigo_sala'");//Faz uma requisição ao banco de dados dos horários disponíveis
    $lista_horarios_fechados = [];//Array de armazenamento de horários não disponíveis.
    
    
    for ($i = 0; $i < mysqli_num_rows($verificar_horario_disponivel); $i++) {//Verifica quantas linhas retornaram do banco de dados
        $verificar_horario_disponivel_assoc = mysqli_fetch_assoc($verificar_horario_disponivel);//Transforma um objeto mysqli em um array associativo
        $horario_fechado = $verificar_horario_disponivel_assoc['id_horario'];//Vai pegar um dos valores do array associativo, que nessea caso é "id_horario"
        
        $lista_horarios_fechados[] = $horario_fechado;//O array string normal recebe o "$horairo_fechado"
    }

    echo 
    "<section>".
            "<ul>".
            "<label for='horarios[]'>7:00</label>".
                desabilitar_checkbox(1).
            "</ul>".
            "<ul>".
            "<label for='horarios[]'>7:50</label>".
                desabilitar_checkbox(2).
            "</ul>".
            "<ul>".
            "<label for='horarios[]'>8:40</label>".
                desabilitar_checkbox(3).
            "</ul>".
            "<ul>".
            "<label for='horarios[]'>9:30</label>".
                desabilitar_checkbox(4).
            "</ul>".
            "<ul>".
            "<label for='horarios[]'>10:40</label>".
                desabilitar_checkbox(5).
            "</ul>".
            "<ul>".
            "<label for='horarios[]'>11:30</label>".
                desabilitar_checkbox(6).
            "</ul>".
    "</section>";

    function desabilitar_checkbox($id_horario) {//Função que desabilita a checkbox de horários

        global $lista_horarios_fechados;//Aumenta o escopo da variável para ser usado nessa função
        

        switch($id_horario) {
            case 1:
                if(in_array(1, $lista_horarios_fechados)) {//Se o valor "1" estiver no array executará essa linha
                    return "<input type='checkbox' name='horarios[]' value='7:00' disabled>";
                } else {
                    return "<input type='checkbox' name='horarios[]' value='7:00'>";
                } 

            break;
            case 2:
                if(in_array(2, $lista_horarios_fechados)) {//Se o valor "2" estiver no array executará essa linha
                    return "<input type='checkbox' name='horarios[]' value='7:50' disabled>";
                } else {
                    return "<input type='checkbox' name='horarios[]' value='7:50'>";
                } 
            break;
            case 3:
                if(in_array(3, $lista_horarios_fechados)) {//Se o valor "3" estiver no array executará essa linha
                    return "<input type='checkbox' name='horarios[]' value='8:40' disabled>";
                } else {
                    return "<input type='checkbox' name='horarios[]' value='8:40'>";
                } 
            break;
            case 4:
                if(in_array(4, $lista_horarios_fechados)) {//Se o valor "4" estiver no array executará essa linha
                    return "<input type='checkbox' name='horarios[]' value='9:50' disabled>";
                } else {
                    return "<input type='checkbox' name='horarios[]' value='9:50'>";
                } 
            break;
            case 5:
                if(in_array(5, $lista_horarios_fechados)) {//Se o valor "5" estiver no array executará essa linha
                    return "<input type='checkbox' name='horarios[]' value='10:40' disabled>";
                } else {
                    return "<input type='checkbox' name='horarios[]' value='10:40'>";
                } 
            break;
            case 6:
                if(in_array(6, $lista_horarios_fechados)) {//Se o valor "6" estiver no array executará essa linha
                    return "<input type='checkbox' name='horarios[]' value='11:30' disabled>";
                } else {
                    return "<input type='checkbox' name='horarios[]' value='11:30'>";
                } 
            break;
        }
       
    }



?>
