

let infoBlocks = document.querySelectorAll('.info');

infoBlocks.forEach((value, key) => {
    value.querySelector('.close-arrow')
        .addEventListener('click', () => {
           value.remove();
    });
});
