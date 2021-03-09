const request = new XMLHttpRequest();

const url = "https://db7e115cdd5f.ngrok.io/api/instagram/posts?host=" + document.location.host;
console.log('start script');

request.open('GET', url);

request.setRequestHeader('Content-Type', 'application/x-www-form-url');
request.setRequestHeader('Access-Control-Allow-Origin','*');
request.setRequestHeader('Access-Control-Allow-Methods','GET');
request.setRequestHeader('Access-Control-Allow-Headers','X-Auth-Token,Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

request.addEventListener("readystatechange", () => {
    request.onload = function () {
        //console.log( request );
        if (request.response) {
            const posts = JSON.parse(request.response);
            initApp(posts);
        } else {
            return false;
        }
    };
});

request.send();

