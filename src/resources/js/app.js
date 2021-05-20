import Api from './api.js';
import Auth from './auth.js';
import UserApi from './apiUser';

require('./bootstrap');
require('./pusher');
window.Vue = require('vue');

window.auth = new Auth();
window.api = new Api();
window.Event = new Vue;



// Модели из БД
window.apiUser = apiUser;




// текстовый редактор
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
import { quillEditor } from 'vue-quill-editor'


// import Quill from 'quill'
// import ImageUploader from "quill-image-uploader";
// Quill.register(ImageUploader)



//Компоненты
Vue.component('modalLogin', require('./components/ModalVue').default);
Vue.component('modalEditorProfile', require('./components/ModalEditorProfile').default);
Vue.component('navbar', require('./components/Navbar').default);
Vue.component('spinner', require('./components/Spinner').default);
Vue.component('quillEditor', quillEditor)



import router from "./router";
import notifications from "./notifications";
import VModal from "./modal";
import apiUser from "./apiUser";

require('../css/app.css');

const app = new Vue({
    el: '#app',
    mode: 'history',
    router: router
});

