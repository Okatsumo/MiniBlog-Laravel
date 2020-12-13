<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <router-link class="navbar-brand" to="/" >МиниБлог<span>.</span></router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Меню
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <router-link to="/" class="nav-link">Главная</router-link>
                    </li>

                    <li class="nav-item active">
                        <router-link :to="{name: 'Articles'}" class="nav-link">Все записи</router-link>
                    </li>


                    <li class="nav-item active" v-for="link in links">
                        <router-link :to="{name: 'Category', params: {id: link.category_id}}" class="nav-link">{{link.name}}</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import axios from 'axios';

export default {
    data(){
        return {
            links: []
        }
    },

    mounted() {
      this.articleLoad()
    },

    methods:{
        articleLoad(){
            axios.get('api/category').then(res=>{
                this.links = res.data
            })
        }
    }
}
</script>
