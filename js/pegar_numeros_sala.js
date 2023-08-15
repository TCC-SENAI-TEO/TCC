
    var numero_salas_disponivel  = document.querySelectorAll('.salas .salas_disponivel').length
    var numero_salas_fechado = document.querySelectorAll('.salas .salas_fechado').length
    var salas_totais = numero_salas_disponivel + numero_salas_fechado

    var salas = document.getElementById("salas_totais").innerHTML = "Salas Totais: " + salas_totais
    var salas_disponiveis = document.getElementById("salas_disponiveis").innerHTML = "Salas Disponiveis: " + numero_salas_disponivel
    var salas_interditadas = document.getElementById("salas_interditadas").innerHTML = "Salas Interditadas: 0"
    var salas_fechadas = document.getElementById("salas_ocupadas").innerHTML = "Salas Ocupadas: " + numero_salas_fechado
    



