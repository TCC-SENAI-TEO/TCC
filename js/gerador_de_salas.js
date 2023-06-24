var $add_salabtn = document.getElementById('add_sala')
var $salas = document.getElementById('salas')
var $texto_codigo_sala = document.getElementById('texto_codigo_sala')
var $texto_descricao_sala = document.getElementById('texto_descricao_sala')
var $numero_quantidade_sala = document.getElementById('numero_quantidade_sala')
var $cadastrar_sala_btn = document.getElementById('cadastrar_sala_btn')

$cadastrar_sala_btn.addEventListener('click', () => {

    //Variaveis que criam elementos do HTML.
    var nova_sala = document.createElement('div')
    var h4_nova_sala = document.createElement('h4')
    var responsavel = document.createElement('p')
    var data_inicio = document.createElement('p')
    var data_final = document.createElement('p')

    //Variaveis que receberão os dados do formulário de registro das salas.
    var codigo_sala = document.createTextNode("Sala " + $texto_codigo_sala.value + ' - ' + $texto_descricao_sala.value)
    var responsavel_txt = document.createTextNode('Responsavel: ')
    var data_inicio_txt = document.createTextNode('Data/hora inicio: ')
    var data_final_txt = document.createTextNode('Data/hora final: ')

    //Adiciona classes para os elementos.
    if (nova_sala.classList) {
        nova_sala.classList.add("sala")
        h4_nova_sala.classList.add("tag")
        responsavel.classList.add("tag")
        data_inicio.classList.add("tag")
        data_final.classList.add("tag")
    }
    else {
        nova_sala.className += "sala"
    }

    //Adciona texto aos elementos.
    responsavel.appendChild(responsavel_txt)
    data_inicio.appendChild(data_inicio_txt)
    data_final.appendChild(data_final_txt)



    //Adiciona filhos.
    $salas.appendChild(nova_sala)
    nova_sala.appendChild(h4_nova_sala)
    h4_nova_sala.appendChild(codigo_sala)
    nova_sala.appendChild(responsavel_txt)
    nova_sala.appendChild(data_final)
    nova_sala.appendChild(data_inicio)
    h4_nova_sala.appendChild(codigo_sala)


    alert(responsavel.classList)
})
