<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title')</title>
    <base href="{{asset('')}}">
    @yield('style')
</head>
<body>
<!-- Navigation -->
@include('client.layouts.nav')
<!-- Page Content -->
@yield('content')
<!-- end Page Content -->
<!-- Footer -->
<hr>
@include('client.layouts.footer')
@yield('js')
</body>
</html>
