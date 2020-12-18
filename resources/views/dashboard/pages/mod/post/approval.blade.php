@extends('client.index')

@section('title')
    {{$post->title}}
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
        <div class="row">
            <!-- Blog Post Content Column -->
            <div class="col-lg-9">
                <!-- Blog Post -->
                <div class="col-md-12">
                    <div class="col-md-2">
                        <a>
                            <img class="img-responsive"
                                 src="https://ui-avatars.com/api/?size=128&name={{substr($post->author->name, 0, 1)}}"
                                 alt="">
                        </a>
                    </div>
                    <div class="col-md-10">
                        <!-- Title -->
                        <h1>{{$post->title}}</h1>
                        <!-- Author -->
                        <p class="lead">
                            by <a>{{$post->author->name}}</a>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <h4>
                            <a>
                                {{$post->category->topic->name}}
                            </a> |
                            <small>
                                <a>
                                    <i>{{$post->category->name}}</i>
                                </a>/
                            </small>
                        </h4>
                    </div>
                    <div class="col-md-pull-4">
                        <p><span class="glyphicon glyphicon-time"></span> Posted at {{$post->created_at}}</p>
                    </div>
                </div>
                <hr>
                <!-- Post Content -->
                <div>{{$post->content}}</div>
                <hr>
                <div class="well">
                    <form role="form" method="post" action="mod/post/approval">
                        @csrf
                        <input name="id" value="{{$post->id}}" hidden>
                        <div class="center-block">
                            @if($post->status == 'approval')
                                <input name="action" type="submit" class="btn btn-primary" value="Approval">
                            @else
                                <input name="action" type="submit" class="btn btn-primary" value="Disapproval">
                            @endif
                            or
                            <input name="action" type="submit" class="btn btn-default" value="Back">
                        </div>
                    </form>
                </div>
                <hr>
            </div>
            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading"><b>Related posts</b></div>
                    <div class="panel-body">
                    @foreach($related_posts as $post)
                        <!-- item -->
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-4">
                                    <a href="post/{{$post->slug}}">
                                        <img class="img-responsive"
                                             src="https://ui-avatars.com/api/?size=64&name={{substr($post->author->name, 0, 1)}}"
                                             alt="">
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <a href="post/{{$post->slug}}"><b>{{$post->title}}</b></a>
                                </div>
                                <div class="break"></div>
                            </div>
                            <!-- end item -->
                        @endforeach
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading"><b>New Posts</b></div>
                    <div class="panel-body">
                    @foreach($new_posts as $post)
                        <!-- item -->
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-4">
                                    <a href="post/{{$post->slug}}">
                                        <img class="img-responsive"
                                             src="https://ui-avatars.com/api/?size=64&name={{substr($post->author->name, 0, 1)}}"
                                             alt="">
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <a href="post/{{$post->slug}}"><b>{{$post->title}}</b></a>
                                </div>
                                <div class="break"></div>
                            </div>
                            <!-- end item -->
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
