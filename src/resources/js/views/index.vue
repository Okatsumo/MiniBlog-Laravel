<template>
    <div>
        <section>
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://i.pinimg.com/originals/ab/d3/91/abd391cf3428d8d3cb03c7993342ce91.jpg" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="https://i.pinimg.com/originals/ab/d3/91/abd391cf3428d8d3cb03c7993342ce91.jpg" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="https://i.pinimg.com/originals/ab/d3/91/abd391cf3428d8d3cb03c7993342ce91.jpg" class="d-block w-100">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </section>

        <section class="ftco-section container-content">
            <div class="container">
                <h3 class="text-center">Последние записи</h3>
                <div class="row">
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-md-6 col-lg-12">
                                <div class="blog-entry d-lg-flex">
                                    <div class="half">
                                        <router-link :to="{name: 'article', params: { id: 1 } }" class="img d-flex align-items-end" style="background-image: url(https://i.pinimg.com/originals/ab/d3/91/abd391cf3428d8d3cb03c7993342ce91.jpg);">
                                            <div class="overlay"></div>
                                        </router-link>
                                    </div>
                                    <div class="text px-md-4 px-lg-5 half pt-3">
                                        <h3><router-link :to="{name: 'article', params: { id: 1 } }">test</router-link></h3>
                                        <p>1 ...</p>
                                        <p class="mb-0"><router-link :to="{name: 'article', params: { id: 1 } }" class="btn btn-primary">Подробнее <span class="icon-arrow_forward ml-4"></span></router-link></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

</template>

<script>
export default {
name: "index"
}
</script>

<style scoped>

</style>
