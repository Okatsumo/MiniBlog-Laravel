<template>
    <div>
        <SideBarAdmin></SideBarAdmin>

        <div class="container container-content">

            <h1>Главная</h1>

            <p>Всего записей: 1</p>

        </div>
    </div>

</template>

<script>
import SideBarAdmin from "../components/SidebarAdmin";

export default {
    name: "IndexAdmin",
    components:{
        SideBarAdmin
    },

    mounted() {
        this.auth()
    },

    methods:{
        auth(){

            if(this.getCookie('refresh')){
                let token = atob(this.getCookie('refresh').split(".")[1]);
                console.log(token)
            }
            else{
                this.$router.push("/")
            }
        },
        getCookie(name) {
            let matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined;
        }
    }

}
</script>

<style scoped>

</style>
