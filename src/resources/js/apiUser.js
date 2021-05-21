class ApiUser{
    constructor() {
        this.id = null;
        this.name = null;
        this.email = null;
        this.emailVerifiedAt = null;
        this.avatar = null;
        this.description = null;
        this.admin =  null;
        this.banned = null;
        this.createdAt = null;
        this.updatedAt = null;
    }

    get(userId) {
        return new Promise((resolve, reject) => {
            api.call('get','/api/get-user/' + userId)
                .then(response => {
                    this.id = response.data.user.user_id;
                    this.name = response.data.user.name;
                    this.email = response.data.user.email;
                    this.emailVerifiedAt = response.data.user.email_verified_at;
                    this.avatar = response.data.user.avatar;
                    this.description = response.data.user.dec;
                    this.admin = response.data.user.admin;
                    this.banned = response.data.user.banned;
                    this.createdAt = response.data.user.created_at;
                    this.updatedAt = response.data.user.updated_at;
                })
                .finally(()=>{
                    resolve(true);
                })
                .catch(({response}) => {
                    reject(response);
                });
        });
    }


    create(){
        return new Promise((resolve, reject) => {
            api.call('get','/api/user/')
                .then(response => {

                })
                .finally(()=>{
                    resolve(true);
                })
                .catch(({response}) => {
                    reject(response);
                });
        });
    }

    update(userId){
        return new Promise((resolve, reject) => {
            let data = new FormData();

            if(this.name){
                data.append('name', this.name)
            }
            if(this.email){
                data.append('email', this.email)
            }

            if(this.description){
                data.append('description', this.description)
            }
            if(this.admin){
                data.append('admin', this.admin)
            }
            if(this.banned){
                data.append('banned', this.banned)
            }


            axios.post(`/api/user/${userId}/edit`, data)
                .then(response => {
                    this.id = response.data.user.user_id;
                    this.name = response.data.user.name;
                    this.email = response.data.user.email;
                    this.emailVerifiedAt = response.data.user.email_verified_at;
                    this.avatar = response.data.user.avatar;
                    this.description = response.data.user.dec;
                    this.admin = response.data.user.admin;
                    this.banned = response.data.user.banned;
                    this.createdAt = response.data.user.created_at;
                    this.updatedAt = response.data.user.updated_at;

                    Vue.notify({group: 'auth',title: 'Обновление информации о пользователе',text: 'Профиль успешно обновлен'})
                })
                .finally(()=>{
                    resolve(true);
                })
                .catch(({response}) => {
                    Vue.notify({group: 'auth',title: 'Обновление информации о пользователе',text: 'Произошла ошибка!'})
                    reject(response);
                });
        });

    }

    getList(page = null){
        let url = page ? '/api/users?page=' + page : '/api/users/';

        return new Promise((resolve, reject) => {
            api.call('get', url)
                .then(response => {
                    resolve(response.data);
                })
                .finally(()=>{
                    resolve(true);
                })
                .catch(({response}) => {
                    reject(response);
                });
        });
    }
}

export default ApiUser;
