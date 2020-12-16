<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
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
</body>
</html>
