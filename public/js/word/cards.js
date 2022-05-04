/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************************!*\
  !*** ./resources/js/site/word/cards.js ***!
  \*****************************************/
// Slider
var slider = document.querySelector(".slider");
var slides = document.querySelectorAll(".slide");
var left = document.querySelector(".left");
var right = document.querySelector(".right");
var scrollValue = 0;
left.addEventListener("click", function () {
  scrollValue -= slider.scrollWidth / slides.length;

  if (scrollValue < 0) {
    scrollValue = slider.scrollWidth - slider.scrollWidth / slides.length;
  }

  console.log(scrollValue);
  slider.scrollLeft = scrollValue;
});
right.addEventListener("click", function () {
  scrollValue += slider.scrollWidth / slides.length;

  if (scrollValue >= slider.scrollWidth) {
    scrollValue = 0;
  }

  slider.scrollLeft = scrollValue;
}); // Переворачивание карточек

var cards = document.querySelectorAll('.slide .card');
cards.forEach(function (card) {
  card.addEventListener('click', function (e) {
    if (e.target.classList[0] != 'button-add-favorite' && e.target.parentNode.classList[0] != 'button-add-favorite') {
      card.classList.toggle('is-flip');
    }
  });
}); ///////// Добавление/Удаление слов из избранных

var icons = {
  deleted: '<i class="fa fa-star-o" aria-hidden="true"></i>',
  added: '<i class="fa fa-star" aria-hidden="true"></i>'
};
slides.forEach(function (elem) {
  var wordBlock = elem.querySelector('.card .word');
  var wordId = wordBlock.dataset.id;
  wordBlock.querySelector('.button-add-favorite').addEventListener('click', function (e) {
    var currentTarget = e.currentTarget; // Если это слово уже добавлено в избранные, то выполняем запрос на удаление из избранного

    if (e.currentTarget.className.includes('added')) {
      axios["delete"]("/user/favorites/".concat(wordId, "/ajax")).then(function (response) {
        if (response.data.code == 200) {
          currentTarget.innerHTML = '';
          currentTarget.classList.remove('added');
          currentTarget.insertAdjacentHTML('beforeend', icons.deleted);
        }
      });
    } else {
      // Если слово не находится в избранных, то добавляем
      axios.post("/user/favorites/".concat(wordId)).then(function (response) {
        if (response.data.code == 200) {
          currentTarget.innerHTML = '';
          currentTarget.classList.add('added');
          currentTarget.insertAdjacentHTML('beforeend', icons.added);
        }
      });
    }
  });
});
/******/ })()
;