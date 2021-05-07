<template>
    <div>
        <section class="hero-wrap hero-wrap-2" style="background-image: url('https://i.pinimg.com/originals/ab/d3/91/abd391cf3428d8d3cb03c7993342ce91.jpg');">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text align-items-end justify-content-center">
                    <div class="col-md-9 pb-5 text-center">
                        <spinner v-if="loading"></spinner>
                        <h1 class="mb-3 bread">{{article.title}}</h1>
                        <p class="breadcrumbs"><span class="mr-2"><a href="/">Главная </a> / </span> <span>{{category.name}}<i class="ion-ios-arrow-forward"></i></span></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="ftco-section container-content" v-if="!loading">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 order-lg-last ">

                        <div class="content">
                            <span v-html="article.content"></span>
                        </div>

                        <div class="tag-widget post-tag-container mb-5 mt-5">
                            <div class="tagcloud">
                                <a href="#" class="tag-cloud-link">Бэкенд</a>
                                <a href="#" class="tag-cloud-link">Веб</a>
                                <a href="#" class="tag-cloud-link">Web</a>
                                <a href="#" class="tag-cloud-link">Backend</a>
                            </div>
                        </div>

                        <div class="about-author d-flex p-4 bg-light">
                            <div class="bio mr-5">
                                <img :src="'/storage/images/avatars/' + author.avatar" alt="Image placeholder" class="img-fluid mb-4" w>
                            </div>
                            <div class="desc">
                                <h3>{{author.name}}</h3>
                                <p>{{author.dec}}</p>
                            </div>
                        </div>


                        <div class="pt-5 mt-5">
                            <h3 class="mb-5">Комментарии</h3>
                            <ul class="comment-list">
                                <li v-for="comment in comments" class="comment">
                                    <div class="vcard bio">
                                        <img src="/storage/images/avatars/default.png" alt="Image placeholder">
                                    </div>
                                    <div class="comment-body">
                                        <h3>{{comment.author.name}}</h3>
                                        <div class="meta">October 03, 2018 at 2:21pm</div>
                                        <p>{{comment.content}}</p>
                                    </div>
                                </li>
                            </ul>

                            <ul class="pagination">
                                <li class="page-item" v-on:click="loadBackComments()"><a class="page-link"  v-if="thisPage > 1">Предыдущие комментарии</a></li>
                            </ul>

                            <!-- END comment-list -->

                            <div class="comment-form-wrap pt-5">
                                <form action="#" class="p-5 bg-light">
                                    <div class="form-group">
                                        <label for="message">Отправить комментарий: </label>
                                        <textarea v-model="message" id="message" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input v-on:click="sendComment()" value="Отправить" class="btn py-3 px-4 btn-primary">
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div> <!-- .col-md-8 -->
                    <div class="col-lg-4 sidebar pr-lg-5">
                        <div class="sidebar-box">
                            <ul class="categories">
                                <h3 class="heading mb-4">Категории</h3>
                                <li v-for="category in categoriesList"><router-link :to="{name: 'Category', params: { id: category.category_id }}" >{{category.name}} <span>(12)</span></router-link></li>
                            </ul>
                        </div>

                        <div class="sidebar-box ">
                            <h3 class="heading mb-4">Другие записи</h3>
                            <div class="block-21 mb-4 d-flex">
                                <a class="blog-img mr-4" style="background-image: url(images/image_1.jpg);"></a>
                                <div class="text">
                                    <h3><a href="#">Название записи</a></h3>
                                    <div class="meta">
                                        <div><a href="#"><span class="icon-calendar"></span> февраль 12, 2020</a></div>
                                        <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                                        <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-box ">
                            <h3 class="heading mb-4">Реклама</h3>
                        </div>
                    </div>

                </div>
            </div>
        </section> <!-- .section -->
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: "Article",

    data: ()=>({
       article: {},
       articleId: null,
       author: {},
       category: {},
       categoriesList: {},
       loading: true,
       comments: [],
       lastPage: null,
       thisPage: null,
       message: null
    }),

    mounted() {
        this.loadingArticle();
        this.loadCategories();
    },

    methods:{
        loadingArticle(){
            axios.get(`/api/article/${this.$route.params.id}`).then(res=>{
                this.article = res.data.article;
                this.author = res.data.author;
                this.category = res.data.category;
                this.loading = false;

                this.webSocketComment(res.data.article.article_id);

            })
            .catch(error=>{
                console.log('Произошла ошибка при загрузке записи');
            })
        },
        loadCategories(){
            axios.get(`/api/category`).then(res=>{
                this.categoriesList = res.data;
            })
            .catch(error=>{
                    console.log('Произошла ошибка при загрузке категорий');
            })
        },

        webSocketComment(articleId){
            axios.get(`/api/comment/${articleId}`).then(res=>{
                this.lastPage = res.data.last_page
                this.thisPage = this.lastPage;
                this.loadCommentsPage(articleId)
            })

            Echo.channel(`comments.${articleId}`)
                .listen(".loadCommentsEven", (e)=> {
                    this.comments.push(e.comment);
                })
        },


        //Работа со страницами:
        loadCommentsPage(articleId){
            axios.get(`/api/comment/${articleId}?page=${this.lastPage}`).then(res=>{
                this.comments = res.data.data;
            })
        },

        loadBackComments(){
            if(this.thisPage > 1){
                this.thisPage -=1;
                axios.get(`/api/comment/${this.article.article_id}?page=${this.lastPage - 1}`).then(res=>{
                    const last = this.comments;
                    const back = res.data.data;
                    this.comments = back.concat(last);
                })
            }
        },

        sendComment(){
            let refreshToken = "eyJhbGciOiJIUzUxMiIsInR5cGUiOiJyZWZyZXNoIiwidHlwIjoiSldUIn0.eyJuYW1lIjoiUm9nZWxpbyBNb3JhciIsImlkIjoxLCJhdmF0YXIiOm51bGwsImV4cCI6MTYyMDQwMDcyMX0.J5bWCORH_TtQRkyQPOYQRHdiqwqjEPAtMiv63WeGnMqZuUHxXy3ctabBbb6pmbX0lC5RRFO4JosbOL9rxB3cOQ";

            axios.get(`/api/comment/create?content=${this.message}&articleId=${this.article.article_id}&refreshToken=${refreshToken}`).then()
                .catch(error=>{
                    console.log('Произошла ошибка при загрузке категорий');
            })

            this.message = null;
        }
    }

}
</script>

<style scoped>

</style>
