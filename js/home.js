var data = document.getElementById("data").valueAsDate = new Date(); //Define a data para a atual
var controle_numeral = 0 
var enviar_controle_edit;




$(document).ready(function() {
    $.get("../php/verificar_sala_disponivel", function(data) { //Recebe as informações do arquivo editar_sala
        $(".salas").html(data); //Imprimi as informações do arquivo
        var numero_salas_disponivel = $(".salas .salas_disponivel").length //Pega a quantidade de salas com a classe especificadas atreavés do comando .length
        var numero_salas_fechado = $(".salas .salas_fechado").length
        var numero_salas_interditado = $(".salas .salas_interditado").length
        var salas_totais = numero_salas_disponivel + numero_salas_fechado + numero_salas_interditado

        $("#salas_totais").html("Salas Totais: " + salas_totais);
        $("#salas_disponiveis").html("Salas Disponiveis: " + numero_salas_disponivel);
        $("#salas_interditadas").html("Salas Interditadas: " + numero_salas_interditado );
        $("#salas_ocupadas").html("Salas Ocupadas: " + numero_salas_fechado);
    });

    $.get("../php/editar_sala", function(data) {
        $("#editar_salas").html(data) 
        
    });
    
});

$("#data, #selecionar_horario").change(() => { //Os itens com os IDs "#data" e "#selecionar_horario" recebem um comando de change, para que toda vez que eles sofrerem alguma alteração, executarem o codigo
    var enviar_data = $('#data').val(); //Pega o valor do ID #data através do comando .val()
    var enviar_horario = $('#selecionar_horario').val();

    $.ajax({ //Envia as informações para o arquivo desejado
        type: "post", //Especifica como sera enviado os dados para o arquivo
        url: "../php/verificar_sala_disponivel.php", //O caminho para qual arquivo sera enviado
        data: {data: enviar_data, horario: enviar_horario}, //Os dados que seram enviados para o arquivo
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
        $("#salas_interditadas").html("Salas Interditadas: " + numero_salas_interditado);
        $("#salas_ocupadas").html("Salas Ocupadas: " + numero_salas_fechado);

        

        
    })

})

