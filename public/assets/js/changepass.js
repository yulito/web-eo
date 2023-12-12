const form      = document.querySelector('#formChangePass');
const btn       = document.querySelector('.btn-chpass');
const loader    = document.querySelector('.loader-msg');
const url       = "/nuevo-pass";

btn.addEventListener('click', (e)=>{
    e.preventDefault

    loader.innerHTML = '<h3><strong>Cargando petición...</strong></h3>';

    const data = new FormData(form);    

    fetch(url,{
        method:'post',
        body:data
    }).then(response => response.json())
    .then(msg =>{
        console.log(msg)
        loader.innerHTML = '';
        
        if(msg.field != null){ document.querySelector('.msg-field').innerHTML = msg.field; }
            else{document.querySelector('.msg-field').innerHTML = '';}
        if(msg.pass1 != null){ document.querySelector('.msg-pass1').innerHTML = msg.pass1; }
            else{document.querySelector('.msg-pass1').innerHTML = '';}
        if(msg.pass2 != null){ document.querySelector('.msg-pass2').innerHTML = msg.pass2; }
            else{document.querySelector('.msg-pass2').innerHTML = '';}
        if(msg.notmatch != null){ document.querySelector('.msg-notmatch').innerHTML = msg.notmatch; }
            else{document.querySelector('.msg-notmatch').innerHTML = '';}
        if(msg.error != null){ document.querySelector('.msg-fail').innerHTML = '<h3>'+msg.error+'</h3>'; }
            else{document.querySelector('.msg-fail').innerHTML = '';}
        if(msg.success){
            swal({
                title: msg.success,                  
                icon: "success",                    
                }).then(result =>{
                if(result.value){
                    location.href ="/"; 
                }else{location.href ="/";;}
                })
            form.reset();
        } 
    }).catch(err => console.log(err))
});