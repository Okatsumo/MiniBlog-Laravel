<template>
    <div class="d-flex">
        <div class="iq-sidebar" v-bind:style="{ width: sideBarWidth }">
            <div id="sidebar-scrollbar">
                <nav class="iq-sidebar-menu" v-bind:style="{ display: sideBarMenuDisplay }" >
                    <ul id="iq-sidebar-toggle" class="iq-menu">
                        <li>
                            <router-link :to = "{name: 'adminPanel.index'}" class="iq-waves-effect">
<!--                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">-->
<!--                                    <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>-->
<!--                                </svg>-->

                                <span>Главная</span>
                            </router-link>
                        </li>
                        <li class="active">
                            <router-link :to = "{name: 'adminPanel.articles'}"  class="iq-waves-effect">
<!--                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">-->
<!--                                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>-->
<!--                                </svg>-->

                                <span>Записи</span>
                            </router-link>
                        </li>
                        <li>
                            <router-link :to = "{name: 'adminPanel.users'}" class="iq-waves-effect">
<!--                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">-->
<!--                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>-->
<!--                                </svg>-->

                                <span>Пользователи</span>
                            </router-link>
                        </li>

                        <li>
                            <a href="#" class="iq-waves-effect">
                                <span>Реклама</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div>
                    <button v-on:click="hideSideBar()" id="sideBarHidden">{{hiddenBtnText}}</button>
                </div>
            </div>
        </div>
<!--        <button class="btn btn-primary btn-block" v-on:click="hideSideBar()">Скрыть</button>-->
    </div>
</template>

<script>
export default {
    name: "SidebarAdmin",

    data(){
        return {
            sideBarWidth: "14rem",
            sideBarMenuDisplay: "block",
            hiddenBtnText: "<",
        }
    },

    mounted() {
      this.load();
    },

    methods: {
        load(){
            if(document.documentElement.clientWidth <= 900){
                this.sideBarWidth = "0rem"
                this.sideBarMenuDisplay = "none"
                this.hiddenBtnText = ">"
            }
        },

        hideSideBar(){
            if(this.sideBarWidth === "14rem"){
                this.sideBarWidth = "0rem"
                this.sideBarMenuDisplay = "none"
                this.hiddenBtnText = ">"
            }
            else{
                this.sideBarWidth = "14rem"
                this.sideBarMenuDisplay = "block"
                this.hiddenBtnText = "<"
            }

        }
    }

}
</script>

<style scoped>

</style>
