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

                        <div class="content" style="line-height: 1.42">
                            <span v-html="article.content" style="color: black"></span>
                        </div>

                        <div class="tag-widget post-tag-container mb-5 mt-5">
                            <div class="tagcloud">
                                <a v-for="tag in tags" href="#" class="tag-cloud-link">{{tag}}</a>
                            </div>
                        </div>

                        <div class="about-author d-flex p-4 bg-light">
                            <div class="bio mr-5">
                                <img :src="'/storage/images/avatars/' + author.avatar" alt="Image placeholder" class="img-fluid mb-4" w>
                            </div>
                            <div class="desc">
                                <h3>{{author.name}}</h3>
                                <p class="text-break">{{author.dec}}</p>
                            </div>
                        </div>


                        <div class="pt-5 mt-5">
                            <h3 class="mb-5">Комментарии</h3>
                            <ul class="comment-list">
                                <li v-for="comment in comments">
                                    <div class="vcard bio">
                                        <img :src="'/storage/images/avatars/' + comment.author.avatar" alt="Image placeholder">
                                    </div>
                                    <div class="comment-body">
                                        <h3> <router-link :to="{name : 'user.profile', params: {userId: comment.author.user_id}}">{{comment.author.name}}</router-link></h3>
                                        <div class="meta">{{comment.created_at}}</div>
                                        <p class="text-break">{{comment.content}}</p>
                                        <span v-if="comment.author.user_id === (user ? user.user_id : 0)" v-on:click="editComment(comment.content, comment.comment_id)" style="cursor: pointer;">Редактировать</span>
                                        <span v-if="comment.author.user_id === (user ? user.user_id : 0)" v-on:click="removeComment(comment.comment_id)" style="cursor: pointer;">Удалить</span>
                                    </div>
                                </li>
                            </ul>

                            <ul class="pagination">
                                <li class="page-item" v-on:click="loadBackComments()"><a class="page-link"  v-if="thisPage > 1">Предыдущие комментарии</a></li>
                            </ul>

                            <!-- END comment-list -->

                            <div class="comment-form-wrap pt-5" v-if="authenticated || user">
                                <form action="#" class="p-5 bg-light">
                                    <div class="form-group">
                                        <label for="message" v-if="!editingComment">Отправить комментарий: </label>
                                        <label for="message" v-else>Редактирование: </label>
                                        <textarea v-model="message" id="message" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <span v-on:click="sendComment()" class="btn py-3 px-4 btn-primary" v-if="!editingComment & !user.banned">Отправить</span>
                                        <span class="btn py-3 px-4 btn-primary" v-if="editingComment" v-on:click="sendEditComment(editingComment)">Редактировать</span>
                                        <p v-model="errorMessage" v-if="errorMessage" style="color: red;">Комментарий не может быть пустым</p>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div> <!-- .col-md-8 -->
                    <div class="col-lg-4 sidebar pr-lg-5">
                        <div class="sidebar-box">
                            <ul class="categories">
                                <h3 class="heading mb-4">Категории</h3>
                                <li v-for="category in categoriesList"><router-link :to="{name: 'Category', params: { id: category.categoryId }}" >{{category.name}}</router-link></li>
                            </ul>
                        </div>

                        <div class="sidebar-box ">
                            <h3 class="heading mb-4">Другие записи</h3>
                            <div class="block-21 mb-4 d-flex" v-for="article in recommendArticles">
                                <a class="blog-img mr-4" v-lazy-load-background :data-src="'/storage/images/articles/' + article.image"></a>
                                <div class="text">
                                    <h3><router-link :to="{name: 'article', params: { id: article.article_id } }">{{article.title}}</router-link></h3>
                                    <div class="meta">
                                        <div><a href="#"><span class="icon-calendar"></span>{{article.created_at}}</a></div>
                                        <div><a href="#"><span class="icon-person"></span> {{article.author.name}}</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>

