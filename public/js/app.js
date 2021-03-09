/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

//require('./bootstrap');
window.urlAjax = "https://7910c053feef.ngrok.io";

__webpack_require__(/*! ./popup */ "./resources/js/popup.js");

__webpack_require__(/*! ./pointer */ "./resources/js/pointer.js");

__webpack_require__(/*! ./search */ "./resources/js/search.js");

__webpack_require__(/*! ./repoint */ "./resources/js/repoint.js");

__webpack_require__(/*! ./payment */ "./resources/js/payment.js");

/***/ }),

/***/ "./resources/js/payment.js":
/*!*********************************!*\
  !*** ./resources/js/payment.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

function payPlan() {
  e.preventDefault();
  var bodyFormData = new FormData();
  bodyFormData.set('plan', '1');
  axios({
    method: 'post',
    url: '/plans/pay',
    data: bodyFormData,
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  }).then(function (response) {
    console.log(response);
  })["catch"](function (response) {
    console.log(response);
  });
}

/***/ }),

/***/ "./resources/js/pointer.js":
/*!*********************************!*\
  !*** ./resources/js/pointer.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

;

(function () {
  document.addEventListener("DOMContentLoaded", addClickListener);

  function addClickListener() {
    var canvas = document.getElementById('canvas');
    canvas.addEventListener('click', function (e) {
      var rect = e.target.getBoundingClientRect();
      createDot(getCoords(rect, e), rect);
      console.log(getCoords(rect, e));
    });
  }

  function getAllDots() {
    return document.getElementsByClassName('dot-point').length;
  }

  function createDot(coords, rect) {
    var elt = 16 * 100 / rect.width;

    if (document.querySelectorAll('div[data-type="unsaved"]').length != 0) {
      document.querySelector('div[data-type="unsaved"]').style.left = coords.left - elt + "%";
      document.querySelector('div[data-type="unsaved"]').style.top = coords.top - elt + "%";
    } else {
      var div = document.createElement('div');
      div.className = "dot-point";
      div.innerText = getAllDots() + 1;
      div.style.cssText = "top: " + (coords.top - elt) + "%; left: " + (coords.left - elt) + "%;";
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
    };
  }
})();

/***/ }),

