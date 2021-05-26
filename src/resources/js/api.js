class Api {
    constructor () {

    }

    // простенький метод в который будут отправляться все запросы требующие авторизации
    // и, в случае если пользователь не авторизован, его будет "выкидывать"
    call (requestType, url, data = null, params = null) {
        return new Promise((resolve, reject) => {
            axios[requestType](url, data, params)
                .then(response => {
                    resolve(response);
                })
                .catch(({response}) => {
                    if (response.status === 401) {
                        auth.logout();
                    }
                    reject(response);
                });
        });
    }
}

export default Api;
