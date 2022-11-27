let libraryId = document.querySelector('#content').dataset.id;

///////// Добавление слова
const edit_row_block = document.querySelector('.add-row-words');
const button_add = document.querySelectorAll('.block-add-word-button');

button_add.forEach(function (elem) {
    elem.addEventListener('click', function () {

        edit_row_block.insertAdjacentHTML('beforeend',
            `<div class="word-block">
                        <div class="header-block"></div>
                                <div class="definition-block">
                                    <input type="text" required placeholder="Слово (на английском)" id="word" >
                                    <input type="text" required placeholder="Слово (на русском)" id="translation">
                                    <p><textarea placeholder="Объяснение" id="description"></textarea></p>
                            </div>
                           <div class="word-panel">
                                <a id="delete-word"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                <a id="open-examples">Примеры</a>
                            </div>

                            <div class="list-examples">
                                <a id="add-example">Добавить пример</a>
                                <br>

                                <div class="example-block">
                                    <input type="text" name="example" placeholder="Пример">
                                </div>
                            </div>
                        </div>
                     </div>
                    `);
        addSentences();
        deleteAction();
    })
})


///////// Удаление блок-слова
function deleteAction() {
    const word_blocks = edit_row_block.querySelectorAll('.word-block');

    word_blocks.forEach(function (elem, key) {
        // Кнопка удаления
        let button_delete = elem.querySelector('#delete-word');

        button_delete.addEventListener('click', function () {
            // Количество блоков-слов
            let words_blocks_count = document
                .querySelector('.add-row-words')
                .childElementCount;

            if (words_blocks_count <= 1) return;

            elem.remove();
        })
    })
}

deleteAction();


/// Примеры
function addSentences() {
    const word_blocks = document.querySelectorAll('.add-row-words .word-block');

    word_blocks.forEach(function (elem) {

        let blockExample = elem.querySelector('#open-examples');
        // Если кто нажал на кнопку "Примеры"

        blockExample.addEventListener('click', function () {

            blockExample.removeEventListener('click', addSentences);

            let list_examples = elem.querySelector('.list-examples');

            if (!list_examples.classList.contains('open')) {
                list_examples.classList.toggle('open');
            } else {
                list_examples.classList.toggle('open');

                list_examples.querySelectorAll('.example-block')
                    .forEach(function (elem) {

                        const input = elem.querySelector('input') ?
                            elem.querySelector('input').value :
                            null;

                        if (input == '') {
                            elem.querySelector('input').remove();
                        }

                    })
            }

        });

        // Добавление нового примера
        elem.querySelector('#add-example').addEventListener('click', function () {
            elem
                .querySelector('.list-examples')
                .insertAdjacentHTML('beforeend',
                    `<div class="example-block">
                            <input type="text" name="example" placeholder="Пример">
                        </div>`
                );
        });


    });
}

addSentences();

///////// Отправка слов на сохранение
const form = document.querySelector('#form');

form.addEventListener('submit', function (event) {
    event.preventDefault()
    const word_blocks = edit_row_block.querySelectorAll('.word-block');
    let data = [];

    word_blocks.forEach(function (elem, key) {
        let
            word = elem.querySelector('#word').value,
            translation = elem.querySelector('#translation').value,
            description = elem.querySelector('#description').value;

        data.push({
            word: word,
            translation: translation,
            description: description,
        })
    })

    axios.post(`/manage/library/${libraryId}/words/add`, {words: data})
        .then(function (response) {
            location.reload();
        })
        .catch(function (error) {
            console.log(error.toJSON());
        });
});
