@extends('Layout.dashboardWithFilter')

@section('resourcesLinks')
    @parent
    <link rel="stylesheet" href="{{asset("css/mailbox.css")}}">
@endsection

@section('title', 'مقالات دردست انتشار')

@section('resourcesScripts')

@endsection

@section('filters')
    <form action="" method="">
        <label for="author">دپارتمان:
            <input type="text" name="author" id="author">
        </label>

        <label for="beginDate">دسته:
            <input type="date" name="beginDate" id="beginDate">
        </label>

        <label for="endDate">تگ:
            <input type="date" name="endDate" id="endDate">
        </label>
    </form>
@endsection

@section('main')
    <table>
        <tr>
            <th>سطر</th>
            <th>دپارتمان</th>
            <th>دسته</th>
            <th>تگ</th>
            <th>تیتر</th>
            <th>خلاصه</th>
        </tr>

        @if()
            @foreach()
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        @endif
    </table>
@endsection
