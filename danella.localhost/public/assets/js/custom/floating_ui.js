import { computePosition, shift, flip, offset } from "https://cdn.jsdelivr.net/npm/@floating-ui/dom@1.6.3/+esm";

const floating = document.getElementById("floating");

document.addEventListener("mousemove", ({ clientX, clientY }) => {
    const virtualEl = {
        getBoundingClientRect() {
            return {
                width: 0,
                height: 0,
                x: clientX,
                y: clientY,
                left: clientX,
                right: clientX,
                top: clientY,
                bottom: clientY
            };
        }
    };

    computePosition(virtualEl, floating, {
        placement: "right-start",
        middleware: [offset(5), flip(), shift()]
    }).then(({ x, y }) => {
        Object.assign(floating.style, {
            top: `${y}px`,
            left: `${x}px`
        });
    });
});
