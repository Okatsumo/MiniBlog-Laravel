<template>
    <div>
        <section class="hero-wrap hero-wrap-2" style="background-image: url('https://i.pinimg.com/originals/ab/d3/91/abd391cf3428d8d3cb03c7993342ce91.jpg');">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text align-items-end justify-content-center">
                    <div class="col-md-9 pb-5 text-center">
                        <spinner v-if="loading"></spinner>
                        <h1 class="mb-3 bread">{{article.title}}</h1>
                        <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Главная </a> / </span> <span>{{category.name}}<i class="ion-ios-arrow-forward"></i></span></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="ftco-section container-content" v-if="!loading">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 order-lg-last ">

                        <div class="content">
                            <span v-html="article.content"></span>
                        </div>

                        <div class="tag-widget post-tag-container mb-5 mt-5">
                            <div class="tagcloud">
                                <a href="#" class="tag-cloud-link">Бэкенд</a>
                                <a href="#" class="tag-cloud-link">Веб</a>
                                <a href="#" class="tag-cloud-link">Web</a>
                                <a href="#" class="tag-cloud-link">Backend</a>
                            </div>
                        </div>

                        <div class="about-author d-flex p-4 bg-light">
                            <div class="bio mr-5">
                                <img :src="'/storage/images/avatars/' + author.avatar" alt="Image placeholder" class="img-fluid mb-4" w>
                            </div>
                            <div class="desc">
                                <h3>{{author.name}}</h3>
                                <p>{{author.dec}}</p>
                            </div>
                        </div>


                        <div class="pt-5 mt-5">
                            <h3 class="mb-5">6 Комментариев</h3>
                            <ul class="comment-list">
                                <li class="comment">
                                    <div class="vcard bio">
                                        <img src="/storage/images/avatars/default.png" alt="Image placeholder">
                                    </div>
                                    <div class="comment-body">
                                        <h3>Admin</h3>
                                        <div class="meta">October 03, 2018 at 2:21pm</div>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>
                                        <p><a href="#" class="reply">Reply</a></p>
                                    </div>
                                </li>

                                <li class="comment">
                                    <div class="vcard bio">
                                        <img src="/storage/images/avatars/default.png">
                                    </div>
                                    <div class="comment-body">
                                        <h3>Admin</h3>
                                        <div class="meta">October 03, 2018 at 2:21pm</div>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>
                                        <p><a href="#" class="reply">Reply</a></p>
                                    </div>

                                    <ul class="children">
                                        <li class="comment">
                                            <div class="vcard bio">
                                                <img src="/storage/images/avatars/default.png">
                                            </div>
                                            <div class="comment-body">
                                                <h3>Admin</h3>
                                                <div class="meta">October 03, 2018 at 2:21pm</div>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>
                                                <p><a href="#" class="reply">Reply</a></p>
                                            </div>


                                            <ul class="children">
                                                <li class="comment">
                                                    <div class="vcard bio">
                                                        <img src="/storage/images/avatars/default.png" alt="Image placeholder">
                                                    </div>
                                                    <div class="comment-body">
                                                        <h3>Admin</h3>
                                                        <div class="meta">October 03, 2018 at 2:21pm</div>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>
                                                        <p><a href="#" class="reply">Reply</a></p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <!-- END comment-list -->

                            <div class="comment-form-wrap pt-5">
                                <form action="#" class="p-5 bg-light">
                                    <div class="form-group">
                                        <label for="message">Отправить комментарий: </label>
                                        <textarea name="" id="message" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="Отправить" class="btn py-3 px-4 btn-primary">
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div> <!-- .col-md-8 -->
                    <div class="col-lg-4 sidebar pr-lg-5">
                        <div class="sidebar-box">
                            <ul class="categories">
                                <h3 class="heading mb-4">Категории</h3>
                                <li><a href="#">Бэкенд <span>(12)</span></a></li>
                                <li><a href="#">Фронтенд <span>(22)</span></a></li>
                            </ul>
                        </div>

                        <div class="sidebar-box ">
                            <h3 class="heading mb-4">Похожие записи</h3>
                            <div class="block-21 mb-4 d-flex">
                                <a class="blog-img mr-4" style="background-image: url(images/image_1.jpg);"></a>
                                <div class="text">
                                    <h3><a href="#">Название записи</a></h3>
                                    <div class="meta">
                                        <div><a href="#"><span class="icon-calendar"></span> февраль 12, 2020</a></div>
                                        <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                                        <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-box ">
                            <h3 class="heading mb-4">Реклама</h3>
                        </div>
                    </div>

                </div>
            </div>
        </section> <!-- .section -->
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: "Article",

    data: ()=>({
      article: {},
      author: {},
      category: {},
      loading: true
    }),

    mounted() {
        this.loadingArticle()
    },

    methods:{
        loadingArticle(){
            axios.get(`/api/article/${this.$route.params.id}`).then(res=>{
                this.article = res.data.article;
                this.author = res.data.author
                this.category = res.data.category
                this.loading = false;
            })
            .catch(error=>{
                console.log('Произошла ошибка')
            })
        }
    }

}
</script>

<style scoped>

</style>
