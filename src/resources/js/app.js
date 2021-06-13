import Api from './api.js';
import Auth from './auth.js';
import apiArticle from './api/apiArticle';
import apiCategory from './api/categoryApi';
import Pusher from './pusher';
import apiUser from "./api/apiUser";
import lazyLoad from "./directives/lazyload";
import lazyLoadBackground from "./directives/lazyLoadBackground";
import AvatarCropper from "vue-avatar-cropper";

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Vue = require('vue');
window.auth = new Auth();
window.api = new Api();
window.Event = new Vue;

// Модели из БД
window.apiUser = apiUser;
window.apiArticle = apiArticle;
window.apiCategory = apiCategory;

// текстовый редактор
import 'quill/dist/quill.snow.css'
import { quillEditor } from 'vue-quill-editor'

//Компоненты
Vue.component('modalLogin', () => import('./components/ModalVue'));
Vue.component('navbar', () => import('./components/Navbar'));
Vue.component('spinner', () => import('./components/Spinner'));
Vue.component('AvatarCropper', AvatarCropper);
Vue.component('quillEditor', quillEditor);
Vue.directive('lazyLoad', lazyLoad)
Vue.directive('lazyLoadBackground', lazyLoadBackground)

import router from "./router";
import {notifications} from "./notifications";
import VModal from "./modal";
import {VueMeta} from "./vueMeta"

require('../css/app.css');

const app = new Vue({
    el: '#app',
    mode: 'history',
    router: router
});

