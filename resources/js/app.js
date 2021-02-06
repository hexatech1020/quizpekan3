import Vue from 'vue'
import Vuex from 'vuex'
import router from './router.js'
import store from './store.js'
import App from './App.vue'
import vuetify from './plugins/vuetify.js'
import './bootstrap.js'


const app = new Vue({
    el: '#app',
    store,
    router,
    vuetify,
    components: {
        App
    },
});

