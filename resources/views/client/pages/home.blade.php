@extends('client.index')

@section('title','Home')

@section('style')
    <!-- Bootstrap Core CSS -->
    <link href="assets_client/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets_client/css/shop-homepage.css" rel="stylesheet">
    <link href="assets_client/css/my.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
@endsection

@section('content')
    <div class="container">
        @include('client.layouts.slider')
        <div class="space20"></div>
        <div class="row main-left">
            <div class="col-md-3 ">
                @include('client.layouts.menu')
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#337AB7; color:white;">
                        <h2 style="margin-top:0px; margin-bottom:0px;"> New Posts</h2>
                    </div>
                    <div class="panel-body">
                        @foreach($posts as $post)
                            @auth
                                <div class="row-item row
                                @if(!str_contains($post->reader??'', Auth::id()))
                                    bg-success
                                @endif
                                    ">
                                    <h3>
                                        <a href="topic/{{$post->category->topic->slug}}">
                                            {{$post->category->topic->name}}
                                        </a> |
                                        <small>
                                            <a href="category/{{$post->category->slug}}">
                                                <i>{{$post->category->name}}</i>
                                            </a>
                                        </small>
                                        <small class="pull-right">
                                            <a href="user/{{$post->author->id}}">
                                                <i>{{$post->author->name}}</i>
                                            </a>
                                        </small>
                                    </h3>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <img class="img-responsive"
                                                 src="https://ui-avatars.com/api/?size=128&name={{$post->category->topic->slug}}"
                                                 alt="">
                                        </div>
                                        <div class="col-md-9">
                                            <h3>{{$post->title}}</h3>
                                            <p>{{$post->description}}...</p>
                                            <a class="btn btn-xs btn-primary" href="post/{{$post->slug}}">
                                                View detail <span class="glyphicon glyphicon-chevron-right"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="break"></div>
                                </div>
                            @endauth
                            @guest
                                <div class="row-item row
                                @if(!in_array($post->id, session('POST')??[]))
                                    bg-success
                                @endif
                                    ">
                                    <h3>
                                        <a href="topic/{{$post->category->topic->slug}}">
                                            {{$post->category->topic->name}}
                                        </a> |
                                        <small>
                                            <a href="category/{{$post->category->slug}}">
                                                <i>{{$post->category->name}}</i>
                                            </a>
                                        </small>
                                        <small class="pull-right">
                                            <a href="user/{{$post->author->id}}">
                                                <i>{{$post->author->name}}</i>
                                            </a>
                                        </small>
                                    </h3>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <img class="img-responsive"
                                                 src="https://ui-avatars.com/api/?size=128&name={{$post->category->topic->slug}}"
                                                 alt="">
                                        </div>
                                        <div class="col-md-9">
                                            <h3>{{$post->title}}</h3>
                                            <p>{{$post->description}}...</p>
                                            <a class="btn btn-xs btn-primary" href="post/{{$post->slug}}">
                                                View detail <span class="glyphicon glyphicon-chevron-right"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="break"></div>
                                </div>
                            @endguest
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
@endsection

@section('js')
    <!-- jQuery -->
    <script src="assets_client/js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="assets_client/js/bootstrap.min.js"></script>
    <script src="assets_client/js/my.js"></script>
@endsection
