@extends('client.index')

@section('title')
    {{$topic->name}}
@endsection

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
                            <div class="row-item row">
                                <h3>
                                    <a href="topic/{{$post->category->topic->slug}}">
                                        {{$post->category->topic->name}}
                                    </a> |
                                    <small>
                                        <a href="category/{{$post->category->slug}}">
                                            <i>{{$post->category->name}}</i>
                                        </a>/
                                    </small>
                                </h3>
                                <div class="col-md-12 border-right">
                                    <div class="col-md-2">
                                        <a href="post/{{$post->slug}}">
                                            <img class="img-responsive"
                                                 src="https://ui-avatars.com/api/?size=100&name={{substr($post->author->name, 0, 1)}}"
                                                 alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-10">
                                        <h3>{{$post->title}}</h3>
                                        <a class="btn btn-primary" href="post/{{$post->slug}}">
                                            View detail <span class="glyphicon glyphicon-chevron-right"></span>
                                        </a>
                                    </div>

                                </div>
                                <div class="break"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{ $posts->links() }}
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
