<template>
    <div>
        <section class="hero-wrap hero-wrap-2" style="background-image: url('https://i.pinimg.com/originals/ab/d3/91/abd391cf3428d8d3cb03c7993342ce91.jpg');">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text align-items-end justify-content-center">
                    <div class="col-md-9 ftco-animate pb-5 text-center">
                        <h1 class="mb-3 bread">{{title}}</h1>
                        <p class="breadcrumbs"><span class="mr-2"><router-link to="/">Главная </router-link> </span> <span>{{title}} <i class="ion-ios-arrow-forward"></i></span></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="ftco-section container-content">
            <spin v-if="loading"></spin>
            <div class="container" v-if="!loading">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="#" class="search-form">
                            <div class="form-group">
                                <span class="icon icon-search"></span>
                                <input type="text" class="form-control" placeholder="Поиск.." v-on:input="search()" v-model="searchText">
                            </div>
                        </form>
                        <div class="row" v-for="article in articles">
                            <div class="col-md-6 col-lg-12">
                                <div class="blog-entry d-lg-flex">
                                    <div class="half">
                                        <router-link :to="{name: 'article', params: { id: article.article_id } }" class="img d-flex align-items-end" v-bind:style="{ backgroundImage: `url('/storage/images/articles/${article.image}')`}">
                                            <div class="overlay"></div>
                                        </router-link>
                                    </div>
                                    <div class="text px-md-4 px-lg-5 half">
                                        <h3><router-link :to="{name: 'article', params: { id: article.article_id } }">{{article.title}}</router-link></h3>
                                        <div class="size" v-if="article.shortDescription"> {{article.shortDescription}}</div>
                                        <p class="mb-0"><router-link :to="{name: 'article', params: { id: article.article_id } }" class="btn btn-primary">Подробнее <span class="icon-arrow_forward ml-4"></span></router-link></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<!--                    <div class="col-lg-3">-->
<!--                        <div class="sidebar-wrap">-->
<!--                            <div class="sidebar-box categories text-center">-->
<!--                                <h2 class="heading mb-4">Реклама</h2>-->

<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>

                <div class="row mt-5">
                    <div class="col text-center">
                        <div class="block-27">
                            <ul>
                                <li><a v-on:click="backPage()">&lt;</a></li>
                                <!--                            <li class="active"><span>1</span></li>-->
                                <li :id="'page.'+ page" v-for="page in pages"><a v-on:click="loadPage(page); thisPage = page">{{ page }}</a></li>
                                <li><a v-on:click="nextPage()">&gt;</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



</template>


<script>

import Axios from 'axios'
import spin from '../components/Spinner'


export default {
    name: "Category",

    components: {
        spin,
    },

    watch: {
        $route(to, from) {
            this.LoadArticles()
        }
    },

    data: ()=>({
        articles: [],
        loading: true,
        title: "",
        pages: 1,
        thisPage: 1,
        searchText: null
    }),
    mounted(){
        this.LoadArticles()
    },
    methods: {
        nextPage(){
            if(this.thisPage + 1 <= this.pages){
                this.thisPage +=1;
                this.loadPage(this.thisPage)


                let btnThisPage = document.getElementById(`page.`+this.thisPage)
                btnThisPage.classList.add("active")

                let oldBtnPage = document.getElementById(`page.`+ (this.thisPage + 1))
                oldBtnPage.classList.remove("active")
            }

        },

        backPage(){
            if(this.thisPage > 1){
                this.thisPage -=1;
                this.loadPage(this.thisPage)
            }
        },

        loadPage(page){
            if(this.$route.params.id){
                axios.get(`/api/category/${this.$route.params.id}?page=${page}`).then(res =>{
                    this.articles = res.data.articles.data;
                    this.title = "Все записи"
                    console.log(`page: ${this.thisPage}`)
                })
            }
            else{
                axios.get('/api/article/?page=' + page).then(res =>{
                    this.articles = res.data.data;
                    this.title = "Все записи"
                    console.log(`page: ${this.thisPage}`)
                })
            }
            window.scrollBy(0, -3000);
        },

        LoadArticles(){
        if(this.$route.params.id){
            axios.get(`/api/category/${this.$route.params.id}`).then(res =>{
                this.articles = res.data.articles.data;
                this.pages = res.data.articles.last_page;
                this.title = res.data.category.name;
                this.loading = false;
            })
        }
        else{
            axios.get('/api/article').then(res =>{
                this.articles = res.data.data;
                this.pages = res.data.last_page;
                this.title = "Все записи"
                this.loading = false;
            })
        }
        },
        search(){
            axios.get(`/api/articles/search?text=${this.searchText}`).then(res =>{
                this.articles = res.data.data;
                console.log(res.data)
            })
        }
    }
}
</script>

<style scoped>

</style>
