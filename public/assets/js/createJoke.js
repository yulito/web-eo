const formJoke  = document.querySelector('#formPublication');
const btnJoke   = document.querySelector('.btn-form-joke');
const urlJoke   = '/agregar-chiste';

btnJoke.addEventListener('click', (e)=>{
    e.preventDefault

    const dataBody = new FormData(formJoke);

    fetch(urlJoke,{
        method:'POST',
        body:dataBody
    }).then(response => response.json())
    .then(msg =>{
        console.log(msg)
        if(msg.field != null){ document.querySelector('.e-field').innerHTML = msg.field }
            else{ document.querySelector('.e-field').innerHTML = '' }
        if(msg.error != null){ document.querySelector('.e-error').innerHTML = msg.error }
            else{ document.querySelector('.e-error').innerHTML = '' }
        if(msg.success){            
            swal({
                title: msg.success,                  
                icon: "success",                    
                }).then(result =>{
                if(result.value){
                    location.href ="/agregar-chiste"; 
                }else{location.href ="/agregar-chiste";}
                })
            formJoke.reset();  
        }

    }).catch(err => console.log(err))
})