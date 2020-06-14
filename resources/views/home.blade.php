<?php $user = "admin"; // admin ?>

@extends($user=="admin" ? 'layout_admin' : 'layout_user')

@include('searchbar')
@section('content')
    <div id="wrapper">
        <p><img src="images/banner2.jpg" class="img-fluid" style="opacity: 0.6"></p>
    </div>
@endsection

