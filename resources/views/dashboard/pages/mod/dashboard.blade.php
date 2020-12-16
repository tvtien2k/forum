@extends('dashboard.index')

@section('title', 'Mod')

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
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-table fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$count_all_post}}</div>
                                    <div>All Post</div>
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
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-eye fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$count_display_post}}</div>
                                    <div>Public Post</div>
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
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-eye-slash fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$count_approval_post}}</div>
                                    <div>Waiting for approval</div>
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
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bell fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$count_notice}}</div>
                                    <div>Not seen notice</div>
                                </div>
                            </div>
                        </div>
                        <a href="member/notice/list">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-clock-o fa-fw"></i> Notice Timeline
                        <div class="pull-right">
                            <a href="member/notice/all">Mark all as seen</a>
                        </div>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <ul class="timeline">
                            @for ($i = 0; $i < count($notices); $i++)
                                <li class="
                                @if($i % 2 != 0)
                                    timeline-inverted
                                @endif
                                    ">
                                    <div class="timeline-badge
                                    @if($notices[$i]->status == "Not seen")
                                        info
                                    @endif
                                        ">
                                        <i class="fa
                                        @if($notices[$i]->status == "Seen")
                                            fa-check
                                        @endif
                                            "></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <p>
                                                <small class="text-muted">
                                                    <i class="fa fa-clock-o"></i> {{$notices[$i]->created_at}}
                                                </small>
                                            </p>
                                        </div>
                                        <div class="timeline-body">
                                            <a href="member/notice/update-status/{{$notices[$i]->id}}">{{$notices[$i]->content}}
                                                !</a>
                                        </div>
                                    </div>
                                </li>
                            @endfor
                        </ul>
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
            <!-- /.row -->
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
