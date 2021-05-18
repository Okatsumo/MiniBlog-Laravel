<template>
            <div>
                <div class="sidebar-wrap">
                    <div class="sidebar-box p-4 about text-center ftco-animate" v-if="user.user_id">
                        <img :src="'/storage/images/avatars/' + user.avatar" class="img-fluid">
                        <p class=" mb-2">{{user.name}}</p>
                        <p class="m-2" v-if="user.admin" style="color: red">Администратор</p>
                        <p class="m-2" v-if="user.banned" style="color: red">Заблокирован</p>
                        <div class="text pt-4">
                            <p>{{user.dec}}</p>
                        </div>
                    </div>
                    <div class="sidebar-box p-4 about text-center ftco-animate" v-else>
                        <p>Пользователь не найден</p>
                    </div>
                </div>


                <div v-if="authUser  && user.user_id && authUser.user_id === user.user_id" class="container">
                    <div class="list-inline text-center">
                        <button class="list-inline-item btn" v-bind:class="{ 'btn-primary': editProfile }">настройки профиля</button>
                        <button class="list-inline-item btn">настройки учетной записи</button>
                    </div>


                    <div class="pt-5">
                        <form>
                            <div class="form-group">
                                <label for="statusInput">Статус</label>
                                <input type="text" class="form-control" id="statusInput" v-model="userDescription">
                            </div>

                            <div class="form-group">
                                <label for="avatar">Обновить аватар (150x1050)</label>
                                <input class="form-control" id="avatar" type="file">
                            </div>

                            <span class="btn btn-primary btn-block" v-on:click="updateProfile()">Обновить</span>
                        </form>
                    </div>

                </div>

            </div>


</template>

<script>


export default {
    name: "user.profile",

    data(){
        return {
            user: [],
            userDescription: null,
            editProfile: true,
            editText: false,


            authenticated: auth.check(),
            authUser: auth.user,
        }
    },

    mounted() {
        this.loadUser();
        Event.$on('userLoggedIn', () => {
            this.authenticated = true;
            this.user = auth.user;
        });

        Event.$on('userLogout', ()=>{
            this.authenticated = false;
            this.user = null;
        });
    },
    methods:{
        updateProfile(){
            api.call('get', `/api/user/${this.authUser.user_id}/edit?description=${this.userDescription}`)
                .then(res=>{
                    this.user.dec = res.user.dec;
                })
        },

        loadUser(){
            api.call('get', '/api/get-user/' + this.$route.params.userId)
                .then(res=>{
                    this.user = res.data.user;
                    this.userDescription = res.data.user.dec;
                })
        }
    }

}
</script>

<style scoped>

</style>
