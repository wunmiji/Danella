const textHiddenInput = document.getElementById('textHiddenInput');

var toolbarOptions = [
    [{ 'header': [1, 2, 3, false] }],
    ['bold', 'italic', 'underline', 'strike'],
    [{ 'script': 'sub' }, { 'script': 'super' }],      // superscript/subscript
    [{ 'indent': '-1' }, { 'indent': '+1' }],
    ['blockquote'],
    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
    ['image', 'video', 'formula', 'link'],
    ['clean'],
];

const quill = new Quill('#editor', {
    modules: {
        toolbar: toolbarOptions,
    },
    placeholder: 'Enter text',
    theme: 'snow'
});

let textHiddenInputValue = textHiddenInput.value;
if (textHiddenInputValue !== null && textHiddenInputValue.length !== 0) {
    quill.root.innerHTML = textHiddenInputValue;
}


quill.on('text-change', () => {
    textHiddenInput.value = '';
    textHiddenInput.value = quill.root.innerHTML;
});

