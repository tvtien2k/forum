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
                <div>
                    <a class="btn" data-toggle="modal" data-target="#exampleModal" data-whatever="{{$post->id}}"
                       href="#">
                        Reply <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>
                    <a class="btn pull-right" href="#">
                        Report <span class="glyphicon glyphicon-flag"></span>
                    </a>
                </div>
                <!-- Blog Comments -->
                <!-- Comments Form -->
                <hr>
                <!-- Posted Comments -->
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
                                <h5 class="media-heading">{{$comment->author->name}}
                                    <small>{{$comment->created_at}}</small>
                                </h5>
                                {{$comment->content}}
                            </div>
                            <div class="media-bottom">
                                <a class="btn btn-sm" data-toggle="modal" data-target="#exampleModal"
                                   data-whatever="@mdo"
                                   href="#">Reply <span class="glyphicon glyphicon-chevron-down"></span>
                                </a>
                                <a class="btn btn-sm pull-right" href="chitiet.html">Report <span
                                        class="glyphicon glyphicon-flag"></span></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="recipient-name"
                                           class="col-form-label">Recipient:</label>
                                    <input type="text" class="form-control" id="recipient-name">
                                </div>
                                <div class="well">
                                    <h4>Viết bình luận ...<span class="glyphicon glyphicon-pencil"></span></h4>
                                    <form role="form">
                                        <div class="form-group">
                                            <textarea class="form-control" rows="3"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Gửi</button>
                                    </form>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                            </button>
                            <button type="button" class="btn btn-primary">Send message</button>
                        </div>
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
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text('New message to ' + recipient)
            modal.find('.modal-body input').val(recipient)
        })
    </script>
@endsection
