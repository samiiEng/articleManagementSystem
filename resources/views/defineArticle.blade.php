@extends('Layout.dashboardWithFilter')

@section('resourcesLinks')

@endsection

@section('title', 'تعریف مقاله')

@section('resourcesScripts')
    <script src="{{asset('javascript/script.js')}}" type="text/javascript"></script>
@endsection

@section('filters')
    <div class="contributorsFilters">
        <form action="{{route('filter.filter')}}" method="post">
            @if(!empty($departments))
                <fieldset class="departments">
                    {{--       getting from the departments table         --}}

                    @foreach($departments as $department)
                        <div>گروه دپارتمان {{$department[0]}}</div>
                        {{--          see all users withing the parent department          --}}
                        <label for="{{$department[0]->english_name}}">{{$department[0]}}
                            <input type="radio" value="{{$department[0]->english_name}}"
                                   name="departments">
                        </label>
                        @foreach($department[1] as $record)
                            <label for="{{$record->english_name}}">{{$record}}
                                <input type="radio" value="{{$record->english_name}}" name="departments">
                            </label>
                        @endforeach
                    @endforeach

                </fieldset>
            @endif

            <button type="button" value="showSearch" id="contributorsFilters"></button>

            <div class="contributorsFinalSearch">
                <label for="searchUsername">
                    <input type="text" name="searchUsername" id="searchUsername">
                </label>
                {{--      This box is shown by ajax when it retrieves the records from the DB     --}}
                <div class="contributorsFiltersResult">
                    <div class="contributorsFiltersRecord{{_$username}}">
                        {{$username}}
                    </div>
                </div>
            </div>

            <button type="button" id="contributorsFiltersPost">search</button>
        </form>
    </div>

    <div class="useFinishedArticlesFilters">
        <form action="" method="post">
            <fieldset class="departments">
                {{--       getting from the departments table         --}}
                @foreach()
                    <label for="">
                        <input type="radio" name="" id="">
                    </label>
                @endforeach
            </fieldset>

            <fieldset class="categories">
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
