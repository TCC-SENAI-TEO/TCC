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
        @$horario_inico_result = $horario_incio_assoc['inicio'];

        $horario_termino = mysqli_query($ConexaoSQL, "SELECT horario.fim FROM agendamentos inner join horario on agendamentos.id_horario = horario.id WHERE id_horario = '$horario' and agendamentos.inicio = '$data' and id_sala = '$i'");
        $horario_termino_assoc = mysqli_fetch_array($horario_termino);
        @$horario_termino_result = $horario_termino_assoc['fim'];

        $professor = mysqli_query($ConexaoSQL, "SELECT * FROM agendamentos inner join funcionarios on agendamentos.id_funcionarios = funcionarios.id WHERE id_horario = '$horario' and agendamentos.inicio = '$data' and id_sala = '$i'");
        $professor_assoc = mysqli_fetch_array($professor);
        @$professor_result = $professor_assoc['nome'];

        if($salas_disponiveis = mysqli_num_rows($salas_disponiveis) > 0) {
            echo 
                "<div class='salas salas_fechado'>".
                    "<form /action='../php/agendar_sala_tratamento.php' class='agendamentos' method='post'>".
                        "<h4 class='tag'>Sala ".$codigo." - ".$descricao."</h4>".
                        "<p class='tag'><strong>Responsável:</strong> ".$professor_result."</p>".
                        "<p class='tag'><strong>Inicio:</strong> ".$horario_inico_result."</p>".
                        "<p class='tag'><strong>Termino</strong> ".$horario_termino_result."</p>".
                        "<p class='tag'><strong>Quantidade</strong>: ".$capacidade."</p>".
                        "<input type='hidden' name='codigo_sala' value='$codigo'>".
                        "<input type='hidden' name='descricao_sala' value='$descricao'>".
                        "<input type='submit' value='Agendar' class='botao'>".
                    "</form>".
                "</div>";         
        } else {
            echo 
                "<div class='salas salas_disponivel'>".
                    "<form action='../php/agendar_sala_tratamento.php' class='agendamentos' method='post'>".
                        "<h4 class='tag'>Sala ".$codigo." - ".$descricao."</h4>".
                        "<p class='tag'><strong>Responsável:</strong> Livre </p>".
                        "<p class='tag'><strong>Inicio:</strong>: Livre</p>".
                        "<p class='tag'><strong>Termino</strong>: Livre</p>".
                        "<p class='tag'><strong>Quantidade</strong>: ".$capacidade."</p>".
                        "<input type='hidden' name='codigo_sala' value='$codigo'>".
                        "<input type='hidden' name='descricao_sala' value='$descricao'>".
                        "<input type='submit' value='Agendar' class='botao'>".
                    "</form>".
                "</div>";   
        }            
                                    
    }    
    

?>