/***/ "./resources/js/popup.js":
/*!*******************************!*\
  !*** ./resources/js/popup.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

;

(function () {
  document.addEventListener("DOMContentLoaded", addButtonListeners);
  var urlHost = window.urlAjax;

  function addButtonListeners() {
    var buttons = document.querySelectorAll('.image-post .set_tag_button');
    var close = document.querySelector('#overlay');
    var closeButton = document.querySelector('.tags-profile svg');
    var publishButtons = Array.from(document.getElementsByClassName('publish_button'));
    var tagContainer = document.querySelector('.tags-list');
    var resultList = document.querySelector('ul[data-type="result-list"]');
    var canvas = document.getElementById('canvas');
    close.addEventListener('click', function () {
      closePop();
    });
    closeButton.addEventListener('click', function () {
      closePop();
    });
    tagContainer.addEventListener('click', function (event) {
      if (event.target.closest('svg')) {
        var request = new XMLHttpRequest();
        url = urlHost + '/api/item/image/dot/unset';
        request.open('POST', url);
        request.setRequestHeader('Content-Type', 'application/x-www-form-url');
        request.setRequestHeader('Access-Control-Allow-Origin', '*');
        request.setRequestHeader('Access-Control-Allow-Methods', 'POST');
        request.setRequestHeader('Access-Control-Allow-Headers', 'X-Auth-Token,Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
        json = JSON.stringify({
          id_post_del: event.target.closest('svg').getAttribute('data-id-post')
        });
        request.addEventListener("readystatechange", function () {
          request.onload = function () {
            if (request.response) {
              response = JSON.parse(request.response);
              document.querySelector('.dot-point[data-id="' + response + '"]').remove();
              document.querySelector('.list-item[data-id-post="' + response + '"]').remove();
              console.log(response);
            }
          };
        });
        request.send(json);
      }
    });
    publishButtons.forEach(function (button) {
      button.addEventListener('click', function (event) {
        if (!event.currentTarget.classList.contains("unpublish")) {
          setPublish(button);
        } else {
          setUnPublish(button);
        }
      });
    });

    buttons.forEach(function (button) {
      button.addEventListener('click', function () {
        showPop(button);
      });
    });
  }

  function togglePublish(item) {
    item.classList.toggle('unpublish');
  }

  function closePop() {
    document.querySelector('#overlay').style.display = 'none';
    document.querySelector('#popup_window').style.display = 'none';
    document.querySelector('.tags-form').style.display = 'none';
    if (document.querySelector('div[data-type="result-list-container"]').classList.contains("Polaris-Popover__PopoverOverlay--open")) document.querySelector('div[data-type="result-list-container"]').classList.remove("Polaris-Popover__PopoverOverlay--open"); //document.querySelector('ul[data-type="result-list"]').innerHTML = "";

    document.querySelector('input[data-type="search"]').value = "";
    document.querySelectorAll('div.dot-point').forEach(function (item) {
      item.remove();
    });
    document.querySelector('.tags-list').innerHTML = "";
  }

  function setUnPublish(button) {
    var request = new XMLHttpRequest();
    var url = urlHost + "/api/item/unpublish";
    request.open('POST', url);
    request.setRequestHeader('Content-Type', 'application/x-www-form-url');
    request.setRequestHeader('Access-Control-Allow-Origin', '*');
    request.setRequestHeader('Access-Control-Allow-Methods', 'POST');
    request.setRequestHeader('Access-Control-Allow-Headers', 'X-Auth-Token,Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    json = JSON.stringify({
      id: button.dataset.img
    });
    button.classList.add("Polaris-Button--disabled");
    button.classList.add("Polaris-Button--loading");
    button.classList.add("Polaris-Button--primary");
    request.addEventListener("readystatechange", function () {
      request.onload = function () {
        if (request.response) {
          button.classList.remove("Polaris-Button--disabled");
          button.classList.remove("Polaris-Button--loading");
          document.querySelector('.Polaris-Badge--statusSuccess[data-item-bage="' + button.dataset.img + '"]').style.display = 'none';
          togglePublish(button);
          response = JSON.parse(request.response);
        }
      };
    });
    request.send(json);
  }

  function setPublish(button) {
    var request = new XMLHttpRequest();
    var url = urlHost + "/api/item/publish";
    request.open('POST', url);
    request.setRequestHeader('Content-Type', 'application/x-www-form-url');
    request.setRequestHeader('Access-Control-Allow-Origin', '*');
    request.setRequestHeader('Access-Control-Allow-Methods', 'POST');
    request.setRequestHeader('Access-Control-Allow-Headers', 'X-Auth-Token,Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    json = JSON.stringify({
      id: button.dataset.img
    });
    button.classList.add("Polaris-Button--disabled");
    button.classList.add("Polaris-Button--loading");
    request.addEventListener("readystatechange", function () {
      request.onload = function () {
        if (request.response) {
          button.classList.remove("Polaris-Button--primary");
          button.classList.remove("Polaris-Button--disabled");
          button.classList.remove("Polaris-Button--loading");
          document.querySelector('.Polaris-Badge--statusSuccess[data-item-bage="' + button.dataset.img + '"]').style.display = 'block';
          togglePublish(button);
          response = JSON.parse(request.response);
        }
      };
    });
    request.send(json);
  }

  function showPop(button) {
    var request = new XMLHttpRequest();
    var url = urlHost + "/api/popup?post=" + button.dataset.img;
    document.querySelector('#overlay').style.display = 'flex';
    document.querySelector('#preloader').style.display = 'flex';
    request.open('GET', url);
    request.setRequestHeader('Content-Type', 'application/x-www-form-url');
    request.setRequestHeader('Access-Control-Allow-Origin', '*');
    request.setRequestHeader('Access-Control-Allow-Methods', 'GET');
    request.setRequestHeader('Access-Control-Allow-Headers', 'X-Auth-Token,Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    request.addEventListener("readystatechange", function () {
      request.onload = function () {
        if (request.response) {
          post = JSON.parse(request.response);
          document.querySelector('#popup_window').style.display = 'flex';
          preloader.style.display = "none";
          document.querySelector('.image_view img').src = post['post']['post_media_url'];
          document.querySelector('#instagram_username').innerHTML = '@' + post['post']['post_username'];
          document.querySelector('#popup_window').setAttribute('data-post', post['post']['id']);
          document.querySelector('.tags-profile img').src = post['pic_user'];
          post['dots'].forEach(function (dot, i) {
            if (!dot['product_image']) dot['product_image'] = "";
            var div = document.createElement('div');
            div.className = "dot-point saved-dot";
            div.innerText = i + 1;
            div.style.cssText = "top: " + dot['serialized_coords']['top'] + "%; left: " + dot['serialized_coords']['left'] + "%;";
            div.setAttribute('data-type', 'saved');
            div.setAttribute('data-left', dot['serialized_coords']['left']);
            div.setAttribute('data-top', dot['serialized_coords']['top']);
            div.setAttribute('data-id', dot['id']);
            document.getElementById('image_view').appendChild(div);
            var divLi = document.createElement('div');
            divLi.className = "list-item";
            divLi.innerHTML = '<img src="' + dot['product_image'] + '" alt=""><p>' + dot['product_name'] + '</p><svg data-id-post="' + dot["id"] + '" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="Polaris-icon/Minor/Mono/Delete"><path id="Icon" fill-rule="evenodd" clip-rule="evenodd" d="M11 16H14V8H11V16ZM6 16H9V8H6V16ZM8 6H12V4H8V6ZM17 6H14V4C14 2.897 13.103 2 12 2H8C6.897 2 6 2.897 6 4V6H3C2.447 6 2 6.448 2 7C2 7.552 2.447 8 3 8H4V17C4 17.552 4.447 18 5 18H15C15.553 18 16 17.552 16 17V8H17C17.553 8 18 7.552 18 7C18 6.448 17.553 6 17 6Z" fill="#637381"/><mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="2" y="2" width="16" height="16"><path id="Icon_2" fill-rule="evenodd" clip-rule="evenodd" d="M11 16H14V8H11V16ZM6 16H9V8H6V16ZM8 6H12V4H8V6ZM17 6H14V4C14 2.897 13.103 2 12 2H8C6.897 2 6 2.897 6 4V6H3C2.447 6 2 6.448 2 7C2 7.552 2.447 8 3 8H4V17C4 17.552 4.447 18 5 18H15C15.553 18 16 17.552 16 17V8H17C17.553 8 18 7.552 18 7C18 6.448 17.553 6 17 6Z" fill="white"/></mask><g mask="url(#mask0)"></g></g></svg>';
            divLi.setAttribute('data-id-post', dot["id"]);
            document.querySelector('.tags-list').appendChild(divLi);
          });
        } else {
          return false;
        }
      };
    });
    request.send();
  }
})();

/***/ }),

