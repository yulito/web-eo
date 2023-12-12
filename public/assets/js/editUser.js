const formEditUser  = document.querySelector('#formEditProfile');
const formEditPass  = document.querySelector('#formEditPass');

const btnEdit       = document.querySelector('.btn-edit-profile');
const btnEditPass   = document.querySelector('.btn-edit-pass');

const urlUser       = "/editar-perfil";
const urlpass       = "/editar-password";

//editar datos personales
btnEdit.addEventListener('click', (e)=>{
    e.preventDefault

    const dataForm = new FormData(formEditUser);

    fetch(urlUser,{
        method:'post',
        body:dataForm
    }).then(response => response.json())
    .then(msg =>{

        if(msg.field != null){ document.querySelector('.e-field').innerHTML = msg.field }
            else{ document.querySelector('.e-field').innerHTML = "" }
        if(msg.email != null){ document.querySelector('.e-email').innerHTML = msg.email }
            else{ document.querySelector('.e-email').innerHTML = "" }
        if(msg.email_exist != null){ document.querySelector('.email-exist').innerHTML = msg.email_exist }
            else{ document.querySelector('.email-exist').innerHTML = "" }
        if(msg.name_exist != null){ document.querySelector('.name-exist').innerHTML = msg.name_exist }
            else{ document.querySelector('.name-exist').innerHTML = "" }

        if(msg.success)
        {
            swal({
                title: msg.success,                  
                icon: "success",                    
                }).then(result =>{
                if(result.value){
                    location.href ="/editar-perfil"; 
                }else{location.href ="/editar-perfil";;}
                }) 
            formEditUser.reset();
        }
    }).catch(err => console.log(err)); 
})

//editar password
btnEditPass.addEventListener('click', (e)=>{
    e.preventDefault

    const formPass = new FormData(formEditPass);

    fetch(urlpass,{
        method:'post',
        body: formPass
    }).then(response => response.json())
    .then(data =>{
        
        if(data.field != null){ document.querySelector('.pass-empty').innerHTML = data.field}
            else{ document.querySelector('.pass-empty').innerHTML = ''}
        if(data.pass != null){ document.querySelector('.pass-len').innerHTML = data.pass}
            else{ document.querySelector('.pass-len').innerHTML = ''}
        if(data.error != null){ document.querySelector('.pass-error').innerHTML = data.error}
            else{ document.querySelector('.pass-error').innerHTML = ''}
        if(data.success){
            swal({
                title: data.success,                  
                icon: "success",                    
                }).then(result =>{
                if(result.value){
                    location.href ="/editar-perfil"; 
                }else{location.href ="/editar-perfil";;}
                })             
        }
    }).catch(err => console.log(err));
})