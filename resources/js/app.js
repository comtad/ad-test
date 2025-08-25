import $ from 'jquery';
window.$ = window.jQuery = $;
import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';


import 'popper.js';
import 'bootstrap';

import './header';
import './cart-trigger';

const notyf = new Notyf({
    duration: 2000,        // время показа
    position: { x: 'right', y: 'top' } // где показывать
});

window.addEventListener('cart:add', () => {
    notyf.success('Товар добавлен в корзину!');
});
