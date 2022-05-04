/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************************!*\
  !*** ./resources/js/site/sentences/statistic.js ***!
  \**************************************************/
var loaded_bar = document.querySelector('.loaded');
var percent = document.querySelector('.percent');
var countWords = document.querySelector('.count-words').dataset.count;
var countWrong = document.querySelector('.count-wrong').dataset.count;
var countTrue = document.querySelector('.count-right').dataset.count;
console.log(countWords, countTrue, countWrong);
console.log(countTrue / (countWords / 100));
var result = countTrue / (countWords / 100); // Указываем проценты для блока с загрузки

loaded_bar.style.width = "".concat(result, "%");
var percent_show = setInterval(function () {
  if (+percent.innerHTML < Math.trunc(+result)) {
    percent.innerHTML = +percent.innerHTML + 1;
  } else {
    clearInterval(percent_show);
  }
}, 30);
/******/ })()
;