function fazer_botao_funcionar() {
    $(document).on('change', '.botao', function (e) { 

        var Pendente;
        var Em_Andamento;
        var Concluido;

        if($("#Pendente").is(":checked")) {
            Pendente = 1
        } else {
            Pendente = 0
        }

        if($("#Em_Andamento").is(":checked")) {
            Em_Andamento = 1
        } else {
            Em_Andamento = 0
        }

        if($("#Concluido").is(":checked")) {
            Concluido = 1
        } else {
            Concluido = 0
        }
        
    var enviar_linha_sql = this.id
    var enviar_status = this.value

    switch(enviar_status) {
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
                
            },
            error: function(error) {
                
            }
        }).done(function() {
            $.ajax({
                type: "post",
                url: "../php/mostrar_reclamacoes_adm.php",
                data: {pendente: Pendente, em_andamento: Em_Andamento, concluido: Concluido},
                success: function (response) {
    
                }, error: function (param) { 
                    
                }
            }).done(function (e) {
                $("#tabela_info").html(e);
                fazer_botao_funcionar()
            });
        });
    });

}

$(document).ready(function () {
    $.get("../php/mostrar_reclamacoes_adm", function(data) {
        $("#tabela_info").html(data);
        fazer_botao_funcionar()
    }) 
    
    
});

    $("#Pendente, #Em_Andamento, #Concluido").click(() => {
        var Pendente;
        var Em_Andamento;
        var Concluido;

        if($("#Pendente").is(":checked")) {
            Pendente = 1
        } else {
            Pendente = 0
        }

        if($("#Em_Andamento").is(":checked")) {
            Em_Andamento = 1
        } else {
            Em_Andamento = 0
        }

        if($("#Concluido").is(":checked")) {
            Concluido = 1
        } else {
            Concluido = 0
        }

        $.ajax({
            type: "post",
            url: "../php/mostrar_reclamacoes_adm.php",
            data: {pendente: Pendente, em_andamento: Em_Andamento, concluido: Concluido},
            success: function (response) {

            }, error: function (param) { 
                
            }
        }).done(function (e) {
            $("#tabela_info").html(e);
            fazer_botao_funcionar()
         
        });
    })
        
    


