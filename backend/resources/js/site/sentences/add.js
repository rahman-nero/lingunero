let libraryId = document.querySelector('#content').dataset.id;

///////// Добавление предложения
const edit_row_block = document.querySelector('.add-row-words');
const button_add = document.querySelectorAll('.block-add-word-button');

button_add.forEach(function (elem) {
    elem.addEventListener('click', function () {

        edit_row_block.insertAdjacentHTML('beforeend',
            `<div class="word-block">
                        <div class="header-block"></div>
                                <div class="definition-block">
                                    <input type="text" required placeholder="Предложение (на английском)" id="word" >
                                    <input type="text" required placeholder="Перевод (на русском)" id="translation">
                                </div>
                            <div class="word-panel">
                                <a id="delete-word"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </div>
                        </div>
                     </div>
                    `);
        deleteAction();
    })
})


///////// Удаление блок-предложении
function deleteAction() {
    const word_blocks = edit_row_block.querySelectorAll('.word-block');

    word_blocks.forEach(function (elem, key) {
        // Кнопка удаления
        let button_delete = elem.querySelector('#delete-word');

        button_delete.addEventListener('click', function () {
            // Количество блоков-предложении
            let words_blocks_count = document
                .querySelector('.add-row-words')
                .childElementCount;

            if (words_blocks_count <= 1) return;

            elem.remove();
        })
    })
}

deleteAction();


///////// Отправка предложении на сохранение
const form = document.querySelector('#form');

form.addEventListener('submit', function (event) {
    event.preventDefault()
    const word_blocks = edit_row_block.querySelectorAll('.word-block');
    let data = [];

    word_blocks.forEach(function (elem, key) {
        let
            sentence = elem.querySelector('#word').value,
            translation = elem.querySelector('#translation').value;
        data.push({
            sentence: sentence,
            translation: translation,
        })
    })

    axios.post(`/manage/library/${libraryId}/sentences/add`, {sentences: data})
        .then(function (response) {
            location.reload();
        })
        .catch(function (error) {
            console.log(error.toJSON());
        });
});

