@extends('Layout.simple')

@section('resourcesLinks')
    <link rel="stylesheet" href="{{asset('css/loginRegister.css')}}">
@endsection

@section('title', 'ثبت نام')

@section('resourcesScripts')

@endsection

@section('main')
    <div class="container">
        <form action="" method="post">

            <label for="first_name">نام:
                <input type="text" name="first_name" id="first_name">
            </label>

            <label for="last_name">نام خانوادگی:
                <input type="text" name="last_name" id="last_name">
            </label>

            <label for="nationalCode">کدملی:
                <input type="text" name="nationalCode" id="nationalCode">
            </label>

            <label for="username">نام کاربری:
                <input type="text" name="username" id="username">
            </label>

            <label for="password">رمز:
                <input type="text" name="password" id="password">
            </label>

            <label for="email">ایمیل:
                <input type="text" name="email" id="email">
            </label>

            <label for="extra"> سایر موارد:
                <input type="text" name="extra">
            </label>

            <input type="submit" value="submit" id="submit">
        </form>
    </div>
@endsection
