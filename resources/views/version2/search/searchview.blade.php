@extends('version2.layout_versao2')
@section('content')
    <style>
        li {
            font-size: 20px;
        }
    </style>
    <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
        <ul id="myTabs" class="nav nav-tabs px-lg-5" role="tablist">
            <li role="presentation" class="active">
                <a href="#search" id="search-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                    PESQUISA
                </a>
            </li>
            <li role="presentation">
                <a href="#search-theme" role="tab" id="search-theme-tab" data-toggle="tab" aria-controls="profile">
                    PESQUISA POR TEMA
                </a>
            </li>
            <li role="presentation">
                <a href="#search-advanced" role="tab" id="search-advanced-tab" data-toggle="tab" aria-controls="profile">
                    PESQUISA AVANCADA
                </a>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="search" aria-labelledby="search-tab">
                @include('version2.search.search')
            </div>
            <div role="tabpanel" class="tab-pane fade" id="search-theme" aria-labelledby="search-theme-tab">
                @include('version2.search.search-theme')
            </div>
            <div role="tabpanel" class="tab-pane fade" id="search-advanced" aria-labelledby="search-advanced-tab">
                @include('version2.search.search-advanced')
            </div>
        </div>
    </div>
<p style="padding-bottom: 200px"></p>
@endsection
