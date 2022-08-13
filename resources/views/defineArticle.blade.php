@extends('Layout.dashboardWithFilter')

@section('resourcesLinks')

@endsection

@section('title', 'تعریف مقاله')

@section('resourcesScripts')
    <script src="{{asset('javascript/defineController.js')}}" type="text/javascript"></script>
@endsection

@section('filters')
    <div class="contributorsFilter">
        <div class="department">
            <p>دپارتمانی که کاربر مدنظر در آن قرار دارد را انتخاب کنید:</p>
            <form action="" method="post">
                <fieldset class="departments">
                    @if($departments)
                        @foreach($departments as $department)
                            <p class="parent">{{$department[0]}}</p>

                            <label for="{{$department[0]->english_name}}">{{$department[0]}}
                                <input type="radio" name="departments" id="{{$department[0]->english_name}}">
                            </label>

                            @foreach($department[1] as $record)
                                <label for="{{$record->english_name}}">{{$record}}
                                    <input type="radio" name="departments" id="{{$record->english_name}}">
                                </label>
                            @endforeach
                        @endforeach
                    @endif
                </fieldset>





            </form>
        </div>
    </div>


    <div class="publishedArticlesFilter">

    </div>
@endsection

@section('main')
    <form action="" method="post">
        <label for="username">
            <input type="text" name="username" id="username" readonly>
        </label>

        <label for="title">
            <input type="text" name="title" id="title">
        </label>

        <label for="purpose">
            <input type="text" name="purpose" id="purpose">
        </label>

        <div class="contributors">
            <p>{{$username}}</p>
            <button type="button" id="deleteContributors">delete contributors</button>
        </div>

        <div class="usePublishedArticles">
            <p>{{$articleTitle}}</p>
            <button type="button" id="deleteArticle">delete article</button>
        </div>


        <button type="button" id="delete">delete</button>

        <button type="button" id="create">create</button>

    </form>
@endsection
