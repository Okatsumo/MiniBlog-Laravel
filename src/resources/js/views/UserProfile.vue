<template>
            <div>
                <div class="sidebar-wrap">
                    <div class="sidebar-box p-4 about text-center ftco-animate" v-if="userId">
                        <img :src="'/storage/images/avatars/' + avatar" class="img-fluid">
                        <p class=" mb-2">{{name}}</p>
                        <p class="m-2" v-if="admin" style="color: red">Администратор</p>
                        <p class="m-2" v-if="banned" style="color: red">Заблокирован</p>
                        <div class="text pt-4">
                            <p v-if="!description">{{description}}</p>
                            <p v-else>{{description}}</p>
                        </div>
                    </div>
                    <div class="sidebar-box p-4 about text-center ftco-animate" v-else>
                        <p>Пользователь не найден</p>
                    </div>
                </div>

                <div v-if="authUser  && userId && authUser.user_id === userId" class="container">
                    <div class="list-inline text-center">
                        <button class="list-inline-item btn" v-bind:class="{ 'btn-primary': editProfile }">настройки профиля</button>
                        <button class="list-inline-item btn">настройки учетной записи</button>
                    </div>

                    <div class="pt-5">
                        <form>
                            <div class="form-group">
                                <label for="statusInput">Статус</label>
                                <input type="text" class="form-control" id="statusInput" v-model="description">
                            </div>

                            <div class="form-group">
                                <label for="avatar">Обновить аватар (150x150, только jpeg, png)</label>
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
            userId: null,
            name: null,
            description: null,
            banned: null,
            admin: null,
            createdAt: null,
            updatedAt: null,
            avatar: null,


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
           let user = new window.apiUser();
           user.name = this.name;
           user.description = this.description;
           user.update(1);

           let avatar = document.getElementById("avatar").files[0];

            if(avatar){
                user.uploadAvatar(this.userId, avatar)
                    .then(()=>{
                        this.avatar = user.avatar
                    })
            }
        },

        loadUser(){
            let user = new window.apiUser();
            user.get(this.$route.params.userId).then(()=>{
                this.userId = user.id;
                this.name = user.name
                this.description = user.description
                this.avatar = user.avatar
                this.banned = user.banned
                this.admin = user.admin
                this.createdAt = user.createdAt
                this.updatedAt = user.updatedAt
            })
        }
    }

}
</script>

<style scoped>

</style>
