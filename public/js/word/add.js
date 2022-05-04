/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***************************************!*\
  !*** ./resources/js/site/word/add.js ***!
  \***************************************/
var libraryId = document.querySelector('#content').dataset.id; ///////// Добавление слова

var edit_row_block = document.querySelector('.add-row-words');
var button_add = document.querySelectorAll('.block-add-word-button');
button_add.forEach(function (elem) {
  elem.addEventListener('click', function () {
    edit_row_block.insertAdjacentHTML('beforeend', "<div class=\"word-block\">\n                        <div class=\"header-block\"></div>\n                                <div class=\"definition-block\">\n                                    <input type=\"text\" required placeholder=\"\u0421\u043B\u043E\u0432\u043E (\u043D\u0430 \u0430\u043D\u0433\u043B\u0438\u0439\u0441\u043A\u043E\u043C)\" id=\"word\" >\n                                    <input type=\"text\" required placeholder=\"\u0421\u043B\u043E\u0432\u043E (\u043D\u0430 \u0440\u0443\u0441\u0441\u043A\u043E\u043C)\" id=\"translation\">\n                                    <p><textarea placeholder=\"\u041E\u0431\u044A\u044F\u0441\u043D\u0435\u043D\u0438\u0435\" id=\"description\"></textarea></p>\n                            </div>\n                           <div class=\"word-panel\">\n                                <a id=\"delete-word\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a>\n                                <a id=\"open-examples\">\u041F\u0440\u0438\u043C\u0435\u0440\u044B</a>\n                            </div>\n\n                            <div class=\"list-examples\">\n                                <a id=\"add-example\">\u0414\u043E\u0431\u0430\u0432\u0438\u0442\u044C \u043F\u0440\u0438\u043C\u0435\u0440</a>\n                                <br>\n\n                                <div class=\"example-block\">\n                                    <input type=\"text\" name=\"example\" placeholder=\"\u041F\u0440\u0438\u043C\u0435\u0440\">\n                                </div>\n                            </div>\n                        </div>\n                     </div>\n                    ");
    addSentences();
    deleteAction();
  });
}); ///////// Удаление блок-слова

function deleteAction() {
  var word_blocks = edit_row_block.querySelectorAll('.word-block');
  word_blocks.forEach(function (elem, key) {
    // Кнопка удаления
    var button_delete = elem.querySelector('#delete-word');
    button_delete.addEventListener('click', function () {
      // Количество блоков-слов
      var words_blocks_count = document.querySelector('.add-row-words').childElementCount;
      if (words_blocks_count <= 1) return;
      elem.remove();
    });
  });
}

deleteAction(); /// Примеры

function addSentences() {
  var word_blocks = document.querySelectorAll('.add-row-words .word-block');
  word_blocks.forEach(function (elem) {
    var blockExample = elem.querySelector('#open-examples'); // Если кто нажал на кнопку "Примеры"

    blockExample.addEventListener('click', function () {
      blockExample.removeEventListener('click', addSentences);
      var list_examples = elem.querySelector('.list-examples');

      if (!list_examples.classList.contains('open')) {
        list_examples.classList.toggle('open');
      } else {
        list_examples.classList.toggle('open');
        list_examples.querySelectorAll('.example-block').forEach(function (elem) {
          var input = elem.querySelector('input') ? elem.querySelector('input').value : null;

          if (input == '') {
            elem.querySelector('input').remove();
          }
        });
      }
    }); // Добавление нового примера

    elem.querySelector('#add-example').addEventListener('click', function () {
      elem.querySelector('.list-examples').insertAdjacentHTML('beforeend', "<div class=\"example-block\">\n                            <input type=\"text\" name=\"example\" placeholder=\"\u041F\u0440\u0438\u043C\u0435\u0440\">\n                        </div>");
    });
  });
}

addSentences(); ///////// Отправка слов на сохранение

var form = document.querySelector('#form');
form.addEventListener('submit', function (event) {
  event.preventDefault();
  var word_blocks = edit_row_block.querySelectorAll('.word-block');
  var data = [];
  word_blocks.forEach(function (elem, key) {
    var word = elem.querySelector('#word').value,
        translation = elem.querySelector('#translation').value,
        description = elem.querySelector('#description').value;
    data.push({
      word: word,
      translation: translation,
      description: description
    });
  });
  axios.post("/manage/library/".concat(libraryId, "/words/add"), {
    words: data
  }).then(function (response) {
    location.reload();
  })["catch"](function (error) {
    console.log(error.toJSON());
  });
});
/******/ })()
;