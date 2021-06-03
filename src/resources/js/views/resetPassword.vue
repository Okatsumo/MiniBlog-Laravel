<template>
    <div class="container mt-5">
            <div class="form-group">
                <input type="password" class="form-control" id="password" v-model="password" placeholder="Введите новый пароль">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="confirmPassword" v-model="passwordConfirm" placeholder="Введите новый пароль ещё раз">
            </div>

            <p class="text mb-3" style="color: red">{{message}}</p>
            <button class="btn btn-primary" v-on:click="resetPassword()">Восстановить пароль</button>
    </div>
</template>

<script>
import router from "../router";

export default {
    name: "resetPassword",

    data: ()=>({
        password: undefined,
        passwordConfirm: undefined,
        message: ""
    }),

    methods: {
        resetPassword(){
            if(!this.password){
                this.message = "Поле с паролем не может быть пустым"
                return
            }

            if(this.password.length < 8){
                this.message = "Минимальная длинна пароля 8 символов"
                return
            }

            if(!this.passwordConfirm){
                this.message = "Поле с повторением пароля не может быть пустым"
                return
            }

            if(this.password !== this.passwordConfirm){
                this.message = "Пароли должны совпадать"
                return
            }



            let token = this.$route.params.token;
            let params = window
                .location
                .search
                .replace('?','')
                .split('&')
                .reduce(
                    function(p,e){
                        let a = e.split('=');
                        p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
                        return p;
                    },
                    {}
                );

            let data = new FormData();
            data.append('token', token);
            data.append('email', params.email);
            data.append('password', this.password);
            data.append('password_confirmation', this.passwordConfirm);

            api.call('post', '/api/reset-password', data)
                .then(res=>{
                    router.push('/')
                })
                .then(res=>{
                    if(res.message === 404){
                        this.message = "ссылка не действительна"
                    }
                    else{
                        this.message = "произошла непредвиденная ошибка на сервере"
                    }
                })
        }
    }

}
</script>

<style scoped>

</style>
