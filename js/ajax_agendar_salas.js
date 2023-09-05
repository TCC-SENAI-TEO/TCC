$(document).ready(function () {
    $.get("../php/mostrar_agendar_salas", function(data) {
        $("#info").html(data);
   });

});

var data = document.getElementById("data_escolhida").valueAsDate = new Date();


$("#data_escolhida").change(function (e) { 
    var enviar_data_escolhida = $("#data_escolhida").val()

    $.ajax({
        type: "post",
        url: "../php/mostrar_agendar_salas.php",
        data: {data_escolhida: enviar_data_escolhida},
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