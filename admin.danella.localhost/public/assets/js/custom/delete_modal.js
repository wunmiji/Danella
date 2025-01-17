const deleteModal = document.getElementById("deleteModal");
const deleteModalLink = document.getElementById("deleteModalLink");


deleteModal.addEventListener("show.bs.modal", (event) => {
    dataHref = event.relatedTarget.getAttribute('data-href');

    deleteModalLink.href = dataHref;
});



