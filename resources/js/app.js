require('./bootstrap');
import Vue from 'vue'

import Match from './components/Match'
import LoginForm from './components/LoginForm'

const app = new Vue({
    el: "#app",
    components: { Match, LoginForm },
    created() {
        // For extra security
        console.log("Puto el que hackeé")
    }
});
