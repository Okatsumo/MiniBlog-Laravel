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


                    <li class="dropdown" v-if="authenticated && user">
                        <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="/storage/images/avatars/default.png" alt="profile-user" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <router-link class="dropdown-item" :to="{name : 'user.profile', params: {userId: user.user_id}}"><i class="text-muted mr-2"></i> Профиль</router-link>
                            <router-link v-if="user ? user['admin'] : false" :to="{name : 'adminPanel.index'}" class="dropdown-item"><i class="text-muted mr-2"></i> Панель администратора</router-link>
                            <div class="dropdown-divider mb-0"></div>
                            <span class="dropdown-item" v-on:click="logOut()"><i class="text-muted mr-2"></i> Выход</span>

                        </div>
                    </li>

                    <li class="nav-item" v-else>
                        <a class="nav-link" v-on:click="$modal.show('login')">Авторизация</a>
                    </li>

                    <li class="dropdown notification-list" v-if="authenticated && user">
                        <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ti-bell noti-icon"></i>
                            <span class="badge badge-danger badge-pill noti-icon-badge">2</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-lg pt-0" style="">

                            <h6 class="dropdown-item-text font-15 m-0 py-3 bg-primary text-white d-flex justify-content-between align-items-center">
                                Уведомления <span class="badge badge-light badge-pill">2</span>
                            </h6>
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 302px;"><div class="slimscroll notification-list" style="overflow: hidden; width: auto; height: 302px;">

                                <a href="#" class="dropdown-item py-3">
                                    <small class="float-right text-muted pl-2">2 минуты назад</small>
                                    <div class="media">
                                        <div class="avatar-md bg-primary">
                                            <i class="la la-cart-arrow-down text-white"></i>
                                        </div>
                                        <div class="media-body align-self-center ml-2 text-truncate">
                                            <h6 class="my-0 font-weight-normal text-dark">Был совершен вход</h6>
                                            <small class="text-muted mb-0">Google Chrome</small>
                                        </div>
                                    </div>
                                </a>

                                <a href="#" class="dropdown-item py-3">
                                    <small class="float-right text-muted pl-2">1 день назад</small>
                                    <div class="media">
                                        <div class="avatar-md bg-success">
                                            <i class="la la-group text-white"></i>
                                        </div>
                                        <div class="media-body align-self-center ml-2 text-truncate">
                                            <h6 class="my-0 font-weight-normal text-dark">Человек ответил на ваш комментарий</h6>
                                            <small class="text-muted mb-0">Alex, ага, ага...</small>
                                        </div>
                                    </div>
                                </a>




                            </div><div class="slimScrollBar" style="background: rgba(162, 177, 208, 0.13); width: 7px; position: absolute; top: 0px; opacity: 1; display: none; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                            <!-- All-->
                            <a href="javascript:void(0);" class="dropdown-item text-center text-primary">
                                Посмотреть все <i class="fi-arrow-right"></i>
                            </a>
                        </div>
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
