<template>
    <div class="d-flex">
        <SideBarAdmin></SideBarAdmin>
        <div class="admin-container ml-auto mr-auto mt-4 ml-lg-4 mr-lg-4">
            <div class="row">
                <div class="col-lg-2">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="iq-todo-page">
                                <form class="position-relative">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control todo-search"  placeholder="Поиск по записям" v-model="searchText" v-on:input="search()">
                                        <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                                    </div>
                                </form>
                                <ul class="todo-task-list p-0 m-0">
                                    <li>
                                        <ul id="todo-task1" class="sub-task  show mt-2 p-0">
                                            <li class="active"><a href="#" v-on:click="loadArticles()"> Все категории </a></li>
                                            <li v-for="category in categories"><a href="#" v-on:click="loadArticles(category.categoryId)">{{category.name}}</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <spinner v-if="loading"></spinner>
                                    <router-link class="btn btn-gradient-primary px-4 btn-rounded float-right mt-0 mb-3" :to = "{name: 'adminPanel.articlesAdd'}">Добавить новую запись</router-link>
                                    <h4 class="header-title mt-0" v-if="loading">Записи (всего: загрузка...)</h4>
                                    <h4 class="header-title mt-0" v-else>Записи (всего: {{totalArticles}})</h4>
                                    <div class="table-responsive dash-social">
                                        <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table id="datatable" class="table dataTable no-footer" role="grid" aria-describedby="datatable_info">
                                                        <thead>
                                                        <tr role="row">
                                                            <th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Customer Name: activate to sort column descending" style="width: 216px;">Id</th>
                                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 117.6px;">Название</th>
                                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 87.6px;">Дата создания</th>
                                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 125.2px;">Рейтинг</th>
                                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 125.2px;">Автор</th>
                                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1"  style="width: 62.4px;">Категория</th>
                                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1"  style="width: 62.4px;">Редактировать</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>

                                                        <tr role="row" v-for="article in articles">
                                                            <td>{{article.article_id}}</td>
                                                            <td><router-link :to = "{name: 'article', params: { id: article.article_id}}">{{article.title}}</router-link></td>
                                                            <td>{{article.created_at}}</td>
                                                            <td>{{ article.rating }}</td>
                                                            <td>{{ article.author.name }}</td>
                                                            <td><router-link :to = "{name: 'Category', params: { id: article.category.category_id}}">{{article.category.name}}</router-link></td>

                                                            <td>
                                                                <a v-on:click="removeArticle(article.article_id)" class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eraser-fill" viewBox="0 0 16 16">
                                                                        <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828l6.879-6.879zm.66 11.34L3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293l.16-.16z"/>
                                                                    </svg>
                                                                </a>
                                                                <router-link :to = "{name: 'adminPanel.editArticle', params: { articleId: article.article_id }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                                    </svg>
                                                                </router-link>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col text-center">
                    <div class="block-27">
                        <ul>
                            <li><a v-on:click="backPage()">&lt;</a></li>
<!--                            <li class="active"><span>1</span></li>-->
                            <li v-for="page in lastPage"><a v-on:click="loadPageArticles(false, page); thisPage = page">{{ page }}</a></li>
                            <li><a v-on:click="nextPage()">&gt;</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

</template>

<script>
import SideBarAdmin from '../components/SidebarAdmin'
export default {
    name: "Articles",
    components:{
        SideBarAdmin
    },
    data: ()=>({
        articles: [],
        categories: [],
        loading: true,
        thisPage: 1,
        lastPage: 1,
        totalArticles: null,
        searchText: null
    }),
    mounted(){
        this.loadArticles();
        this.loadCategories();
    },
    methods: {
        removeArticle(articleId){
            if(confirm('Вы действительно хотите удалить запись?')){
                api.call('delete', '/api/article/' + articleId)
                    .then(res=>{
                        let articleIndex = this.getArticleItem(articleId)
                        this.articles.splice(articleIndex, 1);
                    })
                    .catch(res=>{

                        console.log(res)
                    })
            }
        },

        getArticleItem(id){
            let i = null;
            this.articles.reduce((values, item, index) =>{
                if(item.article_id === id){
                    i = index;
                }
            }, []);
            return i;
        },

        loadArticles(categoryId) {
            if(categoryId){
                axios.get("/api/article/?categoryId=" + categoryId).then(res => {
                    this.articles = res.data.articles.data;
                    this.lastPage = res.data.articles.last_page;
                    this.totalArticles = res.data.articles.total;
                    this.loading = false;
                })
            }
            else{
                axios.get('/api/article').then(res => {
                    this.articles = res.data.data;
                    this.lastPage = res.data.last_page;
                    this.totalArticles = res.data.total;
                    this.loading = false;
                })
            }
        },
        loadCategories(){
            axios.get("/api/v1/category").then(res => {
                this.categories = res.data.data;
            })
        },
        // Работа со страницами
        nextPage(){
            if(this.thisPage + 1 <= this.lastPage){
                this.thisPage +=1;
                this.loadPageArticles(false, this.thisPage)
            }
        },
        backPage(){
            if(this.thisPage > 1){
                this.thisPage -=1;
                this.loadPageArticles(false, this.thisPage)
            }
        },
        loadPageArticles(categoryId, page) {
            if(categoryId){
                axios.get("/api/v1/category/" + categoryId + "?page=" + page).then(res => {
                    this.articles = res.data.articles;
                    this.loading = false;
                })
            }
            else{
                axios.get('/api/article?page=' + page).then(res => {
                    this.articles = res.data.data;
                    this.loading = false;
                })
            }
        },

        search(){
            this.loading = true;
            axios.get(`/api/articles/search?text=${this.searchText}`).then(res =>{
                this.articles = res.data.data;
                this.totalArticles = res.data.total;
                this.loading = false;
            })
        }
    }
}
</script>

<style scoped>
</style>
