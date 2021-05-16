<template>
            <div class="col-lg">
                <div class="sidebar-wrap">
                    <div class="sidebar-box p-4 about text-center ftco-animate">
                        <img :src="'/storage/images/avatars/' + user.avatar" class="img-fluid">
                        <p class=" mb-2">{{user.name}}</p>
                        <p class="m-2" v-if="user.admin" style="color: red">Администратор</p>
                        <p class="m-2" v-if="user.banned" style="color: red">Заблокирован</p>
                        <button class="btn btn-black">Настройки профиля</button>
                        <div class="text pt-4">
                            <p>{{user.description}}</p>
                        </div>
                    </div>
                </div>
            </div>
</template>

<script>

export default {
    name: "user.profile",

    data(){
        return {
            user: []
        }
    },

    mounted() {
        this.loadUser();

    },
    methods:{
        loadUser(){
            api.call('get', '/api/get-user/' + this.$route.params.userId)
                .then(res=>{
                    this.user = res.data.user;
                })
        }
    }

}
</script>

<style scoped>

</style>
