$(document).ready(function () {
    $.get("../php/mostrar_reclamacoes_adm", function(data) {
        $("#tabela_info").html(data);
    }) 
    

});

setTimeout(function () {
    $(".botao").change(function (e) { 
        var enviar_linha_sql = this.id
        var enviar_status = this.value
        
        switch (enviar_status) {
            case 'Em Andamento':
                enviar_status = 2
                break;
                
                case 'Pendente':
                enviar_status = 1
                break;
                
                case 'Concluido':
                    enviar_status = 3
                    break;
                }
                
                $.ajax({
                    type: "post",
                    url: "../php/update_reclamacoes.php",
                    data: {linha_sql: enviar_linha_sql, status: enviar_status},
                    success: function () {
                        console.log("deu certo")
                        location.href = "../php/update_reclamacoes";
                    },
                    error: function(error) {
                        console.log(error)
                    }
                }).done(function(e) {
            $("#tabela_info").html(e);
        });
    });
}, 100)

