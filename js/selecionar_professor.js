$(document).ready(function() {
   $.get("../php/mostrar_salas_interface", function(data) {
        $("#info").html(data);
   });
   
});

$("#selecionar_funcionarios").change(() => {
    var selecionar = $("#selecionar_funcionarios").val()

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

$("#checar_data").change(() => {
    if($('#checar_data').is(':checked')) {
        var valor = $('#checar_data').val();
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