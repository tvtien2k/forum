<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Dashboard</title>
    <base href="{{asset('')}}">
    @yield('style')
</head>
<body>
<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        @include('dashboard.layouts.nav-logo')
        @include('dashboard.layouts.nav-top')
        @if(Auth::user()->level==0)
            @include('dashboard.layouts.nav-left-member')
        @elseif(Auth::user()->level==1)
            @include('dashboard.layouts.nav-left-mod')
        @else
            @include('dashboard.layouts.nav-left-admin')
        @endif
    </nav>
    @yield('content')
</div>
@yield('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function getPost() {
        var key = $("#key").val();
        $.ajax({
            type: "get",
            url: "ajax/getPost/" + key,
            success: function (res) {
                $("#posts").html(res);
            }
        });
    }
</script>
</body>
</html>
