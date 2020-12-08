<template>
    <div>
        <section class="hero-wrap hero-wrap-2" style="background-image: url('https://i.pinimg.com/originals/ab/d3/91/abd391cf3428d8d3cb03c7993342ce91.jpg');">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text align-items-end justify-content-center">
                    <div class="col-md-9 ftco-animate pb-5 text-center">
                        <h1 class="mb-3 bread">Lifestyle</h1>
                        <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Lifestyle <i class="ion-ios-arrow-forward"></i></span></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="ftco-section">
            <spin v-if="loading"></spin>
            <div class="container" v-if="!loading">
                <div class="row">
                    <div class="col-lg-9">
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
                                        <p>{{article.content}}</p>
                                        <p class="mb-0"><router-link :to="{name: 'article', params: { id: article.article_id } }" class="btn btn-primary">Подробнее <span class="icon-arrow_forward ml-4"></span></router-link></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="sidebar-wrap">
                            <div class="sidebar-box p-4">
                                <form action="#" class="search-form">
                                    <div class="form-group">
                                        <span class="icon icon-search"></span>
                                        <input type="text" class="form-control" placeholder="Поиск..">
                                    </div>
                                </form>
                            </div>
                            <div class="sidebar-box categories text-center">
                                <h2 class="heading mb-4">Категории</h2>
                                <ul class="category-image">
                                    <li>
                                        <a href="#" class="img d-flex align-items-center justify-content-center text-center" style="background-image: url(images/category-1.jpg);">
                                            <div class="text">
                                                <h3>Бэкенд</h3>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="img d-flex align-items-center justify-content-center text-center" style="background-image: url(images/category-2.jpg);">
                                            <div class="text">
                                                <h3>Фронтенд</h3>
                                            </div>
                                        </a>
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

import Axios from 'axios'
import spin from '../components/Spinner'

export default {

    name: "Category",

    components: {
        spin
    },

    data: ()=>({
        articles: [],
        loading: true
    }),
    mounted(){
        this.LoadArticles()
    },
    methods: {
        LoadArticles(){
            axios.get('api/article').then(res =>{
                this.articles = res.data.data;
                this.loading = false;
            })
        }
    }

}
</script>

<style scoped>

</style>
