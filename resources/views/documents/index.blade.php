@extends ('layout')

@section ('content')
    <div id="wrapper">
        <div id="page" class="container">

            @foreach($articles as $article)
            <div id="content">
                <div class="title">
                    <h3>
                        <a href="{{ $article->path()  }}">
                            {{ $article->title }}
                        </a>
                    </h3>
                </div>
                <p>
                    <img
                        src="/images/banner.jpg"
                        alt=""
                        class="image image-full" />
                </p>
                <p>
                    {{ $article->excerpt }}
                </p>
                @endforeach
            </div>
        </div>
    </div>
@endsection
