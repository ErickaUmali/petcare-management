/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/notif.js ***!
  \*******************************/
var notifications = document.querySelectorAll('.notification');
notifications.forEach(function (notification) {
  var buttonClose = notification.querySelector('button');
  buttonClose.addEventListener('click', function (event) {
    event.target.parentElement.classList.add('notification-animation');
  });
});
/******/ })()
;