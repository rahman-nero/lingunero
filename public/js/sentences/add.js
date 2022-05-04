/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************!*\
  !*** ./resources/js/site/sentences/add.js ***!
  \********************************************/
var libraryId = document.querySelector('#content').dataset.id; ///////// Добавление предложения

var edit_row_block = document.querySelector('.add-row-words');
var button_add = document.querySelectorAll('.block-add-word-button');
button_add.forEach(function (elem) {
  elem.addEventListener('click', function () {
    edit_row_block.insertAdjacentHTML('beforeend', "<div class=\"word-block\">\n                        <div class=\"header-block\"></div>\n                                <div class=\"definition-block\">\n                                    <input type=\"text\" required placeholder=\"\u041F\u0440\u0435\u0434\u043B\u043E\u0436\u0435\u043D\u0438\u0435 (\u043D\u0430 \u0430\u043D\u0433\u043B\u0438\u0439\u0441\u043A\u043E\u043C)\" id=\"word\" >\n                                    <input type=\"text\" required placeholder=\"\u041F\u0435\u0440\u0435\u0432\u043E\u0434 (\u043D\u0430 \u0440\u0443\u0441\u0441\u043A\u043E\u043C)\" id=\"translation\">\n                                </div>\n                            <div class=\"word-panel\">\n                                <a id=\"delete-word\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a>\n                            </div>\n                        </div>\n                     </div>\n                    ");
    deleteAction();
  });
}); ///////// Удаление блок-предложении

function deleteAction() {
  var word_blocks = edit_row_block.querySelectorAll('.word-block');
  word_blocks.forEach(function (elem, key) {
    // Кнопка удаления
    var button_delete = elem.querySelector('#delete-word');
    button_delete.addEventListener('click', function () {
      // Количество блоков-предложении
      var words_blocks_count = document.querySelector('.add-row-words').childElementCount;
      if (words_blocks_count <= 1) return;
      elem.remove();
    });
  });
}

deleteAction(); ///////// Отправка предложении на сохранение

var form = document.querySelector('#form');
form.addEventListener('submit', function (event) {
  event.preventDefault();
  var word_blocks = edit_row_block.querySelectorAll('.word-block');
  var data = [];
  word_blocks.forEach(function (elem, key) {
    var sentence = elem.querySelector('#word').value,
        translation = elem.querySelector('#translation').value;
    data.push({
      sentence: sentence,
      translation: translation
    });
  });
  axios.post("/manage/library/".concat(libraryId, "/sentences/add"), {
    sentences: data
  }).then(function (response) {
    location.reload();
  })["catch"](function (error) {
    console.log(error.toJSON());
  });
});
/******/ })()
;