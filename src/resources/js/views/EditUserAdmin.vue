<template>
    <div class="d-flex">
        <SideBarAdmin></SideBarAdmin>
        <div class="admin-container mt-4 mr-4 ml-4 mb-4">
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
                    <label for="image">Аватар</label>
                    <input class="form-control" id="image" type="file">
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
            api.call('get', `/api/get-user/${this.$route.params.userId}`)
                .then(res=>{
                    this.name = res.data.user.name
                    this.email = res.data.user.email
                    this.email = res.data.user.email
                    this.description = res.data.user.dec
                    this.banned = res.data.user.banned
                    this.admin = res.data.user.admin
                    this.createdAt = res.data.user.created_at
                    this.updatedAt = res.data.user.created_at

                    let canvas = document.getElementById('canvas').getContext("2d");
                    canvas.width = innerWidth;
                    canvas.height = innerHeight;
                    const image = new Image();
                    image.src = "/storage/images/avatars/" + res.data.user.avatar;

                    image.onload = function(){
                        canvas.drawImage(image,0,0,150,150);
                    }
                })
        },

        updateDataUser(){
            let data = {
                name: this.name
            }

            api.call('get', `/api/user/${this.$route.params.userId}/edit?name=${this.name}&email=${this.email}&dec=${this.description}&admin=${Number(this.admin)}&banned=${Number(this.banned)}`)
                .then(res=>{
                    console.log(res.data)
                })
        }
    }
}
</script>

<style scoped>

</style>
