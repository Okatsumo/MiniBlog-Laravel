<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="favicon.ico"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="color-scheme" content="only light">
    <title>MiniBlog</title>
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
</head>
<body>

    <div id="app">
        <navbar></navbar>

        <router-view></router-view>

        @yield('content')

        <notifications group="auth" position="bottom left"/>
    </div>

    <script src="{{asset('js/app.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
