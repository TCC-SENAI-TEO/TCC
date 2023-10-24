
<?php
    if(session_status() == PHP_SESSION_NONE) { //Verifica se a sessão já foi iniciada
        session_start(); //Inicia a sessão
    }

    echo 
    "<table>
    <tr>
        <th colspan='8'>Meus agendamentos</th>
    </tr>
    <tr>
        <th>Salas</th>
        <th>Dia</th>
        <th>7:00</th>
        <th>7:50</th>
        <th>8:40</thd>
        <th>9:50</th>
        <th>10:40</th>
        <th>11:30</th>
    </tr>";
    
    include "../php/conectar_banco_de_dados.php";
    
    $email = $_SESSION['email_funcionario'];

    if(isset($_POST['nome_usuario'])) { //Verifica se a variável esta vazia
        $nome_usuario_ajax = $_POST['nome_usuario'];
        if($nome_usuario_ajax != "Selecionar Funcionario") {
            $email = mysqli_query($ConexaoSQL, "SELECT email FROM funcionarios WHERE nome = '$nome_usuario_ajax'"); //Faz uma requisição ao banco de dados
            $email = mysqli_fetch_assoc($email); //Transforma o objeto sql em um array associativo
            $email = $email['email'];   //Armazena o valor da key 'email' retornada pelo array associativo
        }
    } 
    

    $data_atual = date("Y-m-d");
    if(isset($_POST['data'])) {
        $data_atual = $_POST['data'];
    } else {
        $data_atual = date("Y-m-d"); 
    }

    if(isset($_POST['sala'])) {
        $sala = $_POST['sala'];
            if($sala == "Selecionar Sala" || $sala == "" || $sala == null) { //Verifica se as varáveis estão vazias
                $sala = "";
            } else {
                $sala = $_POST['sala'];
            }
            
    } else {
        $sala = "";
    }

    global $sala; //Aumenta o escopo da variável


    if(isset($_POST['checkbox'])) {
        $checar_data = $_POST['checkbox'];
        if($checar_data == "checado") { //Caso a checkbox esteja checada ela fara uma requisição diferente ao banco de dados
            $quantidade_salas_agendadas = mysqli_query($ConexaoSQL, "SELECT * FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id WHERE email = '$email'"); 
        } else {
            if($sala != "") {
                
                $quantidade_salas_agendadas = mysqli_query($ConexaoSQL, "SELECT * FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id INNER JOIN salas on agendamentos.id_sala = salas.id WHERE email = '$email' and DATE(agendamentos.inicio) >= '$data_atual' AND salas.codigo = '$sala'"); 

            } else {
                $quantidade_salas_agendadas = mysqli_query($ConexaoSQL, "SELECT * FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id WHERE email = '$email' and DATE(agendamentos.inicio) >= '$data_atual'");
            }
        }
        
    } else {
        $quantidade_salas_agendadas = mysqli_query($ConexaoSQL, "SELECT * FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id WHERE email = '$email' and DATE(agendamentos.inicio) >= '$data_atual'"); 
    }

    
    global $quantidade_salas_agendadas; //Aumenta o escopo da variável
    $quantidade_salas_agendadas = mysqli_num_rows($quantidade_salas_agendadas); //Verifica quantas linhas retornaram da requisição ao banco de dados
    
    global $checar_data;
    if($checar_data == "checado") {
        $codigo_sala = mysqli_query($ConexaoSQL, "SELECT codigo, id_sala, inicio, id_horario FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id INNER JOIN salas on agendamentos.id_sala = salas.id WHERE email = '$email' ORDER BY inicio desc"); 
    } else {
        if($sala != "") {
            
            $codigo_sala = mysqli_query($ConexaoSQL, "SELECT codigo, id_sala, inicio, id_horario FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id INNER JOIN salas on agendamentos.id_sala = salas.id WHERE email = '$email' AND DATE(agendamentos.inicio) >= '$data_atual' AND salas.codigo = '$sala' ORDER BY inicio desc"); 
        } else {
            
            $codigo_sala = mysqli_query($ConexaoSQL, "SELECT codigo, id_sala, inicio, id_horario FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id INNER JOIN salas on agendamentos.id_sala = salas.id WHERE email = '$email' AND DATE(agendamentos.inicio) >= '$data_atual' ORDER BY inicio desc"); 
            
        }
    }
    
    $horarios_armazenados = []; //Cria um array para armazenar os horarios
    $codigo2 = '';
    $inicio2 = '';
    
    
    for($i = 1; $i <= $quantidade_salas_agendadas; $i++) {  
        
        $codigo_sala_assoc = mysqli_fetch_assoc($codigo_sala); //Transforma o objeto sql em um array associativo
        $codigo1 = $codigo_sala_assoc['codigo'];
        $inicio1 = $codigo_sala_assoc['inicio'];
        
        $horario = mysqli_query($ConexaoSQL, "SELECT codigo, id_sala, inicio, id_horario FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id INNER JOIN salas on agendamentos.id_sala = salas.id WHERE email = '$email' AND inicio = '$inicio1' ORDER BY inicio");
        $num = mysqli_num_rows($horario);

        $date = $inicio1;
        $dateObj = date_create_from_format('Y-m-d', $date);
        $formattedDate = $dateObj->format('d-m-Y');

        if($codigo1 != $codigo2 || $inicio1 != $inicio2) {

            for($l = 0; $l < $num ; $l++) {     
                $horario_assoc = mysqli_fetch_assoc($horario);
                $horarios_armazenados[] = $horario_assoc['id_horario']; //armazena o horario presente nas salas
            }
            echo 
            "<tr>
            <td>".$codigo1."</td>
            <td>".$formattedDate."</td>".
            "<td>".marcar_horario(1)."</td>".
            "<td>".marcar_horario(2)."</td>".
            "<td>".marcar_horario(3)."</td>".
            "<td>".marcar_horario(4)."</td>".
            "<td>".marcar_horario(5)."</td>".
            "<td>".marcar_horario(6)."</td>".
            "</tr>";

            
        }
        $horarios_armazenados = array(); //Cria um array que armazena os horarios 
        $codigo2 = $codigo1; //Recebe o valor anterior  para fazer a comparação com o valor atual
        $inicio2 = $inicio1;//Recebe o valor anterior  para fazer a comparação com o valor atual

        
    }

    function marcar_horario($num_horario) { //Função de marcar o horario
        global $horarios_armazenados; //Aumenta o escopo da variável 
        if(empty($horarios_armazenados)) { //Verifica se a varável esta vazia
            return "";
        } else {
            foreach($horarios_armazenados as $horarios_verificados) {  //Percorre toda a variável $horarios_armazenados e toda vez que houver um horario verificado e um numero_horario correspondente retornara um X, marcando o horario
                if($num_horario == 1 && $horarios_verificados == 1) {
                    return "X";
                } else if($num_horario == 2 && $horarios_verificados == 2) {
                    return "X";
                } else if($num_horario == 3 && $horarios_verificados == 3) {
                    return "X";
                } else if($num_horario == 4 && $horarios_verificados == 4) {
                    return "X";
                } else if($num_horario == 5 && $horarios_verificados == 5) {
                    return "X";
                } else if($num_horario == 6 && $horarios_verificados == 6) {
                    return "X";
                }
                
            }
        }
    }
    echo "<table>"
    ?>