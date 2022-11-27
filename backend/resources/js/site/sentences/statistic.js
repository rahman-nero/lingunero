const loaded_bar = document.querySelector('.loaded');
const percent = document.querySelector('.percent');

const countWords = document.querySelector('.count-words').dataset.count;
const countWrong = document.querySelector('.count-wrong').dataset.count;
const countTrue = document.querySelector('.count-right').dataset.count;


console.log(countWords, countTrue, countWrong)
console.log(countTrue / (countWords / 100))

const result = countTrue / (countWords / 100);

// Указываем проценты для блока с загрузки
loaded_bar.style.width = `${result}%`;

let percent_show = setInterval(function () {
    if (+percent.innerHTML < Math.trunc(+result)) {
        percent.innerHTML = +percent.innerHTML + 1
    } else {
        clearInterval(percent_show);
    }
}, 30);
