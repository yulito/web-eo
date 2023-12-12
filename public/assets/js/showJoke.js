//reproduccion
const textJoke = document.querySelector('#textJoke').textContent;
const btnPlay  = document.querySelector('.btn-play');

btnPlay.addEventListener('click', (e)=>{
    e.preventDefault

    play(textJoke)
})
function play(playText){
    speechSynthesis.speak(new SpeechSynthesisUtterance(playText));
}

//likes
const heart = document.querySelector('.heart-span');

heart.addEventListener('click', ()=>{
    heart.classList.toggle('heart-select');

    //cambio de color heart
    if(document.querySelector('.heart-select')){       
        let nro = document.querySelector('.like-span').textContent; 
        document.querySelector('.like-span').innerHTML = parseInt(nro)+1;
    }else{        
        let nro = document.querySelector('.like-span').textContent;
        document.querySelector('.like-span').innerHTML = parseInt(nro)-1;
    }
    //envio de datos para nro de likes
    let id = document.querySelector('#idPub').value;
    let info = {idPub:id}
    let send = JSON.stringify(info)

    fetch('/enviar-like',{
        method:'POST',        
        headers: {"Content-Type":"application/json"},
        body:send
    }).then(response => response.json())
    .then(msg =>{
        console.log(msg)
    }).catch(err => console.log(err))
})

//favoritos
const fav    = document.querySelector('.fav-span');
fav.addEventListener('click', ()=>{    
    fav.classList.toggle('fav-select');

    //envio de datos para fav
    let id = document.querySelector('#idPub').value;
    let info = {idPub:id}
    let send = JSON.stringify(info)

    fetch('/agregar-fav',{
        method:'POST',        
        headers: {"Content-Type":"application/json"},
        body:send
    }).then(response => response.json())
    .then(msg =>{
        console.log(msg)
    }).catch(err => console.log(err))
})