<template>
    <div class="d-flex">
        <SideBarAdmin></SideBarAdmin>
        <div class="admin-container mt-4 mr-4 ml-4">
            <h1>{{title}}</h1>

            <form>
                <div class="form-group">
                    <label for="nameInput">Название</label>
                    <input type="text" class="form-control" id="nameInput" v-model="name">
                </div>

                <div class="form-group">
                    <label for="image">Загрузить изображение</label>
                    <input class="form-control" id="image" type="file" v-on:change="showImage()">
                    <canvas id="canvas" width="640" height="360" class="img-fluid"></canvas>
                </div>

                <div class="form-group">
                    <quillEditor :content="content" v-model="content" :options="editorOptions"></quillEditor>
                </div>

                <div class="form-group">
                    <label for="categoryInput">Категория</label>
                    <select class="form-control" id="categoryInput" v-model="categoryId">
                        <option v-for="category in categories" :value="category.category_id">{{category.name}}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tagsInput">Теги</label>
                    <input type="text" class="form-control" id="tagsInput" v-model = tags v-on:input="categoriesInput">

                    <div class="tag-widget post-tag-container mb-5 mt-5">
                        <div class="tagcloud">
                            <a href="#" class="tag-cloud-link" v-for="tag in tagsList">{{tag}}</a>
                        </div>
                    </div>

                </div>

                <span class="btn btn-primary float-left" v-on:click="addArticle()" v-if="!id">Добавить</span>
                <span class="btn btn-primary float-left" v-on:click="addArticle(true)" v-else>Редактировать</span>
                <router-link class="btn btn-primary float-right" :to = "{name: 'adminPanel.articles'}">Назад</router-link>
            </form>

        </div>

    </div>

</template>

<script>
import SideBarAdmin from "../components/SidebarAdmin";

import Quill from 'quill'
import ImageUploader from "quill-image-uploader";
Quill.register("modules/imageUploader", ImageUploader)


export default {
    name: "AddArticlesAdmin",
    components:{
        SideBarAdmin
    },

    data: ()=>({
        id: null,
        image: null,
        title: "",
        editorOptions: {
            placeholder:"начните вводить текст ...",

            modules: {
                imageUploader: {
                    upload: (file) => {
                        return new Promise((resolve, reject) => {
                            let data = new FormData();
                            data.append('image', file)

                            api.call('post', '/api/upload-image/', data)
                                .then(res=>{
                                    resolve(
                                        res.data.path
                                    );
                                })
                        });
                    },
                },
                toolbar: {
                    container: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'header': 1 }, { 'header': 2 }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'script': 'sub'}, { 'script': 'super' }],
                        [{ 'indent': '-1'}, { 'indent': '+1' }],
                        [{ 'direction': 'rtl' }],
                        [{ 'size': ['small', false, 'large', 'huge'] }],
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'font': [] }],
                        [{ 'align': [] }],
                        ["clean"],
                        ["image"]
                    ],
                },
            }
        },

        categories: [],
        name: null,
        categoryId: null,
        content: "",
        tags: null,
        tagsList: [],
    }),

    mounted() {
      this.loadComponent();
      this.loadCategories();
    },

    methods: {
        showImage(){
            let canvas = document.getElementById('canvas').getContext("2d");
            let file = document.getElementById("image").files[0];

            let url = URL.createObjectURL(file)
            const image = new Image();
            image.src = url;
            canvas.width = innerWidth;
            canvas.height = innerHeight;

            image.onload = function(){
                canvas.drawImage(image,0,0,640,360);
            }
        },

        loadComponent(){
            if(this.$route.params.articleId){
                this.title = "Редактирование записи"

                api.call('get', '/api/article/' + this.$route.params.articleId)
                    .then(res=>{
                        this.id = res.data.article.article_id;
                        this.name = res.data.article.title;
                        this.content = res.data.article.content;
                        this.content = res.data.article.content;
                        this.categoryId = res.data.category.category_id;
                        this.tagsList = JSON.parse(res.data.article.tags)['tags'];
                        this.tags = JSON.parse(res.data.article.tags)['tags'];

                        let canvas = document.getElementById('canvas').getContext("2d");
                        canvas.width = innerWidth;
                        canvas.height = innerHeight;
                        const image = new Image();
                        image.src = "/storage/images/articles/" + res.data.article.image;

                        image.onload = function(){
                            canvas.drawImage(image,0,0,640,360);
                        }
                    })
            }
            else{
                this.title = "Добавление новой записи"
            }
        },

        loadCategories(){
            axios.get('/api/category').then(res => {
                this.categories = res.data;
            })
        },

        categoriesInput(){
            this.tagsList = this.tags.split(",")
        },

        addArticle(edit = false){
            if(!this.name){
                Vue.notify({group: 'auth',title: 'Добавление новой записи',text: "Поле с именем не может быть пустым"})
                return;
            }
            if(!this.content){
                Vue.notify({group: 'auth',title: 'Добавление новой записи',text: "Поле с текстом не может быть пустым"})
                return;
            }
            if(!this.categoryId){
                Vue.notify({group: 'auth',title: 'Добавление новой записи',text: "Выберите категорию"})
                return;
            }

            let data = new FormData();
            data.append("title", this.name);
            data.append("content", this.content);
            data.append("categoryId", this.categoryId);

            if(document.getElementById("image").files[0]){
                data.append("image", document.getElementById("image").files[0]);
            }

            if(this.tags){
                let tags = {
                    'tags': this.tagsList
                }
                data.append("tags", JSON.stringify(tags));
            }

            let params = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
            };


            if(edit){
                api.call("post", `/api/article/${this.id}/edit`, data, params)
                    .then(res=>{
                        Vue.notify({group: 'auth',title: 'Редактирование',text: `Запись "${res.data.article.title}" успешно отредактирована.`})
                    })
                    .catch(res =>{
                        console.log(res)
                        Vue.notify({group: 'auth',title: 'Редактирование',text: 'Произошла ошибка'})
                    })
            }
            else{
                api.call("get", "/api/article", data, params)
                    .then(res=>{
                        this.$router.push({ name: 'article', params: { id:  res.data.article.article_id}})
                        Vue.notify({group: 'auth',title: 'Создание новой записи',text: `Запись "${res.data.article.title}" успешно добавлена.`})
                    })
                    .catch(res =>{
                        Vue.notify({group: 'auth',title: 'Создание новой записи',text: 'Произошла ошибка'})
                    })
            }

        }
    }
}
</script>

<style scoped>

</style>
