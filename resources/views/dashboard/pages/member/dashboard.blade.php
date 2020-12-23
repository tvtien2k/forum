@extends('dashboard.index')

@section('title')
    @if($title=='Recommended')
        Recommended
    @else
        Recently
    @endif
@endsection

@section('style')
    <!-- Bootstrap Core CSS -->
    <link href="assets_dashboard/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="assets_dashboard/css/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="assets_dashboard/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets_dashboard/css/startmin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="assets_dashboard/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
@endsection

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            @if($title=='Recommended')
                                <i class="fa fa-commenting fa-fw"></i> Recommended
                            @else
                                <i class="fa fa-clock-o fa-fw"></i> Recently
                            @endif
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="timeline">
                                @php
                                    $i = 0;
                                @endphp
                                @foreach($posts as $post)
                                    <li
                                        @if($i%2==1)
                                        class="timeline-inverted"
                                        @endif
                                    >
                                        <div class="timeline-badge info"><i class="fa fa-check"></i>
                                        </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">
                                                    <a href="post/{{$post->slug}}">
                                                        {{$post->title}}
                                                    </a>
                                                </h4>
                                                <p>
                                                    <small class="text-muted"><i class="fa fa-clock-o"></i>
                                                        {{$post->created_at}}
                                                    </small>
                                                </p>
                                            </div>
                                            <div class="timeline-body">
                                                {{$post->description}}...
                                            </div>
                                        </div>
                                    </li>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    {{ $posts->links() }}
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Personal information
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <p>
                                    <strong>Name: </strong> {{Auth::user()->name}}
                                <p>
                                <p>
                                    <strong>Email: </strong> {{Auth::user()->email}}
                                <p>
                                <p>
                                    <strong>Gender: </strong> {{Auth::user()->gender}}
                                <p>
                                <p>
                                    <strong>Birthday: </strong> {{Auth::user()->birthday}}
                                <p>
                                <p>
                                    <strong>Level: </strong> Member
                                <p>
                                <p>
                                    <strong>Description: </strong> {{Auth::user()->description}}
                                <p>
                            </div>
                        </div>
                        <div class="panel-footer">
                            Personal information
                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-table fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$count_all_post}}</div>
                                    <div>All my post</div>
                                </div>
                            </div>
                        </div>
                        <a href="member/post/list">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-eye fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$count_display_post}}</div>
                                    <div>Post has been approved</div>
                                </div>
                            </div>
                        </div>
                        <a href="member/post/list">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-eye-slash fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$count_approval_post}}</div>
                                    <div>Post is waiting for approval</div>
                                </div>
                            </div>
                        </div>
                        <a href="member/post/list">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection

@section('js')
    <!-- jQuery -->
    <script src="assets_dashboard/js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets_dashboard/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="assets_dashboard/js/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="assets_dashboard/js/startmin.js"></script>
@endsection
