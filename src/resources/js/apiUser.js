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


    /**
     * Метод отвечающий за получение информации о пользователе из API
     * @param userId id пользователя
     * @return resolve при удачном запросе
     * @return reject при ошибке
     */
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
        //
    }

    /**
     * Загрузка аватара пользователя через API
     * @param userId id пользователя
     * @param avatar files
     */
    uploadAvatar(userId, avatar){
        let data = new FormData();
        data.append('avatar', avatar);

        return new Promise((resolve, reject) => {
            api.call('post', '/api/user/upload-avatar/' + userId, data)
                .then(res => {
                    this.avatar = res.data.avatar.name;
                    Vue.notify({group: 'auth', title: 'Обновление аватара', text: 'Изображения успешно загружено'});
                })
                .finally(() => {
                    resolve(true);
                })
                .catch(({response}) => {
                    if (response.status !== 200) {
                        Vue.notify({group: 'auth', title: 'Обновление аватара', text: 'Произошла ошибка'});
                    }
                });
        })
    }

    /**
     * Метод отвечающий за обновление информации о пользователе через API
     * @param userId id пользователя
     * @return resolve при удачном запросе
     * @return reject при ошибке
     */
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

            console.log(this.admin)


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

    /**
     * Метод отвечающий за получение списка пользователей из API
     * все данные хранятся в then(res)
     * @param page страница с записями из API
     * @return resolve при удачном запросе
     * @return reject при ошибке
     */
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
