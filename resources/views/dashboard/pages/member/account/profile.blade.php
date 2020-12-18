@extends('dashboard.index')

@section('title', 'User profile')

@section('style')
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
@endsection

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User profile</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
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
                            Form Update Profile
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <img class="img-responsive"
                                         src="https://ui-avatars.com/api/?size=300&name={{substr(Auth::user()->name, 0, 1)}}"
                                         alt="">
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-8">
                                    <form role="form" method="post" action="member/account/profile">
                                        @csrf
                                        <div class="form-group col-lg-12">
                                            <label>Name</label>
                                            <input type="text" name="name" value="{{Auth::user()->name}}"
                                                   class="form-control" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Gender</label>
                                            <select class="form-control" name="gender">
                                                @if(Auth::user()->gender=='Male')
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                @elseif(Auth::user()->gender=='Female')
                                                    <option value="Female">Female</option>
                                                    <option value="Male">Male</option>
                                                @else
                                                    <option></option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Birthday</label>
                                            <input type="date" name="birthday" value="{{Auth::user()->birthday}}"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control" rows="3">
                                                {{Auth::user()->description}}
                                            </textarea>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <button type="submit" class="btn btn-default">Update</button>
                                            <button type="reset" class="btn btn-default">Reset</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
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
@endsection
