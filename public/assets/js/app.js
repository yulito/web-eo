document.querySelector(".nav-slct").addEventListener('change',(e)=>{
    
    const valor = document.querySelector(".nav-slct").value
    if (valor != "") { location.href = valor; }
})