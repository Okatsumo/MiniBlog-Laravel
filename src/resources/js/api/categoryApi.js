class CategoryApi{
    constructor() {
        this.id = null;
        this.name = null;
    }

    create(){
        //
    }

    /**
     * метод удаления категории по её id
     * @param categoryId id категории
     * @return resolve при удачном запросе
     * @return reject при ошибке
     */
    static remove(categoryId){
        return new Promise((resolve, reject) => {
            api.call('delete','/api/category/' + categoryId)
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
     * Метод отвечающий за обновление информации о пользователе через API
     * @param userId id пользователя
     * @return resolve при удачном запросе
     * @return reject при ошибке
     */
    update(userId){

    }

    /**
     * Метод отвечающий за получение списка категорий из API
     * все данные хранятся в then(res)
     * @return resolve при удачном запросе
     * @return reject при ошибке
     */
    static getList(){
        return new Promise((resolve, reject) => {
            api.call('get','/api/category/')
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

export default CategoryApi;