/***/ "./resources/js/repoint.js":
/*!*********************************!*\
  !*** ./resources/js/repoint.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

;

(function () {
  var urlHost = window.urlAjax;
  var canvas = document.querySelector('#image_view');
  var dot = null;

  var updateCoordsAjax = function updateCoordsAjax(dot) {
    var request = new XMLHttpRequest();
    url = urlHost + '/api/item/image/dot/update';
    request.open('POST', url);
    request.setRequestHeader('Content-Type', 'application/x-www-form-url');
    request.setRequestHeader('Access-Control-Allow-Origin', '*');
    request.setRequestHeader('Access-Control-Allow-Methods', 'POST');
    request.setRequestHeader('Access-Control-Allow-Headers', 'X-Auth-Token,Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    var json = JSON.stringify({
      id: dot.getAttribute('data-id'),
      coord_left: dot.getAttribute('data-left'),
      coord_top: dot.getAttribute('data-top')
    });
    request.addEventListener("readystatechange", function () {
      request.onload = function () {
        if (request.response) {
          console.log(true);
        }
      };
    });
    request.send(json);
  };

  var onMouseMove = function onMouseMove(e) {
    var rect = canvas.getBoundingClientRect();
    var elt = 16 * 100 / rect.width;
    var left = 100 * (e.clientX - rect.left) / rect.width;
    var top = 100 * (e.clientY - rect.top) / rect.height;
    if (left > 100) left = 100;
    if (left < 0) left = 0;
    if (top > 100) top = 100;
    if (top < 0) top = 0;
    dot.style.left = left - elt + '%';
    dot.style.top = top - elt + '%';
    dot.setAttribute('data-left', left - elt);
    dot.setAttribute('data-top', top - elt);
  };

  var onMouseUp = function onMouseUp(e) {
    document.removeEventListener('mousemove', onMouseMove);
    document.removeEventListener('mouseup', onMouseUp);
    dot.classList.remove('moved-dot');
    updateCoordsAjax(dot);
  };

  var onMouseDown = function onMouseDown(e) {
    if (e.target.classList.contains('saved-dot')) {
      e.preventDefault();
      dot = e.target;
      dot.classList.add('moved-dot');
      document.addEventListener('mousemove', onMouseMove);
      document.addEventListener('mouseup', onMouseUp);
    }
  };

  canvas.addEventListener('mousedown', onMouseDown);
})();

/***/ }),

