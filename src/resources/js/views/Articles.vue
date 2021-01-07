<template>
    <div>
        <section class="hero-wrap hero-wrap-2" style="background-image: url('https://i.pinimg.com/originals/ab/d3/91/abd391cf3428d8d3cb03c7993342ce91.jpg');">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text align-items-end justify-content-center">
                    <div class="col-md-9 ftco-animate pb-5 text-center">
                        <h1 class="mb-3 bread">{{title}}</h1>
                        <p class="breadcrumbs"><span class="mr-2"><router-link to="/">Главная </router-link> </span> <span>все записи <i class="ion-ios-arrow-forward"></i></span></p>
                    </div>
                </div>
            </div>
        </section>


        <modal name="login" :height="375" :draggable = true :adaptive = true>
            <form class="form-horizontal">
                <span class="heading">АВТОРИЗАЦИЯ</span>
                <div class="form-group">
                    <input type="email" class="form-control" id="inputEmail" placeholder="E-mail" v-model="email">
                    <i class="fa fa-user"></i>
                </div>
                <div class="form-group help">
                    <input type="password" class="form-control" id="inputPassword" placeholder="Пароль" v-model="password">
                    <i class="fa fa-lock"></i>
                    <a href="#" class="fa fa-question-circle"></a>
                </div>
                <div class="form-group">
                    <div class="main-checkbox">
                        <input type="checkbox" value="none" id="checkbox1" name="check"/>
                        <label for="checkbox1"></label>
                    </div>
                    <span class="text" style="color: #ffffff">Запомнить</span>
                    <span class="btn btn-primary" v-on:click="login()">ВХОД</span>
                </div>
                <p v-text="loginMes" style="color: #ffffff"></p>
            </form>
        </modal>


        <section class="ftco-section container-content">
            <spin v-if="loading"></spin>
            <div class="container" v-if="!loading">
                <div class="row">
                    <div class="col-lg-9">
                        <form action="#" class="search-form">
                            <div class="form-group">
                                <span class="icon icon-search"></span>
                                <input type="text" class="form-control" placeholder="Поиск..">
                            </div>
                        </form>
                        <div class="row" v-for="article in articles">
                            <div class="col-md-6 col-lg-12">
                                <div class="blog-entry d-lg-flex">
                                    <div class="half">
                                        <router-link :to="{name: 'article', params: { id: article.article_id } }" class="img d-flex align-items-end" style="background-image: url(https://i.pinimg.com/originals/ab/d3/91/abd391cf3428d8d3cb03c7993342ce91.jpg);">
                                            <div class="overlay"></div>
                                        </router-link>
                                    </div>
                                    <div class="text px-md-4 px-lg-5 half pt-3">
                                        <h3><router-link :to="{name: 'article', params: { id: article.article_id } }">{{article.title}}</router-link></h3>
                                        <p>{{article.content.slice(3,90)}} ...</p>
                                        <p class="mb-0"><router-link :to="{name: 'article', params: { id: article.article_id } }" class="btn btn-primary">Подробнее <span class="icon-arrow_forward ml-4"></span></router-link></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="sidebar-wrap">
                            <div class="sidebar-box categories text-center">
                                <h2 class="heading mb-4">Реклама</h2>
                            </div>
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

    data: ()=>({
        articles: [],
        loading: true,
        title: 'Все записи',
        email: undefined,
        password: undefined,
        loginMes: undefined,
    }),
    mounted(){
        this.LoadArticles()
        this.$modal.show('login')
    },
    methods: {
        LoadArticles(){
            axios.get('api/article').then(res =>{
                this.articles = res.data.data;
                console.log(res.data)
                this.loading = false;
            })
        },
        searchFunc(){
            this.title = 'Поиск..';
        },
        login(){
            axios.put('api/auth/login',{
                email: this.email,
                password: this.password
            }).then(res=>{
                if(res.data['status']){
                    this.$modal.hide('login');
                    this.loginMes = undefined;

                    document.cookie = `access = ${res.data['tokens']['access']}`;
                    document.cookie = `refresh = ${res.data['tokens']['refresh']}`;

                    Vue.notify({group: 'auth',title: 'Авторизация',text: 'Вы успешно вошли в аккаунт!'})
                }
                else{
                    this.loginMes = "Введен неверный логин или пароль"
                }
            })
        },


        getCookie(name) {
            let matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined;
        }
    }
}
</script>

<style scoped>

</style>
