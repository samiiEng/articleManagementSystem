@extends('Layout.dashboard')

@section('resourcesLinks')
    @parent
@endsection

@section('title', 'اطلاعات کاربر')

@section('resourcesScripts')

@endsection

<form action="" method="post">
@section('main')
    <table>
        <tr>
            <th>نام</th>
            <th>نام خانوادگی</th>
            <th>کدملی</th>
            <th>کدپرسنلی</th>
            <th>نام کاربری</th>
            <th>ایمیل</th>
            <th>سمت</th>
            <th>ویژگی های دیگر</th>
            <th>تعیین کدپرسنلی</th>
            <th>تعیین سمت</th>
        </tr>
        @if()
            @foreach()
                <tr>
                    {{--         if not null           --}}
                    @if()
                        <td></td>
                    @endif
                    @if()
                        <td></td>
                    @endif
                    @if()
                        <td></td>
                    @endif
                    @if()
                        <td></td>
                    @endif
                    @if()
                        <td></td>
                    @endif
                    @if()
                        <td></td>
                    @endif
                    @if()
                        <td></td>
                    @endif
                    @if()
                        <td></td>
                    @endif
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        @endif
    </table>
@endsection
    <input type="submit" value="submit" id="submit">
</form>
