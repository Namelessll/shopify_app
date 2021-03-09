;(function() {

document.addEventListener("DOMContentLoaded", addButtonListeners);
const urlHost = window.urlAjax;
function addButtonListeners() {

    const buttons = document.querySelectorAll('.image-post .set_tag_button');
    const close = document.querySelector('#overlay');
    const closeButton = document.querySelector('.tags-profile svg');
    const publishButtons =  Array.from(document.getElementsByClassName('publish_button'));
    const tagContainer = document.querySelector('.tags-list');
    const resultList = document.querySelector('ul[data-type="result-list"]')
    const canvas = document.getElementById('canvas');

    close.addEventListener('click', () => {
        closePop();
    });

    closeButton.addEventListener('click', () => {
        closePop();
    });

    tagContainer.addEventListener('click', (event) => {

        if (event.target.closest('svg')) {
            const request = new XMLHttpRequest();
            url = urlHost + '/api/item/image/dot/unset';

            request.open('POST', url);
            request.setRequestHeader('Content-Type', 'application/x-www-form-url');
            request.setRequestHeader('Access-Control-Allow-Origin','*');
            request.setRequestHeader('Access-Control-Allow-Methods','POST');
            request.setRequestHeader('Access-Control-Allow-Headers','X-Auth-Token,Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

            json = JSON.stringify({
                id_post_del: event.target.closest('svg').getAttribute('data-id-post'),
            });

            request.addEventListener("readystatechange", () => {
                request.onload = () =>{
                    if (request.response) {
                        response = JSON.parse(request.response);
                        document.querySelector('.dot-point[data-id="'+response+'"]').remove();
                        document.querySelector('.list-item[data-id-post="'+response+'"]').remove();
                        console.log(response);
                    }
                }
            });

            request.send(json);

        }
    });



    publishButtons.forEach(
        button => {
            button.addEventListener('click', (event)=>{
                if (!event.currentTarget.classList.contains("unpublish")) {
                    setPublish(button);

                } else{
                    setUnPublish(button);
                }
            });
        }
    );

    buttons.forEach(
        button => {
            button.addEventListener('click', ()=>{
                showPop(button)
            });
        }
    );
}

function togglePublish(item) {
    item.classList.toggle('unpublish')
}

function closePop() {
    document.querySelector('#overlay').style.display = 'none';
    document.querySelector('#popup_window').style.display = 'none';
    document.querySelector('.tags-form').style.display = 'none';
    if (document.querySelector('div[data-type="result-list-container"]').classList.contains("Polaris-Popover__PopoverOverlay--open"))
        document.querySelector('div[data-type="result-list-container"]').classList.remove("Polaris-Popover__PopoverOverlay--open");
    //document.querySelector('ul[data-type="result-list"]').innerHTML = "";
    document.querySelector('input[data-type="search"]').value = "";
    document.querySelectorAll('div.dot-point').forEach(function (item) {
        item.remove();
    });
    document.querySelector('.tags-list').innerHTML = "";
}

function setUnPublish(button) {
    const request = new XMLHttpRequest();
    const url = urlHost + "/api/item/unpublish";
    request.open('POST', url);

    request.setRequestHeader('Content-Type', 'application/x-www-form-url');
    request.setRequestHeader('Access-Control-Allow-Origin','*');
    request.setRequestHeader('Access-Control-Allow-Methods','POST');
    request.setRequestHeader('Access-Control-Allow-Headers','X-Auth-Token,Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

    json = JSON.stringify({
        id: button.dataset.img
    });

    button.classList.add("Polaris-Button--disabled");
    button.classList.add("Polaris-Button--loading");
    button.classList.add("Polaris-Button--primary");

    request.addEventListener("readystatechange", () => {
        request.onload = () =>{
            if (request.response) {
                button.classList.remove("Polaris-Button--disabled");
                button.classList.remove("Polaris-Button--loading");
                document.querySelector('.Polaris-Badge--statusSuccess[data-item-bage="'+button.dataset.img+'"]').style.display = 'none';
                togglePublish(button);

                response = JSON.parse(request.response);
            }
        }
    });

    request.send(json);

}

function setPublish(button) {
    const request = new XMLHttpRequest();
    const url = urlHost + "/api/item/publish";

    request.open('POST', url);

    request.setRequestHeader('Content-Type', 'application/x-www-form-url');
    request.setRequestHeader('Access-Control-Allow-Origin','*');
    request.setRequestHeader('Access-Control-Allow-Methods','POST');
    request.setRequestHeader('Access-Control-Allow-Headers','X-Auth-Token,Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

    json = JSON.stringify({
        id: button.dataset.img
    });

    button.classList.add("Polaris-Button--disabled");
    button.classList.add("Polaris-Button--loading");

    request.addEventListener("readystatechange", () => {
        request.onload = () =>{
            if (request.response) {
                button.classList.remove("Polaris-Button--primary");
                button.classList.remove("Polaris-Button--disabled");
                button.classList.remove("Polaris-Button--loading");
                document.querySelector('.Polaris-Badge--statusSuccess[data-item-bage="'+button.dataset.img+'"]').style.display = 'block';
                togglePublish(button);
                response = JSON.parse(request.response);
            }
        }
    });

    request.send(json);
}


function showPop(button) {
    const request = new XMLHttpRequest();
    const url = urlHost + "/api/popup?post=" + button.dataset.img;
    document.querySelector('#overlay').style.display = 'flex';
    document.querySelector('#preloader').style.display = 'flex';
    request.open('GET', url);

    request.setRequestHeader('Content-Type', 'application/x-www-form-url');
    request.setRequestHeader('Access-Control-Allow-Origin','*');
    request.setRequestHeader('Access-Control-Allow-Methods','GET');
    request.setRequestHeader('Access-Control-Allow-Headers','X-Auth-Token,Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

    request.addEventListener("readystatechange", () => {
        request.onload = () =>{

            if (request.response) {
                post = JSON.parse(request.response);

                document.querySelector('#popup_window').style.display = 'flex';
                preloader.style.display = "none";

                document.querySelector('.image_view img').src = post['post'][0]['post_media_url'];
                document.querySelector('#instagram_username').innerHTML = '@' + post['post'][0]['post_username'];
                document.querySelector('#popup_window').setAttribute('data-post', post['post'][0]['id']);
                document.querySelector('.tags-profile img').src = post['pic_user'];

                post['dots'].forEach(function(dot, i) {
                    if (!dot['product_image'])
                        dot['product_image'] = "";
                    let div = document.createElement('div');
                    div.className = "dot-point saved-dot";
                    div.innerText = i+1;
                    div.style.cssText = "top: " + dot['serialized_coords']['top']+ "%; left: " + dot['serialized_coords']['left'] + "%;"
                    div.setAttribute('data-type', 'saved');
                    div.setAttribute('data-left', dot['serialized_coords']['left']);
                    div.setAttribute('data-top', dot['serialized_coords']['top']);
                    div.setAttribute('data-id', dot['id']);
                    document.getElementById('image_view').appendChild(div);

                    let divLi = document.createElement('div');
                    divLi.className = "list-item";
                    divLi.innerHTML = '<img src="'+dot['product_image']+'" alt=""><p>'+dot['product_name']+'</p><svg data-id-post="'+dot["id"]+'" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="Polaris-icon/Minor/Mono/Delete"><path id="Icon" fill-rule="evenodd" clip-rule="evenodd" d="M11 16H14V8H11V16ZM6 16H9V8H6V16ZM8 6H12V4H8V6ZM17 6H14V4C14 2.897 13.103 2 12 2H8C6.897 2 6 2.897 6 4V6H3C2.447 6 2 6.448 2 7C2 7.552 2.447 8 3 8H4V17C4 17.552 4.447 18 5 18H15C15.553 18 16 17.552 16 17V8H17C17.553 8 18 7.552 18 7C18 6.448 17.553 6 17 6Z" fill="#637381"/><mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="2" y="2" width="16" height="16"><path id="Icon_2" fill-rule="evenodd" clip-rule="evenodd" d="M11 16H14V8H11V16ZM6 16H9V8H6V16ZM8 6H12V4H8V6ZM17 6H14V4C14 2.897 13.103 2 12 2H8C6.897 2 6 2.897 6 4V6H3C2.447 6 2 6.448 2 7C2 7.552 2.447 8 3 8H4V17C4 17.552 4.447 18 5 18H15C15.553 18 16 17.552 16 17V8H17C17.553 8 18 7.552 18 7C18 6.448 17.553 6 17 6Z" fill="white"/></mask><g mask="url(#mask0)"></g></g></svg>'
                    divLi.setAttribute('data-id-post', dot["id"]);
                    document.querySelector('.tags-list').appendChild(divLi);
                });

            } else {
                return false;
            }
        }
    });

    request.send();
}
})();
