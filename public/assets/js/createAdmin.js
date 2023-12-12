const formCreateAdmin   = document.querySelector('#formCreateAdmin');
const btnCreateAdmin    = document.querySelector('.btn-create-admin');
const url = "/crear-admin";

btnCreateAdmin.addEventListener('click', (e)=>{
    e.preventDefault

    const formdata  = new FormData(formCreateAdmin);

    fetch(url,{
        method:'post',
        body:formdata
    }).then(response => response.json())
    .then(msg =>{
        console.log(msg)

        
        if(msg.field != null){ document.querySelector('.e-field').innerHTML = msg.field }
            else{ document.querySelector('.e-field').innerHTML = "" }
        if(msg.email != null){ document.querySelector('.e-email').innerHTML = msg.email }
            else{ document.querySelector('.e-email').innerHTML = "" }
        if(msg.pass != null){ document.querySelector('.pass-len').innerHTML = msg.pass }
            else{ document.querySelector('.pass-len').innerHTML = "" }
        if(msg.email_exist != null){ document.querySelector('.email-exist').innerHTML = msg.email_exist }
            else{ document.querySelector('.email-exist').innerHTML = "" }
        if(msg.name_exist != null){ document.querySelector('.name-exist').innerHTML = msg.name_exist }
            else{ document.querySelector('.name-exist').innerHTML = "" }

        if(msg.success)
        {
            formCreateAdmin.reset();
            swal({
                title: msg.success,                  
                icon: "success",                    
                }).then(result =>{
                if(result.value){
                    location.href ="/crear-admin"; 
                }else{location.href ="/crear-admin";}
                })             
        }

    }).catch(err => console.log(err));
})