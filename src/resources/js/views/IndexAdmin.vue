<template>
    <div>
        <SideBarAdmin></SideBarAdmin>

        <div class="container container-content admin-container">

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

    },

    methods:{

    }

}
</script>

<style scoped>

</style>