/***/ "./resources/js/search.js":
/*!********************************!*\
  !*** ./resources/js/search.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

;

(function () {
  var TIME_OUT = 500;
  var input = document.querySelector('input[data-type="search"]');
  var resultList = document.querySelector('ul[data-type="result-list"]');
  var resultListContainer = document.querySelector('div[data-type="result-list-container"]');
  var urlHost = window.urlAjax;
  var timer = null;

  var ajax = function ajax(q, shop) {
    var request = new XMLHttpRequest();
    var url = urlHost + '/api/admin/shop/products?shop_id=' + shop + "&query=" + q;
    request.open('GET', url);
    request.setRequestHeader('Content-Type', 'application/x-www-form-url');
    request.setRequestHeader('Access-Control-Allow-Origin', '*');
    request.setRequestHeader('Access-Control-Allow-Methods', 'GET');
    request.setRequestHeader('Access-Control-Allow-Headers', 'X-Auth-Token,Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    request.addEventListener("readystatechange", function () {
      request.onload = function () {
        resultList.innerHTML = "";

        if (request.response) {
          post = JSON.parse(request.response);
          post.forEach(function (element) {
            resultList.innerHTML += '<li data-item="' + element.id + '" class="Polaris-OptionList-Option" tabindex="-1" role="option"><button id="PolarisComboBox4-0" type="button" class="Polaris-OptionList-Option__SingleSelectOption">' + element.title + '</button></li>';
          });
          console.log(resultListContainer);
          console.log(document.querySelectorAll('li[role="option"]').length);
          if (document.querySelectorAll('li[role="option"]').length > 0) resultListContainer.classList.add("Polaris-Popover__PopoverOverlay--open");else resultListContainer.classList.remove("Polaris-Popover__PopoverOverlay--open");
          console.log(post);
        } else {
          return false;
        }
      };
    });
    request.send();
  };

  input.addEventListener('input', function (e) {
    var _this = this;

    if (timer) {
      clearTimeout(timer);
      timer = setTimeout(function () {
        return ajax(_this.value, _this.getAttribute('data-shop-id'));
      }, TIME_OUT);
    } else {
      timer = setTimeout(function () {
        return ajax(_this.value, _this.getAttribute('data-shop-id'));
      }, TIME_OUT);
    }
  });
  resultList.addEventListener('click', function (e) {
    var item = e.target.closest('li');

    if (item) {
      var request = new XMLHttpRequest();
      var url = urlHost + '/api/item/image/dot/set';
      request.open('POST', url);
      request.setRequestHeader('Content-Type', 'application/x-www-form-url');
      request.setRequestHeader('Access-Control-Allow-Origin', '*');
      request.setRequestHeader('Access-Control-Allow-Methods', 'POST');
      request.setRequestHeader('Access-Control-Allow-Headers', 'X-Auth-Token,Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
      json = JSON.stringify({
        id_product: item.getAttribute('data-item'),
        coord_left: document.querySelector('div[data-type="unsaved"]').getAttribute('data-left'),
        coord_top: document.querySelector('div[data-type="unsaved"]').getAttribute('data-top'),
        id: document.querySelector('#popup_window').getAttribute('data-post'),
        shop_id: input.getAttribute('data-shop-id')
      });
      request.addEventListener("readystatechange", function () {
        request.onload = function () {
          if (request.response) {
            response = JSON.parse(request.response);
            document.querySelector('div[data-type="unsaved"]').classList.add('saved-dot');
            document.querySelector('div[data-type="unsaved"]').setAttribute('data-id', response[0]['id']);
            document.querySelector('div[data-type="unsaved"]').setAttribute('data-type', 'saved');
            var divLi = document.createElement('div');
            divLi.className = "list-item";
            divLi.innerHTML = '<img src="' + response[0]['product_image'] + '" alt=""><p>' + response[0]['product_name'] + '</p><svg data-id-post="' + response[0]["id"] + '" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="Polaris-icon/Minor/Mono/Delete"><path id="Icon" fill-rule="evenodd" clip-rule="evenodd" d="M11 16H14V8H11V16ZM6 16H9V8H6V16ZM8 6H12V4H8V6ZM17 6H14V4C14 2.897 13.103 2 12 2H8C6.897 2 6 2.897 6 4V6H3C2.447 6 2 6.448 2 7C2 7.552 2.447 8 3 8H4V17C4 17.552 4.447 18 5 18H15C15.553 18 16 17.552 16 17V8H17C17.553 8 18 7.552 18 7C18 6.448 17.553 6 17 6Z" fill="#637381"/><mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="2" y="2" width="16" height="16"><path id="Icon_2" fill-rule="evenodd" clip-rule="evenodd" d="M11 16H14V8H11V16ZM6 16H9V8H6V16ZM8 6H12V4H8V6ZM17 6H14V4C14 2.897 13.103 2 12 2H8C6.897 2 6 2.897 6 4V6H3C2.447 6 2 6.448 2 7C2 7.552 2.447 8 3 8H4V17C4 17.552 4.447 18 5 18H15C15.553 18 16 17.552 16 17V8H17C17.553 8 18 7.552 18 7C18 6.448 17.553 6 17 6Z" fill="white"/></mask><g mask="url(#mask0)"></g></g></svg>';
            divLi.setAttribute('data-id-post', response[0]["id"]);
            document.querySelector('.tags-list').appendChild(divLi);
            if (document.querySelector('div[data-type="result-list-container"]').classList.contains("Polaris-Popover__PopoverOverlay--open")) document.querySelector('div[data-type="result-list-container"]').classList.remove("Polaris-Popover__PopoverOverlay--open"); //document.querySelector('ul[data-type="result-list"]').innerHTML = "";

            document.querySelector('input[data-type="search"]').value = "";
            document.querySelector('.tags-form').style.display = 'none';
            document.querySelector('button[data-img="' + response[0]['post_id'] + '"]');
            var numbers_dot = Number.parseInt(document.querySelector('button[data-update-img="' + response[0]['post_id'] + '"]').querySelector('.Polaris-Button__Text').textContent.split('(').pop().split(')')[0]);
            if (numbers_dot) document.querySelector('button[data-update-img="' + response[0]['post_id'] + '"]').querySelector('.Polaris-Button__Text').innerHTML = 'Tags products (' + (numbers_dot + 1) + ')';else document.querySelector('button[data-update-img="' + response[0]['post_id'] + '"]').querySelector('.Polaris-Button__Text').innerHTML = 'Tags products (1)';
          }
        };
      });
      request.send(json);
    }
  });
})();

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! C:\openserver\domains\shopify-app\resources\js\app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! C:\openserver\domains\shopify-app\resources\sass\app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });
