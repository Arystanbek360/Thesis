import './bootstrap';
import '../css/app.css';
import Vue from 'vue';
import Hello from './components/Hello.vue';

const app = new Vue({
    el: '#app',
    components: {
        Hello
    },
    template: '<Hello />'
});
