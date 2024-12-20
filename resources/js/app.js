import "./bootstrap";
import collect from "collect.js";
import { Alpine, Livewire } from "../../vendor/livewire/livewire/dist/livewire.esm";
import overlap from "alpinejs-overlap";
import rangy from "rangy/lib/rangy-core.js";
import "rangy/lib/rangy-highlighter";
import "rangy/lib/rangy-classapplier";
import resize from "@alpinejs/resize";

window.collect = collect;
window.rangy = rangy;

Alpine.plugin(overlap);
Alpine.plugin(resize);
Livewire.start();


// A function is used for dragging and moving
function dragElement(element, direction)
{
    var   md; // remember mouse down info
    const first  = document.getElementById("document-viewer");
    const second = document.getElementById("transcript");

    element.onmousedown = onMouseDown;

    function onMouseDown(e)
    {
        //console.log("mouse down: " + e.clientX);
        md = {e,
            offsetLeft:  element.offsetLeft,
            offsetTop:   element.offsetTop,
            firstWidth:  first.offsetWidth,
            secondWidth: second.offsetWidth
        };

        document.onmousemove = onMouseMove;
        document.onmouseup = () => {
            //console.log("mouse up");
            document.onmousemove = document.onmouseup = null;
        }
    }

    function onMouseMove(e)
    {
        //console.log("mouse move: " + e.clientX);
        var delta = {x: e.clientX - md.e.clientX,
            y: e.clientY - md.e.clientY};

        if (direction === "H" ) // Horizontal
        {
            // Prevent negative-sized elements
            delta.x = Math.min(Math.max(delta.x, -md.firstWidth),
                md.secondWidth);

            element.style.left = md.offsetLeft + delta.x + "px";
            first.style.width = (md.firstWidth + delta.x) + "px";
            second.style.width = (md.secondWidth - delta.x) + "px";
        }
    }
}

if(document.getElementById("document-viewer")){
    dragElement( document.getElementById("separator"), "H" );
}

