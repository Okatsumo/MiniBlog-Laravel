<template>
    <modal name="login" :height="'auto'" :draggable = true :adaptive = true>
        <form class="form-horizontal" v-if="authForm === 'login'">
            <span class="heading">АВТОРИЗАЦИЯ</span>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="E-mail" v-model="email">
                <i class="fa fa-user"></i>
            </div>
            <div class="form-group help">
                <input type="password" class="form-control" placeholder="Пароль" v-model="password">
                <i class="fa fa-lock"></i>
                <a href="#" class="fa fa-question-circle"></a>
            </div>
            <div class="form-group">
                <div class="main-checkbox">
                    <input type="checkbox" value="none" id="checkbox1" name="check"/>
                    <label for="checkbox1"></label>
                </div>

                <div class="row">
                    <div class="col">
                        <span class="text" style="color: #ffffff">Запомнить</span>
                    </div>
                </div>

                <div class="row" style="padding-top: 1rem">
                    <div class="col">
                        <span class="btn btn-primary float-left" v-on:click="login()">ВХОД</span>
                        <span class="btn btn-primary float-right" v-on:click="authForm = 'register'">Регистрация</span>
                    </div>
                </div>
            </div>
            <p v-text="loginMes" style="color: #ffffff"></p>
        </form>


        <form class="form-horizontal" v-if="authForm === 'register'">
            <span class="heading">РЕГИСТРАЦИЯ</span>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="E-mail">
                <i class="fa fa-user"></i>
            </div>
            <div class="form-group help">
                <input type="password" class="form-control" placeholder="Пароль">
                <i class="fa fa-lock"></i>
                <a href="#" class="fa fa-question-circle"></a>
            </div>

            <div class="form-group help">
                <input type="password" class="form-control" placeholder="Повторите пароль">
                <i class="fa fa-lock"></i>
                <a href="#" class="fa fa-question-circle"></a>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <span class="btn btn-primary float-left" v-on:click="login()">Зарегистрироваться</span>
                        <span class="btn btn-primary float-right" v-on:click="authForm = 'login'">Авторизация</span>
                    </div>
                </div>
            </div>
        </form>
    </modal>
</template>

<script>
export default {
    name: "ModalVue",

    data: ()=>({
        email: undefined,
        password: undefined,
        loginMes: undefined,
        authForm: "login"
    }),

    methods: {
        login(){
            axios.put('api/auth/login',{
                email: this.email,
                password: this.password
            }).then(res=>{
                if(res.data['status']){
                    this.$modal.hide('login');
                    this.loginMes = null;

                    let accessToken = JSON.parse(atob(res.data['tokens']['access'].split(".")[1]));
                    let refreshToken = JSON.parse(atob(res.data['tokens']['refresh'].split(".")[1]));


                    document.cookie = `access = ${res.data['tokens']['access']}; max-age = ${accessToken['exp']}`;
                    document.cookie = `refresh = ${res.data['tokens']['refresh']}; max-age = ${refreshToken['exp']}`;

                    vu.Navbar.auth = true;

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
        },
        parse(obj) {

        }
    }
}
</script>

<style scoped>

</style>
