let libraryId = document.querySelector('#content').dataset.id;

///////// Удаление слова
const word_blocks = document.querySelectorAll('.edit-row-words .word-block');

word_blocks.forEach(function (elem) {
    // Кнопка удаления
    let button_delete = elem.querySelector('#delete-word');

    button_delete.addEventListener('click', function () {
        // Количество блоков-слов
        let words_blocks_count = document
            .querySelector('.edit-row-words')
            .childElementCount;

        if (words_blocks_count <= 1) return;

        const id = elem.dataset.id;

        axios.delete(`/manage/library/${libraryId}/sentences/${id}`)
            .then(function (response) {
                elem.remove();
            })
            .catch(function (error) {
                alert(error.toString())
                console.log(error.toJSON());
            });

    })
});


///////// Отправка слов на сохранение
const form = document.querySelector('#form');

form.addEventListener('submit', function (event) {
    event.preventDefault();

    const word_blocks = document.querySelectorAll('.edit-row-words .word-block');

    let data = [];
    word_blocks.forEach(function (elem, key) {
        let
            sentenceId = elem.dataset.id,
            sentence = elem.querySelector('#word').value,
            translation = elem.querySelector('#translation').value;
        data.push({
            id: +sentenceId,
            sentence: sentence,
            translation: translation,
        })
    })

    axios.post(`/manage/library/${libraryId}/sentences/edit`, {sentences: data})
        .then(function (response) {
            // console.log(response)
            location.reload();
        })
        .catch(function (error) {
            console.log(error.toJSON());
        });
});
