
let notifyBlocks = document.querySelectorAll('.info');

notifyBlocks.forEach((value, key) => {
    value.querySelector('.close-arrow')
        .addEventListener('click', () => {
           value.remove();
    });
});
