const renameModal = document.getElementById("renameModal");
const renameModalForm = document.getElementById("renameModalForm");
const nameModalInput = document.getElementById("nameModalInput");


renameModal.addEventListener("show.bs.modal", (event) => {
    dataHref = event.relatedTarget.getAttribute('data-href');
    dataName = event.relatedTarget.getAttribute('data-name');

    renameModalForm.action = dataHref;
    nameModalInput.value = dataName;
});



