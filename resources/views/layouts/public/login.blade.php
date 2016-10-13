@extends('layouts.main')

@section('title')
    Login
@endsection

@section('page-content')
    <div class="row">
        <div class="col-md-12 col-md-offset-11">
            @include('auth.login')
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var rule = {
                'username': {
                    'required': true,
                },
                'password': {
                    'required': true,
                },
            };
            var validator = getJqueryValidator($('#formLogin'), rule);
        });
    </script>
@endsection