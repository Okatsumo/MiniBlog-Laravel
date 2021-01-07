<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <router-link class="navbar-brand" to="/" >МиниБлог<span>.</span></router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Меню
            </button>


            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <router-link to="/" class="nav-link">Главная</router-link>
                    </li>

                    <li class="nav-item">
                        <router-link :to="{name: 'Articles'}" class="nav-link">Все записи</router-link>
                    </li>


                    <li class="nav-item" v-for="category in categories">
                        <router-link :to="{name: 'Articles'}" class="nav-link">{{category.name}}</router-link>
                    </li>


                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name : 'adminPanel.index'}">Панель администратора</router-link>
                    </li>


                    <li class="nav-item" v-if="auth">
                        <a class="nav-link">Выход</a>
                    </li>
                    <li class="nav-item" v-else>
                        <a class="nav-link">Авторизация</a>
                    </li>


                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: "Navbar",

    data: ()=>({
        categories: [],
        auth:false,
        user: []
    }),

    mounted() {
      this.loadCategories()
      this.verifyAuth()
    },

    methods: {
        loadCategories(){
            axios.get("/api/category/").then(res => {
                this.categories = res.data;
            })
        },

        getCookie(name) {
            let matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined;
        },

        verifyAuth(){
            if(this.getCookie('refresh')){
                this.user = atob(this.getCookie('refresh').split(".")[1]);
                this.auth = true;
            }
            else{
                this.auth = false;
            }
        },
    }
}
</script>

<style scoped>

</style>
