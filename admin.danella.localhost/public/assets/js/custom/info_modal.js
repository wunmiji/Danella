const infoModal = document.getElementById("infoModal");
const infoModalBodyDiv = document.getElementById("infoModalBodyDiv");


infoModal.addEventListener("show.bs.modal", (event) => {
    const map = new Map();
    map.set('Name', event.relatedTarget.getAttribute('data-name'));
    map.set('Url', event.relatedTarget.getAttribute('data-src'));
    map.set('Mime type', event.relatedTarget.getAttribute('data-mime'));
    map.set('Size', event.relatedTarget.getAttribute('data-size'));
    map.set('Extension', event.relatedTarget.getAttribute('data-extension'));
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

