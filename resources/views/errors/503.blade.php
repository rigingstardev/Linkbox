@extends('layouts.default')

@section('content')
<!--Banner-->
<div class="register-main">
    <div class="container">
        <h1 class="huge">503</h1>
        <p><h1>Be right back !!!</h1></p>
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