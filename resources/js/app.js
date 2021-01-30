import Vue from 'vue'
import Vuex from 'vuex'
import router from './router.js'
import App from './App.vue'
import vuetify from './plugins/vuetify.js'
import './bootstrap.js'



Vue.use(Vuex)

const store = new Vuex.Store({
    state : {
        donate : 0
    },
    mutations:{
        increment(state){
            state.donate++
        }
    },
    actions: {

    }
})
const app = new Vue({
    el: '#app',
    store,
    router,
    vuetify,
    components: {
        App
    },
});

