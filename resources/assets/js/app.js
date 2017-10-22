
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Vddl from 'vddl';

Vue.use(Vddl);
Vue.component('task', require('./components/Task.vue'));

const app = new Vue({
    el: '#app',
    data: {
        tasks: [],
        "list": [
            {
                "id": 1,
                "label": "Item A1"
            },
            {
                "id": 2,
                "label": "Item A2"
            }
        ]
    },
    created() {
        axios.get('/tasks').then(response => this.tasks = response.data);
    }
});
