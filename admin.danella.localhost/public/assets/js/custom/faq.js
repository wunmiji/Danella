const plusButton = document.getElementById('plus-button');
const faqsDiv = document.getElementById('div-faqs');
const faqsHiddenInput = document.getElementById('faqsHidden');


if (faqsHiddenInput.value !== null && faqsHiddenInput.value.length !== 0) {
    let faqsHiddenInputValues = JSON.parse(faqsHiddenInput.value);

    if (faqsHiddenInputValues.length !== 0) {
        Object.values(faqsHiddenInputValues).forEach(values => {
            createFaqs(values['question'], values['answer'], values['id'], true);
        });
    } else createFaqs('', '', null, false);
} else createFaqs('', '', null, false);

plusButton.addEventListener("click", (event) => {
    event.stopPropagation();
    event.preventDefault();

    createFaqs('', '', null, true);
});

function createFaqs(question, answer, id, addButton) {
    const parent = document.createElement('div');
    parent.classList.add('mb-4');
    parent.setAttribute("name", "div-faq");
    faqsDiv.appendChild(parent);

    var input = document.createElement("input");
    input.setAttribute("type", "text");
    input.setAttribute("value", question);
    input.classList.add('form-control');
    input.setAttribute("placeholder", "Enter Question");
    parent.appendChild(input);

    var textarea = document.createElement("textarea");
    textarea.setAttribute("rows", "4");
    textarea.setAttribute("placeholder", "Enter Answer");
    textarea.value = answer;
    textarea.classList.add('form-control', 'my-1');
    parent.appendChild(textarea);

    var input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("value", id);
    parent.appendChild(input);

    if (addButton === true) {
        const button = document.createElement('button');
        button.classList.add('float-end');
        button.addEventListener("click", (event) => {
            event.stopPropagation();
            event.preventDefault();

            faqsDiv.removeChild(parent);
        });
        parent.appendChild(button);

        const i = document.createElement('i');
        i.classList.add('bx', 'bx-x', 'bx-sm', 'ms-auto');
        button.appendChild(i);
    }


}

// const submitButton = document.getElementById('submit-button');
// submitButton.addEventListener("click", (event) => {
//     event.stopPropagation();
//     event.preventDefault();
// });

function isEmpty(value) {
    return (value == null || (typeof value === "string" && value.trim().length === 0));
}

function saveContent() {
    const faqsArray = [];
    const faqDiv = document.getElementsByName('div-faq');
    for (let i = 0; i < faqDiv.length; i++) {
        let faq = faqDiv[i];

        let question = faq.children[0].value;
        let answer = faq.children[1].value;
        let id = faq.children[2].value;

        if (!isEmpty(question) && !isEmpty(answer)) {
            var faqArray = { "id": id === 'null' ? null : id, "question": question, "answer": answer };
            faqsArray.push(faqArray);
        }

    }

    let jsonData = JSON.stringify(faqsArray);
    faqsHiddenInput.value = jsonData;
}

