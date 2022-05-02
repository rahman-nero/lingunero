/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
var infoBlocks = document.querySelectorAll('.info');
infoBlocks.forEach(function (value, key) {
  value.querySelector('.close-arrow').addEventListener('click', function () {
    value.remove();
  });
});
/******/ })()
;