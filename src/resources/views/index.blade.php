<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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

</body>
</html>
