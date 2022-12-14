<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/Layout/simple.css')}}">
    @section('resourcesLinks')
    @show
    <title>@yield('title')</title>
</head>
<body>
<div class="nav">
    <nav>
        <ul class="flex">
            {{--      Check if the user is logged in so the login/register links should be hidden
                  and the avatar icon should be shown--}}
            @if(auth()->user())
                <li><a href=""><img src="../../../public/images/" alt="avatar"></a></li>
            @else
                <li><a href="">ثبت نام</a></li>
                <li><a href="">ورود</a></li>
            @endif
            <li><a href="">خانه</a></li>
        </ul>
    </nav>
</div>

<div class="main">
    @section('main')

    @show
</div>


<script src="{{asset('javascript/jquery/jquery.js')}}" type="text/javascript"></script>
</body>
</html>
