require("./bootstrap");
import Vue from "vue";

import GameMatch from "./components/GameMatch";
import LoginForm from "./components/LoginForm";

const app = new Vue({
    el: "#app",
    components: { GameMatch, LoginForm },
});
