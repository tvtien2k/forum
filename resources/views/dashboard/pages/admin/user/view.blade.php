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
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade" id="myPost">
                                </div>
                                <div class="tab-pane fade in active" id="postOnTopic">

                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover"
                                                       id="dataTables-example">
                                                    <thead>

                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Gender</th>
                                                        <th>Level</th>
                                                        <th>Number of posts</th>
                                                        <th>Created_at</th>
                                                        <th>Action</th>
                                                    </tr>

                                                    </thead>
                                                    <tbody id="post-i-manage">
                                                    @foreach($user as $u)
                                                        <tr>
                                                            @if($u->isBan!=null)
                                                                <td><a class="text-danger" href="admin/dashboard/{{$u->id}}">{{$u->name}}</a></td>
                                                            @else
                                                                <td><a href="admin/dashboard/{{$u->id}}">{{$u->name}}</a></td>
                                                            @endif
                                                            <td>{{$u->email}}</td>
                                                            <td>{{$u->gender}}</td>
                                                            @if($u->level==0)
                                                                <td>Member</td>
                                                            @endif
                                                            @if($u->level==1)
                                                                <td>Mod</td>
                                                            @endif
                                                            @if($u->level==2)
                                                                <td>Admin</td>
                                                            @endif
                                                            <td>{{ App\Models\Post::where('author_id', $u->id)->count()}}
                                                                <a href="admin/manage-post/list/post-i-manage/{{$u->id}}">
                                                                    <button type="button"
                                                                            class="btn btn-success btn-circle">
                                                                        <i class="fa fa-eye"></i>
                                                                    </button>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                {{$u->created_at}}
                                                            </td>
                                                            <td>
                                                                @if($u->name!=Auth::user()->name&&$u->level!=2)
                                                                    <a href="admin/manage-user/get-edit/{{$u->id}}">
                                                                        <button type="button"
                                                                                class="btn btn-info btn-circle">
                                                                            <i class="fa fa-edit"></i>
                                                                        </button>
                                                                    </a>
                                                                    <form method="post"
                                                                          action="admin/manage-user/delete/{{$u->id}}">
                                                                        @csrf
                                                                        <button type="submit"
                                                                                class="btn btn-danger btn-circle"
                                                                                onclick="return confirm('If you delete this account, posts will also be deleted. If you still want to delete click ok ');">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                    <!--                                                                       Day la form button  -->
                                                                    <div id="button-wrapper{{$u->id}}" class="button-ban">
                                                                        <button id="{{$u->id}}"
                                                                                class="btn btn-danger btn-circle"
                                                                                onclick="getBan(this.id)">
                                                                            <i class="fa fa-ban"></i>
                                                                        </button>
                                                                        <!--                                                                      Day la form input  -->
                                                                        <div id="input{{$u->id}}" hidden class="input-ban">
                                                                            <form method="post"
                                                                                  action="admin/manage-user/ban/{{$u->id}}">
                                                                                @csrf
                                                                                <input type="focus "  id="datepicker{{$u->id}}"
                                                                                       name="datepicker" onclick="inputBan()">
                                                                                <button class="btn btn-danger"style="height: 30px" type="submit">Ban</button>
                                                                            </form>
                                                                        </div>

                                                                    </div>

                                                                @endif
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
        $(document).ready(function () {
            $('#dataTables-example').DataTable({
                responsive: true,
                order: [
                    [4, "desc"]
                ]
            });
        });
    </script>
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
    </script>
@endsection
