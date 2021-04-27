@extends('dashboard.index')

@section('title', 'List Post')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap Core CSS -->
    <link href="assets_dashboard/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="assets_dashboard/css/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="assets_dashboard/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="assets_dashboard/css/dataTables/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets_dashboard/css/startmin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="assets_dashboard/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- day la jquery calendar-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"/>
    <!-- day la jquery calendar-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.css"/>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
@endsection

@section('content')
    <style>
        body {
            background-color: #f9f9fa
        }
        .img-responsive{
            width: 100px;
            height: 100px;
            margin-left: 60px;
            border-radius: 50px;
        }
        .padding {
            padding: 3rem !important
        }
        .user-card-full {
            overflow: hidden
        }
        .card {
            border-radius: 5px;
            -webkit-box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
            box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
            border: none;
            margin-bottom: 30px
        }
        .m-r-0 {
            margin-right: 0px
        }
        .m-l-0 {
            margin-left: 0px
        }
        .user-card-full .user-profile {
            border-radius: 5px 0 0 5px
        }
        .bg-c-lite-green {
            background: -webkit-gradient(linear, left top, right top, from(#f29263), to(#ee5a6f));
            background: linear-gradient(to right, #ee5a6f, #f29263);
            height: 100px;
        }
        .user-profile {
            padding: 20px 0
        }
        .card-block {
            padding: 1.25rem
        }
        .m-b-25 {
            margin-bottom: 25px
        }
        .img-radius {
            border-radius: 5px
        }
        h6 {
            font-size: 14px
        }
        .card .card-block p {
            line-height: 25px
        }
        @media only screen and (min-width: 1400px) {
            p {
                font-size: 14px
            }
        }
        .card-block {
            padding: 1.25rem
        }
        .b-b-default {
            border-bottom: 1px solid #e0e0e0
        }
        .m-b-20 {
            margin-bottom: 20px
        }
        .p-b-5 {
            padding-bottom: 5px !important
        }
        .card .card-block p {
            line-height: 25px
        }
        .m-b-10 {
            margin-bottom: 10px
        }
        .text-muted {
            color: #919aa3 !important
        }
        .b-b-default {
            border-bottom: 1px solid #e0e0e0
        }
        .f-w-600 {
            font-weight: 600
        }
        .m-b-20 {
            margin-bottom: 20px
        }
        .m-t-40 {
            margin-top: 20px
        }
        .p-b-5 {
            padding-bottom: 5px !important
        }
        .m-b-10 {
            margin-bottom: 10px
        }
        .m-t-40 {
            margin-top: 20px
        }
        .user-card-full .social-link li {
            display: inline-block
        }
        .user-card-full .social-link li a {
            font-size: 20px;
            margin: 0 10px 0 0;
            -webkit-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out
        }
    </style>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card user-card-full" style="height: 50%;width: 50%;margin-left: 100px;margin-top: 5%" >
                        <div class="row m-l-0 m-r-0">
                            <div class="col-sm-4 bg-c-lite-green user-profile">
                                <div class="card-block text-center text-white">
                                    <div class="m-b-25"> <img class="img-responsive" src="https://ui-avatars.com/api/?size=200&name={{substr($user->name, 0, 1)}}" class="img-radius" alt="User-Profile-Image"> </div>
                                    <h6 class="f-w-600">{{$user->name}}</h6>
                                    <a href="admin/manage-post/list/post-i-manage/{{$user->id}}">{{$user->email}}</a> <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                                    <div id="button-wrapper{{$user->id}}" class="button-ban">
                                        <button id="{{$user->id}}"
                                                class="btn btn-danger btn-circle"
                                                onclick="getBan(this.id)">
                                            <i class="fa fa-ban"></i>
                                        </button>
                                        <!--                                                                      Day la form input  -->
                                        <div id="input{{$user->id}}" hidden class="input-ban">
                                            <form method="post"
                                                  action="admin/manage-user/ban/{{$user->id}}">
                                                @csrf
                                                <input type="focus "  id="datepicker{{$user->id}}"
                                                       name="datepicker" onclick="inputBan()">
                                                <button class="btn btn-danger"style="height: 30px" type="submit">Ban</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="card-block">
                                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information User</h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Gender: </p>
                                            <h6 class="text-muted f-w-400">{{$user->gender}}</h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Level:</p>
                                            <h6 class="text-muted f-w-400"> @if($user->level==0) Member @elseif($user->level==1)
                                                    Mod @endif
                                            </h6>
                                        </div>
                                    </div>
                                    <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600"></h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Birthday:</p>
                                            <h6 class="text-muted f-w-400">{{$user->birthday}}</h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Total numbers Violation </p>
                                            <h6 class="text-muted f-w-400">{{$count_report}}</h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Total posted</p>
                                            <h6 class="text-muted f-w-400">{{$count_all_post}}</h6>
                                        </div>
                                        @if($user->level!=2)
                                            <div class="col-sm-6" >
                                                <p class="m-b-10 f-w-600">Status </p>
                                                @if($user->isBan!=null) <h6 class="text-muted f-w-400">Banned</h6>
                                                @else<h6 class="text-muted f-w-400">Active</h6>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            All report
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <!-- Nav tabs -->
                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div class="tab-pane fade" id="myPost">
                                </div>
                                <div class="tab-pane fade in active" id="postOnTopic">

                                    <div class="panel panel-default">
                                        <div class="panel-body">

                                            <div class="table-responsive">
                                                <div class="delete-all-report">
                                                    <form method="POST"
                                                          action="admin/manage-report/delete-all-report/{{$user->id}}">
                                                        @csrf
                                                        <button type="submit"
                                                                class="btn btn-danger" style="margin-left: 40%"
                                                                onclick="return confirm('Do you want delete all report?');">
                                                            Delete all report
                                                        </button>
                                                    </form>
                                                </div>
                                                <table id="example" class="display" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Reported account</th>
                                                        <th>Violation title post</th>
                                                        <th>Content report</th>
                                                        <th>Created at</th>
                                                        <th>Updated at</th>
                                                        <th>Delete report</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($reportAll as $r)
                                                        <tr>
                                                            <td><a href="admin/dashboard/{{$r->user->id}}">{{$r->user->name}}</a></td>
                                                            <?php
                                                            $post = explode("_", $r->post_id);
                                                            $post = $post[0];
                                                            $postTitle = \App\Models\Post::find($post);
                                                            $idPost = explode("_", $r->post_id);
                                                            $idBookmark = "";
                                                            for ($i = 1; $i <= sizeof($idPost) - 1; $i++) {
                                                                if ($i != 1) {
                                                                    $idBookmark = $idBookmark . "_" . $idPost[$i];
                                                                } else {
                                                                    $idBookmark = $idPost[$i];
                                                                }
                                                            }
                                                            ?>
                                                            <td>
                                                                <a href="admin/manage-report/view-post/{{$r->post_id}}#{{$idBookmark ??''}}">{{$postTitle->title??' ' }}
                                                            </td>
                                                            <td>{!!$r->content!!}</td>
                                                            <td>{{$r->created_at}}</td>
                                                            <td>{{$r->updated_at}}</td>
                                                            <td>
                                                                <form method="post"
                                                                      action="admin/manage-report/delete/{{$r->id}}">
                                                                    @csrf
                                                                    <button type="submit"
                                                                            class="btn btn-danger btn-circle"
                                                                            onclick="return confirm('Do you want delete?');">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
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

    <!-- DataTables JavaScript -->
    <script src="assets_dashboard/js/dataTables/jquery.dataTables.min.js"></script>
    <script src="assets_dashboard/js/dataTables/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="assets_dashboard/js/startmin.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        function getBan(id) {
            document.getElementById(id).setAttribute('style', 'display:none');
            document.getElementById("input"+id).setAttribute('style', 'display:inline');
            var className = document.getElementsByClassName("input-ban");
            Array.prototype.forEach.call(className, function(cl) {
                // Do stuff here
                if(cl.id!= "input"+id){
                    document.getElementById(cl.id).setAttribute('style', 'display:none');
                    document.getElementById(id).setAttribute('style', 'display:inline');
                }
            });
        }
        function inputBan (){
            //document.getElementById(id).datepicker();
            $('input[id^=datepicker]').datepicker();
        }
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
@endsection
