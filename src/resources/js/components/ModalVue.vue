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
                <div class="row" style="padding-top: 1rem">
                    <div class="col">
                        <span class="btn btn-primary float-left" v-on:click="login()">ВХОД</span>
                        <span class="btn btn-primary float-right" v-on:click="authForm = 'register'">Регистрация</span>
                    </div>
                </div>
            </div>
            <p v-text="mes" style="color: #ffffff"></p>
        </form>

        <form class="form-horizontal" v-if="authForm === 'register'">
            <span class="heading">РЕГИСТРАЦИЯ</span>

            <div class="form-group">
                <input type="text" class="form-control" placeholder="Логин" v-model="nameReg">
                <i class="fa fa-user"></i>
            </div>

            <div class="form-group">
                <input type="email" class="form-control" placeholder="E-mail" v-model="emailReg">
                <i class="fa fa-user"></i>
            </div>
            <div class="form-group help">
                <input type="password" class="form-control" placeholder="Пароль" v-model="passwordReg">
                <i class="fa fa-lock"></i>
                <a href="#" class="fa fa-question-circle"></a>
            </div>

            <div class="form-group help">
                <input type="password" class="form-control" placeholder="Повторите пароль" v-model="passwordConfReg">
                <i class="fa fa-lock"></i>
                <a href="#" class="fa fa-question-circle"></a>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <span class="btn btn-primary float-left" v-on:click="register()">Зарегистрироваться</span>
                        <span class="btn btn-primary float-right" v-on:click="authForm = 'login' ">Авторизация</span>
                    </div>
                </div>
            </div>
            <p v-text="mes" style="color: #ffffff"></p>
        </form>
    </modal>
</template>

<script>
export default {
    name: "ModalVue",

    data: ()=>({
        email: undefined,
        password: undefined,
        mes: undefined,
        authForm: "login",
        admin: false,

        nameReg: undefined,
        passwordReg: undefined,
        passwordConfReg: undefined,
        emailReg: undefined,
    }),

    methods: {
        // Метод отвечающий за регистрацию
        register(){
            if(!this.nameReg){
                this.mes = "Поле с логином не может быть пустым";
                return;
            }
            if (!this.emailReg)
            {
                this.mes = "Поле с email-ом не может быть пустым";
                return;
            }
            if(!this.passwordReg){
                this.mes = "Поле с паролем не может быть пустым";
                return;
            }
            if(!this.passwordConfReg){
                this.mes = "Поле с повтором пароля не может быть пустым";
                return;
            }
            if(this.passwordReg != this.passwordConfReg){
                this.mes = "Пароли не совпадают";
                return;
            }

            axios.put('/api/auth/register',{
                email: this.emailReg,
                password: this.passwordReg,
                name: this.nameReg
            }).then(res=>{
                if(res.data.status){
                    this.mes = "Вы были успешно зарегистрированы!";


                }
                else this.mes = res.data.error;
            })


        },

        // Метод отвечающий за авторизацию
        login(){
            if (!this.email)
            {
                this.mes = "Поле с email-ом не может быть пустым"

                return;
            }
            if(!this.password){
                this.mes = "Поле с паролем не может быть пустым"
                return;
            }

            axios.put('/api/auth/login',{
                email: this.email,
                password: this.password
            }).then(res=>{
                if(res.data['status']){
                    this.$modal.hide('login');
                    this.mes = null;

                    let accessToken = JSON.parse(atob(res.data['tokens']['access'].split(".")[1]));
                    let refreshToken = JSON.parse(atob(res.data['tokens']['refresh'].split(".")[1]));

                    document.cookie = `access = ${res.data['tokens']['access']}; max-age = ${accessToken['exp']}`;
                    document.cookie = `refresh = ${res.data['tokens']['refresh']}; max-age = ${refreshToken['exp']}`;

                    Vue.notify({group: 'auth',title: 'Авторизация',text: 'Вы успешно вошли в аккаунт!'})
                    this.$root.$emit('Navbar')
                    this.email = null;
                    this.password = null;
                }
                else{
                    this.mes = "Введен неверный логин или пароль"
                    this.password = null;
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
