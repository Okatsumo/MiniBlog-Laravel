<template>

    <div>
        <SideBarAdmin></SideBarAdmin>
        <div class="container container-content">
            <h1>Добавление записи</h1>


            <form>
                <div class="form-group">
                    <label for="nameInput">Название</label>
                    <input type="text" class="form-control" id="nameInput">
                </div>

                <div class="form-group">
                    <label for="loadImage">Загрузить изображение</label>
                    <input class="form-control" id="loadImage" type="file">
                </div>

                <div class="form-group">
                    <label>Текст</label>
                    <medium-editor :content='content' :options='optionsEditor' style="background: #fcfcfc"/>

                </div>

                <div class="form-group">
                    <label for="categoryInput">Категория</label>
                    <select class="form-control" id="categoryInput">
                        <option v-for="category in categories">{{category.name}}</option>
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

                <button class="btn btn-primary float-left">Добавить</button>
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
      this.loadCategories()
    },

    methods: {
        loadCategories(){
            axios.get('/api/category').then(res => {
                this.categories = res.data;
                console.log(res.data)
            })
        },

        categoriesInput(){
            this.tagsList = this.tags.split(",")
        },
    }
}
</script>

<style scoped>

</style>
