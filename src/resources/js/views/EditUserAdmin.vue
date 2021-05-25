<template>
    <div class="d-flex">
        <SideBarAdmin></SideBarAdmin>
        <div class="admin-container ml-lg-4 mr-lg-4 mt-4">
            <h1>Редактирование пользователя</h1>


            <form>
                <div class="form-group">
                    <label for="nameInput">Логин</label>
                    <input type="text" class="form-control" id="nameInput" v-model="name">
                </div>

                <div class="form-group">
                    <label for="emailInput">Email</label>
                    <input type="text" class="form-control" id="emailInput" v-model="email">
                </div>

                <div class="form-group">
                    <label for="descInput">Статус</label>
                    <input type="text" class="form-control" id="descInput" v-model="description">
                </div>

                <div class="form-group">
                    <label for="descInput">Заблокирован</label>
                    <input type="checkbox" class="form-check" >
                </div>

                <div class="form-group">
                    <label for="descInput">Администратор</label>
                    <input type="checkbox" class="form-check" v-model="admin">
                </div>

                <div class="form-group">
                    <label for="avatar">Аватар</label>
                    <input class="form-control" id="avatar" type="file">
                    <canvas id="canvas" width="150" height="150" class="img-fluid"></canvas>
                </div>

                <p>Дата создания профиля: {{createdAt}}</p>
                <p>Дата последнего обновления профиля: {{updatedAt}}</p>

                <span class="btn btn-primary float-left" v-on:click="updateDataUser()">Обновить профиль</span>
                <router-link class="btn btn-primary float-right" :to = "{name: 'adminPanel.users'}">Назад</router-link>
            </form>

        </div>

    </div>
</template>

<script>
import SideBarAdmin from "../components/SidebarAdmin";

export default {
    name: "adminPanel.editUser",
    components:{
        SideBarAdmin
    },

    data: ()=>({
        name: "",
        email: "",
        description: "",
        banned: false,
        admin: false,
        createdAt: null,
        updatedAt: null
    }),

    mounted() {
      this.loadComponent();
    },

    methods: {
        loadComponent(){
            let user = new window.apiUser();
            user.get(this.$route.params.userId).then(()=>{
                this.name = user.name
                this.email = user.email
                this.description = user.description
                this.banned = user.banned
                this.admin = user.admin
                this.createdAt = user.createdAt
                this.updatedAt = user.createdAt

                let canvas = document.getElementById('canvas').getContext("2d");
                canvas.width = innerWidth;
                canvas.height = innerHeight;
                const image = new Image();
                image.src = "/storage/images/avatars/" + user.avatar;

                image.onload = function(){
                    canvas.drawImage(image,0,0,150,150);
                }
            })
        },

        updateDataUser(){
            let user = new window.apiUser();
            user.name = this.name;
            user.description = this.description;
            user.email = this.email;
            user.banned = this.banned;
            user.admin = this.admin;
            user.update(this.$route.params.userId)

            let avatar = document.getElementById("avatar").files[0];

            if(avatar){
                user.uploadAvatar(this.$route.params.userId, avatar)
                    .then(()=>{
                        this.avatar = user.avatar
                    })
            }

        }
    }
}
</script>

<style scoped>

</style>
