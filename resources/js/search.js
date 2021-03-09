;(function () {
    const TIME_OUT = 500;
    const input = document.querySelector('input[data-type="search"]');
    const resultList = document.querySelector('ul[data-type="result-list"]')
    const resultListContainer = document.querySelector('div[data-type="result-list-container"]')

    const urlHost = window.urlAjax;
    let timer = null;

    const ajax = function (q, shop) {
        const request = new XMLHttpRequest();
        const url = urlHost + '/api/admin/shop/products?shop_id=' + shop + "&query=" + q;

        request.open('GET', url);

        request.setRequestHeader('Content-Type', 'application/x-www-form-url');
        request.setRequestHeader('Access-Control-Allow-Origin','*');
        request.setRequestHeader('Access-Control-Allow-Methods','GET');
        request.setRequestHeader('Access-Control-Allow-Headers','X-Auth-Token,Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

        request.addEventListener("readystatechange", () => {
            request.onload = () =>{
                resultList.innerHTML = "";
                if (request.response) {
                    post = JSON.parse(request.response);

                    post.forEach(element => {
                        resultList.innerHTML += '<li data-item="'+element.id+'" class="Polaris-OptionList-Option" tabindex="-1" role="option"><button id="PolarisComboBox4-0" type="button" class="Polaris-OptionList-Option__SingleSelectOption">'+element.title+'</button></li>';
                    });

                    console.log(resultListContainer);
                    console.log(document.querySelectorAll('li[role="option"]').length);
                    if (document.querySelectorAll('li[role="option"]').length > 0)
                        resultListContainer.classList.add("Polaris-Popover__PopoverOverlay--open");
                    else
                        resultListContainer.classList.remove("Polaris-Popover__PopoverOverlay--open");

                    console.log(post);
                } else {
                    return false;
                }
            }
        });

        request.send();

    };

    input.addEventListener('input', function(e) {
        if(timer) {
            clearTimeout(timer)
            timer = setTimeout(()=>ajax(this.value, this.getAttribute('data-shop-id')), TIME_OUT)
        } else {
            timer = setTimeout(()=>ajax(this.value, this.getAttribute('data-shop-id')), TIME_OUT)
        }
    });

    resultList.addEventListener('click', function(e) {
        const item = e.target.closest('li');
        if (item) {

            const request = new XMLHttpRequest();
            let url = urlHost + '/api/item/image/dot/set';

            request.open('POST', url);
            request.setRequestHeader('Content-Type', 'application/x-www-form-url');
            request.setRequestHeader('Access-Control-Allow-Origin','*');
            request.setRequestHeader('Access-Control-Allow-Methods','POST');
            request.setRequestHeader('Access-Control-Allow-Headers','X-Auth-Token,Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

            json = JSON.stringify({
                id_product: item.getAttribute('data-item'),
                coord_left: document.querySelector('div[data-type="unsaved"]').getAttribute('data-left'),
                coord_top: document.querySelector('div[data-type="unsaved"]').getAttribute('data-top'),
                id: document.querySelector('#popup_window').getAttribute('data-post'),
                shop_id: input.getAttribute('data-shop-id')
            });

            request.addEventListener("readystatechange", () => {
                request.onload = () =>{
                    if (request.response) {
                        response = JSON.parse(request.response);

                        document.querySelector('div[data-type="unsaved"]').classList.add('saved-dot');
                        document.querySelector('div[data-type="unsaved"]').setAttribute('data-id', response[0]['id']);
                        document.querySelector('div[data-type="unsaved"]').setAttribute('data-type', 'saved');

                        let divLi = document.createElement('div');
                        divLi.className = "list-item";
                        divLi.innerHTML = '<img src="'+response[0]['product_image']+'" alt=""><p>'+response[0]['product_name']+'</p><svg data-id-post="'+response[0]["id"]+'" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="Polaris-icon/Minor/Mono/Delete"><path id="Icon" fill-rule="evenodd" clip-rule="evenodd" d="M11 16H14V8H11V16ZM6 16H9V8H6V16ZM8 6H12V4H8V6ZM17 6H14V4C14 2.897 13.103 2 12 2H8C6.897 2 6 2.897 6 4V6H3C2.447 6 2 6.448 2 7C2 7.552 2.447 8 3 8H4V17C4 17.552 4.447 18 5 18H15C15.553 18 16 17.552 16 17V8H17C17.553 8 18 7.552 18 7C18 6.448 17.553 6 17 6Z" fill="#637381"/><mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="2" y="2" width="16" height="16"><path id="Icon_2" fill-rule="evenodd" clip-rule="evenodd" d="M11 16H14V8H11V16ZM6 16H9V8H6V16ZM8 6H12V4H8V6ZM17 6H14V4C14 2.897 13.103 2 12 2H8C6.897 2 6 2.897 6 4V6H3C2.447 6 2 6.448 2 7C2 7.552 2.447 8 3 8H4V17C4 17.552 4.447 18 5 18H15C15.553 18 16 17.552 16 17V8H17C17.553 8 18 7.552 18 7C18 6.448 17.553 6 17 6Z" fill="white"/></mask><g mask="url(#mask0)"></g></g></svg>'
                        divLi.setAttribute('data-id-post', response[0]["id"])
                        document.querySelector('.tags-list').appendChild(divLi);

                        if (document.querySelector('div[data-type="result-list-container"]').classList.contains("Polaris-Popover__PopoverOverlay--open"))
                            document.querySelector('div[data-type="result-list-container"]').classList.remove("Polaris-Popover__PopoverOverlay--open");
                        //document.querySelector('ul[data-type="result-list"]').innerHTML = "";
                        document.querySelector('input[data-type="search"]').value = "";
                        document.querySelector('.tags-form').style.display = 'none';

                        document.querySelector('button[data-img="'+response[0]['post_id']+'"]');
                        let numbers_dot = Number.parseInt(document.querySelector('button[data-update-img="'+response[0]['post_id']+'"]').querySelector('.Polaris-Button__Text').textContent.split('(').pop().split(')')[0]);
                        if (numbers_dot)
                            document.querySelector('button[data-update-img="'+response[0]['post_id']+'"]').querySelector('.Polaris-Button__Text').innerHTML = 'Tags products ('+ (numbers_dot +1) +')';
                        else
                            document.querySelector('button[data-update-img="'+response[0]['post_id']+'"]').querySelector('.Polaris-Button__Text').innerHTML = 'Tags products (1)';

                    }
                }
            });

            request.send(json);

        }
    });


})();
