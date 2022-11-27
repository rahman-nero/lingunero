let list_blocks = document.querySelectorAll('.list-block');

list_blocks.forEach(function (elem, key) {
    elem.style.backgroundImage = "url(" + elem.dataset.background + ")";
});
