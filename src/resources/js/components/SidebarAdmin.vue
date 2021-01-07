<template>
    <div>
        <div class="iq-sidebar">
            <div id="sidebar-scrollbar">
                <nav class="iq-sidebar-menu">
                    <ul id="iq-sidebar-toggle" class="iq-menu">
                        <li>
                            <a href="#" class="iq-waves-effect"><i class="las la-newspaper"></i><router-link :to = "{name: 'adminPanel.index'}">Главная</router-link></a>
                        </li>
                        <li class="active">
                            <a href="#" class="iq-waves-effect"><i class="las la-user"></i><router-link :to = "{name: 'adminPanel.articles'}">Записи</router-link></a>
                        </li>
                        <li>
                            <a href="#" class="iq-waves-effect"><i class="las la-user-friends"></i><span>Пользователи</span></a>
                        </li>
                        <li>
                            <a href="#" class="iq-waves-effect"><i class="las la-user-friends"></i><span>Пользователи</span></a>
                        </li>
                        <li>
                            <a href="#" class="iq-waves-effect"><i class="las la-users"></i><span>Реклама</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SidebarAdmin"
}
</script>

<style scoped>

</style>
