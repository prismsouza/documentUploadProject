<!DOCTYPE html>

@include('includes')

<body>
@include('header')
<div class="container">
    <div id="wrapper">
        <div id="page" class="container py-3">
            @yield('content')
        </div>
    </div>
</div>
@include('footer')
</body>
