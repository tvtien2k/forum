@extends('dashboard.index')

@section('title', 'Member')

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
        @if(isset($user))
            <div style="margin-left: 100px; margin-top:50px" class="page-content page-container" id="page-content">
                <div class="padding">
                    <div class="row container d-flex justify-content-center">
                        <div class="col-xl-6 col-md-8">
                            <div class="card user-card-full">
                                <div class="row m-l-0 m-r-0">
                                    <div class="col-sm-4 bg-c-lite-green user-profile">
                                        <div class="card-block text-center text-white">
                                            <div class="m-b-25"> <img class="img-responsive" src="https://ui-avatars.com/api/?size=200&name={{substr($user->name, 0, 1)}}" class="img-radius" alt="User-Profile-Image"> </div>
                                            <h6 class="f-w-600">{{$user->name}}</h6>
                                            <p>{{$user->email}}</p> <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
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
                                                    <p class="m-b-10 f-w-600">Total </p>
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
                    </div>
                </div>
            </div>
        @else
            <div style="margin-left: 100px; margin-top:50px" id="page-content">
                <div class="padding">
                    <div class="row container d-flex justify-content-center">
                        <div class="col-xl-6 col-md-8">
                            <div class="card user-card-full">
                                <div class="row m-l-0 m-r-0">
                                    <div class="col-sm-4 bg-c-lite-green user-profile">
                                        <div class="card-block text-center text-white">
                                            <div class="m-b-25"> <img class="img-responsive" src="https://ui-avatars.com/api/?size=200&name={{substr(Auth::user()->name, 0, 1)}}" class="img-radius" alt="User-Profile-Image"> </div>
                                            <h6 class="f-w-600">{{Auth::user()->name}}</h6>
                                            <p>{{Auth::user()->email}}</p> <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="card-block">
                                            <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <p class="m-b-10 f-w-600">Gender: </p>
                                                    <h6 class="text-muted f-w-400">{{Auth::user()->gender}}</h6>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p class="m-b-10 f-w-600">Level:</p>
                                                    <h6 class="text-muted f-w-400">@if(Auth::user()->level==2) Admin
                                                        @elseif(Auth::user()->level==1)
                                                            Mod
                                                        @else User @endif
                                                    </h6>
                                                </div>
                                            </div>
                                            <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600"></h6>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <p class="m-b-10 f-w-600">Birthday:</p>
                                                    <h6 class="text-muted f-w-400">{{Auth::user()->birthday}}</h6>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p class="m-b-10 f-w-600">Total </p>
                                                    <h6 class="text-muted f-w-400">{{$count_all_post}}</h6>
                                                </div>
                                            </div>
                                            <ul class="social-link list-unstyled m-t-40 m-b-10">
                                                <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="facebook" data-abc="true"><i class="mdi mdi-facebook feather icon-facebook facebook" aria-hidden="true"></i></a></li>
                                                <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="twitter" data-abc="true"><i class="mdi mdi-twitter feather icon-twitter twitter" aria-hidden="true"></i></a></li>
                                                <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="instagram" data-abc="true"><i class="mdi mdi-instagram feather icon-instagram instagram" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endif

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
