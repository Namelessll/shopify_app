;(function() {
    document.addEventListener("DOMContentLoaded", addClickListener);

    function addClickListener() {
        const canvas = document.getElementById('canvas');

        canvas.addEventListener('click', (e) => {
            const rect = e.target.getBoundingClientRect();
            createDot(getCoords(rect, e), rect);
            console.log(getCoords(rect, e));
        });

    }

    function getAllDots() {
        return document.getElementsByClassName('dot-point').length;
    }

    function createDot(coords, rect) {
        const elt = 16 * 100 / rect.width;
        if(document.querySelectorAll('div[data-type="unsaved"]').length != 0) {
            document.querySelector('div[data-type="unsaved"]').style.left = (coords.left - elt) + "%";
            document.querySelector('div[data-type="unsaved"]').style.top = (coords.top - elt) + "%";
        } else {
            let div = document.createElement('div');
            div.className = "dot-point";
            div.innerText = (getAllDots()+1);
            div.style.cssText = "top: " + (coords.top - elt) + "%; left: " + (coords.left - elt) + "%;"
            div.setAttribute('data-type', 'unsaved');
            div.setAttribute('data-left', coords.left);
            div.setAttribute('data-top', coords.top);

            document.querySelector('.tags-form').style.display = 'block';
            return document.getElementById('image_view').appendChild(div);
        }

    }

    function getCoords(rect, e) {
        return {
            left: 100 * e.offsetX / rect.width,
            top: 100 * e.offsetY / rect.height
        }
    }

})();
