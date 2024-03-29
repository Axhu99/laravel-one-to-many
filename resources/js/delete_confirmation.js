const deleForms = document.querySelectorAll('.delete-form');
const modal = document.getElementById('modal');
const modalTitle = document.querySelector('.modal-title');
const modalBody = document.querySelector('.modal-body');
const confirmationButton = document.getElementById('modal-confirmation-button');

let activeForm = null;

deleForms.forEach(form => {
    form.addEventListener('submit', e => {
        //Blocco l'invio
        e.preventDefault();

        activeForm = form;

        //Inserisco i contenuti
        confirmationButton.innerText = 'Conferma Elimina';
        confirmationButton.className = 'btn btn-danger';
        modalTitle.innerText = 'Elimina post';
        modalBody.innerText = 'Sei sicuro di voler elimnare questo progetto?';

    })
});

confirmationButton.addEventListener('click', () => {
    if (activeForm) activeForm.submit();
});

modal.addEventListener('hidden.bs.modal', () => {
    activeForm = null
})