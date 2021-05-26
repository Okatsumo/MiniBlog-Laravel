<template>
    <div>
        <section class="ftco-section container-content mr-2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="card mb-4">
                            <h3 class="text-center">Последние записи</h3>
                        </div>
                        <div class="col-lg-12" v-for="article in articles">
                            <div class="blog-entry d-lg-flex">
                                <div v-bind:class="{half: !loading}">
                                    <router-link :to="{name: 'article', params: { id: article.article_id } }" class="img d-flex align-items-end" v-lazy-load-background :data-src="'/storage/images/articles/' + article.image">
                                        <div class="overlay"></div>
                                    </router-link>
                                </div>
                                <div class="text px-md-4 px-lg-5 half pt-3 ">
                                    <h3><router-link :to="{name: 'article', params: { id: article.article_id } }">{{article.title}}</router-link></h3>
                                    <p class="size" v-if="article.shortDescription"> {{article.shortDescription}}</p>
                                    <p class="mb-0"><router-link :to="{name: 'article', params: { id: article.article_id } }" class="btn btn-primary">Подробнее <span class="icon-arrow_forward ml-4"></span></router-link></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mt-0 mb-3">Последние комментарии</h4>
                                    <h4 v-if="!comments">загрузка ...</h4>

                                    <ul class="comment-list">
                                        <li v-for="comment in comments">
                                            <div class="vcard bio">
                                                <img v-lazy-load :data-src="'/storage/images/avatars/' + comment.author.avatar"   alt="avatar">
                                            </div>
                                            <div class="comment-body">
                                                <h3> <router-link :to="{name : 'user.profile', params: {userId: comment.author.user_id}}">{{comment.author.name}}</router-link></h3>
                                                <div class="meta">{{comment.created_at}}</div>
                                                <p>{{comment.content}}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: "index",

    data: ()=> ({
        articles: null,
        comments: null,

        loading: true
    }),

    mounted() {
        this.loadArticles()
        this.loadNewComments()
    },

    methods: {
        loadArticles(){
            api.call('get', '/api/article')
                .then(res=>{
                    this.articles = res.data.data;
                     this.loading = false;
                })
        },

        loadNewComments(){
            api.call('get', '/api/comment')
                .then(res=>{
                    this.comments = res.data.comments;
                })
        }
    }

}
</script>

<style scoped>

</style>
