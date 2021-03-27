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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Tabs
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#myPost" data-toggle="tab">List Category</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="myPost">
                                    <br>
                                    <div class="panel panel-default">
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <form style="margin-left: 300px" class="form-inline" role="form"
                                                  method="post"
                                                  action="admin/manage-category/filter">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Select Topic</label>
                                                    <select class="form-control" id="topic_id" name="topic"
                                                            onchange="getCategory();">
                                                        @if(isset($topicC))
                                                            @foreach($topic as $t)
                                                                @if($topicC==$t->id)
                                                                    <option value="{{$t->id}}"
                                                                            selected>{{$t->name}}</option>
                                                                @else
                                                                    <option value="{{$t->id}}">{{$t->name}}</option>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            @foreach($topic as $t)
                                                                <option value="{{$t->id}}">{{$t->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-default">Submit</button>
                                            </form>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover"
                                                       id="table1">
                                                    <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Topic</th>
                                                        <th>Created_at</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($cate as $c)
                                                        <tr>
                                                            <td>{{$c->name}}</td>
                                                            <td>{{$c->topic->name}}</td>
                                                            <td>{{$c->created_at}} </td>
                                                            <td>
                                                                <a href="admin/manage-category/get-edit/{{$c->id}}">
                                                                    <button type="button"
                                                                            class="btn btn-info btn-circle">
                                                                        <i class="fa fa-edit"></i>
                                                                    </button>
                                                                </a>
                                                                <form method="post"
                                                                      action="admin/manage-category/delete/{{$c->id}}">
                                                                    @csrf
                                                                    <button type="submit"
                                                                            class="btn btn-danger btn-circle"
                                                                            onclick="return confirm('If you delete this category, posts will also be deleted. If you still want to delete click ok ');">
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
                                <div class="tab-pane fade" id="postOnTopic">
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
            $('#table1').DataTable();
        });
    </script>
@endsection
