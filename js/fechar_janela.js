
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