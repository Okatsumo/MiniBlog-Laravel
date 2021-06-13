<template>
        <div class="row">
        <div class="col-lg-12">
            <div class="blog-entry d-lg-flex">
                <div class="half">
                    <router-link :to="{name: 'article', params: { id: articleId } }" class="img d-flex align-items-end" v-lazy-load-background :data-src="'/storage/images/articles/' + image">
                        <div class="overlay"></div>
                    </router-link>
                </div>
                <div class="text px-md-4 px-lg-5 half">
                    <h3><router-link :to="{name: 'article', params: { id: articleId } }">{{title}}</router-link></h3>
                    <p class="size" v-if="shortDescription"> {{shortDescription}}</p>
                    <p class="mb-0"><router-link :to="{name: 'article', params: { id: articleId } }" class="btn btn-primary">Подробнее <span class="icon-arrow_forward ml-4"></span></router-link></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ArticleItem",
    props: ['title', 'articleId', 'shortDescription', 'image']
}
</script>

<style scoped>

</style>
