$(document).ready(function() {
   $.get("../php/mostrar_salas_interface", function(data) {
        $("#info").html(data);
   });

   
});

var data = document.getElementById("escolher_data").valueAsDate = new Date() 

$("#selecionar_funcionarios").change(() => {
    var selecionar = $("#selecionar_funcionarios").val()
    var checkbox = $("#checar").prop('checked', false)


    $.ajax({
        type: "post",
        url: "../php/mostrar_salas_interface.php",
        data: {nome_usuario: selecionar},
        success: function (response) {
            console.log("deu certo")
        }, error: function() {
            console.log("error")
        }
    }).done(function(e) {
        $("#info").html(e);
    })
})

$("#checar").change(() => {
    if($('#checar').is(':checked')) {
        var valor = $('#checar').val();
        
        $.ajax({
            type: "post",
            url: "../php/mostrar_salas_interface.php",
            data: {checkbox: valor},
            success: function (response) {
                console.log("deu certo")
            }, error: function() {
                console.log("error")
            }
        }).done(function(e) {
            $("#info").html(e);
        })

    } else {
        $.ajax({
            type: "post",
            url: "../php/mostrar_salas_interface.php",
            data: {checkbox: ""},
            success: function (response) {
                console.log("deu certo")
            }, error: function() {
                console.log("error")
            }
        }).done(function(e) {
            $("#info").html(e);
        })
    }

})

$("#escolher_data").on("change", () => {
    var enviar_data = $("#escolher_data").val();
    $.ajax({
        type: "post",
        url: "../php/mostrar_salas_interface.php",
        data: {data: enviar_data},
        success: function (response) {
            console.log("deu certo")
        }, error: function() {
            console.log("error")
        }
    }).done(function(e) {
        $("#info").html(e);
    })
})