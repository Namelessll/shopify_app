;(function() {
    const urlHost = window.urlAjax;
    const canvas = document.querySelector('#image_view');
    let dot = null;

    const updateCoordsAjax = function (dot) {
        const request = new XMLHttpRequest();
        url = urlHost + '/api/item/image/dot/update';
        request.open('POST', url);

        request.setRequestHeader('Content-Type', 'application/x-www-form-url');
        request.setRequestHeader('Access-Control-Allow-Origin','*');
        request.setRequestHeader('Access-Control-Allow-Methods','POST');
        request.setRequestHeader('Access-Control-Allow-Headers','X-Auth-Token,Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

        let json = JSON.stringify({
            id: dot.getAttribute('data-id'),
            coord_left: dot.getAttribute('data-left'),
            coord_top: dot.getAttribute('data-top'),
        });

        request.addEventListener("readystatechange", () => {
            request.onload = () =>{
                if (request.response) {
                    console.log(true);
                }
            }
        });

        request.send(json);
    }

    const onMouseMove = function (e) {
            const rect = canvas.getBoundingClientRect();
            const elt = 16 * 100 / rect.width;
            let left = 100 * (e.clientX - rect.left) / rect.width;
            let top = 100 * (e.clientY - rect.top) / rect.height;
            if (left > 100) left = 100;
            if (left < 0) left = 0;
            if (top > 100) top = 100;
            if (top < 0) top = 0;

            dot.style.left = (left - elt) + '%';
            dot.style.top = (top - elt) + '%';

            dot.setAttribute('data-left', (left - elt));
            dot.setAttribute('data-top', (top - elt));
    }

    const onMouseUp = function (e) {
        document.removeEventListener('mousemove', onMouseMove);
        document.removeEventListener('mouseup', onMouseUp);
        dot.classList.remove('moved-dot');
        updateCoordsAjax(dot);
    }

    const onMouseDown = function (e) {
        if (e.target.classList.contains('saved-dot')) {
            e.preventDefault();
            dot = e.target;
            dot.classList.add('moved-dot');
            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        }
    }

    canvas.addEventListener('mousedown', onMouseDown);
})();