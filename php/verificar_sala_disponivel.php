<?php
    include '../php/conectar_banco_de_dados.php';
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_POST['horario'])) {
        $horario = $_POST['horario'];
    } else {
        $horario = 1;
    }
    global $horario;

    if(isset($_POST['data'])) {
        $data = $_POST['data'];
    } else {
        $data = date('Y-m-d');
    }
    global $data;
    $dia_data = DateTime::createFromFormat("Y-m-d", $data);
    $dia_data_format = $dia_data->format("d");
    

    $date_inicial = date('Y-m-d');
    $date_inicial = $dia_data->format("Y-m-d");
    
    switch($horario) {
        case '7:00':$horario = 1;
        break;
        case '7:50':$horario = 2;
        break;
        case '8:40':$horario = 3;
        break;
        case '9:50':$horario = 4;
        break;
        case '10:40':$horario = 5;
        break;
        case '11:30':$horario = 6;
        break;
    }
    
    $quantidade_salas = mysqli_query($ConexaoSQL, "SELECT * from salas");   //faz o query no banco de dados
    $quantidade_salas = mysqli_num_rows($quantidade_salas); //pega o numero de linhas afetadas pelo query

    for ($i=1; $i <= $quantidade_salas; $i++) { 

        $codigo = mysqli_query($ConexaoSQL, "SELECT codigo FROM salas WHERE id = '$i'");
        $codigo = mysqli_fetch_array($codigo);
        $codigo = $codigo['codigo']; //usar esse
        
        $descricao = mysqli_query($ConexaoSQL, "SELECT descricao FROM salas WHERE id = '$i'");
        $descricao = mysqli_fetch_array($descricao);
        $descricao = $descricao['descricao']; //usar esse
        
        $capacidade = mysqli_query($ConexaoSQL, "SELECT capacidade FROM salas WHERE id = '$i'");
        $capacidade = mysqli_fetch_array($capacidade);
        $capacidade = $capacidade['capacidade']; //usar esse

        $salas_disponiveis = mysqli_query($ConexaoSQL, "SELECT * FROM agendamentos WHERE id_horario = '$horario' and inicio = '$data' and id_sala = '$i'");
        $horario_incio = mysqli_query($ConexaoSQL, "SELECT horario.inicio FROM agendamentos inner join horario on agendamentos.id_horario = horario.id WHERE id_horario = '$horario' and agendamentos.inicio = '$data' and id_sala = '$i'");
        
        $horario_incio_assoc = mysqli_fetch_array($horario_incio);
        @$horario_inicio_result = $horario_incio_assoc['inicio'];

        $horario_termino = mysqli_query($ConexaoSQL, "SELECT horario.fim FROM agendamentos inner join horario on agendamentos.id_horario = horario.id WHERE id_horario = '$horario' and agendamentos.inicio = '$data' and id_sala = '$i'");
        $horario_termino_assoc = mysqli_fetch_array($horario_termino);
        @$horario_termino_result = $horario_termino_assoc['fim'];

        $professor = mysqli_query($ConexaoSQL, "SELECT * FROM agendamentos inner join funcionarios on agendamentos.id_funcionarios = funcionarios.id WHERE id_horario = '$horario' and agendamentos.inicio = '$data' and id_sala = '$i'");
        $professor_assoc = mysqli_fetch_array($professor);
        @$professor_result = $professor_assoc['nome'];

        if($salas_disponiveis = mysqli_num_rows($salas_disponiveis) > 0) {
            echo 
                "<div class='salas salas_fechado flex_div'>".
                    "<form action='../php/tratamento_de_dados_sala.php' method='post'>".
                        "<ul class='report'>".
                            "<li><h4 class='tag'>Sala ".$codigo." - ".$descricao."</h4></li>".
                            "<li><button class='reportar'>Reportar</button></li>".
                        "</ul>".
                        "<p class='tag'><strong>Responsável:</strong> ".$professor_result."</p>".
                        "<p class='tag'><strong>Inicio:</strong> ".$horario_inicio_result."</p>".
                        "<p class='tag'><strong>Termino</strong> ".$horario_termino_result."</p>".
                        "<p class='tag'><strong>Quantidade</strong>: ".$capacidade."</p>".
                        "<input type='hidden' name='codigo_sala' value='$codigo'>".
                        "<input type='hidden' name='descricao_sala' value='$descricao'>".
                        "<input type='submit' value='Agendar' class='botao'>".
                    "</form>".
                "<section>";        
        } else {
            echo 
                "<div class='salas salas_disponivel flex_div'>".
                "<ul>".
                    "<li><h4 class='tag'>Sala ".$codigo." - ".$descricao."</h4></li>".
                    "<li><form action='../php/tratamento_de_dados_sala.php' method='post'>".
                    "<input type='hidden' name='codigo_sala' value='$codigo'>".
                    "<input type='hidden' name='descricao_sala' value='$descricao'>".
                    "<input type='hidden' name='identificar_reporte' value='enviar_reporte'>".
                    "<input type='submit' value='Reclamar' >".
                    "</form>".
                "</li>".
                "</ul>".
                    "<form action='../php/tratamento_de_dados_sala.php' method='post'>".
                        "<p class='tag'><strong>Responsável:</strong> Livre </p>".
                        "<p class='tag'><strong>Inicio:</strong>: Livre</p>".
                        "<p class='tag'><strong>Termino</strong>: Livre</p>".
                        "<p class='tag'><strong>Quantidade</strong>: ".$capacidade."</p>".
                        "<input type='hidden' name='codigo_sala' value='$codigo'>".
                        "<input type='hidden' name='descricao_sala' value='$descricao'>".
                        "<input type='submit' value='Agendar' class='botao'>".
                    "</form>".
                "<section>";
        }

    
                    for ($l = 1; $l <= 9; $l++) { //desenha as datas
                        $verificar = false;
                        $datas_da_semana = $dia_data_format + $l;

                        $data_teste = new DateTime(); // pega a data atual
                        $ano = $data_teste->format('Y'); // pega o ano atual
                        $mes = $data_teste->format('m'); // pega o mês atual
                        $dia = $datas_da_semana; // define o novo dia
                        $data_teste->setDate($ano, $mes, $dia); // altera apenas o dia da data atual
                        $data_true = $data_teste->format('Y-m-d');
                        if($datas_da_semana > 31) {
                            $datas_da_semana = $datas_da_semana - 31;
                        }
                        

                        $marcar_datas_ocupadas = mysqli_query($ConexaoSQL, "SELECT agendamentos.inicio FROM agendamentos inner join horario on agendamentos.id_horario = horario.id WHERE agendamentos.inicio = '$data_true' and agendamentos.id_horario = '$horario' and agendamentos.id_sala = '$i'"); 
                        
                        for ($j=0; $j < mysqli_num_rows($marcar_datas_ocupadas); $j++) { 
                            
                            $marcar_datas_ocupadas_assoc = mysqli_fetch_assoc($marcar_datas_ocupadas);
                            
                            if(@$marcar_datas_ocupadas_assoc['inicio'] == $data_teste->format('Y-m-d')) {
                                echo "<div class='data_indisponivel'>".$datas_da_semana."</div>";
                                $verificar = true;
                                
                            }   

                        }
                        if($verificar != true) {
                            echo "<div class='data_disponivel'>".$datas_da_semana."</div>";
                        }
                        
                    }
                    echo "</section>".
                    "</div>";   
                    
                                    
    }    
    

?>
