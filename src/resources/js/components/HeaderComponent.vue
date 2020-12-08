<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <router-link class="navbar-brand" to="/" >МиниБлог<span>.</span></router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active" v-for="link in links">
                        <router-link :to="link.href" class="nav-link">{{link.title}}</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    data(){
        return {
            links: [
                {
                    title: 'Главная',
                    href: '/',
                },
                {
                    title: 'Бэкенд',
                    href: '/category',
                },
                {
                    title: 'Фронтенд',
                    href: '/category',
                }
            ]
        }
    }
}
</script>
