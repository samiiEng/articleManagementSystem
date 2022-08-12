@extends('Layout.dashboardWithFilter')

@section('resourcesLinks')
    @parent
    <link rel="stylesheet" href="{{asset('css/mailbox.css')}}">
@endsection

@section('title', 'صندوق بازیابی')

@section('resourcesScripts')

@endsection

@section('filters')
    <form action="" method="">
        <label for="author">نویسنده:
            <input type="text" name="author" id="author">
        </label>

        <label for="beginDate">تاریخ شروع:
            <input type="date" name="beginDate" id="beginDate">
        </label>

        <label for="endDate">تاریخ پایان:
            <input type="date" name="endDate" id="endDate">
        </label>
    </form>
@endsection

{{-- After filtering the page would be redirected to the specific account --}}
@section('main')
    <table>
        <tr>
            <th>اکانت</th>
            <th>آخرین پیام</th>
        </tr>

        @if()
            @foreach()
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        @endif

    </table>
@endsection
