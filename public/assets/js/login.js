const formLogin  = document.querySelector('#formLogin');
const btnLogin   = document.querySelector('.btn-login');
const url   = '/login';

//limpiar campos mensajes
function cleanFieldError()
{
    document.querySelector('.e-field').innerHTML = "";
    document.querySelector('.e-email').innerHTML = "";
    document.querySelector('.e-auth_error').innerHTML = "";

}

btnLogin.addEventListener('click', (e)=>{
    e.preventDefault

    const data = new FormData(formLogin);

    fetch(url ,{
        method:'POST',
        body:data
    }).then(response=>response.json())      
    .then(datos=>{     
      
      //console.log(datos)
        
        //almacenar mensaje error
         if(datos.field != null || datos.email != null || datos.auth_error != null)
        {
            cleanFieldError();

            if(datos.field){ document.querySelector('.e-field').innerHTML = datos.field };
            if(datos.email){ document.querySelector('.e-email').innerHTML = datos.email };
            if(datos.auth_error){ document.querySelector('.e-auth_error').innerHTML = datos.auth_error };

        }else{           
            cleanFieldError();

            //limpiar campos formulario
            let input = document.querySelectorAll('.input');
            for(i=0; i < input.length; i++)
            {
                input[i].value = '';
            }
            
            //mensaje y redirección
            swal({
                title: datos.welcome,                  
                icon: "success",                    
                }).then(result =>{
                if(result.value){
                    location.href ="/"; 
                }else{location.href ="/";;}
                }) 
            }                

    }).catch(err => console.log(err));
}) 