@extends('dashboard.index')

@section('title', 'List Post')

@section('style')
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
                    <h1 class="page-header">Tables</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @if (session('status'))
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{session('status')}}
                        </div>
                    @endif
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Tabs
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li>
                                    <a href="mod/post/list/my-post">My post</a>
                                </li>
                                <li class="active">
                                    <a href="#postOnTopic" data-toggle="tab">Post I manage</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade" id="myPost">
                                </div>
                                <div class="tab-pane fade in active" id="postOnTopic">
                                    <br>
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <form class="form-inline" role="form" method="post" action="">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Topic: </label>
                                                    <select class="form-control" disabled>
                                                        <option>{{$topic->name}}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Category: </label>
                                                    <select class="form-control" name="category_id">
                                                        <option>All</option>
                                                        @foreach($topic->categories as $category)
                                                            @if($category_id == $category->id)
                                                                <option value="{{$category->id}}" selected>
                                                                    {{$category->name}}
                                                                </option>
                                                            @else
                                                                <option value="{{$category->id}}">
                                                                    {{$category->name}}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-default">Search</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover"
                                                       id="dataTables-example">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Author</th>
                                                        <th>Category</th>
                                                        <th>Title</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                        <th>Created at</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="post-i-manage">
                                                    @foreach($posts as $post)
                                                        <tr>
                                                            <td>{{$post->id}}</td>
                                                            <td>
                                                                <a href="user/{{$post->author->id}}">
                                                                    {{$post->author->name}}
                                                                </a>
                                                            </td>
                                                            <td>{{$post->category->name}}</td>
                                                            <td>{{$post->title}}</td>
                                                            <td>
                                                                @if($post->status == 'display')
                                                                    <div class="alert alert-success">
                                                                        {{$post->status}}
                                                                    </div>
                                                                @elseif($post->status == 'update')
                                                                    <div class="alert alert-warning">
                                                                        {{$post->status}}
                                                                    </div>
                                                                @elseif($post->status == 'approval')
                                                                    <div class="alert alert-danger">
                                                                        {{$post->status}}
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="mod/post/approval/{{$post->id}}">
                                                                    <button type="button"
                                                                            class="btn btn-success btn-circle">
                                                                        <i class="fa fa-eye"></i>
                                                                    </button>
                                                                </a>
                                                            </td>
                                                            <td>{{$post->created_at}}</td>
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

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function () {
            $('#dataTables-example').DataTable({
                responsive: true,
                order: [[6, "desc"]]
            });
        });
    </script>
@endsection
