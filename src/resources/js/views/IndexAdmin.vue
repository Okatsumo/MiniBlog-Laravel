<template>
    <div class="d-flex">
        <SideBarAdmin></SideBarAdmin>

        <div class="admin-container ml-auto mr-auto mt-4">
            <div class="row ml-lg-4 mr-lg-4">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body profile-card">
                            <div class="media align-items-center">
                                <img src="/storage/images/avatars/default.png" alt="user" class="rounded-circle thumb-lg">
                                <div class="media-body ml-3 align-self-center">
                                    <h5 class="pro-title">Admin</h5>
                                    <p class="mb-1 text-muted">мой профиль</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4 align-self-center">
                                            <div class="icon-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users align-self-center icon-lg icon-dual-warning"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                            </div>
                                        </div>
                                        <div class="col-8 align-self-center text-right">
                                            <div class="ml-2">
                                                <p class="mb-1 text-muted">Пользователей</p>
                                                <h4 v-if="!totalUsers">Загрузка ...</h4>
                                                <h4 v-else class="mt-0 mb-1 text-warning font-22">{{totalUsers}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4 align-self-center">
                                            <div class="icon-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open align-self-center icon-lg icon-dual-purple"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                                            </div>
                                        </div>
                                        <div class="col-8 align-self-center text-right">
                                            <div class="ml-2">
                                                <div class="ml-2">
                                                    <p class="mb-0 text-muted">Постов</p>
                                                    <h4 class="mt-0 mb-1 d-inline-block text-purple font-22" v-if="!totalArticles">загрузка...</h4>
                                                    <h4 class="mt-0 mb-1 d-inline-block text-purple font-22" v-else>{{totalArticles}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4 align-self-center">
                                            <div class="icon-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book align-self-center icon-lg icon-dual-pink"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                                            </div>
                                        </div>
                                        <div class="col-8 align-self-center text-right">
                                            <div class="ml-2">
                                                <p class="mb-0 text-muted">Категорий</p>
                                                <h4 class="mt-0 mb-1 d-inline-block text-pink font-22" v-if="!totalCategory">Загрузка...</h4>
                                                <h4 class="mt-0 mb-1 d-inline-block text-pink font-22" v-else>{{totalCategory}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row mt-4 ml-lg-4 mr-lg-4">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-3">Последние записи</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>Id</th>
                                        <th>Название</th>
                                        <th>Дата создания</th>
                                        <th>Рейтинг</th>
                                        <th>Автор</th>
                                        <th>Категория</th>
                                        <th>Редактор</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr v-for="article in articles">
                                        <td>{{article.article_id}}</td>
                                        <td>{{article.title}}</td>
                                        <td>{{article.created_at}}</td>
                                        <td> <span class="badge badge-md badge-soft-purple">{{article.rating}}</span> / 10</td>
                                        <td><router-link :to="{name : 'user.profile', params: {userId: article.author.user_id}}">{{article.author.name}}</router-link></td>
                                        <td><router-link :to = "{name: 'Category', params: { id: article.category.category_id}}">{{article.category.name}}</router-link></td>
                                        <td>
                                            <router-link :to = "{name: 'adminPanel.editArticle', params: { articleId: article.article_id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                </svg>
                                            </router-link>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-3">Последние комментарии</h4>
                            <h4 v-if="!newComments">загрузка ...</h4>

                            <ul class="comment-list">
                                <li v-for="comment in newComments">
                                    <div class="vcard bio">
                                        <img :src="'/storage/images/avatars/default.png'" alt="avatar">
                                    </div>
                                    <div class="comment-body">
                                        <h3><router-link :to="{name : 'user.profile', params: {userId: comment.author.user_id}}">{{comment.author.name}}</router-link></h3>
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
    </div>

</template>

<script>
import SideBarAdmin from "../components/SidebarAdmin";

export default {
    name: "adminPanel.users",
    components:{
        SideBarAdmin
    },

    data: ()=> ({
        articles: null,
        totalArticles: null,
        totalCategory: null,
        totalUsers: null,
        newComments: null

    }),

    mounted() {
        this.loadArticles();
        this.loadTotalUsers();
        this.loadTotalCategory();
        this.loadNewComments();
    },

    methods:{
        loadArticles(){
            api.call('get', '/api/article?sort=descending')
                .then(res=>{
                    this.articles = res.data.articles;
                    this.totalArticles = res.data.count;
                })
        },
        loadTotalUsers(){
            api.call('get', '/api/get-count-users')
                .then(res=>{
                    this.totalUsers = res.data.total;
                })
        },
        loadTotalCategory(){
            api.call('get', '/api/get-count-category')
                .then(res=>{
                    this.totalCategory = res.data.total;
                })
        },

        loadNewComments(){
            api.call('get', '/api/comment')
                .then(res=>{
                    this.newComments = res.data.comments;
                })
        }
    }

}
</script>

<style scoped>

</style>
