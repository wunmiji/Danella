const gallaryModal = document.getElementById("gallaryModal");
const gallaryModalH2 = document.getElementById("gallaryModalLabel");
const modalBodyDiv = document.getElementById("modalBodyDiv");


gallaryModal.addEventListener("show.bs.modal", (event) => {
    let dataSrc = event.relatedTarget.getAttribute('data-src');
    let dataName = event.relatedTarget.getAttribute('data-name');
    let dataMime = event.relatedTarget.getAttribute('data-mime');

    gallaryModalH2.innerHTML = dataName;

    if (dataMime.startsWith('image')) {
        var img = new Image();
        img.className = "img-fluid";
        img.src = dataSrc;
        modalBodyDiv.appendChild(img);
    }

    if (dataMime.startsWith('video')) {
        let video = document.createElement('video');
        video.src = dataSrc;
        video.controls = true;
        video.className = "img-fluid";
        modalBodyDiv.appendChild(video);
    }

});

gallaryModal.addEventListener("hidden.bs.modal", (event) => {
    modalBodyDiv.innerHTML = '';
});

