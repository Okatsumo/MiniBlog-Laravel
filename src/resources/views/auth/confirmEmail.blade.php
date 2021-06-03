<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Подтверждение почты</title>
</head>
<body>

</body>
    <div>
        <p>Пожалуйста, подождите, идет перенаправление на главную страницу...</p>
    </div>
<script>

    let params = window.location.pathname.split( '/');
    let id = params[3]
    let hash = params[4] + window.location.search;
    fetch(`/api/email/verify/${id}/${hash}`, {
        method: "get",
        headers: {
            'Authorization': 'Bearer ' + window.localStorage.getItem('token'),
            'Content-Type':'application/json'
        }
    })
        .then((response) => {
            setTimeout(function(){
                this.window.location.href = '/';
            }, 2 * 1000);
        })
        .catch((data) => {
            console.log(data);
        });
</script>

</html>
