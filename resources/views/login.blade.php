@extends('Layout.simple')

@section('resourcesLinks')
    <link rel="stylesheet" href="{{asset('css/loginRegister.css')}}">
@endsection

@section('title', 'ورود')

@section('resourcesScripts')

@endsection

@section('main')
    <div class="container">
        <form action="" method="post">
            <label for="username">نام کاربری:
                <input type="text" name="username" id="username">
            </label>

            <label for="password">رمز ورود:
                <input type="text" name="password" id="password">
            </label>

            <input type="submit" value="submit" id="submit">
        </form>
    </div>
@endsection
