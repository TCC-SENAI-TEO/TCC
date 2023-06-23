var $add_salabtn = document.getElementById('add_sala')
var $salas = document.getElementById('salas')
var $texto_codigo_sala = document.getElementById('texto_codigo_sala')
var $texto_descricao_sala = document.getElementById('texto_descricao_sala')
var $numero_quantidade_sala = document.getElementById('numero_quantidade_sala')
var $cadastrar_sala_btn = document.getElementById('cadastrar_sala_btn')

$cadastrar_sala_btn.addEventListener('click', () => {

    var hora_inicial = 'Data/hora inicio: '
    var hora_final = 'Data/hora fim: '
    var novaSala = document.createElement('h1')
    var codigo = document.createTextNode("Sala " + $texto_codigo_sala.value)
    if (novaSala.classList) {
        novaSala.classList.add("sala");
    }
    else {
        novaSala.className += "sala";
    }
    novaSala.appendChild(codigo)
    $salas.appendChild(novaSala)
})