<!--                        <div class="sidebar-box ">-->
<!--                            <h3 class="heading mb-4">Реклама</h3>-->
<!--                        </div>-->
                    </div>

                </div>
            </div>
        </section>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: "Article",

    data: ()=>({
        article: {},
        recommendArticles: {},
        author: {},
        category: {},
        categoriesList: {},
        loading: true,
        comments: [],
        lastPage: null,
        thisPage: null,
        message: "",
        errorMessage: "",
        editingComment: null,
        tags: {},

        authenticated: auth.check(),
        user: auth.user,
    }),

    watch: {
        $route(to, from) {
            this.loadingArticle();
            this.loadCategories();
            this.loadRecommendArticles();
        }
    },

    mounted() {
        this.loadingArticle();
        this.loadCategories();

        Event.$on('userLoggedIn', () => {
            this.authenticated = true;
            this.user = auth.user;
        });

        Event.$on('userLogout', ()=>{
            this.authenticated = false;
            this.user = null;
        });
        this.loadRecommendArticles();
    },

    methods:{
        loadRecommendArticles(){
            api.call('get', '/api/article?sort=descending')
                .then(res=>{
                    this.recommendArticles = res.data.articles;
                })
        },

        loadingArticle(){
            axios.get(`/api/article/${this.$route.params.id}`).then(res=>{
                this.article = res.data.article;
                this.author = res.data.author;
                this.category = res.data.category;
                if(res.data.article.tags){
                    this.tags = JSON.parse(res.data.article.tags)['tags'];
                }
                this.loading = false;

                this.webSocketComment(res.data.article.article_id);

            })
            .catch(error=>{
                console.log('Произошла ошибка при загрузке записи');
            })
        },
        loadCategories(){
            axios.get(`/api/v1/category`).then(res=>{
                this.categoriesList = res.data.data;
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
                .listen(".CreateCommentsEven", (e)=> {
                    if(e.comment.author.user_id !== (this.user ? this.user.user_id : 0)){
                        switch (e.method){
                            case 'remove':
                                this.removeCommentItem(Number(e.comment.comment_id))
                                break;
                            case 'create':
                                this.comments.push(e.comment);
                                break;
                            case 'edit':
                                this.comments[this.getCommentItem(e.comment.comment_id)].content = e.comment.content;
                                break;
                        }
                    }
                })
        },


        //Работа со страницами:
        loadCommentsPage(articleId){
            axios.get(`/api/comment/${articleId}?page=${this.lastPage}`).then(res=>{
                this.comments = res.data.data;
            })
        },

        loadBackComments(){
                this.thisPage -=1;
                axios.get(`/api/comment/${this.article.article_id}?page=${this.thisPage}`).then(res=>{
                    const last = this.comments;
                    const back = res.data.data;
                    this.comments = back.concat(last);
                })
        },

        editComment(content, id){
            this.message = content;
            this.editingComment = id;

            const el = document.getElementById('message');
            el.scrollIntoView();
        },

        sendEditComment(id){
            this.comments[this.getCommentItem(id)].content = this.message;

            api.call('get', `/api/comment/${id}/edit?content=${this.message}`)
            this.editingComment = null;
            this.message = "";
        },

        removeCommentItem(id){
            this.comments.reduce((values, item, index) =>{
                if(item.comment_id === id){
                    this.comments.splice(index, 1);
                }
            }, []);
        },

        removeComment(id){
            api.call('delete', `/api/comment/` + id)
                .then(res=>{
                    this.removeCommentItem(id)
                })
        },


        getCommentItem(id){
            let i = null;
            this.comments.reduce((values, item, index) =>{
                if(item.comment_id === id){
                    i = index;
                }
            }, []);
            return i;
        },

        sendComment(){
            let refreshToken = window.getCookie("refresh");

            if(this.message !== "" ){
                api.call('get', `/api/comment/create?content=${this.message}&articleId=${this.article.article_id}`)
                .then(res=>{
                    this.comments.push(res.data[0]);
                })

                .catch(res=>{
                    if(res.status === 403){
                        auth.check();
                    }
                });

                this.message = "";
                this.errorMessag = null;
            }
            else{
                this.errorMessage = "Сообщение не может быть пустым!";
            }
        }
    },



}
</script>

<style scoped>

</style>
