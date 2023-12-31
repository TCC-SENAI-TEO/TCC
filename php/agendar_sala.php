<?php
    include '../php/conectar_banco_de_dados.php';
    
    session_start();//Inicia sessão

    $data = new DateTime(); // Pega o momento atual
    $data = $data->format('Y-m-d'); // Exibe no formato desejado

    $horarios = $_POST['horarios'];//Recebe o valor do input "name" do HTML 
    $professor = mysqli_real_escape_string($ConexaoSQL, $_SESSION['email_funcionario']);//O comando "mysqli_real_escape_string()" verifica se o valor enviado é válido, caso contrário ele deleta
    $sala = mysqli_real_escape_string($ConexaoSQL, $_SESSION['codigo_sala']);
    $data_agendamento = mysqli_real_escape_string($ConexaoSQL, $data);
    $data_inicio = mysqli_real_escape_string($ConexaoSQL, $_POST['data_inicio']);

    if($professor == "" || $horarios == "" || $sala == "" || $data_agendamento == "" || $data_inicio == "") {//Verifica se alguma das variáveis está vazia
        $_SESSION['error_agendar_sala'] = 1;//A variável recebe 1
    } else {

        foreach($horarios as $valor_horario) {//Transforma cada valor do array na variável "$valor_horario"
            
            $horarios = mysqli_query($ConexaoSQL, "SELECT id FROM horario WHERE inicio = '$valor_horario'");//Faz uma requisição no banco de dados em busca da coluna inicio = '$valor_horario'
            $horarios_assoc = mysqli_fetch_assoc($horarios);//Transforma um objeto mysqli em um array associativo
            $horarios_result = $horarios_assoc['id'];//A variável '$horarios_result' recebe o valor da key id do array associativo gerado pelo '$horarios_assoc'
            
            $professor_sql = mysqli_query($ConexaoSQL, "SELECT id FROM funcionarios WHERE email = '$professor'");
            $professor_assoc = mysqli_fetch_assoc($professor_sql);
            $professor_result = $professor_assoc['id'];
            
            $sala_sql = mysqli_query($ConexaoSQL, "SELECT id FROM salas WHERE codigo = '$sala'");
            $sala_assoc = mysqli_fetch_assoc($sala_sql);
            $sala_result = $sala_assoc['id'];
            
            $Enviando_dados = mysqli_query($ConexaoSQL, "INSERT INTO agendamentos(id_funcionarios, id_horario, id_sala, data_agendamento, inicio) VALUES ('$professor_result','$horarios_result','$sala_result','$data_agendamento', '$data_inicio')");//Armeza os dados enviados para os bancos de dados
        }
        $_SESSION['error_agendar_sala'] = 2;//A variável recebe 2
    }

    header(("location: ../html/agendamento.php"));
    
?>