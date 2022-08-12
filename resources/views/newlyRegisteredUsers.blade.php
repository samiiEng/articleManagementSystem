@extends('Layout.dashboardWithFilter')

@section('resourcesLinks')
    @parent
@endsection

@section('title', 'اعضای تازه ثبت شده و منتظر تایید')

@section('resourcesScripts')

@endsection

@section('filters')
    <form action="" method="">
        <label for="department">دپارتمان:
            <input type="text" name="department" id="department">
        </label>

        <label for="is_normal">عادی یا فنی:
            <input type="checkbox" name="is_normal" id="is_normal">
        </label>
    </form>
@endsection

@section('main')
    <table>
        <form action="" method="post">
        <tr>
            <th>سطر</th>
            <th>نام کاربری</th>
            <th>کدملی</th>
            <th>تعیین کدپرسنلی</th>
            <th>تعیین سمت</th>
            <th></th>
            <th></th>
        </tr>

        @if()
            @foreach()
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <td></td>
                <td></td>
                <td>تایید</td>
                <td>حذف</td>
            @endforeach
        @endif
            <input type="submit" value="submit" id="submit">
        </form>
    </table>
@endsection
