var data = document.getElementById("data").valueAsDate = new Date();

$(document).ready(function() {
    $.get("../php/verificar_sala_disponivel", function(data) {
        $(".salas").html(data);
        var numero_salas_disponivel = $(".salas .salas_disponivel").length
        var numero_salas_fechado = $(".salas .salas_fechado").length
        var salas_totais = numero_salas_disponivel + numero_salas_fechado

        $("#salas_totais").html("Salas Totais: " + salas_totais);
        $("#salas_disponiveis").html("Salas Disponiveis: " + numero_salas_disponivel);
        $("#salas_interditadas").html("Salas Interditadas: 0");
        $("#salas_ocupadas").html("Salas Ocupadas: " + numero_salas_fechado);
    });

    
});

$("#data, #selecionar_horario").change(() => {
    var enviar_data = $('#data').val();
    var enviar_horario = $('#selecionar_horario').val();

    $.ajax({
        type: "post",
        url: "../php/verificar_sala_disponivel.php",
        data: {data: enviar_data, horario: enviar_horario},
        success: function (response) {
            console.log("foi")
        }, error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown)
        }
    }).done(function(e) {
        $(".salas").html(e);
        var numero_salas_disponivel = $(".salas .salas_disponivel").length
        var numero_salas_fechado = $(".salas .salas_fechado").length
        var salas_totais = numero_salas_disponivel + numero_salas_fechado

        $("#salas_totais").html("Salas Totais: " + salas_totais);
        $("#salas_disponiveis").html("Salas Disponiveis: " + numero_salas_disponivel);
        $("#salas_interditadas").html("Salas Interditadas: 0");
        $("#salas_ocupadas").html("Salas Ocupadas: " + numero_salas_fechado);
    })

})




