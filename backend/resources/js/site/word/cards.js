// Slider
const slider = document.querySelector(".slider");
const slides = document.querySelectorAll(".slide");
const left = document.querySelector(".left");
const right = document.querySelector(".right");
let scrollValue = 0;

left.addEventListener("click", () => {
    scrollValue -= slider.scrollWidth / slides.length;

    if (scrollValue < 0) {
        scrollValue = slider.scrollWidth - (slider.scrollWidth / slides.length);
    }

    console.log(scrollValue);
    slider.scrollLeft = scrollValue;
});

right.addEventListener("click", () => {
    scrollValue += slider.scrollWidth / slides.length;

    if (scrollValue >= slider.scrollWidth) {
        scrollValue = 0;
    }

    slider.scrollLeft = scrollValue;
});

// Переворачивание карточек
const cards = document.querySelectorAll('.slide .card');
cards.forEach(function (card) {

    card.addEventListener('click', (e) => {
        if (
            e.target.classList[0] != 'button-add-favorite'
            && e.target.parentNode.classList[0] != 'button-add-favorite'
            && e.target.parentNode.classList[0] != 'voice'
        ) {
            card.classList.toggle('is-flip');
        }

    });
})


///////// Добавление/Удаление слов из избранных

const icons = {
    deleted: '<i class="fa fa-star-o" aria-hidden="true"></i>',
    added: '<i class="fa fa-star" aria-hidden="true"></i>'
};

slides.forEach((elem) => {
    let wordBlock = elem.querySelector('.card .word')
    let wordId = wordBlock.dataset.id;

    wordBlock.querySelector('.button-add-favorite')
        .addEventListener('click', (e) => {
            let currentTarget = e.currentTarget;

            // Если это слово уже добавлено в избранные, то выполняем запрос на удаление из избранного
            if (e.currentTarget.className.includes('added')) {
                axios.delete(`/user/favorites/${wordId}/ajax`).then(function (response) {

                    if (response.data.code == 200) {
                        currentTarget.innerHTML = '';
                        currentTarget.classList.remove('added');
                        currentTarget.insertAdjacentHTML('beforeend', icons.deleted)
                    }
                });

            } else { // Если слово не находится в избранных, то добавляем
                axios.post(`/user/favorites/${wordId}`).then(function (response) {

                    if (response.data.code == 200) {
                        currentTarget.innerHTML = '';
                        currentTarget.classList.add('added');
                        currentTarget.insertAdjacentHTML('beforeend', icons.added)
                    }

                });
            }

        });


});


// Text to speech a text (word or sentences)
const voice = document.querySelectorAll('.voice');

voice.forEach((elem, key) => {
    elem.addEventListener('click', (e) => {
        let text = e.currentTarget.dataset.text;

        new Audio(`https://translate.google.com/translate_tts?q=${text}&tl=en&client=duncan3dc-speaker`)
            .play()
            .catch(() => {
                new Audio(`https://tts.voicetech.yandex.net/tts?text=${text}`).play();
            });
    })

})
