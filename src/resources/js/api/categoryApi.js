class CategoryApi{
    constructor() {
        this.id = null;
        this.name = null;
    }


    static get(categoryId){
        return new Promise((resolve, reject) => {
            api.call('get','/api/v1/category/' + categoryId)
                .then((res)=>{
                    resolve(res.data);
                })
                .finally(()=>{
                    resolve(true);
                })
                .catch(response=>{
                })
        });
    }


    create(){
        let data = new FormData();
        data.append('name', this.name);

        return new Promise((resolve, reject) => {
            api.call('post','/api/v1/category', data)
                .then(()=>{
                    Vue.notify({group: 'auth',title: 'Добавление новой категории',text: "Категория успешно создана"})
                })
                .finally(()=>{
                    resolve(true);
                })
                .catch(response=>{
                    if(response.status === 422){
                        Vue.notify({group: 'auth',title: 'Добавление новой категории',text: "Категория с таким названием уже существует"})
                    }
                })
        });
    }

    /**
     * метод удаления категории по её id
     * @param categoryId id категории
     * @return resolve при удачном запросе
     * @return reject при ошибке
     */
    static remove(categoryId){
        return new Promise((resolve, reject) => {
            api.call('delete','/api/v1/category/' + categoryId)
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

    /**
     * Метод отвечающий за обновление категории через API
     * @param categoryId id категории
     * @return resolve при удачном запросе
     * @return reject при ошибке
     */
    update(categoryId){
        return new Promise((resolve, reject) => {
            api.call('put','/api/v1/category/' + categoryId + '?name=' + this.name)
                .then(()=>{
                    Vue.notify({group: 'auth',title: 'Обновление названия категории',text: "Название категории успешно обновлено"})
                })
                .finally(()=>{
                    resolve(true);
                })
                .catch(response=>{
                    if(response.status === 422){
                        Vue.notify({group: 'auth',title: 'Обновление названия категории',text: "Категория с таким названием уже существует"})
                    }
                })
        });
    }

    /**
     * Метод отвечающий за получение списка категорий из API
     * все данные хранятся в then(res)
     * @return resolve при удачном запросе
     * @return reject при ошибке
     */
    static getList(){
        return new Promise((resolve, reject) => {
            api.call('get','/api/v1/category/')
                .then(response => {
                    resolve(response.data.data);
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

export default CategoryApi;
