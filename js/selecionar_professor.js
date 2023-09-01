$(document).ready(function() {
   $.get("../php/mostrar_salas_interface", function(data) {
        $("#info").html(data);
   });
   
});

var data = document.getElementById("escolher_data").valueAsDate = new Date() 

$("#checar, #escolher_data, #selecionar_sala, #selecionar_funcionarios").change(() => {
    enviar_todos_dados(); 
});


function enviar_todos_dados() { 
    var enviar_data = $("#escolher_data").val();
    var enviar_sala = $("#selecionar_sala").val();
    var enviar_funcionario = $("#selecionar_funcionarios").val();
    var enviar_checkbox;

    if($("#checar").is(":checked")) {
        enviar_checkbox = $("#checar").val();
    } else {
        enviar_checkbox = ""
    }

    console.log(enviar_checkbox, enviar_data, enviar_sala, enviar_funcionario)

    $.ajax({
        type: "POST",
        url: "../php/update_reclamacoes.php",
        data: {nome_usuario: enviar_funcionario, data: enviar_data, checkbox: enviar_checkbox, sala: enviar_sala},
        success: function(response) {
            console.log("deu certo")
           
            
        }, 
        error: function(error) {
            console.log("deu errado")
        }
    }).done(function(e) {
    })

}

/*
    #escolher_data
    #selecionar_sala
    #checar
*/ 
