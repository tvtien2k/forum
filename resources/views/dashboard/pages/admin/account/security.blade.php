@extends('dashboard.index')

@section('title', 'Security')

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
                    <h1 class="page-header">Security</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
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
                    @if (session('status'))
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{session('status')}}
                        </div>
                    @endif
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Form Change Password
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <img class="img-responsive"
                                         src="https://ui-avatars.com/api/?size=300&name={{substr(Auth::user()->name, 0, 1)}}"
                                         alt="">
                                </div>
                                <div class="col-lg-8">
                                    <form role="form" method="post" action="admin/account/change-password">
                                        @csrf
                                        <div class="form-group col-lg-12">
                                            <label>Old password</label>
                                            <input type="password" name="old_pass" class="form-control" required>
                                            <a href="member/account/forgot-password" class="help-block">
                                                If you forget your password, we will logout and send an email
                                                to {{Auth::user()->email}}
                                            </a>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label>New password</label>
                                            <input type="password" name="new_pass" class="form-control" required>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label>Confirm new password</label>
                                            <input type="password" name="re_pass" class="form-control" required>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <button type="submit" class="btn btn-default">Update</button>
                                            <button type="reset" class="btn btn-default">Reset</button>
                                        </div>
                                    </form>
                                </div>
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
