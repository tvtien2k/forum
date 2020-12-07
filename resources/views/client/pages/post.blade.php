@extends('client.index')

@section('title', 'Page Title')

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
                        <a href="#">
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
                            by <a href="#">{{$post->author->name}}</a>
                        </p>
                    </div>
                </div>
                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted at {{$post->created_at}}</p>
                <hr>
                <!-- Post Content -->
                <div>{{$post->content}}</div>
                <hr>
                @auth
                    <div>
                        <a class="btn" data-toggle="modal" data-target="#reply" data-id="{{$post->id}}"
                           data-author="{{$post->author->name}}" href="#">
                            Reply <span class="glyphicon glyphicon-chevron-down"></span>
                        </a>
                        <a class="btn pull-right" href="#">
                            <span class="glyphicon glyphicon-flag"></span>
                        </a>
                    </div>
                    <!-- Blog Comments -->
                    <!-- Comments Form -->
                    <hr>
                @endauth
            <!-- Posted Comments -->
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
            <!-- Comment -->
                @foreach($comments as $comment)
                    <div class="row-item row">
                        @php
                            $level = count(explode('_', explode('-', $comment->id)[1])) - 2;
                        @endphp
                        <div class="col-md-{{$level}}"></div>
                        <div class="media col-md-{{12-$level}} border-left">
                            <a class="pull-left" href="#">
                                <img class="media-object"
                                     src="https://ui-avatars.com/api/?size=64&name={{substr($comment->author->name, 0, 1)}}"
                                     alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">{{$comment->author->name}}
                                    <small>{{$comment->created_at}}</small>
                                </h4>
                                {{$comment->content}}
                            </div>
                            @auth
                                <div class="media-bottom">
                                    <a class="btn" data-toggle="modal" data-target="#reply" data-id="{{$comment->id}}"
                                       data-author="{{$comment->author->name}}" href="#">
                                        Reply <span class="glyphicon glyphicon-chevron-down"></span>
                                    </a>
                                    <a class="btn btn-sm pull-right" href="chitiet.html">
                                        <span class="glyphicon glyphicon-flag"></span>
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="modal fade" id="reply" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Reply</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" action="member/post/comment">
                            @csrf
                            <div class="modal-body">
                                <input class="id" type="hidden" name="id">
                                <div class="well">
                                    <h4>Comment ...<span class="glyphicon glyphicon-pencil"></span></h4>
                                    <div class="form-group">
                                        <textarea class="editor" name="_content"></textarea>
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
                    <div class="panel-heading"><b>Tin liên quan</b></div>
                    <div class="panel-body">

                        <!-- item -->
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-5">
                                <a href="detail.html">
                                    <img class="img-responsive" src="image/320x150.png" alt="">
                                </a>
                            </div>
                            <div class="col-md-7">
                                <a href="#"><b>Project Five</b></a>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            <div class="break"></div>
                        </div>
                        <!-- end item -->

                        <!-- item -->
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-5">
                                <a href="detail.html">
                                    <img class="img-responsive" src="image/320x150.png" alt="">
                                </a>
                            </div>
                            <div class="col-md-7">
                                <a href="#"><b>Project Five</b></a>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            <div class="break"></div>
                        </div>
                        <!-- end item -->

                        <!-- item -->
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-5">
                                <a href="detail.html">
                                    <img class="img-responsive" src="image/320x150.png" alt="">
                                </a>
                            </div>
                            <div class="col-md-7">
                                <a href="#"><b>Project Five</b></a>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            <div class="break"></div>
                        </div>
                        <!-- end item -->

                        <!-- item -->
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-5">
                                <a href="detail.html">
                                    <img class="img-responsive" src="image/320x150.png" alt="">
                                </a>
                            </div>
                            <div class="col-md-7">
                                <a href="#"><b>Project Five</b></a>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            <div class="break"></div>
                        </div>
                        <!-- end item -->
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Tin nổi bật</b></div>
                    <div class="panel-body">

                        <!-- item -->
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-5">
                                <a href="detail.html">
                                    <img class="img-responsive" src="image/320x150.png" alt="">
                                </a>
                            </div>
                            <div class="col-md-7">
                                <a href="#"><b>Project Five</b></a>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            <div class="break"></div>
                        </div>
                        <!-- end item -->

                        <!-- item -->
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-5">
                                <a href="detail.html">
                                    <img class="img-responsive" src="image/320x150.png" alt="">
                                </a>
                            </div>
                            <div class="col-md-7">
                                <a href="#"><b>Project Five</b></a>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            <div class="break"></div>
                        </div>
                        <!-- end item -->

                        <!-- item -->
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-5">
                                <a href="detail.html">
                                    <img class="img-responsive" src="image/320x150.png" alt="">
                                </a>
                            </div>
                            <div class="col-md-7">
                                <a href="#"><b>Project Five</b></a>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            <div class="break"></div>
                        </div>
                        <!-- end item -->

                        <!-- item -->
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-5">
                                <a href="detail.html">
                                    <img class="img-responsive" src="image/320x150.png" alt="">
                                </a>
                            </div>
                            <div class="col-md-7">
                                <a href="#"><b>Project Five</b></a>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            <div class="break"></div>
                        </div>
                        <!-- end item -->
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
        $('#reply').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var author = button.data('author')
            var modal = $(this)
            modal.find('.modal-title').text('Reply ' + author)
            modal.find('input.id').val(id)
        })
    </script>
    <script src="ckeditor5/build/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('.editor'), {
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'indent',
                        'outdent',
                        '|',
                        'alignment',
                        'insertTable',
                        'blockQuote',
                        'undo',
                        'redo',
                        '|',
                        'mediaEmbed',
                        'imageInsert',
                        '|',
                        'code',
                        'codeBlock',
                        '|',
                        'htmlEmbed',
                        'exportPdf'
                    ]
                },
                language: 'en',
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'imageStyle:full',
                        'imageStyle:side'
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells'
                    ]
                },
                licenseKey: '',
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error('Oops, something went wrong!');
                console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
                console.warn('Build id: t7ukt7v91nmd-3rq4gwmsanl7');
                console.error(error);
            });
    </script>
@endsection
