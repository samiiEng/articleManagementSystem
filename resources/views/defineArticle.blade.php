@extends('Layout.dashboardWithFilter')

@section('resourcesLinks')

@endsection

@section('title', 'تعریف مقاله')

@section('resourcesScripts')
    <script src="{{asset('javascript/script.js')}}" type="text/javascript"></script>
@endsection

@section('filters')
    <div class="contributorsFilters">
        <form action="" method="post">
            <fieldset>
                {{--       getting from the departments table         --}}
                @foreach()
                    <label for="">
                        <input type="radio" name="" id="">
                    </label>
                @endforeach
            </fieldset>

            <label for="searchUsername">
                <input type="text" name="searchUsername" id="searchUsername">
            </label>
            {{--      This box is shown by ajax when it retrieves the records from the DB     --}}
            <div class="contributorsFiltersResult">
                <div class="contributorsFiltersRecord{{_$username}}">
                    {{$username}}
                </div>
            </div>

            <button type="button" id="contributorsFiltersPost">search</button>
        </form>
    </div>

    <div class="useFinishedArticlesFilters">
        <form action="" method="post">
            <fieldset>
                {{--       getting from the departments table         --}}
                @foreach()
                    <label for="">
                        <input type="radio" name="" id="">
                    </label>
                @endforeach
            </fieldset>

            <fieldset>
                {{--       getting from the categories table         --}}
                @foreach()
                    <label for="">
                        <input type="radio" name="" id="">
                    </label>
                @endforeach
            </fieldset>

            <label for="searchUsername">
                <input type="text" name="searchUsername" id="searchUsername">
            </label>
            {{--      This box is shown by ajax when it retrieves the records from the DB     --}}
            <div class="usernamesContributorsFiltersResult">
                <div class="usernamesContributorsFiltersRecord{{_$username}}">
                    {{$username}}
                </div>
            </div>

            <label for="searchTitle">
                <input type="text" name="searchTitle" id="searchTitle">
            </label>
            {{--      This box is shown by ajax when it retrieves the records from the DB     --}}
            <div class="titlesArticlesFiltersResult">
                <div class="titlesArticlesFiltersRecord{{_$titlename}}">
                    {{$titlename}}
                </div>
            </div>

            <button type="button" id="articlesFiltersPost">search</button>
        </form>
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

        <div class="useFinishedArticles">
            <p>{{$articleTitle}}</p>
            <button type="button" id="deleteArticle">delete article</button>
        </div>


        <button type="button" id="delete">delete</button>

        <button type="button" id="create">create</button>

    </form>
@endsection
