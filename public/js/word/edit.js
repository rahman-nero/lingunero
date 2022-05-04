/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************!*\
  !*** ./resources/js/site/word/edit.js ***!
  \****************************************/
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
    axios["delete"]("/manage/library/".concat(libraryId, "/words/").concat(id)).then(function (response) {
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
    var wordId = elem.dataset.id,
        word = elem.querySelector('#word').value,
        translation = elem.querySelector('#translation').value,
        description = elem.querySelector('#description').value;
    data.push({
      id: +wordId,
      word: word,
      translation: translation,
      description: description
    });
  });
  axios.post("/manage/library/".concat(libraryId, "/words/edit"), {
    words: data
  }).then(function (response) {
    // console.log(response)
    location.reload();
  })["catch"](function (error) {
    console.log(error.toJSON());
  });
}); ///////// Добавление/Удаление слов из избранных

var icons = {
  deleted: '<i class="fa fa-star-o" aria-hidden="true"></i>',
  added: '<i class="fa fa-star" aria-hidden="true"></i>'
};
word_blocks.forEach(function (elem) {
  var wordId = elem.dataset.id;
  elem.querySelector('.word-panel .add-favorite').addEventListener('click', function (e) {
    e.preventDefault();
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
      console.log('Кликнутый элемент', e.currentTarget);
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