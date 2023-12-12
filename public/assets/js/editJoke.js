const form  = document.querySelector('#formEditJoke');
const btn   = document.querySelector('.btn-edit-joke');
const url   = '/editar-chiste';

btn.addEventListener('click', (e)=>{
    e.preventDefault

    const data = new FormData(form);

    fetch(url,{
        method:"POST",
        body:data
    }).then(response => response.json())
    .then(msg =>{
        console.log(msg)
        if(msg.field != null){ document.querySelector('.e-field').innerHTML = msg.field}
            else{ document.querySelector('.e-field').innerHTML = ''}
        if(msg.error != null){ document.querySelector('.e-error').innerHTML = msg.error}
            else{ document.querySelector('.e-error').innerHTML = ''}
        if(msg.success){
            swal({
                title: msg.success,                  
                icon: "success",                    
                })
        }
    }).catch(err => console.log(err))
})