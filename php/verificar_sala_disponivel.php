<?php
    include '../php/conectar_banco_de_dados.php';
    
    if(session_status() == PHP_SESSION_NONE) {  //Verifica se a sessão ja foi iniciada anteriormente
        session_start(); //Inicia a session
    }

    if(isset($_POST['horario'])) {  //Verifica se a variável possui algum valor 
        $horario = $_POST['horario']; //Caso possuir sera armazenada nesta variável
    } else {
        $horario = 1; //Caso nao tenha nenhum valor, recebera 1
    }
    global $horario; //Aumenta o escopo da variável, transformando-a em uma global

    if(isset($_POST['data'])) {
        $data = $_POST['data'];
    } else {
        $data = date('Y-m-d'); //Cria um modelo de data especifico no estilo de ano-mes-dia, recebendo a data atual
    }
    global $data;

    $dia_data = DateTime::createFromFormat("Y-m-d", $data); //Transforma a variável $data
    $dia_data_format = $dia_data->format("d"); //Formata a data e armazena apenas o dia dela
    
    $date_inicial = date('Y-m-d');  //Armazena a data atual
    $date_inicial = $dia_data->format("Y-m-d"); //Formata a data
    
    switch($horario) {  //Switch usado para armazenar informações especificas na variável $horario de acordo com o valor passado para ela
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
    
    $quantidade_salas = mysqli_query($ConexaoSQL, "SELECT * from salas");  //Faz o query no banco de dados
    $quantidade_salas_numero = mysqli_num_rows($quantidade_salas); //Pega o numero de linhas afetadas pelo query

    for ($i=1; $i <= $quantidade_salas_numero; $i++) {  //Irá rodar o codigo baseado no numero de salas existentes no banco de dados 

        $fetch_id = mysqli_fetch_assoc($quantidade_salas); 
        $fetch_id_assoc = $fetch_id["id"];

        $codigo = mysqli_query($ConexaoSQL, "SELECT codigo FROM salas WHERE id = '$fetch_id_assoc'"); //Faz uma requisição ao banco de dados
        $codigo = mysqli_fetch_array($codigo);  //Transforma o objeto sql em um array associativo mas tambem podendo acessar através de numeros comuns do array
        $codigo = $codigo['codigo']; //Armazena o valor da key codigo do array
        
        $descricao = mysqli_query($ConexaoSQL, "SELECT descricao FROM salas WHERE id = '$fetch_id_assoc'");
        $descricao = mysqli_fetch_array($descricao);
        $descricao = $descricao['descricao']; 
        
        $capacidade = mysqli_query($ConexaoSQL, "SELECT capacidade FROM salas WHERE id = '$fetch_id_assoc'");
        $capacidade = mysqli_fetch_array($capacidade);
        $capacidade = $capacidade['capacidade'];

        $status_sala = mysqli_query($ConexaoSQL, "SELECT status_sala FROM salas WHERE id = '$fetch_id_assoc'");
        $status_sala = mysqli_fetch_array($status_sala);
        $status_sala = $status_sala['status_sala'];

        $motivo_manutencao = mysqli_query($ConexaoSQL, "SELECT motivo_manutencao FROM salas WHERE id = '$fetch_id_assoc'");
        $motivo_manutencao = mysqli_fetch_array($motivo_manutencao);
        $motivo_manutencao = $motivo_manutencao['motivo_manutencao'];

        $salas_disponiveis = mysqli_query($ConexaoSQL, "SELECT * FROM agendamentos inner join salas on id_sala = salas.id WHERE id_horario = '$horario' and inicio = '$data' and id_sala = '$fetch_id_assoc'");

        $horario_incio = mysqli_query($ConexaoSQL, "SELECT horario.inicio FROM agendamentos inner join horario on agendamentos.id_horario = horario.id WHERE id_horario = '$horario' and agendamentos.inicio = '$data' and id_sala = '$fetch_id_assoc'");
        
        $horario_incio_assoc = mysqli_fetch_array($horario_incio);
        @$horario_inicio_result = $horario_incio_assoc['inicio'];

        $horario_termino = mysqli_query($ConexaoSQL, "SELECT horario.fim FROM agendamentos inner join horario on agendamentos.id_horario = horario.id WHERE id_horario = '$horario' and agendamentos.inicio = '$data' and id_sala = '$fetch_id_assoc'");
        $horario_termino_assoc = mysqli_fetch_array($horario_termino);
        @$horario_termino_result = $horario_termino_assoc['fim'];

        $professor = mysqli_query($ConexaoSQL, "SELECT * FROM agendamentos inner join funcionarios on agendamentos.id_funcionarios = funcionarios.id WHERE id_horario = '$horario' and agendamentos.inicio = '$data' and id_sala = '$fetch_id_assoc'");
        $professor_assoc = mysqli_fetch_array($professor);
        @$professor_result = $professor_assoc['nome'];

        if($salas_disponiveis = mysqli_num_rows($salas_disponiveis) > 0) { //caso haja salas disponiveis, ira imprimir as salas
            echo 
            "<div class='sala salas_fechado flex_div' id='$codigo' tag='$descricao' cap='$capacidade' status='$status_sala'>".
            "<div class='container-1'>".
            "<ul>".
                "<li><h4 class='tag'>Sala ".$codigo." - ".$descricao."</h4></li>".
                "<li><form action='../php/tratamento_de_dados_sala.php' method='post'>".
                "<input type='hidden' name='codigo_sala' value='$codigo'>".
                "<input type='hidden' name='descricao_sala' value='$descricao'>".
                "<input type='hidden' name='identificar_reporte' value='enviar_reporte'>".
                "<input type='submit' value='Reclamar'>".
                "</form>".
            "</li>".
            "</ul>".
                "<form action='../php/tratamento_de_dados_sala.php' method='post'>".
                    "<p class='tag'><strong>Responsável:</strong> ".$professor_result."</p>".
                    "<p class='tag'><strong>Inicio:</strong>: ".$horario_inicio_result."</p>".
                    "<p class='tag'><strong>Termino</strong>: ".$horario_termino_result."</p>".
                    "<p class='tag'><strong>Quantidade</strong>: ".$capacidade."</p>".
                    "<input type='hidden' name='codigo_sala' value='$codigo'>".
                    "<input type='hidden' name='descricao_sala' value='$descricao'>".
                    "<input type='submit' value='Agendar' class='botao'>".
                "</form>".
            "</div>".
            "<section>";

        } else {
            if($status_sala == 2) { //Caso o status da sala seja 2 ira imprimir como uma sala interditada
                echo 
                    "<div class='sala salas_interditado flex_div' id='$codigo' tag='$descricao' cap='$capacidade' status='$status_sala'>".
                    "<div class='container-1'>".
                    "<ul>".
                        "<li><h4 class='tag'>Sala ".$codigo." - ".$descricao."</h4></li>".
                        "<li><form action='../php/tratamento_de_dados_sala.php' method='post'>".
                        "<input type='hidden' name='codigo_sala' value='$codigo'>".
                        "<input type='hidden' name='descricao_sala' value='$descricao'>".
                        "<input type='hidden' name='identificar_reporte' value='enviar_reporte'>".
                        "<input type='submit' value='Reclamar' disabled>".
                        "</form>".
                    "</li>".
                    "</ul>".
                        "<form action='../php/tratamento_de_dados_sala.php' method='post'>".
                            "<p class='tag'><strong>Responsável:</strong> "."Interditado"."</p>".
                            "<p class='tag'><strong>Inicio:</strong>: "."Interditado"."</p>".
                            "<p class='tag'><strong>Termino</strong>: "."interditado"."</p>".
                            "<p class='tag'><strong>Quantidade</strong>: ".$capacidade."</p>".
                            "<input type='hidden' name='codigo_sala' value='$codigo'>".
                            "<input type='hidden' name='descricao_sala' value='$descricao'>".
                            "<p class='tag'><strong>Motivo</strong>: ".$motivo_manutencao."</p>".
                            "<input type='submit' value='Agendar' class='botao' disabled>".
                        "</form>".
                    "</div>".
                    "<section>";
            } else if($status_sala == 0) {  //Caso o status da sala seja 0 ela será imprimida como uma sala livre
                echo 

                "<div class='sala salas_disponivel flex_div' id='$codigo' tag='$descricao' cap='$capacidade' status='$status_sala'>".
                    "<div class='container-1'>".
                    "<ul>".
                        "<li><h4 class='tag'>Sala ".$codigo." - ".$descricao."</h4></li>".
                        "<li><form action='../php/tratamento_de_dados_sala.php' method='post'>".
                        "<input type='hidden' name='codigo_sala' value='$codigo'>".
                        "<input type='hidden' name='descricao_sala' value='$descricao'>".
                        "<input type='hidden' name='identificar_reporte' value='enviar_reporte'>".
                        "<input type='submit' value='Reclamar'>".
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
                    "</div>".
                    "<section>";

                } else {
                    echo 
                    "<div class='sala salas_fechado flex_div' id='$codigo' tag='$descricao' cap='$capacidade' status='$status_sala'>".
                    "<div class='container-1'>".
                    "<ul>".
                        "<li><h4 class='tag'>Sala ".$codigo." - ".$descricao."</h4></li>".
                        "<li><form action='../php/tratamento_de_dados_sala.php' method='post'>".
                        "<input type='hidden' name='codigo_sala' value='$codigo'>".
                        "<input type='hidden' name='descricao_sala' value='$descricao'>".
                        "<input type='hidden' name='identificar_reporte' value='enviar_reporte'>".
                        "<input type='submit' value='Reclamar' disabled>".
                        "</form>".
                    "</li>".
                    "</ul>".
                        "<form action='../php/tratamento_de_dados_sala.php' method='post'>".
                            "<p class='tag'><strong>Responsável:</strong> "."Não há responsáveis"."</p>".
                            "<p class='tag'><strong>Inicio:</strong>: "."Fechado"."</p>".
                            "<p class='tag'><strong>Termino</strong>: "."Fechado"."</p>".
                            "<p class='tag'><strong>Quantidade</strong>: ".$capacidade."</p>".
                            "<input type='hidden' name='codigo_sala' value='$codigo'>".
                            "<input type='hidden' name='descricao_sala' value='$descricao'>".
                            "<input type='submit' value='Agendar' class='botao' disabled>".
                        "</form>".
                    "</div>".
                    "<section>";
                    
            }
        }

    
        for ($l = 1; $l <= 9; $l++) { //desenha as datas
            $verificar = false;
            $datas_da_semana = $dia_data_format + $l;

            $data_definitiva = new DateTime(); // pega a data atual
            $ano = $data_definitiva->format('Y'); // pega o ano atual
            $mes = $data_definitiva->format('m'); // pega o mês atual
            $dia = $datas_da_semana; // define o novo dia
            $data_definitiva->setDate($ano, $mes, $dia); // altera apenas o dia da data atual
            $data_true = $data_definitiva->format('Y-m-d');
            if($datas_da_semana > 31) {
                $datas_da_semana = $datas_da_semana - 31;
            }
            

            $marcar_datas_ocupadas = mysqli_query($ConexaoSQL, "SELECT agendamentos.inicio FROM agendamentos inner join horario on agendamentos.id_horario = horario.id WHERE agendamentos.inicio = '$data_true' and agendamentos.id_horario = '$horario' and agendamentos.id_sala = '$i'"); 
            
            for ($j=0; $j < mysqli_num_rows($marcar_datas_ocupadas); $j++) { 
                
                $marcar_datas_ocupadas_assoc = mysqli_fetch_assoc($marcar_datas_ocupadas); //Verifica se há datas já registradas
                
                if(@$marcar_datas_ocupadas_assoc['inicio'] == $data_definitiva->format('Y-m-d')) {
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