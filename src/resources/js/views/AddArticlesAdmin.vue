<template>

    <div>
        <SideBarAdmin></SideBarAdmin>
        <div class="container container-content admin-container">
            <h1>Добавление записи</h1>


            <form>
                <div class="form-group">
                    <label for="nameInput">Название</label>
                    <input type="text" class="form-control" id="nameInput" v-model="name">
                </div>

                <div class="form-group">
                    <label for="image">Загрузить изображение</label>
                    <input class="form-control" id="image" type="file">
                </div>

                <div class="form-group">
                    <label>Текст</label>
                    <medium-editor :content='content' :options='optionsEditor' style="background: #fcfcfc" v-model ="content"/>

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

                <span class="btn btn-primary float-left" v-on:click="addArticle()">Добавить</span>
                <router-link class="btn btn-primary float-right" :to = "{name: 'adminPanel.articles'}">Назад</router-link>
            </form>

        </div>

    </div>

</template>

<script>
import SideBarAdmin from "../components/SidebarAdmin";

export default {
    name: "AddArticlesAdmin",
    components:{
        SideBarAdmin
    },

    data: ()=>({
        image: null,

        categories: [],
        name: null,
        categoryId: null,
        content: "",
        optionsEditor: {
            toggleEnabled: false,
            placeholder: false,
            toolbar: {
                buttons: [
                    'bold',
                    {
                      name: 'italic',
                      aria: 'пропись',
                    },
                    {
                        name: 'h1',
                        action: 'append-h2',
                        aria: 'header type 1',
                        tagNames: ['h1'],
                        contentDefault: '<b>H1</b>',
                        // classList: ['custom-class-h1'],
                        attrs: {
                            'data-custom-attr': 'attr-value-h1'
                        }
                    },
                    {
                        name: 'h2',
                        action: 'append-h3',
                        aria: 'header type 2',
                        tagNames: ['h2'],
                        contentDefault: '<b>H2</b>',
                        // classList: ['custom-class-h2'],
                        attrs: {
                            'data-custom-attr': 'attr-value-h2'
                        }
                    },
                    {
                        name: 'justifyCenter',
                        aria: 'поместить текст по центру',
                    },
                    'quote',
                    'anchor'
                ]
            },
        },
        tags: null,
        tagsList: [],
    }),


    mounted() {
      this.loadCategories();
    },

    methods: {
        loadCategories(){
            axios.get('/api/category').then(res => {
                this.categories = res.data;
            })
        },

        categoriesInput(){
            this.tagsList = this.tags.split(",")
        },

        getCookie(name) {
            let matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined;
        },

        addArticle(){
            let formData = new FormData();
            formData.append("image", document.getElementById("image").files[0]);
            formData.append("title", this.name);
            formData.append("content", this.content);
            formData.append("categoryId", this.categoryId);

            console.log(this.categoryId)

            axios.post('/api/article', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            })
            .then( function (data){
                console.log(data)

            })
        }
    }
}
</script>

<style scoped>

</style>
