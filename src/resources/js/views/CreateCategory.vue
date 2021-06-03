<template>
    <div class="d-flex">
        <SideBarAdmin></SideBarAdmin>
        <div class="container mt-4">
            <h1>{{title}}</h1>
            <div class="form-group">
                <label for="nameInput">Название</label>
                <input type="text" class="form-control" id="nameInput" v-model="name" placeholder="макс. 11 символов">
            </div>

            <p class="text" style="color: black">{{error}}</p>
            <span class="btn btn-primary float-left" v-if="!update" v-on:click="createCategory()">Добавить</span>
            <span class="btn btn-primary float-left" v-else v-on:click="updateCategory()">Редактировать</span>

        </div>
    </div>
</template>

<script>
import SideBarAdmin from "../components/SidebarAdmin";
import router from "../router";
export default {
    name: "adminPanel.createCategory",

    components: {
        SideBarAdmin
    },

    data: ()=>({
        name: "",
        error: "",
        update: false,

        title: "Добавление новой категории"
    }),

    mounted() {
        this.loadComponent();
    },

    methods:{
        loadComponent(){
            if(this.$route.params.categoryId){
                this.title = "Редактирование категории"
                this.update = true;
                window.apiCategory.get(this.$route.params.categoryId).then(res=>{
                    this.name = res.category.name;
                });
            }
            else{
                this.title = "Добавление новой категории"
            }
        },

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

            category.create().then(res=>{
                this.name = "";
                this.error = "";
                router.back();
            });

        },

        updateCategory(){
            let category = new window.apiCategory();
            category.name = this.name;
            category.update(this.$route.params.categoryId).then(res=>{
                console.log(res.data)
            })
        }
    }
}
</script>

<style scoped>

</style>
