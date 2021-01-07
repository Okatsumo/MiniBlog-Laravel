<template>
    <div>
        <SideBarAdmin></SideBarAdmin>
        <div class="container container-content">
            <div class="row">
                <div class="col-lg-3">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="iq-todo-page">
                                <form class="position-relative">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control todo-search"  placeholder="Поиск по записям">
                                        <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                                    </div>
                                </form>
                                <ul class="todo-task-list p-0 m-0">
                                    <li>
                                        <ul id="todo-task1" class="sub-task  show mt-2 p-0">
                                            <li class="active"><a href="#" v-on:click="loadArticles()"> Все категории </a></li>
                                            <li v-for="category in categories"><a href="#" v-on:click="loadArticles(category.category_id)">{{category.name}}</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="todo-date d-flex mr-3">
                                            <i class="ri-calendar-2-line text-success mr-2"></i>
                                            <span>Всего записей: {{articles.length}}</span>
                                        </div>
                                        <div class="todo-notification d-flex align-items-center">
                                             <router-link class="btn iq-bg-success" :to = "{name: 'adminPanel.articlesAdd'}">Добавить новую запись</router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="iq-card">
                                <div class="iq-card-body p-0">
                                    <ul class="todo-task-lists m-0 p-0">
                                        <li class="d-flex align-items-center p-3" v-for="article in articles">
                                            <div class="user-img img-fluid"><router-link :to="{name: 'article', params: { id: article.article_id } }"><img src="images/user/05.jpg" class="rounded-circle avatar-40"></router-link></div>
                                            <div class="media-support-info ml-3">
                                                <h6 class="d-inline-block"><router-link :to="{name: 'article', params: { id: article.article_id } }">{{article.title}}</router-link></h6>
                                                <p class="mb-0">Автор: {{article.author.name}}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

import SideBarAdmin from '../components/SidebarAdmin'

export default {
    name: "Articles",

    components:{
        SideBarAdmin
    },

    data: ()=>({
        articles: [],
        categories: []
    }),

    mounted(){
        this.loadArticles();
        this.loadCategories()
    },

    methods: {
        loadArticles(categoryId) {
            if(categoryId){
                axios.get("/api/category/" + categoryId).then(res => {
                    this.articles = res.data.articles;
                    this.loading = false;

                    console.log(res.data.data)
                })
            }
            else{
                axios.get('/api/article').then(res => {
                    this.articles = res.data.data;
                    this.loading = false;

                    console.log(res.data.data)
                })
            }
        },
        loadCategories(){
            axios.get("/api/category/").then(res => {
                this.categories = res.data;
                console.log(res.data);
            })
        }
    }
}
</script>

<style scoped>

</style>
