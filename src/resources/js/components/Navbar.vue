<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <router-link class="navbar-brand" to="/" >Technology<span>+</span></router-link>
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
                        <router-link :to="{name: 'Category', params: { id: category.category_id }}" class="nav-link">{{category.name}}</router-link>
                    </li>


                    <li class="nav-item" v-if="admin">
                        <router-link class="nav-link" :to="{name : 'adminPanel.index'}">Панель администратора</router-link>
                    </li>


                    <li class="nav-item" v-if="auth">
                        <a class="nav-link" v-on:click="logOut()">Выход</a>
                    </li>
                    <li class="nav-item" v-else>
                        <a class="nav-link" v-on:click="$modal.show('login')">Авторизация</a>
                    </li>


                </ul>
            </div>
        </div>
        <modalLogin></modalLogin>
    </nav>
</template>

<script>
export default {
    name: "Navbar",

    data: ()=>({
        categories: [],
        auth:false,
        admin: false,
        user: []
    }),

    mounted() {
      this.loadCategories()
      this.verifyAuth()
      this.$root.$on('Navbar', () => {
              this.updateLogin()
          })
    },

    methods: {
        loadCategories(){
            axios.get("/api/category/").then(res => {
                this.categories = res.data;
            })
        },

        updateLogin(){
//            this.auth = !this.auth;
            if(this.auth){
                this.admin = false;
                this.auth = false;
            }
            else {
                this.auth = true;
                this.verifyAuth();
            }
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
                this.admin = JSON.parse(atob(this.getCookie('access').split(".")[1]))['admin'];
            }
            else{
                this.auth = false;
            }
        },
        logOut(){
            if(confirm("Вы действительно хотите выйти?")){
                document.cookie ="access = '123'; max-age = 0";
                document.cookie = "refresh = '123'; max-age = 0";
                Vue.notify({group: 'auth',title: 'Авторизация',text: 'Вы успешно вышли из аккаунта!'});
                this.auth = false;
            }

        }
    }
}
</script>

<style scoped>

</style>
