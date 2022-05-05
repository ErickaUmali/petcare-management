/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************!*\
  !*** ./resources/js/feedback.js ***!
  \**********************************/
var feedBackElement = document.querySelector('#feedback');
var starsContainer = feedBackElement.querySelector('.stars');
var starInput = feedBackElement.querySelector('input[type="number"]');
var clickedStar = false;
starsContainer.addEventListener('mouseleave', function () {
  if (!clickedStar && !starInput.value) {
    var stars = Array.from(starsContainer.children);

    for (var i = 0; i < stars.length; i++) {
      var src = 'http://192.168.100.80:8000/images/star-outline.svg';
      stars[i].setAttribute('src', src);
    }
  }
});
feedBackElement.addEventListener('mouseover', starMouseOver);
feedBackElement.addEventListener('click', starClick);

function starMouseOver(event) {
  if (!clickedStar && !starInput.value) {
    setStar(event);
  }
}

function starClick(event) {
  setStar(event);
}

function setStar(event) {
  if (event.target.nodeName == 'IMG') {
    Array.from(event.target.parentElement.children).forEach(function (element, index) {
      if (element == event.target) {
        var stars = Array.from(starsContainer.children);

        if (starsContainer.classList.contains('has-error')) {
          starsContainer.classList.remove('has-error');
        }

        for (var i = 0; i < stars.length; i++) {
          var src = '';

          if (i < index + 1) {
            src = 'http://192.168.100.80:8000/images/star-solid.svg';
          } else {
            src = 'http://192.168.100.80:8000/images/star-outline.svg';
          }

          stars[i].setAttribute('src', src);
        }

        if (event.type == 'click') {
          clickedStar = true;
          starInput.value = index + 1;
          var starErrorContainer = feedBackElement.querySelector('.star-error');

          if (starErrorContainer) {
            starErrorContainer.style.display = 'none';
          }
        }
      }
    });
  }
}
/******/ })()
;