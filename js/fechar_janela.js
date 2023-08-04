try {
    let abrir_update = document.getElementById('upload_foto_btn').addEventListener("click", () => {
        var aberto = document.getElementById("tela_upload").style.display = "flex"
    })
} catch (error) {

}

try {
    var fechar_erro = document.getElementById("fechar_erro").addEventListener("click", () => {
        let erro = document.getElementById("erro").style.display = "none"
    })
} catch (error) {

}

try {
    var fechar_certo =  document.getElementById("fechar_certo").addEventListener("click", () => {
        let certo = document.getElementById("certo").style.display = "none"
    })
} catch (error) {

}

try {
    var fechar_certo =  document.getElementById("fechar_upload").addEventListener("click", () => {
        let certo = document.getElementById("tela_upload").style.display = "none"
    })
} catch (error) {

}