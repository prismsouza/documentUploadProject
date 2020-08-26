@extends($admin ? 'layout_admin' : 'layout_user')

@include('searchbar')
@section('content')
    <div id="wrapper">
        @if($admin)
        <div id="page" class="row py-1">

            <div class="col-10">
                <p><img src="images/banner2.jpg" class="img-fluid" style="opacity: 0.6"></p>
            </div>
            <div class="menu col-2 text-left light lighten-1 ">
                @include('lateralmenu')
            </div>
        </div>
        @else
            <p><img src="images/banner2.jpg" class="img-fluid" style="opacity: 0.6"></p>
        @endif
    </div>
@endsection

