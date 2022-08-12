@extends('Layout.dashboardWithFilter')

@section('resourcesLinks')
    @parent
@endsection

@section('title', 'مقالات موجود')

@section('resourcesScripts')

@endsection

@section('filters')
    <form action="" method="">

        <fieldset>
            <label for="departmentBased">به تفکیک دپارتمان
                <input type="radio" value="departmentBased" name="departmentBased" id="departmentBased">
            </label>
            {{--    Get input only if the departmentBased radio button is selected    --}}
            <label for="" class="noneDisplay">انتخاب کنید:
                <select name="departments" id="departments">
                    {{--        show departments if has access otherwise show the restriction        --}}
                    @if()
                        @foreach()
                            <option value=""></option>
                        @endforeach
                    @else
                    @endif
                </select>
            </label>

            <label for="mine">مقالات خودم
                <input type="radio" value="mine" name="mine" id="mine">
            </label>

            <label for="overall">همه ی مقالات
                <input type="radio" value="overall" name="overall" id="overall">
            </label>

            <label for="authorBased">نویسنده:
                <input type="radio" value="author" name="authorBased" id="authorBased">
            </label>
            {{--     show this only if the author radio button is selected   --}}
            <label for="author">نام نویسنده:
                <input type="text" name="author" value="author">
            </label>

            <label for="categoryBased">
                <input type="radio" value="categoryBased" name="categoryBased" id="categoryBased">
            </label>
            {{--     show only if this radio button is checked   --}}
            <label for="category">نام دسته :
                <input type="text" name="category" id="category">
            </label>

            <label for="tagBased">
                <input type="radio" value="tagBased" name="tagBased" id="tagBased">
            </label>
            {{--     show only if this radio button is checked   --}}
            <label for="tag">نام تگ :
                <input type="text" name="tag" id="tag">
            </label>

            <label for="publishDate">تاریخ انتشار:
                <input type="date" name="publishDate" id="publishDate">
            </label>

            <label for="contributorBased">براساس مشارکت کنندگان:
                <input type="radio" value="contributorBased" name="contributorBased" id="contributorBased">
            </label>
            {{--      show only if this radio button is selected      --}}
            <label for="contributor">انتخاب کنید:
                <input type="text" name="contributor" id="contributor">
            </label>

        </fieldset>
    </form>
@endsection

@section('main')
    <table>
        <tr>
            <th>سطر</th>
            <th>تیتر</th>
            <th>خلاصه</th>
            <th>نویسنده</th>
            {{--      check if this is the user's own article       --}}
            @if()
                <th></th>
                <th></th>
            @endif
        </tr>

        @if()
            @foreach()
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    {{--      check if this is the user's own article       --}}
                    @if()
                        <td><a href="">ویرایش</a></td>
                        <td><a href="">درخواست حذف</a></td>
                    @endif
                </tr>
            @endforeach
        @endif

    </table>
@endsection
