@extends('dashboard.index')

@section('title', 'Create Post')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap Core CSS -->
    <link href="assets_dashboard/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="assets_dashboard/css/metisMenu.min.css" rel="stylesheet">

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

    <!-- jquery -->
    <script>
        import Button from "../../../../../js/Jetstream/Button";
        export default {
            components: {Button}
        }
    </script>
@endsection

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Update User</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div style="margin-left: 100px"  class="col-lg-6">
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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Form Update User
                        </div>
                        <div class="panel-body">
                            <form style="width: 500px" role="form" method="post" action="admin/manage-user/post-edit/{{$user->id}}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input style="width: 300px" class="form-control" id="title" onkeyup="ChangeToSlug();"
                                                   name="name"  value="{{$user->name}}" required>
                                        </div>
                                    </div>
                                    <!-- /.col-lg-6 (nested) -->
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Choose
                                                Gender</label>

                                            <select style="width: 100px" class="form-control" id="topic_id" name="gender">
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Choose
                                                level</label>

                                            <select style="width: 200px" class="form-control" id="topic_id" name="level">
                                                <option value="0">Member</option>
                                                <option value="1">Mod</option>
                                                <option value="2">Admin</option>
                                            </select>

                                        </div>
                                    </div>
                                    <!-- /.col-lg-6 (nested) -->
                                </div>
                                <button style="margin-left: 300px;border-width: 2px;background: #f5f5f5;" type="submit" class="btn btn-default">Update
                                </button>

                            </form>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
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

    <!-- ckeditor5 -->
    <script src="ckeditor5/build/ckeditor.js"></script>
@endsection
