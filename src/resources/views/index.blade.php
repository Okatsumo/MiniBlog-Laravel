<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MiniBlog</title>


{{--    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">--}}
{{--    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">--}}


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">

</head>
<body>

    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark ftco-navbar-light" id="ftco-navbar">
            <div class="container">
                <router-link class="navbar-brand" to="/" >МиниБлог<span>.</span></router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="oi oi-menu"></span> Меню
                </button>

                <div class="collapse navbar-collapse" id="ftco-nav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <router-link to="/" class="nav-link">Главная</router-link>
                        </li>

                        <li class="nav-item">
                            <router-link :to="{name: 'Articles'}" class="nav-link">Все записи</router-link>
                        </li>


                    @foreach($categories as $category)
                        <li class="nav-item">
                                <router-link :to="{name: 'Category', params: {id: {{$category['category_id']}}  }}" class="nav-link">{{$category['name']}}</router-link>
                        </li>
                    @endforeach

                        <li class="nav-item">
                            <a class="nav-link">Авторизация</a>
                        </li>

                        <li class="nav-item">
                            <router-link class="nav-link" :to="{name : 'adminPanel.index'}">Панель администратора</router-link>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>

        <router-view></router-view>


        <notifications group="auth" position="bottom left"/>
    </div>

<script src="{{asset('js/app.js')}}"></script>

</body>
</html>
