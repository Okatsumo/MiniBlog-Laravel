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
                    <canvas id="canvas" width="640" height="360" class="img-fluid"></canvas>
                </div>

                <p>Дата создания профиля: {{createdAt}}</p>
                <p>Дата последнего обновления профиля: {{updatedAt}}</p>

                <span class="btn btn-primary float-left">Обновить профиль</span>
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
            let user = new apiUser(1);
            console.log(user)


            // this.name = user.name
            // this.email = user.email
            // this.email = user.email
            // this.description = user.description
            // this.banned = user.banned
            // this.admin = user.admin
            // this.createdAt = user.createdAt
            // this.updatedAt = user.updatedAt

        },

        sendUser(){
            let data = new FormData();

          api.call('post', `/api/user/${this.$route.params.userId}/edit`)
            .then(res=>{

            })
        }
    }
}
</script>

<style scoped>

</style>
