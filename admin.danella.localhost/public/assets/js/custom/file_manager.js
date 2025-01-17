const dropsZone = document.getElementById("drops-zone");
const filesText = document.getElementById('filesText');
const filesInput = document.getElementById('filesInput');
const divUploadedFiles = document.getElementById('div-uploaded-files');
let fileArray = [];

setDefaultUploadsText();


filesInput.addEventListener("change", function () {
    let files = [...filesInput.files];
    if (files != undefined) {
        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            fileArray.push(file);
            createUploadedFile(file);
        }

        updateFilesInput(fileArray);
    }
});

dropsZone.onclick = () => {
    filesInput.click();
}

dropsZone.addEventListener("dragover", (event) => {
    event.stopPropagation();
    event.preventDefault();
    filesText.textContent = "Release to Upload File(s)";
});

dropsZone.addEventListener("dragleave", () => {
    setDefaultUploadsText();
});

dropsZone.addEventListener("drop", (event) => {
    event.stopPropagation();
    event.preventDefault();
    let files = event.dataTransfer.files;
    if (files != undefined) {
        setDefaultUploadsText();
        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            fileArray.push(file);
            createUploadedFile(file);
        }

        updateFilesInput(fileArray);
    }
});

function setDefaultUploadsText() {
    filesText.textContent = "Drag or drop file(s) here or click to upload.";
}

function createUploadedFile(file) {
    const parent = document.createElement('div');
    parent.classList.add('mt-2', 'py-1', 'd-flex', 'justify-content-between', 'align-items-center');
    divUploadedFiles.appendChild(parent);

    const span = document.createElement('span');
    span.textContent = file.name;
    parent.appendChild(span);

    const button = document.createElement('button');
    button.addEventListener("click", (event) => {
        event.stopPropagation();
        event.preventDefault();

        let index = Array.from(divUploadedFiles.children).indexOf(parent);
        fileArray.splice(index, 1);
        divUploadedFiles.removeChild(parent);
        let dataTransfer = new DataTransfer();
        for (let i = 0; i < fileArray.length; i++) {
            let newFile = fileArray[i];
            dataTransfer.items.add(newFile);
        }
        filesInput.files = dataTransfer.files;
    });
    parent.appendChild(button);
    const i = document.createElement('i');
    i.classList.add('bx', 'bx-x', 'bx-sm');
    button.appendChild(i);
}

function updateFilesInput(fileArray) {
    let dataTransfer = new ClipboardEvent('').clipboardData || new DataTransfer();
    for (let i = 0; i < fileArray.length; i++) {
        let file = fileArray[i];
        dataTransfer.items.add(file);
    }
    filesInput.files = dataTransfer.files;
}

/*
const submitButton = document.getElementById('submit-button');
submitButton.addEventListener("click", (event) => {
    event.stopPropagation();
    event.preventDefault();
}); */





