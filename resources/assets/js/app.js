require('./bootstrap');

window.Vue = require('vue');
window.axios = window.axios = require('axios');
window.$ = window.jQuery = require('jquery');

import Takentabel from './components/takentabel';
import Ledentabel from './components/ledentabel';

const app = new Vue({
    el: '#main',
    data: {
        databasetaken: databasetaken,
        werknemers: werknemers
    },
    components: {
        Takentabel,
        Ledentabel
    }
});
