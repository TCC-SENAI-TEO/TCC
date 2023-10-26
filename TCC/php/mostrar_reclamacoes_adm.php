<?php    
    include "../php/conectar_banco_de_dados.php";

    echo 
    '<tr>
        <th>Sala</th>
        <th>Data</th>
        <th>Reclamante</th>
        <th>Denuncia</th>
        <th>Urgencia</th>
        <th>Status</th>
    </tr>';

    $pendente;
    $em_andamento;
    $pendente;

    if(isset($_POST['pendente'])) { //Verifica se a variável esta vazia
        if($_POST['pendente'] > 0) {
            $pendente = 1;
            
        }
    }
    if(isset($_POST['em_andamento'])) { //Verifica se a variável esta vazia
        if($_POST['em_andamento'] > 0) {
            $em_andamento = 2;
            
        }
    }
    if(isset($_POST['concluido'])) { //Verifica se a variável esta vazia
        if($_POST['concluido'] > 0) {
            $concluido = 3;
            
        }
    }

    global $pendente; //Aumenta o escopo das variáveis
    global $em_andamento;
    global $concluido;

    if($pendente > 0 && $em_andamento > 0 && $concluido > 0) {
        $denuncias = mysqli_query($ConexaoSQL, "SELECT * from manutencao INNER JOIN funcionarios ON reclamante = funcionarios.email WHERE manutencao.status_denuncia = 1 OR manutencao.status_denuncia = 2 OR manutencao.status_denuncia = 3");

    } else if($pendente > 0 && $em_andamento > 0) {
        $denuncias = mysqli_query($ConexaoSQL, "SELECT * from manutencao INNER JOIN funcionarios ON reclamante = funcionarios.email WHERE manutencao.status_denuncia = 1 OR manutencao.status_denuncia = 2");

    } else if($pendente > 0 && $concluido > 0) {
        $denuncias = mysqli_query($ConexaoSQL, "SELECT * from manutencao INNER JOIN funcionarios ON reclamante = funcionarios.email WHERE manutencao.status_denuncia = 1 OR manutencao.status_denuncia = 3");

    } else if($em_andamento > 0 && $concluido > 0) {
        $denuncias = mysqli_query($ConexaoSQL, "SELECT * from manutencao INNER JOIN funcionarios ON reclamante = funcionarios.email WHERE manutencao.status_denuncia = 2 OR manutencao.status_denuncia = 3");

    } else if($pendente > 0) {
        $denuncias = mysqli_query($ConexaoSQL, "SELECT * from manutencao INNER JOIN funcionarios ON reclamante = funcionarios.email WHERE manutencao.status_denuncia = 1");

    } else if($em_andamento > 0) {
        $denuncias = mysqli_query($ConexaoSQL, "SELECT * from manutencao INNER JOIN funcionarios ON reclamante = funcionarios.email WHERE manutencao.status_denuncia = 2");

    } else if($concluido > 0) {
        $denuncias = mysqli_query($ConexaoSQL, "SELECT * from manutencao INNER JOIN funcionarios ON reclamante = funcionarios.email WHERE manutencao.status_denuncia = 3");

    } else {
        $denuncias = mysqli_query($ConexaoSQL, "SELECT * from manutencao INNER JOIN funcionarios ON reclamante = funcionarios.email WHERE manutencao.status_denuncia != 3");
    }

    

if(mysqli_num_rows($denuncias) > 0) { //Verifica quantas linhas retornaram do banco de dados

        for ($i = 0; $i < mysqli_num_rows($denuncias); $i++) { 
            $denuncias_fetch = mysqli_fetch_assoc($denuncias); //Transforma o objeto sql em um array associativo

            $codigo_sala = $denuncias_fetch['codigo_sala']; //Armazena o valor de acordo com a key do array associativo
            $nome_funcionario = $denuncias_fetch['nome'];
            $data_denuncia = $denuncias_fetch['data_denuncia']; 
            $texto_denuncia = $denuncias_fetch['denuncia']; 
            $status_denuncia = $denuncias_fetch['status_denuncia']; 
            $nivel_urgencia = $denuncias_fetch['nivel_urgencia']; 

            $id_sql = $denuncias_fetch['id_manutencao'];

            switch ($nivel_urgencia) { //Transforma o numero da variável em um texto

                case 1:
                    $nivel_urgencia = "Leve";
                    break;
                
                case 2:
                    $nivel_urgencia = "Mediano";
                    break;

                case 3:
                    $nivel_urgencia = "Grave";
                    break;
            }

            switch ($status_denuncia) { //Transforma o numero da variável em um texto

                case 1:
                    $status_denuncia = 'Pendente';
                    break;
                
                case 2:
                    $status_denuncia = 'Em Andamento';
                    break;

                case 3:
                    $status_denuncia = 'Concluido';
                    break;

            }
            
            
            echo 
            "<tr>".
            "<td data-cell='Sala' class='n_linha'>".$codigo_sala."</td>".
            "<td data-cell='Data'>".$data_denuncia.  "</td>".
            "<td data-cell='Relatante'>".$nome_funcionario."</td>".
            "<td data-cell='Denuncia'>".$texto_denuncia."</td>".
            "<td data-cell='Urgencia'>".$nivel_urgencia."</td>".
            "<td data-cell='Status' class='urgencia'>
            <select class='botao' id=".$id_sql.">".definir_status()."</select>
            </td>". 
            "</tr>";

            
        }
        
    }

    function definir_status() { //Retorna os status quando é chamada, de acordo com os status da denuncia
        global $status_denuncia;
        if($status_denuncia == 'Pendente') {
            return 
            "<option>".$status_denuncia."</option>".
            "<option>Em Andamento</option>".
            "<option>Concluido</option>";
    
        } else if($status_denuncia == 'Em Andamento') {
            return 
            "<option>".$status_denuncia."</option>".
            "<option>Pendente</option>".
            "<option>Concluido</option>";
    
        } else {
            return 
            "<option>".$status_denuncia."</option>".
            "<option>Pendente</option>".
            "<option>Em Andamento</option>";
        }
    }

    

?>