const filesModal = document.getElementById("filesModal");
const filesModalBodyDiv = document.getElementById("filesModalBodyDiv");
const foldersModalBodyLink = document.getElementsByClassName("folders-modal-body-link");
const addFilesModalButton = document.getElementById("addFilesModalButton");
const dropzoneDiv = document.getElementById("dropzone");
const dropszoneDiv = document.getElementById("dropszone");
const fileText = document.getElementById("fileText");
const filesText = document.getElementById("filesText");
const fileHiddenInput = document.getElementById("fileHidden");
const filesHiddenInput = document.getElementById("filesHidden");

var dataUploadedFileDiv;
var dataMultiple;

var styles = ['border', 'border-5', 'p-3'];

if (fileText !== null) fileText.textContent = 'Click to upload featured Image';
if (filesText !== null) filesText.textContent = 'Click to upload files';
if (fileHiddenInput !== null && fileHiddenInput.length !== 0) {
    let fileHiddenInputValue = fileHiddenInput.value;
    let fileObject = JSON.parse(fileHiddenInputValue);

    let map = new Map();
    map.set('id', fileObject.id);
    map.set('fileId', fileObject.fileId);

    let myObj = Object.fromEntries(map);
    let json = JSON.stringify(myObj);

    dataUploadedFileDiv = document.getElementById(dropzoneDiv.dataset.output)
    dataMultiple = dropzoneDiv.dataset.multiple;
    createUploadedFile(dataUploadedFileDiv, fileObject.fileName, dataMultiple, json);
}
if (filesHiddenInput !== null && filesHiddenInput.length !== 0) {
    let filesHiddenInputValue = filesHiddenInput.value;
    let filesObject = JSON.parse(filesHiddenInputValue);

    Object.values(filesObject).forEach(fileObject => {
        let map = new Map();
        map.set('id', fileObject.id);
        map.set('fileId', fileObject.fileId);

        let myObj = Object.fromEntries(map);
        let json = JSON.stringify(myObj);

        dataUploadedFileDiv = document.getElementById(dropszoneDiv.dataset.output);
        dataMultiple = dropszoneDiv.dataset.multiple;
        createUploadedFile(dataUploadedFileDiv, fileObject.fileName, dataMultiple, json);
    });
}



filesModal.addEventListener("show.bs.modal", (event) => {
    dataUploadedFileDiv = document.getElementById(event.relatedTarget.getAttribute('data-output'));
    dataMultiple = event.relatedTarget.getAttribute('data-multiple');

    for (let i = 0; i < foldersModalBodyLink.length; i++) {
        foldersModalBodyLink[i].onclick = (event) => {
            filesModalBodyDiv.innerHTML = '';
            let folder = JSON.parse(foldersModalBodyLink[i].dataset.folder);
            for (let i = 0; i < folder.length; i++) {
                createFileDiv(folder[i], dataMultiple);
            }
        }
    }
});

filesModal.addEventListener("hidden.bs.modal", (event) => {
    filesModalBodyDiv.innerHTML = '';
});

addFilesModalButton.onclick = (event) => {
    var children = filesModalBodyDiv.children;
    for (let j = 0; j < children.length; j++) {
        if (children[j].classList.contains(...styles)) {
            var id = children[j].dataset.fileId;
            var name = children[j].dataset.name;

            let map = new Map();
            map.set('fileId', id);

            let myObj = Object.fromEntries(map);
            let json = JSON.stringify(myObj);

            if (eval(dataMultiple) === false) dataUploadedFileDiv.innerHTML = '';
            createUploadedFile(dataUploadedFileDiv, name, dataMultiple, json);
        }
    }

    var modalInstance = bootstrap.Modal.getInstance(filesModal)
    modalInstance.hide();
}

function createUploadedFile(dataUploadedFileDiv, name, multiple, json) {
    const parent = document.createElement('div');
    parent.classList.add('mt-2', 'py-1', 'd-flex', 'justify-content-between', 'align-items-center');
    dataUploadedFileDiv.appendChild(parent);

    const span = document.createElement('span');
    span.textContent = name;
    parent.appendChild(span);

    const button = document.createElement('button');
    button.addEventListener("click", (event) => {
        event.stopPropagation();
        event.preventDefault();

        dataUploadedFileDiv.removeChild(parent);
    });
    parent.appendChild(button);
    const i = document.createElement('i');
    i.classList.add('bx', 'bx-x', 'bx-sm');
    button.appendChild(i);

    var inputId = document.createElement("input");
    inputId.setAttribute("type", "hidden");
    inputId.setAttribute("value", json);
    if (eval(multiple) === true) inputId.setAttribute("name", 'files[]');
    else inputId.setAttribute("name", 'file');
    parent.appendChild(inputId);
}

function createFileDiv(file, multiple) {
    if (eval(multiple) === false) {
        if (file.fileMimetype.startsWith('image')) {
            var parent = createParentDiv(filesModalBodyDiv, file, multiple);

            createImage(parent, file)
        };
    } else {
        if (file.fileMimetype.startsWith('image')) {
            var parent = createParentDiv(filesModalBodyDiv, file, multiple);
            createImage(parent, file);
        }
        else if (file.fileMimetype.startsWith('video')) {
            var parent = createParentDiv(filesModalBodyDiv, file, multiple);
            createVideo(parent, file);
        }
    }


}

function createParentDiv(filesModalBodyDiv, file, multiple) {
    const parent = document.createElement('div');
    parent.classList.add('card', 'shadow-none', 'h-100');
    parent.setAttribute("data-file-id", file.id);
    parent.setAttribute("data-name", file.fileName);
    filesModalBodyDiv.appendChild(parent);

    parent.addEventListener('click', function () {
        if (eval(multiple) === true) {
            if (parent.classList.contains(...styles)) parent.classList.remove(...styles);
            else parent.classList.add(...styles);
        } else {
            if (parent.classList.contains(...styles)) parent.classList.remove(...styles);
            else {
                for (let j = 0; j < filesModalBodyDiv.children.length; j++) {
                    filesModalBodyDiv.children[j].classList.remove(...styles);
                }
                parent.classList.add(...styles);
            }
        }
    });

    return parent;
}

function createImage(parent, file) {
    var img = new Image();
    img.classList.add('rounded-0', 'object-fit-cover', 'w-100', 'h-100');
    img.src = file.fileSrc;
    parent.appendChild(img);

    cardBody(parent, file.fileName);
}

function createVideo(parent, file) {
    var video = document.createElement('video');
    video.classList.add('rounded-0', 'object-fit-cover', 'w-100', 'h-100');
    video.src = file.fileSrc;
    video.controls = false;
    parent.appendChild(video);

    cardBody(parent, file.fileName);
}

function cardBody(parent, fileName) {
    const cardBody = document.createElement('div');
    cardBody.classList.add('card-body', 'px-0', 'mx-auto', 'text-center');
    parent.appendChild(cardBody);
    const small = document.createElement('small');
    small.classList.add('card-text');
    small.innerText = fileName;
    cardBody.appendChild(small);
}




