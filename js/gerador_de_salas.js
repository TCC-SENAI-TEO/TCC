var $add_salabtn = document.getElementById('add_sala')
var $salas = document.getElementById('salas')
var $texto_codigo_sala = document.getElementById('texto_codigo_sala')
var $texto_descricao_sala = document.getElementById('texto_descricao_sala')
var $numero_quantidade_sala = document.getElementById('numero_quantidade_sala')
var $cadastrar_sala_btn = document.getElementById('cadastrar_sala_btn')

$cadastrar_sala_btn.addEventListener('click', () => {

    var novaSala = document.createElement('div')
    var conteudo = document.createTextNode("teste")
    novaSala.appendChild(conteudo)
    $salas.appendChild(novaSala)
})
