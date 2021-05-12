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


                    <li class="nav-item" v-if="user ? user['admin'] : false">
                        <router-link class="nav-link" :to="{name : 'adminPanel.index'}">Панель администратора</router-link>
                    </li>


                    <li class="nav-item" v-if="authenticated && user">
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

    data() {
        return {
            categories: [],
            authenticated: auth.check(),
            user: auth.user,
        };
    },


    mounted() {
      this.loadCategories();
      Event.$on('userLoggedIn', () => {
          this.authenticated = true;
          this.user = auth.user;
          this.userId = auth.user.user_id;
      });

      Event.$on('userLogout', ()=>{
          this.authenticated = false;
          this.user = null;
      });
    },

    methods: {
        loadCategories(){
            axios.get("/api/category/").then(res => {
                this.categories = res.data;
            })
        },

        logOut(){
            if(confirm("Вы действительно хотите выйти?")){
                auth.logout();
                Vue.notify({group: 'auth',title: 'Выход',text: 'Вы успешно вышли из аккаунта!'})
            }
        }
    }
}
</script>

<style scoped>

</style>
