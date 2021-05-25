import Api from './api.js';
import Auth from './auth.js';
import UserApi from './api/apiUser';
import apiArticle from './api/apiArticle';
import apiCategory from './api/categoryApi';
import lazyLoad from "./directives/lazyload";
import lazyLoadBackground from "./directives/lazyLoadBackground";

require('./bootstrap');
require('./pusher');

window.Vue = require('vue');
window.auth = new Auth();
window.api = new Api();
window.Event = new Vue;

// Модели из БД
window.apiUser = apiUser;
window.apiArticle = apiArticle;
window.apiCategory = apiCategory;

// текстовый редактор
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
import { quillEditor } from 'vue-quill-editor'


//Компоненты
// Vue.component('modalLogin', require('./components/ModalVue').default);
Vue.component('modalLogin', () => import('./components/ModalVue'));
// Vue.component('navbar', require('./components/Navbar').default);
Vue.component('navbar', () => import('./components/Navbar'));
// Vue.component('spinner', require('./components/Spinner').default);
Vue.component('spinner', () => import('./components/Spinner'));
Vue.component('quillEditor', quillEditor);
Vue.directive('lazyLoad', lazyLoad)
Vue.directive('lazyLoadBackground', lazyLoadBackground)



import router from "./router";
import notifications from "./notifications";
import VModal from "./modal";
import apiUser from "./api/apiUser";


require('../css/app.css');

const app = new Vue({
    el: '#app',
    mode: 'history',
    router: router,
});

