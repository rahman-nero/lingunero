/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************************!*\
  !*** ./resources/js/site/sentences/edit.js ***!
  \*********************************************/
var libraryId = document.querySelector('#content').dataset.id; ///////// Удаление слова

var word_blocks = document.querySelectorAll('.edit-row-words .word-block');
word_blocks.forEach(function (elem) {
  // Кнопка удаления
  var button_delete = elem.querySelector('#delete-word');
  button_delete.addEventListener('click', function () {
    // Количество блоков-слов
    var words_blocks_count = document.querySelector('.edit-row-words').childElementCount;
    if (words_blocks_count <= 1) return;
    var id = elem.dataset.id;
    axios["delete"]("/manage/library/".concat(libraryId, "/sentences/").concat(id)).then(function (response) {
      elem.remove();
    })["catch"](function (error) {
      alert(error.toString());
      console.log(error.toJSON());
    });
  });
}); ///////// Отправка слов на сохранение

var form = document.querySelector('#form');
form.addEventListener('submit', function (event) {
  event.preventDefault();
  var word_blocks = document.querySelectorAll('.edit-row-words .word-block');
  var data = [];
  word_blocks.forEach(function (elem, key) {
    var sentenceId = elem.dataset.id,
        sentence = elem.querySelector('#word').value,
        translation = elem.querySelector('#translation').value;
    data.push({
      id: +sentenceId,
      sentence: sentence,
      translation: translation
    });
  });
  axios.post("/manage/library/".concat(libraryId, "/sentences/edit"), {
    sentences: data
  }).then(function (response) {
    // console.log(response)
    location.reload();
  })["catch"](function (error) {
    console.log(error.toJSON());
  });
});
/******/ })()
;