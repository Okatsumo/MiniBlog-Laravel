<template>
    <div class="d-flex">
        <SideBarAdmin></SideBarAdmin>
        <div class="container mt-4">
            <h1>Добавление новой категории</h1>
            <div class="form-group">
                <label for="nameInput">Название</label>
                <input type="text" class="form-control" id="nameInput" v-model="name" placeholder="макс. 11 символов">
            </div>

            <p class="text" style="color: black">{{error}}</p>
            <span class="btn btn-primary float-left" v-on:click="createCategory()">Добавить</span>
        </div>
    </div>
</template>

<script>
import SideBarAdmin from "../components/SidebarAdmin";
export default {
    name: "adminPanel.createCategory",

    components: {
        SideBarAdmin
    },

    data: ()=>({
        name: "",
        error: ""
    }),

    methods:{
        createCategory(){
            if(!this.name){
                this.error = "Название не может быть пустым"
                return;
            }

            if(this.name.length > 11){
                this.error = "Название не может быть длиннее 11 символов"
                return;
            }

            let category = new window.apiCategory();
            category.name = this.name;

            category.create().then()
        }
    }
}
</script>

<style scoped>

</style>
