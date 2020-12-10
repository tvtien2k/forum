<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
