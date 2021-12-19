@extends('layouts.default')

@section('content')
<!--Banner-->
<div class="register-main">
    <div class="container">
        <h1 class="huge">401</h1>
        <p><h1>Unauthorized.</h1></p>
        <p>You are not authorized to access this page.</p>

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