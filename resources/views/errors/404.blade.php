@extends('layouts.default')

@section('content')
<!--Banner-->
<div class="register-main">
    <div class="container">
        <h1 class="huge">404</h1>
        <p><h1>Sorry - Page Not Found!</h1></p>
        <p>The page you are looking for was moved, removed, renamed or might never existed. You stumbled upon a broken link :(</p>

    </div>

</div>

<!--Banner End-->
@endsection
@section('page-script')
<script>
    $(document).ready(function () {
        $(".register-main").height($(document).height());
    });
</script>
@endsection