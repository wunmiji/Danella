const infoModal = document.getElementById("infoModal");
const infoModalBodyDiv = document.getElementById("infoModalBodyDiv");


infoModal.addEventListener("show.bs.modal", (event) => {
    var isDirectory = event.relatedTarget.getAttribute('data-is-directory');
    
    const map = new Map();
    map.set('Name', event.relatedTarget.getAttribute('data-name'));
    if (eval(isDirectory) == 1) map.set('Description', event.relatedTarget.getAttribute('data-description'));
    if (eval(isDirectory) != 1) map.set('Url', event.relatedTarget.getAttribute('data-src'));
    map.set('Parent Path', event.relatedTarget.getAttribute('data-parent-path'));
    if (eval(isDirectory) != 1) map.set('Mime type', event.relatedTarget.getAttribute('data-mime'));
    map.set('Size', event.relatedTarget.getAttribute('data-size'));
    if (eval(isDirectory) != 1) map.set('Extension', event.relatedTarget.getAttribute('data-extension'));
    map.set('Last Modified', event.relatedTarget.getAttribute('data-modified'));
    map.set('Created', event.relatedTarget.getAttribute('data-added'));

    const tbl = document.createElement("table");
    tbl.classList.add('table');
    const tblBody = document.createElement("tbody");

    map.forEach((values, keys) => {
        let row = document.createElement("tr");

        const cell1 = document.createElement("td");
        const cellText1 = document.createTextNode(keys);
        cell1.appendChild(cellText1);
        row.appendChild(cell1);

        const cell2 = document.createElement("td");
        const cellText2 = document.createTextNode(values);
        cell2.appendChild(cellText2);
        row.appendChild(cell2);
        
        tblBody.appendChild(row);
    });



    tbl.appendChild(tblBody);
    infoModalBodyDiv.appendChild(tbl);
});

infoModal.addEventListener("hidden.bs.modal", (event) => {
    infoModalBodyDiv.innerHTML = '';
});

