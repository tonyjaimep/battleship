require('./bootstrap');
import Vue from 'vue'

import Match from './components/Match'

const app = new Vue({
    el: "#app",
    components: { Match },
});
