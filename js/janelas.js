try {
    var abrir_update = document.getElementById('upload_foto_btn').addEventListener("click", () => {
        var aberto = document.getElementById("tela_upload").style.display = "flex"
    })
} catch (error) {

}

try {
    var fechar_erro = document.getElementById("fechar_erro").addEventListener("click", () => {
        var erro = document.getElementById("erro").style.display = "none"
    })
} catch (error) {

}

try {
    var fechar_certo =  document.getElementById("fechar_certo").addEventListener("click", () => {
        var certo = document.getElementById("certo").style.display = "none"
    })
} catch (error) {

}

try {
    var fechar_certo =  document.getElementById("fechar_upload").addEventListener("click", () => {
        var certo = document.getElementById("tela_upload").style.display = "none"
    })
} catch (error) {

}
