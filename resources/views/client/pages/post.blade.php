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

    <!-- Tiny -->
    <script src="https://cdn.tiny.cloud/1/hdeyuuwa87xv4l8rh9se9bd7ze213rdiibh73cg19yqswf8j/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <!-- Blog Post Content Column -->
            <div class="col-lg-9">
                <!-- Blog Post -->
                <div class="col-md-12">
                    <div class="col-md-2">
                        <img class="img-responsive"
                             src="https://ui-avatars.com/api/?size=128&name={{$post->category->topic->slug}}"
                             alt="">
                    </div>
                    <div class="col-md-10">
                        <!-- Title -->
                        <h1>{{$post->title}}</h1>
                        <!-- Author -->
                        <p class="lead">
                            by <a href="user/{{$post->author_id}}">{{$post->author->name}}</a>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <span>
                        <strong>
                            <a href="topic/{{$post->category->topic->slug}}">
                                Topic: {{$post->category->topic->name}}
                            </a>
                        </strong>
                    </span>
                    <span class="pull-right">
                        <a href="category/{{$post->category->slug}}">
                            Category: {{$post->category->name}}
                        </a>
                    </span>
                </div>
                <div class="row">
                    <span class="glyphicon glyphicon-time"></span> Posted at {{$post->created_at}}
                    <span class="pull-right">
                        <span class="glyphicon glyphicon-eye-open"></span> {{$post->view}} view
                    </span>
                </div>
                <hr>
                <div>
                    {!!$post->description!!}
                </div>
                <hr>
                <div>
                    {!!$post->content!!}
                </div>
                <hr>
                @auth
                    <div>
                        <a class="btn" id="btn-reply-{{$post->id}}" onclick="showFormCmt(this.id)">
                            Reply <span class="glyphicon glyphicon-chevron-down"></span>
                        </a>
                        <a class="btn pull-right" data-toggle="modal" data-target="#report" data-id="{{$post->id}}"
                           data-author="{{$post->author->name}}" href="#">
                            <span class="glyphicon glyphicon-flag"></span>
                        </a>
                    </div>
                    <div class="well form-reply" id="form-reply-{{$post->id}}">
                        <h4>Comment ...<span class="glyphicon glyphicon-pencil"></span></h4>
                        <form role="form" method="post" action="member/post/comment">
                            @csrf
                            <input name="id" value="{{$post->id}}" hidden>
                            <div id="div-textarea-{{$post->id}}">
                                <div class="form-group textarea-reply">
                                    <textarea class="editor" name="_content"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </form>
                    </div>
                    <hr>
                @endauth
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @foreach($comments as $comment)
                    <div class="row-item row">
                        @php
                            $level = count(explode('_', explode('-', $comment->id)[1])) - 2;
                        @endphp
                        <div class="col-md-{{$level}}"></div>
                        <div class="media col-md-{{12-$level}} border-left"
                             id="{{explode($post->id."_",$comment->id)[1]}}">
                            <a class="pull-left" href="user/{{$comment->author_id}}">
                                <img class="media-object"
                                     src="https://ui-avatars.com/api/?size=64&name={{substr($comment->author->name, 0, 1)}}"
                                     alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">{{$comment->author->name}}
                                    <small>{{$comment->created_at}}</small>
                                </h4>
                                {!!$comment->content!!}
                            </div>
                            @auth
                                <div class="media-bottom" id="btn-reply-{{$comment->id}}">
                                    <a class="btn" id="btn-reply-{{$comment->id}}" onclick="showFormCmt(this.id)">
                                        Reply <span class="glyphicon glyphicon-chevron-down"></span>
                                    </a>
                                    <a class="btn pull-right" data-toggle="modal" data-target="#report"
                                       data-id="{{$comment->id}}"
                                       data-author="{{$comment->author->name}}" href="#">
                                        <span class="glyphicon glyphicon-flag"></span>
                                    </a>
                                </div>
                                <div class="well form-reply" id="form-reply-{{$comment->id}}" hidden>
                                    <h4>Comment ...<span class="glyphicon glyphicon-pencil"></span></h4>
                                    <form role="form" method="post" action="member/post/comment">
                                        @csrf
                                        <input name="id" value="{{$comment->id}}" hidden>
                                        <div class="form-group">
                                            <textarea name="_content"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Send</button>
                                    </form>
                                </div>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="modal fade" id="report" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Reply</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" action="member/report/add">
                            @csrf
                            <div class="modal-body">
                                <input class="id" type="hidden" name="id">
                                <div class="well">
                                    <h4>Content report ...<span class="glyphicon glyphicon-pencil"></span></h4>
                                    <div class="form-group">
                                        <textarea name="_content"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
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
    <script>
        $('#report').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var author = button.data('author')
            var modal = $(this)
            modal.find('.modal-title').text('Report ' + author)
            modal.find('input.id').val(id)
        });
    </script>

    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker autoresize',
            toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });
    </script>

    <script>
        function showFormCmt(btn_id) {
            var forms = document.getElementsByClassName("form-reply");
            for (var i = 0; i < forms.length; i++) {
                forms[i].setAttribute('hidden', true);
            }
            var id = btn_id.slice(10);
            document.getElementById('form-reply-' + id).removeAttribute('hidden');
        }
    </script>
@endsection
