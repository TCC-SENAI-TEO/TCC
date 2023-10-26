$(document).ready(function () {
    var enviar_codigo_sala = $("#codigo_sala").val()

    $.ajax({
        type: "post",
        url: "../php/mostrar_agendar_salas.php",
        data: {codigo_sala: enviar_codigo_sala},
        success: function (response) {
            console.log("enviado")
        },
        error: function (error) {
            console.log("nao_enviado")
        }
    }).done(function(e) {
        $("#info").html(e)
   });

});

var data = document.getElementById("data_escolhida").valueAsDate = new Date();


$("#data_escolhida").change(function (e) { 
    var enviar_data_escolhida = $("#data_escolhida").val()
    var enviar_codigo_sala = $("#codigo_sala").val()

    console.log(enviar_codigo_sala)
    $.ajax({
        type: "post",
        url: "../php/mostrar_agendar_salas.php",
        data: {data_escolhida: enviar_data_escolhida, codigo_sala: enviar_codigo_sala},
        success: function (response) {
            console.log("success")
        },
        error: function (error) {
            console.log("error")
        }
    }).done(function(e) {
        $("#info").html(e)
    })
})