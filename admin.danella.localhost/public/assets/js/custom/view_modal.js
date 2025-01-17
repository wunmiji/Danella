const viewModal = document.getElementById("viewModal");
const viewModalH2 = document.getElementById("viewModalLabel");
const modalBodyDiv = document.getElementById("modalBodyDiv");


viewModal.addEventListener("show.bs.modal", (event) => {
    let dataSrc = event.relatedTarget.getAttribute('data-src');
    let dataName = event.relatedTarget.getAttribute('data-name');
    let dataMime = event.relatedTarget.getAttribute('data-mime');

    viewModalH2.innerHTML = dataName;

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

    if (dataMime.startsWith('audio')) {
        var audio = document.createElement('audio');
        audio.controls = true;
        audio.src = dataSrc;
        audio.className = "img-fluid";
        modalBodyDiv.appendChild(audio);
    }

});

viewModal.addEventListener("hidden.bs.modal", (event) => {
    modalBodyDiv.innerHTML = '';
});

