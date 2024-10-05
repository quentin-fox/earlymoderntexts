(function () {

    'use strict';

    var i, toggles;

    document.getElementById('author').addEventListener('change', function () {
        window.location = this.value;
    });

    document.getElementById('search').addEventListener('submit', function (e) {
        if (this.getElementsByTagName('input')[0].value === '') {
            e.preventDefault();
        }
    });

    toggles = document.querySelectorAll('[data-action="toggle"]');
    for (i = 0; i < toggles.length; i++) {
        toggles[i].addEventListener('click', function () {
            this.nextSibling.classList.toggle('active');
        });
    }

})();