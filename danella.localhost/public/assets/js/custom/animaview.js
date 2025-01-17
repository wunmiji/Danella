import AnimaView from '/assets/js/library/animaview.min.js';
// can be any dom element
const elements = document.querySelectorAll('[data-anima]');
// without options default is bottom
const anima = new AnimaView(elements, 'bottom');
anima.init();