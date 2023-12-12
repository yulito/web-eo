const formRec  = document.querySelector('#recoveryForm');
const btnRec   = document.querySelector('.btn-rec');
const loader    = document.querySelector('.loader-msg');
const urlRec   = '/recuperar';

btnRec.addEventListener('click', (e)=>{
    e.preventDefault

    loader.innerHTML = '<h3><strong>Cargando petición...</strong></h3>';
    console.log(loader)

    const data = new FormData(formRec);    

    fetch(urlRec,{
        method:'post',
        body:data
    }).then(response=>response.json())      
    .then(msg=>{
        
        loader.innerHTML = '';

        let msgB = document.querySelector('.msg-rec');        

        if(msg.success){
            msgB.style.color='black';
            msgB.style.backgroundColor='white';
            msgB.style.padding='20px';
            msgB.style.borderRadius='8px';
            msgB.innerHTML = '<strong>'+msg.success+'</strong>';
            formRec.reset();
        }else{
            msgB.style.color='red';
            msgB.innerHTML = '<strong>'+msg.error+'</strong>';            
        }        
        
    }).catch(err => console.log(err));
})