const box = document.querySelector('.main-content')

window.addEventListener('load', (e)=>{
    e.preventDefault
    
    fetch('/principal' ,{
        method:'GET',        
    }).then(response=>response.json())      
    .then(list=>{                 
        
        const template = document.querySelector('#tmp-list').content
        const fragment = document.createDocumentFragment()
        
        list.forEach(data =>{
            template.querySelector('a').href = "/chiste/"+data.id_publication+"/"+data.name;
            template.querySelector('h2').textContent = data.title;
            template.querySelector('.content').textContent = data.publication.substring(0, 60)+' ...';            
            template.querySelector('.date').textContent = data.updated_at;
            template.querySelector('.user').textContent = data.name;
            const clone = template.cloneNode(true)        
            fragment.appendChild(clone)
        })
        box.appendChild(fragment)
        
    }).catch(err => console.log(err));
})
