<template>
    <div class="d-flex">
        <SideBarAdmin></SideBarAdmin>
        <div class="admin-container ml-auto mr-auto mt-4 ml-lg-4 mr-lg-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <router-link class="btn btn-gradient-primary px-4 btn-rounded float-right mt-0 mb-3" :to = "{name: 'adminPanel.createCategory'}">Добавить новую категорию</router-link>
                            <div class="table-responsive dash-social">
                                <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="datatable" class="table dataTable no-footer" role="grid" aria-describedby="datatable_info">
                                                <thead>

                                                <tr role="row">
                                                    <th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Customer Name: activate to sort column descending" style="width: 88%;">Название</th>
                                                    <th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Customer Name: activate to sort column descending">Управление</th>
                                                </tr>
                                                </thead>

                                                <tbody>

                                                <tr role="row" v-for="category in categories">
                                                    <td>{{category.name}}</td>
                                                    <td>
                                                        <a class="mr-2" v-on:click="remove(category.categoryId)">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eraser-fill" viewBox="0 0 16 16">
                                                                <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828l6.879-6.879zm.66 11.34L3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293l.16-.16z"/>
                                                            </svg>
                                                        </a>
                                                        <router-link :to = "{name: 'adminPanel.editCategory', params: { categoryId: category.categoryId}}">
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
</template>

<script>
import SideBarAdmin from "../components/SidebarAdmin";
export default {
    name: "CategoriesAdmin",
    components:{
        SideBarAdmin
    },

    data: ()=>({
        categories: {},

    }),
    mounted(){
        this.loadComponent()
    },
    methods: {
        loadComponent(){
            apiCategory.getList()
                .then(res=>{
                    this.categories = res;
                })
        },
        remove(categoryId){
            if(confirm('Вы действительно хотите удалить данную категорию?')){
                apiCategory.remove(categoryId)
                .then(({res})=>{
                    this.categories.reduce((values, item, index) =>{
                        if(item.categoryId === categoryId){
                            this.categories.splice(index, 1);
                        }
                    }, []);
                })


            }
        }
    }
}
</script>

<style scoped>

</style>
