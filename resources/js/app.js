import Vue from 'vue';
import axios from 'axios';
import ThemeSwitcher from './components/ThemeSwitcher.vue';
import NewProjectModal from './components/NewProjectModal.vue'
import VModal from 'vue-js-modal';

Vue.use(VModal);
Vue.use(axios);

const app = new Vue({
    el: '#app',
    components : {ThemeSwitcher, NewProjectModal},
})