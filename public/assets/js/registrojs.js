const loader    = document.querySelector('.loader-msg');
const form  = document.querySelector('#form-reg');
const btn   = document.querySelector('.btn-reg');
const url   = '/registrar';

btn.addEventListener('click', (e)=>{
    e.preventDefault
    e.stopPropagation

    loader.innerHTML = '<h3><strong>Cargando petición...</strong></h3>';

    const data = new FormData(form);

    fetch(url ,{
        method:'POST',        
        body:data
    }).then(response=>response.json())      
    .then(datos=>{

        console.log(datos);
        loader.innerHTML = '';

        if(datos.field != null){ document.querySelector('.e-field').innerHTML = datos.field }
            else{ document.querySelector('.e-field').innerHTML = "" }
        if(datos.email != null){ document.querySelector('.e-email').innerHTML = datos.email }
            else{ document.querySelector('.e-email').innerHTML = "" }
        if(datos.pass != null){ document.querySelector('.e-pass').innerHTML = datos.pass }
            else{ document.querySelector('.e-pass').innerHTML = "" }
        if(datos.email_exist != null){ document.querySelector('.email-exist').innerHTML = datos.email_exist }
            else{ document.querySelector('.email-exist').innerHTML = "" }
        if(datos.name_exist != null){ document.querySelector('.name-exist').innerHTML = datos.name_exist }
            else{ document.querySelector('.name-exist').innerHTML = "" }

        if(datos.success)
        {
            swal({
                title: datos.success,                  
                icon: "success",                    
                }).then(result =>{
                if(result.value){
                    location.href ="/"; 
                }else{location.href ="/";;}
                }) 
            form.reset();
        }
    }).catch(err => console.log(err));  
})