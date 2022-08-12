@extends('Layout.dashboard')

@section('resourcesLinks')
    @parent
@endsection

@section('title', 'مقاله')

@section('resourcesScripts')

@endsection

<form action="" method="post">
    @section('main')
        <div class="myPart">
            <table>

            </table>
        </div>

        <div class="contributors">
            <table>

            </table>
            {{--      if the contributor has accepted then the div is visible      --}}
            <div>

            </div>
        </div>

        <div class="useOtherArticles">
            <table>

            </table>
            {{--      if the contributor has accepted then the div is visible      --}}
            <div>

            </div>
        </div>

    @endsection
    <input type="submit" value="save" id="save">
    <input type="submit" value="publish" id="publish">
</form>
