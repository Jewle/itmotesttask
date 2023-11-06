document.addEventListener('DOMContentLoaded', function() {
    const modals =  document.querySelectorAll('.modal');
    const selects = document.querySelectorAll('select');


    const modal = M.Modal.init(modals);

    const selectOption = document.querySelector("#select_authors");
    const confirmButton = document.querySelector('#book_authors_confirm_btn')



    confirmButton.addEventListener('click',async ({target})=>{
        const modal_waiting = document.querySelector('.book_waiting')
        const confirm_button = document.querySelector('#book_authors_confirm_btn')
        const bookId = target.dataset.bookid || ''
        const instance = M.FormSelect.getInstance(selectOption);
        const selectedValues = instance.getSelectedValues();


        modal_waiting.style.display = 'block'
        confirm_button.disabled = true
        const fetchResult = await fetch('/admin/attach_authors',{
            method:'POST',
            body:JSON.stringify({
                bookId,
                authors:selectedValues
            })
        })
        const response = await fetchResult.json()

        modal_waiting.style.display = 'none'
        confirm_button.disabled = false


    })

    M.FormSelect.init(selects);
});
