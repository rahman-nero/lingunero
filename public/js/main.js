/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
var notifyBlocks = document.querySelectorAll('.info');
notifyBlocks.forEach(function (value, key) {
  value.querySelector('.close-arrow').addEventListener('click', function () {
    value.remove();
  });
});
/******/ })()
;