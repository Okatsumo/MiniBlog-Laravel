<template>
    <div class="d-flex">
        <SideBarAdmin></SideBarAdmin>
        <div class="admin-container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <button class="btn btn-gradient-primary px-4 btn-rounded float-right mt-0 mb-3">добавить нового пользователя</button>
                            <h4 class="header-title mt-0" v-if="!totalUsers">Пользователи (всего: загрузка...)</h4>
                            <h4 class="header-title mt-0" v-else>Пользователи (всего: {{totalUsers}})</h4>
                            <div class="table-responsive dash-social">
                                <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="datatable" class="table dataTable no-footer" role="grid" aria-describedby="datatable_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Customer Name: activate to sort column descending" style="width: 216px;">Имя пользователя</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 117.6px;">Email</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 87.6px;">Дата регистрации</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 125.2px;">Администратор</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 125.2px;">Заблокирован</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1"  style="width: 62.4px;">Управление</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    <tr role="row" v-for="user in users">
                                        <td>{{user.name}}</td>
                                        <td>{{user.email}}</td>
                                        <td>{{user.created_at}}</td>
                                        <td v-if="user.admin">Да</td>
                                        <td v-else>Нет</td>
                                        <td v-if="user.banned">Да</td>
                                        <td v-else>Нет</td>

                                        <td>
                                            <a href="#" class="mr-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-dash" viewBox="0 0 16 16">
                                                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                                    <path fill-rule="evenodd" d="M11 7.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z"/>
                                                </svg>
                                            </a>
                                            <a href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                </svg>
                                            </a>
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
    name: "IndexAdmin",
    components:{
        SideBarAdmin
    },


    data: ()=> ({
        users: [],
        totalUsers: null,
    }),

    mounted() {
        this.loadArticles();
    },

    methods:{
        loadArticles(){
            api.call('get', '/api/users')
                .then(res=>{
                    this.users = res.data.data;
                    this.totalUsers = res.data.total;
                })
        },
    }

}
</script>

<style scoped>

</style>
