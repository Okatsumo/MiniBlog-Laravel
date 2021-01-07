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
                    <label for="contentInput">Текст</label>

                    <div class="row">
                        <div class="col">
                            <button class="btn icon-bold" title="жирный текст"></button>
                            <button class="btn icon-italic" title="пропись"></button>
                            <button class="btn icon-code" title="код"></button>

                            <button class="btn icon-align-left" title="жирный текст"></button>
                            <button class="btn icon-align-center" title="жирный текст"></button>
                            <button class="btn icon-align-right" title="жирный текст"></button>
                            <button class="btn icon-align-justify" title="жирный текст"></button>
                            <button class="btn icon-list" title="список"></button>


                            <button class="btn icon-camera" title="загрузить изображение"></button>
                        </div>

                    </div>

                    <textarea class="form-control" id="contentInput" rows="10"></textarea>
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
        content: null,
        tags: null,
        tagsList: []
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