setTimeout(() => {
    $(".sala").on("click", function(e) {
        var enviar_codigo_sala_original = this.id
        var enviar_codigo_sala = this.id
        var enviar_descricao_sala = $(this).attr("tag")
        var enviar_capacidade_sala = $(this).attr("cap")
        var enviar_status_sala = $(this).attr("status")


        $(".sala").on("dblclick", function(e) {

            if(controle_numeral % 2 == 0) {
                enviar_controle_edit = true;
                controle_numeral++
            } else {
                enviar_controle_edit = false;
                controle_numeral++
            }

            if(enviar_controle_edit == true) {
                $.get("../php/editar_sala", function(data) {
                    $("#editar_salas").html(data)
                    
                });
            }
            
        })

        $.ajax({
            type: "post",
            url: "../php/editar_sala.php",
            data: {selecionar_edit: enviar_controle_edit, codigo_sala: enviar_codigo_sala, descricao_sala: enviar_descricao_sala, capacidade: enviar_capacidade_sala, status_sala: enviar_status_sala},
            success: function (response) {

            },
            error: function() {
                
            }
        }).done(function(e) { 
            $("#editar_salas").html(e)

            $("#editar_salas").on("change",".definir_status", function (a) { 

                enviar_capacidade_sala = $("#numero_quantidade_sala").val()
                enviar_descricao_sala = $("#texto_descricao_sala").val()
                enviar_codigo_sala = $("#texto_codigo_sala").val()
                enviar_status_sala = $(".definir_status").val()
        
        
                $.ajax({
                    type: "post",
                    url: "../php/editar_sala.php",
                    data: {status_sala: enviar_status_sala, codigo_sala: enviar_codigo_sala, descricao_sala: enviar_descricao_sala, capacidade: enviar_capacidade_sala, codigo_sala_origial: enviar_codigo_sala_original, selecionar_edit: true},
                    success: function (response) {
                        console.log("deu certo")
                    }, error: function(e) {
                        console.log("error manutençao")
                    }
                }).done(function(e) {
                    $("#editar_salas").html(e)
                    $("#editar_sala_btn").on("click", function(e) {   
                        enviar_capacidade_sala = $("#numero_quantidade_sala").val()
                        enviar_descricao_sala = $("#texto_descricao_sala").val()
                        enviar_codigo_sala = $("#texto_codigo_sala").val()
                        enviar_status_sala = $(".definir_status").val()
                        let enviar_motivo = $("#motivo_manutencao").val()
                        console.log(enviar_status_sala)
                        
                        
        
                        e.preventDefault();
                        var enviar_confirmar_edit = confirm("Tem certeza que deseja editar a sala " + enviar_codigo_sala + " ?")
        
                        $.ajax({
                            type: "post",
                            url: "../php/enviar_edit_sala.php",
                            data: {status_sala: enviar_status_sala, codigo_sala: enviar_codigo_sala, descricao_sala: enviar_descricao_sala, capacidade: enviar_capacidade_sala, confirmar_edit: enviar_confirmar_edit, codigo_sala_original: enviar_codigo_sala_original, motivo_manutencao: enviar_motivo},
                            success: function (response) {
                                console.log("edit sucedida")
                            }, error: function(e) {
                                console.log("error edit")
                            }
                        }).done(function(e) {
        
                            $.get("../php/verificar_sala_disponivel", function(data) {
                                $(".salas").html(data);
                                $("#teste123").html(e)
                            })
                        });
        
                    })

                })
                
            })
            
            $("#editar_sala_btn").on("click", function(e) {   
                enviar_capacidade_sala = $("#numero_quantidade_sala").val()
                enviar_descricao_sala = $("#texto_descricao_sala").val()
                enviar_codigo_sala = $("#texto_codigo_sala").val()
                enviar_status_sala = $(".definir_status").val()
                let enviar_motivo = $("#motivo_manutencao").val()
                console.log(enviar_status_sala)
                

                e.preventDefault();
                var enviar_confirmar_edit = confirm("Tem certeza que deseja editar a sala " + enviar_codigo_sala + " ?")

                $.ajax({
                    type: "post",
                    url: "../php/enviar_edit_sala.php",
                    data: {status_sala: enviar_status_sala, codigo_sala: enviar_codigo_sala, descricao_sala: enviar_descricao_sala, capacidade: enviar_capacidade_sala, confirmar_edit: enviar_confirmar_edit, codigo_sala_original: enviar_codigo_sala_original, motivo_manutencao: enviar_motivo},
                    success: function (response) {
                        console.log("edit sucedida")
                    }, error: function(e) {
                        console.log("error edit")
                    }
                }).done(function(e) {

                    $.get("../php/verificar_sala_disponivel", function(data) {
                        $(".salas").html(data);
                        
                    })
                });
            

            })


            $("#apagar_sala_btn").on("click", function(e) {
                e.preventDefault();
                enviar_capacidade_sala = $("#numero_quantidade_sala").val()
                enviar_descricao_sala = $("#texto_descricao_sala").val()
                enviar_codigo_sala = $("#texto_codigo_sala").val()
                enviar_status_sala = $(".definir_status").val()

                var enviar_confirmar_delete = confirm("Tem certeza que deseja apagar a sala " + enviar_codigo_sala + " ?")

                $.ajax({
                    type: "post",
                    url: "../php/enviar_edit_sala.php",
                    data: {status_sala: enviar_status_sala, codigo_sala: enviar_codigo_sala, descricao_sala: enviar_descricao_sala, capacidade: enviar_capacidade_sala, confirmar_delete: enviar_confirmar_delete, codigo_sala_original: enviar_codigo_sala_original},
                    success: function (response) {
                        console.log("sucesso no delete")
                        console.log(enviar_codigo_sala_original)
                    }, error: function(e) {
                        console.log("erro no delete")
                        console.log(enviar_codigo_sala_original)
                    }
                }).done(function(e) {
                    $.get("../php/verificar_sala_disponivel", function(data) {
                        $(".salas").html(data);
                        $("#teste123").html(e)
                    })
                    
                });

            })

        });
        
    }) 

    
}, 300);
