window.onload = ()=>{
    const authorInputFields = document.querySelectorAll('.to-validate-name')
    const creat_author_button = document.querySelector('.create_author_button')
    authorInputFields.forEach(input=>{
      input.addEventListener('blur', async ()=>{
          const nameValues = [...authorInputFields].map(a=>a.value)
          if (nameValues.filter(q=>q).length>2){
              try{
                  const fetchResult = await fetch('/ajax/check_author',{
                      method:'POST',
                      body:JSON.stringify({
                          nameValues
                      })
                  })

                  if (fetchResult.status===200){
                      creat_author_button.disabled = false
                  }
                  else {
                      alert('Такой автор уже существует')
                  }
              }
              catch (e) {
                  console.warn(e)
              }

          }

      })
    })
}